<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaksi;

class TransaksiIndex extends Component
{
    public $status = 'menunggu';

    protected $queryString = ['status'];

    public function mount()
    {
        $this->status = request()->get('status', 'menunggu');
    }

    public function render()
    {
        $transaksis = Transaksi::with(['jasa', 'kapster'])
            ->where('status', $this->status)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.admin.transaksi-index', compact('transaksis'));
    }
}
