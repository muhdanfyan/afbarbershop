<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\WAService;

class SendBookingReminders extends Command
{
    protected $signature = 'app:send-reminders';
    protected $description = 'Send WhatsApp reminders for upcoming bookings that haven\'t been reminded yet.';

    public function handle(WAService $waService)
    {
        $now = now();
        $today = $now->toDateString();

        // Get all upcoming bookings for today that are still waiting
        $bookings = Transaksi::where('tanggal', $today)
            ->where('status', 'menunggu')
            ->where('waktu', '>', $now->format('H:i'))
            ->get();

        $this->info("Checking " . $bookings->count() . " bookings for reminders.");

        /** @var Transaksi $booking */
        foreach ($bookings as $booking) {
            $bookingTime = Carbon::createFromFormat('Y-m-d H:i', $today . ' ' . $booking->waktu);
            $diffInMinutes = $now->diffInMinutes($bookingTime, false); // false to get negative if already passed

            // 15 Minutes Reminder
            if ($diffInMinutes <= 15 && $diffInMinutes > 10 && is_null($booking->reminded_at)) {
                if ($waService->sendBookingReminder($booking, "15 Menit Lagi")) {
                    $booking->update(['reminded_at' => now()]);
                    $this->info("15m Reminder sent to " . $booking->nama);
                }
            } 
            // 10 Minutes Reminder
            elseif ($diffInMinutes <= 10 && $diffInMinutes > 5 && is_null($booking->reminded_at_10)) {
                if ($waService->sendBookingReminder($booking, "10 Menit Lagi")) {
                    $booking->update(['reminded_at_10' => now()]);
                    $this->info("10m Reminder sent to " . $booking->nama);
                }
            }
            // 5 Minutes Reminder
            elseif ($diffInMinutes <= 5 && $diffInMinutes > 0 && is_null($booking->reminded_at_5)) {
                if ($waService->sendBookingReminder($booking, "5 Menit (SEBENTAR LAGI)")) {
                    $booking->update(['reminded_at_5' => now()]);
                    $this->info("5m Reminder sent to " . $booking->nama);
                }
            }
        }
    }
}
