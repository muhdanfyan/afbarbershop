# Admin Sidebar CRUD Testing Skill

This skill defines the canonical process for testing the data integrity and basic functionality of admin sidebar modules without using the browser.

## Workflow

### 1. CRUD Health Checks
Initialize and verify the main sidebar models (`Barang`, `Kapster`, `Jasa`, `Member`) via unit tests.

**Command**:
```bash
php artisan test --filter BarangIndexTest --filter KapsterIndexTest
```

**Verification Steps**:
- Verify data creation (`Barang::create()`).
- Verify data update and record retrieval.
- Verify status toggles (e.g., Kapster `bekerja` vs `libur`).

### 2. Livewire Component Verification
Verify rendering and initial state of admin Livewire components via `Livewire::test()`.

**Script (Example)**:
```php
Livewire::test(Admin\BarangIndex::class)
    ->assertViewIs('livewire.admin.barang-index')
    ->assertSee('Stok Produk')
    ->call('showAddModal')
    ->set('nama', 'Test Product')
    ->call('save')
    ->assertHasNoErrors();
```

### 3. Sidebar Search Logic
Verify that search filtering works correctly for large datasets (Member, Barang).

**Script**:
```php
$member = App\Models\Member::where('nama', 'LIKE', '%test%')->get();
$form = new App\Livewire\Admin\MemberIndex();
$form->search = 'test';
$form->render(); // Verify it returns filtered results
```

## Rules
- **Access Control**: Always assume `Auth::login($user)` is required for admin-side tests.
- **Model Integrity**: Ensure `Delete` actions detach many-to-many relationships (e.g., `Transaksi` relationships).
