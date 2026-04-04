<?php

namespace Tests\Feature;

use App\Livewire\Front\BookingForm;
use App\Models\Jasa;
use App\Models\Kapster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireBookingTest extends TestCase
{
    use RefreshDatabase;

    protected $jasa;
    protected $kapster;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jasa = Jasa::create(['nama' => 'Potong Rambut', 'harga' => 50000]);
        $this->kapster = Kapster::create([
            'nama' => 'Barber A', 
            'status' => 'bekerja',
            'nik' => '12345678',
            'no_wa' => '08123456789',
            'alamat' => 'Alamat Test'
        ]);
    }

    /** @test */
    public function it_can_render_the_booking_form()
    {
        Livewire::test(BookingForm::class)
            ->assertStatus(200)
            ->assertSee('KONFIRMASI BOOKING')
            ->assertSee($this->jasa->nama)
            ->assertSee($this->kapster->nama);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        Livewire::test(BookingForm::class)
            ->set('tanggal', '') // Clear default date
            ->call('submit')
            ->assertHasErrors([
                'nama' => 'required',
                'no_hp' => 'required',
                'layanan' => 'required',
                'tanggal' => 'required',
                'waktu' => 'required',
            ]);
    }

    /** @test */
    public function it_can_successfully_book_a_slot()
    {
        $date = now()->addDay()->toDateString();
        $time = '10:00';

        Livewire::test(BookingForm::class)
            ->set('nama', 'John Doe')
            ->set('no_hp', '08123456789')
            ->set('layanan', $this->jasa->nama)
            ->set('tanggal', $date)
            ->set('waktu', $time)
            ->set('barber', $this->kapster->nama)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', 'Booking berhasil! Kami akan menghubungi Anda.')
            ->assertDispatched('bookingSuccess');

        $this->assertDatabaseHas('transaksis', [
            'nama' => 'John Doe',
            'no_hp' => '08123456789',
            'tanggal' => $date,
            'waktu' => $time,
            'status' => 'menunggu',
        ]);
    }

    /** @test */
    public function it_fails_if_booking_for_past_time_today()
    {
        $pastTime = now()->subHour()->format('H:i');

        Livewire::test(BookingForm::class)
            ->set('nama', 'John Doe')
            ->set('no_hp', '08123456789')
            ->set('layanan', $this->jasa->nama)
            ->set('tanggal', now()->toDateString())
            ->set('waktu', $pastTime)
            ->call('submit')
            ->assertHasErrors(['waktu']);
    }
}
