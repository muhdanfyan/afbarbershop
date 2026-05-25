<?php
$components = [
    \App\Livewire\Admin\BarangIndex::class,
    \App\Livewire\Admin\Dashboard::class,
    \App\Livewire\Admin\GalleryIndex::class,
    \App\Livewire\Admin\JasaIndex::class,
    \App\Livewire\Admin\KapsterIndex::class,
    \App\Livewire\Admin\KasirTransaksi::class,
    \App\Livewire\Admin\LaporanTransaksi::class,
    \App\Livewire\Admin\MemberIndex::class,
    \App\Livewire\Admin\PlaylistIndex::class,
    \App\Livewire\Admin\Setting::class,
    \App\Livewire\Admin\TransaksiCrud::class,
    \App\Livewire\Admin\TransaksiIndex::class,
    \App\Livewire\Admin\UserIndex::class,
];

foreach ($components as $component) {
    if (class_exists($component)) {
        try {
            \Livewire\Livewire::test($component)->assertStatus(200);
            echo "OK: {$component}\n";
        } catch (\Exception $e) {
            echo "FAIL: {$component} - " . $e->getMessage() . "\n";
        }
    } else {
        echo "MISSING: {$component}\n";
    }
}
