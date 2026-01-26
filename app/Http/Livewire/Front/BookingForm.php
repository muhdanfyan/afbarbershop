<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Transaksi;
use App\Models\Member;
use Illuminate\Support\Carbon;

class BookingForm extends Component
{
    public $nama;
    public $no_hp;
    public $layanan;
    public $tanggal;
    public $waktu;
    public $barber;
    public $catatan;
    public $jasaList = [];
    public $kapsterList = [];
    public $successMessage;

    public function mount()
    {
        $this->jasaList = Jasa::all();
        $this->kapsterList = Kapster::all();
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'barber' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $member = Member::firstOrCreate(
            ['no_hp' => $this->no_hp],
            ['nama' => $this->nama, 'alamat' => null]
        );
        $jasa = Jasa::where('nama', $this->layanan)->first();
        $kapster = $this->barber ? Kapster::where('nama', $this->barber)->first() : null;

        $transaksi = Transaksi::create([
            'nama' => $member->nama,
            'no_hp' => $member->no_hp,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'jumlah' => 1,
            'total_harga' => $jasa ? $jasa->harga : 0,
            'status' => 'menunggu',
            'kapster_id' => $kapster ? $kapster->id : null,
            'catatan' => $this->catatan,
        ]);
        if ($jasa) {
            $transaksi->jasa()->attach($jasa->id);
        }
        $this->reset(['nama', 'no_hp', 'layanan', 'tanggal', 'waktu', 'barber', 'catatan']);
        $this->successMessage = 'Booking berhasil! Kami akan menghubungi Anda.';
    }

    public function render()
    {
        return view('livewire.front.booking-form');
    }
}
