<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class SettingPage extends Component
{
    public $nama_aplikasi;
    public $alamat;
    public $telepon;

    public function mount()
    {
        $this->nama_aplikasi = Setting::where('key', 'nama_usaha')->value('value') ?? '';
        $this->alamat = Setting::where('key', 'alamat')->value('value') ?? '';
        $this->telepon = Setting::where('key', 'telepon')->value('value') ?? '';
    }

    public function simpanSetting()
    {
        Setting::updateOrInsert(['key' => 'nama_usaha'], ['value' => $this->nama_aplikasi]);
        Setting::updateOrInsert(['key' => 'alamat'], ['value' => $this->alamat]);
        Setting::updateOrInsert(['key' => 'telepon'], ['value' => $this->telepon]);
        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.setting');
    }
}
