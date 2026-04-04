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
        // Get bookings for today, status 'menunggu', that haven't been reminded, 
        // and are scheduled for the next 2 hours.
        $bookings = Transaksi::where('tanggal', $now->toDateString())
            ->where('status', 'menunggu')
            ->whereNull('reminded_at')
            ->where('waktu', '>=', $now->format('H:i'))
            ->where('waktu', '<=', $now->copy()->addHours(2)->format('H:i'))
            ->get();

        $this->info("Found " . $bookings->count() . " bookings to remind.");

        foreach ($bookings as $booking) {
            if ($this->sendWhatsAppReminder($booking)) {
                $booking->update(['reminded_at' => now()]);
                $this->info("Reminder sent to " . $booking->nama);
            }
        }
    }

    private function sendWhatsAppReminder($booking)
    {
        $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
        $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');
        $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';

        $message = "*PENGINGAT JADWAL BOOKING - " . strtoupper($namaUsaha) . "*\n\n";
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
