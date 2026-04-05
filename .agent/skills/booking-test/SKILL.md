# Booking Simulation Skill

This skill defines the canonical process for simulating and verifying customer bookings without using the browser.

## Workflow

### 1. Livewire Component Testing
The primary method for testing the booking form logic is using `Livewire::test()`.

**Command**:
```bash
php artisan test --filter LivewireBookingTest
```

**Verification Steps**:
- Verify initial data loading (Jasa, Kapster).
- Simulate form input: `set('nama', 'John Doe')`, `set('no_hp', '08123456789')`, etc.
- Call the `submit()` action.
- Assert that a `Transaksi` record is created in the database.
- Assert that validation errors are thrown for double bookings (30-minute slot).

### 2. Manual Simulation (Tinker)
Use `php artisan tinker` to manually inject bookings and check availability logic.

**Script**:
```php
// Simulate a booking for today at 10:00
$jasa = App\Models\Jasa::first();
$kapster = App\Models\Kapster::where('status', 'bekerja')->first();

$transaksi = App\Models\Transaksi::create([
    'nama' => 'Test User',
    'no_hp' => '628123456789',
    'tanggal' => now()->toDateString(),
    'waktu' => '10:00',
    'jumlah' => 1,
    'total_harga' => $jasa->harga,
    'status' => 'menunggu',
    'jasa_id' => $jasa->id,
    'kapster_id' => $kapster->id,
]);

// Verify slot availability after booking
$form = new App\Livewire\Front\BookingForm();
$form->tanggal = now()->toDateString();
$form->barber = $kapster->nama;
$form->loadAvailableSlots();
// Check if 10:00 is marked as 'booked'
collect($form->availableSlots)->where('time', '10:00')->first();
```

## Rules
- **Date Consistency**: Always use `now()->toDateString()` for testing "today" scenarios.
- **Cleanup**: Delete test transactions after verification to avoid polluting slot availability.
