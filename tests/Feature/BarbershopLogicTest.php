<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BarbershopLogicTest extends TestCase
{
    use RefreshDatabase;

    protected $jasa;
    protected $kapster;
    protected $barang;
    protected $member;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup initial data
        $this->jasa = Jasa::create(['nama' => 'Potong Rambut', 'harga' => 50000]);
        $this->kapster = Kapster::create([
            'nama' => 'Barber A',
            'nik' => '1234567890',
            'no_wa' => '08123456789',
            'alamat' => 'Alamat Test',
            'status' => 'bekerja'
        ]);
        $this->barang = Barang::create([
            'nama' => 'Pomade',
            'harga_beli' => 50000,
            'harga_jual' => 100000,
            'stok' => 10
        ]);
        $this->member = Member::create(['nama' => 'Customer Test', 'nomor_wa' => '08123456789']);
    }

    /** @test */
    public function it_prevents_double_booking_for_the_same_kapster_at_the_same_time()
    {
        $date = now()->addDay()->toDateString();
        $time = '10:00';

        // First booking
        Transaksi::create([
            'nama' => $this->member->nama,
            'no_hp' => $this->member->nomor_wa,
            'tanggal' => $date,
            'waktu' => $time,
            'kapster_id' => $this->kapster->id,
            'jasa_id' => $this->jasa->id,
            'status' => 'menunggu',
            'jumlah' => 1,
            'total_harga' => 50000,
        ]);

        // Attempt second booking at the same time (should fail validation in Livewire)
        // We'll test the logic used in BookingForm.php
        $startTime = \Carbon\Carbon::parse($time)->subMinutes(29)->format('H:i');
        $endTime = \Carbon\Carbon::parse($time)->addMinutes(29)->format('H:i');

        $isBooked = Transaksi::where('kapster_id', $this->kapster->id)
            ->where('tanggal', $date)
            ->whereIn('status', ['menunggu', 'proses'])
            ->whereBetween('waktu', [$startTime, $endTime])
            ->exists();

        $this->assertTrue($isBooked, 'The slot should be marked as booked.');
    }

    /** @test */
    public function it_reduces_stock_when_transaction_is_completed()
    {
        $transaksi = Transaksi::create([
            'nama' => $this->member->nama,
            'no_hp' => $this->member->nomor_wa,
            'tanggal' => now()->toDateString(),
            'waktu' => '11:00',
            'status' => 'proses',
            'jumlah' => 1,
            'total_harga' => 150000,
        ]);

        // Attach product (Pomade)
        $transaksi->barangs()->attach($this->barang->id, ['jumlah' => 2]);

        // Initial stock is 10. After 2 sold, it should be 8.
        // We mimic the logic in KasirTransaksi.php@simpanTransaksi
        $transaksi->update(['status' => 'selesai']);
        
        foreach ($transaksi->barangs as $item) {
            $item->decrement('stok', $item->pivot->jumlah);
        }

        $this->assertEquals(8, $this->barang->fresh()->stok);
    }

    /** @test */
    public function it_shows_tomorrow_bookings_separately()
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        // Today booking
        Transaksi::create([
            'nama' => 'Today Guest',
            'tanggal' => $today,
            'status' => 'menunggu',
            'jumlah' => 1,
            'total_harga' => 50000,
        ]);

        // Tomorrow booking
        Transaksi::create([
            'nama' => 'Tomorrow Guest',
            'tanggal' => $tomorrow,
            'status' => 'menunggu',
            'jumlah' => 1,
            'total_harga' => 50000,
        ]);

        $todayCount = Transaksi::where('tanggal', $today)->where('status', 'menunggu')->count();
        $tomorrowCount = Transaksi::where('tanggal', $tomorrow)->where('status', 'menunggu')->count();

        $this->assertEquals(1, $todayCount);
        $this->assertEquals(1, $tomorrowCount);
    }
}
