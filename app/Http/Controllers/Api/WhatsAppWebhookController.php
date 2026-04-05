<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaksi;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $remoteJid = $request->input('remoteJid');
        $body = $request->input('body');
        $apiKey = $request->header('X-API-Key');

        // Simple auth check
        if ($apiKey !== config('services.wa_gateway.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$body || !str_starts_with($body, '.')) {
            return response()->json(['status' => 'ignored']);
        }

        $command = strtolower(trim(substr($body, 1)));
        $phone = explode('@', $remoteJid)[0];

        switch ($command) {
            case 'status':
                return $this->handleStatus($remoteJid, $phone);
            case 'info':
                return $this->handleInfo($remoteJid);
            default:
                return response()->json(['status' => 'unknown_command']);
        }
    }

    protected function handleStatus($remoteJid, $phone)
    {
        // Find member by phone (handle both formats: 62 and 0)
        $phoneFormatted = str_starts_with($phone, '62') ? '0' . substr($phone, 2) : $phone;
        
        $member = Member::where('nomor_wa', $phone)
            ->orWhere('nomor_wa', $phoneFormatted)
            ->first();

        if (!$member) {
            return $this->sendWA($remoteJid, "Maaf, nomor Anda belum terdaftar di sistem kami. Silakan lakukan booking di website kami.");
        }

        $transaksi = Transaksi::where('no_hp', $member->nomor_wa)
            ->whereIn('status', ['menunggu', 'proses'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->first();

        if (!$transaksi) {
            return $this->sendWA($remoteJid, "Halo {$member->nama}, saat ini Anda tidak memiliki antrian aktif. Yuk booking sekarang di " . config('app.url'));
        }

        $statusText = $transaksi->status === 'proses' ? "SEDANG DILAYANI" : "MENUNGGU";
        $msg = "Halo {$member->nama}!\n\n*Status Booking Anda:*\n";
        $msg .= "Invoice: #{$transaksi->invoice}\n";
        $msg .= "Layanan: " . ($transaksi->jasa->pluck('nama')->implode(', ') ?: '-') . "\n";
        $msg .= "Waktu: {$transaksi->tanggal} {$transaksi->waktu}\n";
        $msg .= "Status: *{$statusText}*\n\n";
        
        if ($transaksi->status === 'menunggu') {
            $msg .= "Silakan datang tepat waktu ya. Terima kasih!";
        }

        return $this->sendWA($remoteJid, $msg);
    }

    protected function handleInfo($remoteJid)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $namaUsaha = $settings['nama_usaha'] ?? 'AF Barbershop';
        $alamat = $settings['alamat'] ?? '-';
        $jamBuka = $settings['jam_buka'] ?? '-';
        $email = $settings['email'] ?? '-';

        $msg = "*{$namaUsaha}*\n\n";
        $msg .= "📍 *Alamat:*\n{$alamat}\n\n";
        $msg .= "⏰ *Jam Buka:*\n{$jamBuka}\n\n";
        $msg .= "📧 *Email:* {$email}\n\n";
        $msg .= "Booking online di: " . config('app.url');

        return $this->sendWA($remoteJid, $msg);
    }

    protected function sendWA($remoteJid, $message)
    {
        $url = config('services.wa_gateway.url') . '/api/send-message';
        $apiKey = config('services.wa_gateway.api_key');

        try {
            Http::withHeaders(['X-API-Key' => $apiKey])
                ->post($url, [
                    'number' => $remoteJid,
                    'message' => $message,
                ]);
        } catch (\Exception $e) {
            Log::error("WA Webhook failed to send reply: " . $e->getMessage());
        }

        return response()->json(['status' => 'success']);
    }
}
