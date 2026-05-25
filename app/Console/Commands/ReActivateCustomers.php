<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Transaksi;
use App\Services\WAService;
use Carbon\Carbon;

class ReActivateCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:re-activate-customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp re-activation message for customers who haven\'t visited in 30 days';

    /**
     * Execute the console command.
     */
    public function handle(WAService $waService)
    {
        $thirtyDaysAgo = now()->subDays(30);

        // Find members who haven't visited in 30 days AND haven't received a reactivation message yet
        // A member hasn't visited in 30 days if their LATEST transaction is older than 30 days
        $members = Member::whereNull('reactivation_sent_at')
            ->get()
            ->filter(function ($member) use ($thirtyDaysAgo) {
                $lastTransaksi = Transaksi::where('member_id', $member->id)
                    ->orderByDesc('tanggal')
                    ->first();
                
                if (!$lastTransaksi) return false; // Never had a transaction? (maybe just registered)

                $lastVisit = Carbon::parse($lastTransaksi->tanggal);
                return $lastVisit->lte($thirtyDaysAgo);
            });

        if ($members->isEmpty()) {
            $this->info('No dormant customers to re-activate.');
            return;
        }

        foreach ($members as $member) {
            $this->info("Sending re-activation message to " . $member->nama);
            if ($waService->sendReactivation($member)) {
                $member->update(['reactivation_sent_at' => now()]);
                $this->info("Successfully sent to " . $member->nama);
            }
        }
    }
}
