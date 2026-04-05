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
    public $kursi_id;
    public $catatan;
    public $jasaList = [];
    public $kapsterList = [];
    public $kursiList = [];
    public $successMessage;
    public $estimasiTunggu = 0;
    public $showTimePicker = false;
    public $availableSlots = [];
    public $workingHours = ['09:00', '21:00'];

    public function mount()
    {
        $this->jasaList = Jasa::all();
        $this->kapsterList = Kapster::where('status', 'bekerja')->get();
        $this->kursiList = \App\Models\Kursi::where('status', 'aktif')->get();
        // Set default ke waktu sekarang dalam format date
        $this->tanggal = now()->toDateString();
        $this->loadAvailableSlots();
    }

    public function updatedWaktuLengkap($value)
    {
        if ($value) {
            $dt = \Illuminate\Support\Carbon::parse($value);
            $this->tanggal = $dt->toDateString();
            $this->waktu = $dt->format('H:i');
            $this->loadAvailableSlots(); // Update slots when date changes
            $this->hitungEstimasi();
        }
    }

    public function updatedTanggal($value)
    {
        $this->loadAvailableSlots();
        $this->hitungEstimasi();
    }

    public function selectSlot($time)
    {
        $this->waktu = $time;
    }

    public function loadAvailableSlots()
    {
        $slots = [];
        $start = \Carbon\Carbon::parse($this->workingHours[0]);
        $end = \Carbon\Carbon::parse($this->workingHours[1]);
        $kapster = $this->barber ? Kapster::where('nama', $this->barber)->first() : null;

        while ($start->lessThan($end)) {
            $timeStr = $start->format('H:i');
            $status = 'available';

            // Check if past (if today)
            if ($this->tanggal == now()->toDateString() && $start->lt(now())) {
                $status = 'past';
            }

            // Check if booked
            if ($kapster || $this->kursi_id) {
                $startTime = $start->copy()->subMinutes(29);
                $endTime = $start->copy()->addMinutes(29);
                
                $query = Transaksi::where('tanggal', $this->tanggal)
                    ->whereIn('status', ['menunggu', 'proses'])
                    ->whereBetween('waktu', [$startTime->format('H:i'), $endTime->format('H:i')]);
                
                if ($kapster) {
                    $query->where('kapster_id', $kapster->id);
                }
                
                if ($this->kursi_id) {
                    $query->where('kursi_id', $this->kursi_id);
                }

                if ($query->exists()) {
                    $status = 'booked';
                }
            } else {
                // If "Bebas" (no specific barber/chair), check if BOTH all barbers and all chairs are booked
                $activeKapsterCount = Kapster::where('status', 'bekerja')->count();
                $activeKursiCount = \App\Models\Kursi::where('status', 'aktif')->count();
                
                $startTime = $start->copy()->subMinutes(29);
                $endTime = $start->copy()->addMinutes(29);
                
                $bookedKapsterCount = Transaksi::whereNotNull('kapster_id')
                    ->where('tanggal', $this->tanggal)
                    ->whereIn('status', ['menunggu', 'proses'])
                    ->whereBetween('waktu', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->distinct('kapster_id')
                    ->count();

                $bookedKursiCount = Transaksi::whereNotNull('kursi_id')
                    ->where('tanggal', $this->tanggal)
                    ->whereIn('status', ['menunggu', 'proses'])
                    ->whereBetween('waktu', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->distinct('kursi_id')
                    ->count();

                if (($activeKapsterCount > 0 && $bookedKapsterCount >= $activeKapsterCount) || 
                    ($activeKursiCount > 0 && $bookedKursiCount >= $activeKursiCount)) {
                    $status = 'booked';
                }
            }

            $slots[] = [
                'time' => $timeStr,
                'status' => $status
            ];
            $start->addMinutes(30);
        }
        $this->availableSlots = $slots;
    }

    public function updatedBarber($value)
    {
        $this->loadAvailableSlots();
        $this->hitungEstimasi();
    }

    public function updatedKursiId($value)
    {
        $this->loadAvailableSlots();
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
            'kursi_id' => 'nullable|exists:kursis,id',
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

        // Cek Double Booking (Slot 30 Menit)
        $kapster = $this->barber ? Kapster::where('nama', $this->barber)->first() : null;
        if ($kapster) {
            $selectedTime = \Carbon\Carbon::parse($this->waktu);
            $startTime = $selectedTime->copy()->subMinutes(29);
            $endTime = $selectedTime->copy()->addMinutes(29);

            $isBooked = Transaksi::where('kapster_id', $kapster->id)
                ->where('tanggal', $this->tanggal)
                ->whereIn('status', ['menunggu', 'proses'])
                ->whereBetween('waktu', [$startTime->format('H:i'), $endTime->format('H:i')])
                ->exists();

            if ($isBooked) {
                $this->addError('waktu', 'Maaf, jadwal untuk kapster ini sudah terisi di jam tersebut. Silakan pilih waktu lain.');
                return;
            }
        }

        // Cek Double Booking Kursi
        if ($this->kursi_id) {
            $selectedTime = \Carbon\Carbon::parse($this->waktu);
            $startTime = $selectedTime->copy()->subMinutes(29);
            $endTime = $selectedTime->copy()->addMinutes(29);

            $isBookedKursi = Transaksi::where('kursi_id', $this->kursi_id)
                ->where('tanggal', $this->tanggal)
                ->whereIn('status', ['menunggu', 'proses'])
                ->whereBetween('waktu', [$startTime->format('H:i'), $endTime->format('H:i')])
                ->exists();

            if ($isBookedKursi) {
                $this->addError('waktu', 'Maaf, kursi ini sudah dipesan di jam tersebut. Silakan pilih waktu lain.');
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
            'kursi_id' => $this->kursi_id,
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
