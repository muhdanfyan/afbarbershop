<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    protected $signature = 'app:send-reminders';
    protected $description = 'Send WhatsApp reminders for upcoming bookings that haven\'t been reminded yet.';

    public function handle()
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
                if ($this->sendWhatsAppReminder($booking, "15 Menit Lagi")) {
                    $booking->update(['reminded_at' => now()]);
                    $this->info("15m Reminder sent to " . $booking->nama);
                }
            } 
            // 10 Minutes Reminder
            elseif ($diffInMinutes <= 10 && $diffInMinutes > 5 && is_null($booking->reminded_at_10)) {
                if ($this->sendWhatsAppReminder($booking, "10 Menit Lagi")) {
                    $booking->update(['reminded_at_10' => now()]);
                    $this->info("10m Reminder sent to " . $booking->nama);
                }
            }
            // 5 Minutes Reminder
            elseif ($diffInMinutes <= 5 && $diffInMinutes > 0 && is_null($booking->reminded_at_5)) {
                if ($this->sendWhatsAppReminder($booking, "5 Menit (SEBENTAR LAGI)")) {
                    $booking->update(['reminded_at_5' => now()]);
                    $this->info("5m Reminder sent to " . $booking->nama);
                }
            }
        }
    }

    private function sendWhatsAppReminder(Transaksi $booking, $intervalLabel = "")
    {
        $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
        $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');
        $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';

        $message = "*PENGINGAT JADWAL BOOKING (" . $intervalLabel . ") - " . strtoupper($namaUsaha) . "*\n\n";
        $message .= "Halo Kak *" . $booking->nama . "*,\n";
        $message .= "Kami ingin mengingatkan jadwal booking Kakak pada:\n\n";
        $message .= "⏰ Jam: *" . $booking->waktu . "*\n";
        $message .= "✂️ Layanan: *" . ($booking->jasa->pluck('nama')->implode(', ') ?: '-') . "*\n";
        $message .= "💇‍♂️ Barber: *" . ($booking->kapster->nama ?? 'Bebas') . "*\n\n";
        $message .= "Mohon datang 10 menit sebelum jadwal ya Kak. Terima kasih! 🙏\n";
        $message .= " https://poseidonbarbershop.my.id ";

        $no_hp = $booking->no_hp;
        if (str_starts_with($no_hp, '0')) {
            $no_hp = '62' . substr($no_hp, 1);
        } elseif (str_starts_with($no_hp, '+')) {
            $no_hp = substr($no_hp, 1);
        }

        try {
            $response = Http::withHeaders(['x-api-key' => $apiKey])
                ->post($baseUrl . '/api/send-message', [
                    'number' => $no_hp,
                    'message' => $message,
                ]);
            
            return $response->successful();
        } catch (\Exception $e) {
            $this->error("Failed to send reminder to {$booking->nama}: " . $e->getMessage());
            return false;
        }
    }
}
