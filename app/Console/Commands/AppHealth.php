<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Models\Jasa;
use App\Models\Kapster;

class AppHealth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the health and readiness of the AF Barbershop system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->header();

        $checks = [
            'Database Connection' => fn() => $this->checkDatabase(),
            'Storage Link' => fn() => $this->checkStorage(),
            'Cache System' => fn() => $this->checkCache(),
            'Vital Data (Settings)' => fn() => $this->checkSettings(),
            'Vital Data (Services)' => fn() => $this->checkServices(),
            'Vital Data (Barbers)' => fn() => $this->checkBarbers(),
        ];

        $failed = 0;
        foreach ($checks as $name => $check) {
            $result = $check();
            if ($result) {
                $this->components->info("$name: PASS");
            } else {
                $this->components->error("$name: FAIL");
                $failed++;
            }
        }

        $this->newLine();
        if ($failed === 0) {
            $this->components->info('ALL SYSTEMS GO! AF Barbershop is healthy.');
            return self::SUCCESS;
        } else {
            $this->components->error("SYSTEM UNHEALTHY: $failed check(s) failed.");
            return self::FAILURE;
        }
    }

    private function header()
    {
        $this->newLine();
        $this->line('<fg=yellow;options=bold>AF BARBERSHOP - SYSTEM HEALTH CHECK</>');
        $this->line('-----------------------------------');
    }

    private function checkDatabase()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function checkStorage()
    {
        return file_exists(public_path('storage'));
    }

    private function checkCache()
    {
        Cache::put('health_check', true, 10);
        return Cache::get('health_check') === true;
    }

    private function checkSettings()
    {
        return Setting::count() > 0;
    }

    private function checkServices()
    {
        return Jasa::count() > 0;
    }

    private function checkBarbers()
    {
        return Kapster::where('status', 'bekerja')->count() > 0;
    }
}
