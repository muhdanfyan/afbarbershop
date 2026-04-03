<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DevCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Laravel server and WhatsApp Gateway simultaneously';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting AF Barbershop Development Environment...');

        // 1. WhatsApp Gateway Process
        $waProcess = new Process(['node', 'index.js'], base_path('wagateway'));
        $waProcess->setTimeout(null);
        $waProcess->start(function ($type, $buffer) {
            $this->output->write('<fg=green>[WA Gateway]</> ' . $buffer);
        });

        // 2. Laravel Serve Process
        $laravelProcess = new Process(['php', 'artisan', 'serve']);
        $laravelProcess->setTimeout(null);
        $laravelProcess->start(function ($type, $buffer) {
            $this->output->write('<fg=blue>[Laravel]</> ' . $buffer);
        });

        $this->info('✨ Services are running!');
        $this->info('   - Laravel: http://127.0.0.1:8000');
        $this->info('   - WA Gateway: http://localhost:3001');
        $this->info('Press Ctrl+C to stop all services.');

        // Monitor processes
        while ($waProcess->isRunning() && $laravelProcess->isRunning()) {
            usleep(500000);
        }

        $waProcess->stop();
        $laravelProcess->stop();

        $this->error('⚠️ Services stopped.');
    }
}
