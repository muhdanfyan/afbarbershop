<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingIndex extends Component
{
    use WithFileUploads;

    public $nama_usaha;
    public $alamat;
    public $telepon;
    public $email;
    public $jam_buka;
    public $slogan;
    public $logo;
    public $logo_lama;

    public function mount()
    {
        $this->nama_usaha = Setting::where('key', 'nama_usaha')->value('value') ?? '';
        $this->alamat = Setting::where('key', 'alamat')->value('value') ?? '';
        $this->telepon = Setting::where('key', 'telepon')->value('value') ?? '';
        $this->email = Setting::where('key', 'email')->value('value') ?? '';
        $this->jam_buka = Setting::where('key', 'jam_buka')->value('value') ?? '';
        $this->slogan = Setting::where('key', 'slogan')->value('value') ?? '';
        $this->logo = Setting::where('key', 'logo')->value('value') ?? null;
        $this->logo_lama = $this->logo;
    }

    public function simpanSetting()
    {
        $fields = [
            'nama_usaha' => $this->nama_usaha,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jam_buka' => $this->jam_buka,
            'slogan' => $this->slogan,
        ];
        // Handle upload logo
        $logoPath = $this->logo_lama;
        if ($this->logo) {
            if ($this->logo_lama && \Storage::disk('public')->exists($this->logo_lama)) {
                \Storage::disk('public')->delete($this->logo_lama);
            }
            $logoPath = $this->logo->store('logos', 'public');
        }
        $fields['logo'] = $logoPath;
        foreach ($fields as $key => $value) {
            Setting::updateOrInsert(['key' => $key], ['value' => $value]);
        }
        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        $logo_lama = Setting::where('key', 'logo')->value('value') ?? null;
        return view('livewire.admin.setting', ['logo_lama' => $logo_lama]);
    }
}
