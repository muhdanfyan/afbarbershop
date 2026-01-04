<?php
namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $foto;
    public $foto_lama;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->foto_lama = $user->foto ?? null;
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|max:2048',
        ], [
            'email.unique' => 'Email sudah digunakan.',
        ]);
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->foto) {
            if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
                \Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $this->foto->store('user', 'public');
            $this->foto_lama = $user->foto;
            $this->foto = null;
        }
        $user->save();
        session()->flash('message', 'Profil berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
        $user = Auth::user();
        $user->password = Hash::make($this->password);
        $user->save();
        $this->password = $this->password_confirmation = '';
        session()->flash('message', 'Password berhasil diubah!');
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
