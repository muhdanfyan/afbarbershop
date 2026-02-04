<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;




class LoginIndex extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Kata sandi harus diisi.',
        'password.min' => 'Kata sandi harus minimal 6 karakter.',
    ];


    public function login()
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        session()->flash('error', 'Email atau kata sandi salah.');

        $this->resetField();
    }

    protected function resetField()
    {
        $this->email = "";
        $this->password = "";
    }

    protected function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    public function render()
    {
        $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';
        $slogan = \App\Models\Setting::where('key', 'slogan')->value('value') ?? 'Premium Grooming Portal';
        return view('livewire.admin.login-index', [
            'nama_usaha' => $namaUsaha,
            'slogan' => $slogan,
        ]);
    }
}
