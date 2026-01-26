<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Kapster;
use App\Models\Transaksi;

class AntrianStatus extends Component
{
    public $kapsterStats = [];

    public function mount()
    {
        $this->updateStats();
    }

    public function updateStats()
    {
        $kapsters = Kapster::all();
        $today = now()->toDateString();
        $this->kapsterStats = $kapsters->map(function ($k) use ($today) {
            $menunggu = Transaksi::where('kapster_id', $k->id)->where('status', 'menunggu')->whereDate('created_at', $today)->count();
            $proses = Transaksi::where('kapster_id', $k->id)->where('status', 'proses')->whereDate('created_at', $today)->count();
            $selesai = Transaksi::where('kapster_id', $k->id)->where('status', 'selesai')->whereDate('created_at', $today)->count();
            return [
                'id' => $k->id,
                'nama' => $k->nama,
                'foto' => $k->foto,
                'menunggu' => $menunggu,
                'proses' => $proses,
                'selesai' => $selesai,
            ];
        });
    }

    public function render()
    {
        $this->updateStats();
        $this->dispatch('antrian-updated');
        return view('livewire.front.antrian-status');
    }
}
