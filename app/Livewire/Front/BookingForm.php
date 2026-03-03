<?php

namespace App\Livewire\Front;

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
    public $waktu_lengkap;
    public $tanggal;
    public $waktu;
    public $selectedHour;
    public $barber;
    public $catatan;
    public $jasaList = [];
    public $kapsterList = [];
    public $successMessage;
    public $estimasiTunggu = 0;
    public $showTimePicker = false;

    public function mount()
    {
        $this->jasaList = Jasa::all();
        $this->kapsterList = Kapster::where('status', 'bekerja')->get();
        // Set default ke waktu sekarang dalam format datetime-local
        $this->waktu_lengkap = now()->format('Y-m-d\TH:i');
        $this->updatedWaktuLengkap($this->waktu_lengkap);
    }

    public function updatedWaktuLengkap($value)
    {
        if ($value) {
            $dt = \Illuminate\Support\Carbon::parse($value);
            $this->tanggal = $dt->toDateString();
            $this->waktu = $dt->format('H:i');
            $this->hitungEstimasi();
        }
    }

    public function updatedBarber($value)
    {
        $this->hitungEstimasi();
    }

    public function hitungEstimasi()
    {
        if ($this->barber) {
            $kapster = Kapster::where('nama', $this->barber)->first();
            if ($kapster) {
                $menunggu = Transaksi::where('kapster_id', $kapster->id)
                    ->where('status', 'menunggu')
                    ->where('tanggal', $this->tanggal)
                    ->count();
                $this->estimasiTunggu = $menunggu * 30;
            } else {
                $this->estimasiTunggu = 0;
            }
        } else {
            $this->estimasiTunggu = 0;
        }
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'layanan' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|string',
            'barber' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Cek jika tanggal adalah hari ini, maka waktu tidak boleh kurang dari sekarang
        if ($this->tanggal == now()->toDateString()) {
            $waktuSekarang = now()->format('H:i');
            if ($this->waktu < $waktuSekarang) {
                $this->addError('waktu', 'Waktu tidak boleh kurang dari jam sekarang.');
                return;
            }
        }

        $member = Member::firstOrCreate(
            ['nomor_wa' => $this->no_hp],
            ['nama' => $this->nama, 'alamat' => null]
        );
        $jasa = Jasa::where('nama', $this->layanan)->first();
        $kapster = $this->barber ? Kapster::where('nama', $this->barber)->first() : null;

        $transaksi = Transaksi::create([
            'nama' => $member->nama,
            'no_hp' => $member->nomor_wa,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'jumlah' => 1,
            'total_harga' => $jasa ? $jasa->harga : 0,
            'status' => 'menunggu',
            'jasa_id' => $jasa ? $jasa->id : null,
            'kapster_id' => $kapster ? $kapster->id : null,
            'catatan' => $this->catatan,
        ]);
        if ($jasa) {
            $transaksi->jasa()->attach($jasa->id);
        }
        $this->reset(['nama', 'no_hp', 'layanan', 'tanggal', 'waktu', 'barber', 'catatan']);
        $this->successMessage = 'Booking berhasil! Kami akan menghubungi Anda.';
        $this->dispatch('bookingSuccess');
        $this->dispatch('transaksi-updated');
    }

    public function render()
    {
        return view('livewire.front.booking-form');
    }
}
