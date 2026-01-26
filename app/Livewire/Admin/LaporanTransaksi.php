<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;
use App\Models\Kapster;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;

class LaporanTransaksi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $mode = 'harian';
    public $tanggal;
    public $minggu;
    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->minggu = date('W');
    }

    public function updated($property)
    {
        $this->resetPage();
    }

    protected function queryLaporan()
    {
        if ($this->mode === 'harian') {
            return Transaksi::whereDate('tanggal', $this->tanggal);
        } elseif ($this->mode === 'mingguan') {
            $start = Carbon::now()->setISODate($this->tahun, $this->minggu)->startOfWeek();
            $end = Carbon::now()->setISODate($this->tahun, $this->minggu)->endOfWeek();
            return Transaksi::whereBetween('tanggal', [$start, $end]);
        } else {
            return Transaksi::whereYear('tanggal', $this->tahun)->whereMonth('tanggal', $this->bulan);
        }
    }

    public function exportExcel()
    {
        $query = $this->queryLaporan();
        $data = $query->orderByDesc('tanggal')->get();
        $filename = 'laporan-transaksi-' . $this->mode . '-' . date('Ymd_His') . '.xlsx';
        return Excel::download(new LaporanTransaksiExport($data, $this->mode, $this->tanggal, $this->minggu, $this->bulan, $this->tahun), $filename);
    }

    public function render()
    {
        $query = $this->queryLaporan();
        $total = $query->sum('total_harga');
        $allTransaksi = $query->with(['kapster', 'jasa'])->get();
        $penghasilanKapster = [];
        $fotoKapster = [];
        $allKapster = Kapster::all(['id', 'nama', 'foto']);
        // Inisialisasi semua kapster dengan fee 0 dan foto
        foreach ($allKapster as $k) {
            $penghasilanKapster[$k->id] = [
                'nama' => $k->nama,
                'fee' => 0,
            ];
            $fotoKapster[$k->id] = $k->foto;
        }
        // Hitung fee dari seluruh transaksi hasil query (bukan dari $data)
        foreach ($allTransaksi as $transaksi) {
            if ($transaksi->kapster) {
                $totalJasa = $transaksi->jasa->sum('harga');
                $fee = $totalJasa * 0.4;
                $kapsterId = $transaksi->kapster->id;
                if (isset($penghasilanKapster[$kapsterId])) {
                    $penghasilanKapster[$kapsterId]['fee'] += $fee;
                }
            }
        }
        // Urutkan berdasarkan nama kapster
        usort($penghasilanKapster, function ($a, $b) {
            return strcmp($a['nama'], $b['nama']);
        });
        $data = $query->orderByDesc('tanggal')->paginate(10);
        return view('livewire.admin.laporan-transaksi', compact('data', 'total', 'penghasilanKapster', 'fotoKapster'));
    }
}
