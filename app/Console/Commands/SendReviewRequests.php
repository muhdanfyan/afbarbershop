<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Services\WAService;
use Carbon\Carbon;

class SendReviewRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-review-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp review request for completed transactions after 30 minutes';

    /**
     * Execute the console command.
     */
    public function handle(WAService $waService)
    {
        $thirtyMinutesAgo = now()->subMinutes(30);

        // Find transactions completed more than 30 mins ago but not yet requested for review
        $transaksis = Transaksi::where('status', 'selesai')
            ->where('updated_at', '<=', $thirtyMinutesAgo)
            ->whereNull('review_requested_at')
            ->get();

        if ($transaksis->isEmpty()) {
            $this->info('No review requests to send.');
            return;
        }

        foreach ($transaksis as $transaksi) {
            $this->info("Sending review request to " . $transaksi->nama);
            if ($waService->sendRatingRequest($transaksi)) {
                $transaksi->update(['review_requested_at' => now()]);
                $this->info("Successfully sent to " . $transaksi->nama);
            }
        }
    }
}
