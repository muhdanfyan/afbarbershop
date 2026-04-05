# Kasir (POS) Lifecycle Testing Skill

This skill defines the canonical process for testing the cashier transaction lifecycle without using the browser.

## Workflow

### 1. Simulating a Transaction
Perform a full transaction simulation (Jasa + Barang + Payment) via `Livewire::test(Admin\KasirTransaksi::class)`.

**Command**:
```bash
php artisan test --filter KasirTransaksiTest
```

**Verification Steps**:
- Verify selection of `jasa` and `barangSelected`.
- Verify `hitungTotal()` produces the correct total.
- Verify `simpanTransaksi()` sets status to `selesai`.
- Assert that `stok` in the `barangs` table is decremented correctly.

### 2. Monitoring the Transaction Hub (Tinker)
Manually verify the `Transaksi` record and its relationships.

**Script**:
```php
$trx = App\Models\Transaksi::with(['jasa', 'barangs'])->latest()->first();
// Verify stock reduction in DB
$barang = App\Models\Barang::find($trx->barangs->first()->id);
$barang->stok; // Expected original_stok - jumlah
```

### 3. State Management Verification
Verify that a `selesai` transaction cannot be modified.

**Script**:
```php
$trx = App\Models\Transaksi::where('status', 'selesai')->first();
$form = new App\Livewire\Admin\KasirTransaksi();
$form->trxId = $trx->id;
$form->status = $trx->status;
$form->simpanTransaksi();
// Assert that it returns early or dispatches 'swal-error'
```

## Rules
- **Invoice Integrity**: Verify that `NOTA-` invoices are generated only upon saving a new transaction.
- **WhatsApp Dispatch**: Look for the `kirimStrukWa()` call and verify the log `WA API Error` for any failures.
