<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanTransaksiExport implements FromView
{
    protected $data;
    protected $mode;
    protected $tanggal;
    protected $minggu;
    protected $bulan;
    protected $tahun;

    public function __construct($data, $mode, $tanggal, $minggu, $bulan, $tahun)
    {
        $this->data = $data;
        $this->mode = $mode;
        $this->tanggal = $tanggal;
        $this->minggu = $minggu;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('exports.laporan-transaksi', [
            'data' => $this->data,
            'mode' => $this->mode,
            'tanggal' => $this->tanggal,
            'minggu' => $this->minggu,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}
