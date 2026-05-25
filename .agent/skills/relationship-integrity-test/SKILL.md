# Eloquent Relationship Integrity Testing Skill

This skill defines the canonical process for detecting **undefined or broken Eloquent relationships** before they cause 500 errors in production. This catches bugs like calling `->member` when no such relationship exists on the model.

## Context

A common bug pattern in this project:
- A Blade template or Livewire component calls `Model::with(['relationship'])` or `$model->relationship`
- But the relationship method doesn't exist on the Model class
- Or the corresponding foreign key column doesn't exist in the database table
- Result: **500 Internal Server Error** (`Call to undefined relationship`)

## Workflow

### 1. Scan Blade Templates for Relationship Calls

Find all `with()` eager-load calls in Blade and Livewire views:

```bash
grep -rn "::with\(\[" resources/views/ --include="*.blade.php"
```

For each result, verify that **every relationship name** in the array exists as a method on the corresponding Model class.

### 2. Scan Livewire Components for Relationship Calls

```bash
grep -rn "::with\(\[" app/Livewire/ --include="*.php"
grep -rn "->load\(\[" app/Livewire/ --include="*.php"
```

### 3. Validate Model Relationships Against Database Schema

For each Model in `app/Models/`, cross-reference:
- Every `belongsTo`, `hasMany`, `belongsToMany`, `hasOne` relationship method
- The corresponding foreign key column exists in the database table
- The related Model class exists

**Command**:
```bash
# List all relationship methods defined in models
grep -rn "belongsTo\|hasMany\|belongsToMany\|hasOne\|morphTo\|morphMany" app/Models/ --include="*.php"

# List actual table columns
php artisan tinker --execute="
  \$models = glob('app/Models/*.php');
  foreach (\$models as \$file) {
    \$class = 'App\\\\Models\\\\' . basename(\$file, '.php');
    if (class_exists(\$class)) {
      \$model = new \$class;
      \$table = \$model->getTable();
      echo \$table . ': ' . implode(', ', \\Illuminate\\Support\\Facades\\Schema::getColumnListing(\$table)) . PHP_EOL;
    }
  }
"
```

### 4. Cross-Reference Blade Access Patterns

Find all `$variable->relationship` patterns in Blade files that imply relationship access:

```bash
# Find relationship-style access in Blade (e.g., $trx->kapster->nama)
grep -rn '\$[a-z]*->[a-z]*->[a-z]*' resources/views/livewire/ --include="*.blade.php"

# Find member_id or similar FK references without corresponding relationship
grep -rn 'member_id\|user_id\|booking_id' resources/views/livewire/ --include="*.blade.php"
```

### 5. Automated Livewire Render Test

Test that each admin Livewire component renders without 500 errors:

```php
// In a PHPUnit test or tinker session:
$components = [
    \App\Livewire\Admin\TransaksiCrud::class,
    \App\Livewire\Admin\BarangIndex::class,
    \App\Livewire\Admin\KapsterIndex::class,
    // ... add all admin Livewire components
];

foreach ($components as $component) {
    try {
        Livewire::test($component)->assertStatus(200);
        echo "✅ {$component} OK\n";
    } catch (\Exception $e) {
        echo "❌ {$component}: " . $e->getMessage() . "\n";
    }
}
```

## Known Bug Registry

Track previously found relationship bugs here to prevent regressions:

| Date | Model | Relationship | Issue | Fix |
|------|-------|-------------|-------|-----|
| 2026-04-06 | `Transaksi` | `member` | Called `with(['member'])` in `transaksi-crud.blade.php` but no `member()` relationship on model and no `member_id` column in `transaksis` table | Replaced with `with(['jasa', 'kapster', 'kursi'])`, removed `$trx->member_id` check |

## Rules

- **Before deploying any Blade/Livewire change**: Run Step 1-2 to verify all `with()` calls reference valid relationships.
- **Before adding a new `with()` call**: Confirm the relationship method exists on the Model AND the FK column exists in the DB.
- **After modifying migrations**: Re-run Step 3 to ensure Model relationships still match the schema.
- **Never reference a relationship in Blade without defining it in the Model first.**
