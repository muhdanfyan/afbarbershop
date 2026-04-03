<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    protected $signature = 'wa:remind';
    protected $description = 'Send WhatsApp reminders for bookings in 15, 10, and 5 minutes.';

    public function handle()
    {
        $now = now();
        $intervals = [15, 10, 5];

        foreach ($intervals as $minutes) {
            $targetTime = $now->copy()->addMinutes($minutes)->format('H:i');
            
            $bookings = Transaksi::where('tanggal', $now->toDateString())
                ->where('status', 'menunggu')
                ->where('waktu', $targetTime)
                ->get();

            foreach ($bookings as $booking) {
                $this->sendWhatsAppReminder($booking, $minutes);
            }
        }
    }

    private function sendWhatsAppReminder($booking, $minutes)
    {
        $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
        $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

        $message = "*PENGINGAT BOOKING*\n\n";
        $message .= "Halo " . $booking->nama . ",\n";
        $message .= "Ini adalah pengingat bahwa jadwal booking Anda di *AF Barbershop* adalah dalam *" . $minutes . " menit* lagi pada pukul *" . $booking->waktu . "*.\n\n";
        $message .= "Kapster: " . ($booking->kapster->nama ?? 'Bebas') . "\n";
        $message .= "Mohon datang tepat waktu ya. Terima kasih!\n\n";
        $message .= "https://poseidonbarbershop.my.id";

        $no_hp = $booking->no_hp;
        if (str_starts_with($no_hp, '0')) {
            $no_hp = '62' . substr($no_hp, 1);
        } elseif (str_starts_with($no_hp, '+')) {
            $no_hp = substr($no_hp, 1);
        }

        try {
            Http::withHeaders(['x-api-key' => $apiKey])
                ->post($baseUrl . '/api/send-message', [
                    'number' => $no_hp,
                    'message' => $message,
                ]);
            
            $this->info("Reminder sent to " . $booking->nama . " for " . $minutes . " minutes.");
        } catch (\Exception $e) {
            $this->error("Failed to send reminder: " . $e->getMessage());
        }
    }
}
