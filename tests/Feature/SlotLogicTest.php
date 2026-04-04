<?php

namespace Tests\Feature;

use App\Livewire\Front\BookingForm;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SlotLogicTest extends TestCase
{
    use RefreshDatabase;

    protected $jasa;
    protected $kapster1;
    protected $kapster2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jasa = Jasa::create(['nama' => 'Potong Rambut', 'harga' => 50000]);
        
        // Create 2 active barbers
        $this->kapster1 = Kapster::create([
            'nama' => 'Barber A', 
            'status' => 'bekerja',
            'nik' => '1111',
            'no_wa' => '081',
            'alamat' => 'A'
        ]);
        $this->kapster2 = Kapster::create([
            'nama' => 'Barber B', 
            'status' => 'bekerja',
            'nik' => '2222',
            'no_wa' => '082',
            'alamat' => 'B'
        ]);
    }

    /** @test */
    public function a_slot_is_available_if_at_least_one_barber_is_free()
    {
        $date = now()->addDay()->toDateString();
        $time = '10:00';

        // Book Barber A at 10:00
        Transaksi::create([
            'nama' => 'Cust 1',
            'no_hp' => '081',
            'tanggal' => $date,
            'waktu' => $time,
            'kapster_id' => $this->kapster1->id,
            'status' => 'menunggu',
            'jumlah' => 1,
            'total_harga' => 50000,
        ]);

        // Check availability via Livewire component for "Bebas" (no barber selected)
        $component = Livewire::test(BookingForm::class)
            ->set('tanggal', $date)
            ->set('barber', ''); // Bebas

        $slots = collect($component->get('availableSlots'));
        $slot10 = $slots->firstWhere('time', $time);

        $this->assertEquals('available', $slot10['status'], 'Slot should be available because Barber B is free.');
    }

    /** @test */
    public function a_slot_is_booked_if_all_barbers_are_busy()
    {
        $date = now()->addDay()->toDateString();
        $time = '10:00';

        // Book both barbers
        Transaksi::create(['nama' => 'C1', 'no_hp' => '081', 'tanggal' => $date, 'waktu' => $time, 'kapster_id' => $this->kapster1->id, 'status' => 'menunggu', 'jumlah' => 1, 'total_harga' => 50000]);
        Transaksi::create(['nama' => 'C2', 'no_hp' => '082', 'tanggal' => $date, 'waktu' => $time, 'kapster_id' => $this->kapster2->id, 'status' => 'menunggu', 'jumlah' => 1, 'total_harga' => 50000]);

        $component = Livewire::test(BookingForm::class)
            ->set('tanggal', $date)
            ->set('barber', '');

        $slots = collect($component->get('availableSlots'));
        $slot10 = $slots->firstWhere('time', $time);

        $this->assertEquals('booked', $slot10['status'], 'Slot should be booked because ALL barbers are busy.');
    }
}
