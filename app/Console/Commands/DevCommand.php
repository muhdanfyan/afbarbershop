<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DevCommand extends Command
{
    protected $signature = 'dev';
    protected $description = 'Run Laravel server and WhatsApp Gateway simultaneously';

    public function handle()
    {
        $this->info('🚀 Starting AF Barbershop Development Environment...');
        $this->newLine();

        $waDir = base_path('wagateway');
        $processes = [];

        // 1. Check if wagateway directory exists
        if (is_dir($waDir)) {
            // Check if node_modules exists
            if (!is_dir($waDir . '/node_modules')) {
                $this->warn('📦 Installing WA Gateway dependencies...');
                $install = new Process(['npm', 'install'], $waDir);
                $install->setTimeout(120);
                $install->run(function ($type, $buffer) {
                    $this->output->write($buffer);
                });
            }

            $waProcess = new Process(['node', 'index.js'], $waDir);
            $waProcess->setTimeout(null);
            $waProcess->start(function ($type, $buffer) {
                $this->output->write('<fg=green>[WA Gateway]</> ' . $buffer);
            });
            $processes['wa'] = $waProcess;
            $this->info('✅ WA Gateway started on http://localhost:3001');
        } else {
            $this->warn('⚠️  WA Gateway directory not found, skipping...');
        }

        // 2. Laravel Serve
        $laravelProcess = new Process(['php', 'artisan', 'serve'], base_path());
        $laravelProcess->setTimeout(null);
        $laravelProcess->start(function ($type, $buffer) {
            $this->output->write('<fg=blue>[Laravel]</> ' . $buffer);
        });
        $processes['laravel'] = $laravelProcess;

        $this->info('✅ Laravel started on http://127.0.0.1:8000');
        $this->newLine();
        $this->info('Press Ctrl+C to stop all services.');

        // Register shutdown handler for clean stop
        pcntl_async_signals(true);
        pcntl_signal(SIGINT, function () use (&$processes) {
            $this->newLine();
            $this->warn('🛑 Stopping all services...');
            foreach ($processes as $name => $p) {
                $p->stop(3);
                $this->info("   ⏹ {$name} stopped.");
            }
            exit(0);
        });

        // Monitor processes
        while (true) {
            $allRunning = false;
            foreach ($processes as $p) {
                if ($p->isRunning()) {
                    $allRunning = true;
                    break;
                }
            }
            if (!$allRunning) break;
            usleep(500000);
        }

        // Cleanup
        foreach ($processes as $p) {
            if ($p->isRunning()) $p->stop();
        }

        $this->error('⚠️ Services stopped.');
    }
}
