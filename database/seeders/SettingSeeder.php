<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data setting dari database lama jika ada
        $settings = DB::table('settings')->get();
        if ($settings->count() > 0) {
            foreach ($settings as $row) {
                DB::table('settings')->updateOrInsert([
                    'key' => $row->key
                ], [
                    'value' => $row->value
                ]);
            }
        } else {
            // Jika database kosong, seed default
            $data = [
                ['key' => 'nama_usaha', 'value' => 'AF POSEIDON BARBERSHOP'],
                ['key' => 'alamat', 'value' => "Jl. Betoambari\nKota Baubau"],
                ['key' => 'telepon', 'value' => "+62 852-2021-0003"],
                ['key' => 'email', 'value' => "info@poseidonbarbershop.my.id"],
                ['key' => 'jam_buka', 'value' => "Senin - Sabtu: 09:00 - 21:00\nMinggu: 10:00 - 20:00"],
                ['key' => 'slogan', 'value' => ''],
                ['key' => 'logo', 'value' => ''],
            ];
            foreach ($data as $row) {
                DB::table('settings')->updateOrInsert(['key' => $row['key']], ['value' => $row['value']]);
            }
        }
    }
}
