<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Kapster;
use App\Models\Transaksi;
use Livewire\Attributes\On;

class AntrianStatus extends Component
{
    public $kapsterStats = [];

    public function mount()
    {
        $this->updateStats();
    }

    #[On('transaksi-updated')]
    public function updateStats()
    {
        $kapsters = Kapster::where('status', 'bekerja')->get();
        $today = now()->toDateString();
        $this->kapsterStats = $kapsters->map(function ($k) use ($today) {
            $menunggu = Transaksi::where('kapster_id', $k->id)->where('status', 'menunggu')->where('tanggal', $today)->count();
            $proses = Transaksi::where('kapster_id', $k->id)->where('status', 'proses')->where('tanggal', $today)->count();
            $selesai = Transaksi::where('kapster_id', $k->id)->where('status', 'selesai')->where('tanggal', $today)->count();

            $estimasi = $menunggu * 30; // 30 menit per antrian

            return [
                'id' => $k->id,
                'nama' => $k->nama,
                'foto' => $k->foto,
                'sertifikat' => $k->sertifikat,
                'menunggu' => $menunggu,
                'proses' => $proses,
                'selesai' => $selesai,
                'estimasi' => $estimasi,
            ];
        });
    }

    public function render()
    {
        return view('livewire.front.antrian-status');
    }
}
