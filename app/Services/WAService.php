<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class WAService
{
    protected $baseUrl;
    protected $apiKey;
    protected $namaUsaha;
    protected $teleponUsaha;
    protected $websiteUrl = 'https://poseidonbarbershop.my.id';

    public function __construct()
    {
        $this->baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
        $this->apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');
        $this->namaUsaha = Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';
        $this->teleponUsaha = Setting::where('key', 'telepon')->value('value') ?? '';
    }

    /**
     * Parse template by replacing placeholders with actual data.
     */
    protected function parseTemplate($template, $data = [])
    {
        $common = [
            '{{NAMA_USAHA}}' => $this->namaUsaha,
            '{{WEBSITE}}' => $this->websiteUrl,
            '{{TELEPON_USAHA}}' => $this->teleponUsaha,
        ];

        $allData = array_merge($common, $data);

        return str_replace(array_keys($allData), array_values($allData), $template);
    }

    /**
     * Send a raw message to a specific number.
     */
    public function sendMessage($to, $message)
    {
        if (str_starts_with($to, '0')) {
            $to = '62' . substr($to, 1);
        } elseif (str_starts_with($to, '+')) {
            $to = substr($to, 1);
        }

        try {
            $response = Http::withHeaders(['x-api-key' => $this->apiKey])
                ->post($this->baseUrl . '/api/send-message', [
                    'number' => $to,
                    'message' => $message,
                ]);
            
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('WAService Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send instant booking confirmation.
     */
    public function sendBookingConfirmation(Transaksi $transaksi)
    {
        $template = Setting::where('key', 'wa_tpl_confirmation')->value('value');
        
        if (!$template) {
            $template = "*KONFIRMASI BOOKING - {{NAMA_USAHA}}*\n\n" .
                       "Halo Kak *{{NAMA}}*! Terima kasih telah melakukan booking di {{NAMA_USAHA}}.\n\n" .
                       "Detail Booking:\n" .
                       "📅 Tanggal: *{{TANGGAL}}*\n" .
                       "⏰ Jam: *{{JAM}}*\n" .
                       "✂️ Layanan: *{{LAYANAN}}*\n" .
                       "💇‍♂️ Barber: *{{BARBER}}*\n\n" .
                       "Mohon datang 10 menit sebelum jadwal ya Kak. Kami tunggu kedatangannya! 🙏\n\n" .
                       "{{WEBSITE}}";
        }

        $message = $this->parseTemplate($template, [
            '{{NAMA}}' => $transaksi->nama,
            '{{TANGGAL}}' => Carbon::parse($transaksi->tanggal)->format('d/m/Y'),
            '{{JAM}}' => $transaksi->waktu,
            '{{LAYANAN}}' => $transaksi->jasa->pluck('nama')->implode(', ') ?: '-',
            '{{BARBER}}' => $transaksi->kapster->nama ?? 'Bebas',
        ]);

        return $this->sendMessage($transaksi->no_hp, $message);
    }

    /**
     * Send booking reminder.
     */
    public function sendBookingReminder(Transaksi $transaksi, $label = "")
    {
        $template = Setting::where('key', 'wa_tpl_reminder')->value('value');

        if (!$template) {
            $template = "*PENGINGAT JADWAL BOOKING ({{INTERVAL}}) - {{NAMA_USAHA}}*\n\n" .
                       "Halo Kak *{{NAMA}}*,\n" .
                       "Kami ingin mengingatkan jadwal booking Kakak pada:\n\n" .
                       "⏰ Jam: *{{JAM}}*\n" .
                       "✂️ Layanan: *{{LAYANAN}}*\n" .
                       "💇‍♂️ Barber: *{{BARBER}}*\n\n" .
                       "Mohon datang 10 menit sebelum jadwal ya Kak. Terima kasih! 🙏\n\n" .
                       "{{WEBSITE}}";
        }

        $message = $this->parseTemplate($template, [
            '{{INTERVAL}}' => $label,
            '{{NAMA}}' => $transaksi->nama,
            '{{JAM}}' => $transaksi->waktu,
            '{{LAYANAN}}' => $transaksi->jasa->pluck('nama')->implode(', ') ?: '-',
            '{{BARBER}}' => $transaksi->kapster->nama ?? 'Bebas',
        ]);

        return $this->sendMessage($transaksi->no_hp, $message);
    }

    /**
     * Send electronic receipt.
     */
    public function sendReceipt(Transaksi $transaksi)
    {
        $template = Setting::where('key', 'wa_tpl_receipt')->value('value');

        if (!$template) {
            // Receipt logic is more complex, keeping manual build for now or using a more advanced parser if needed.
            // For now, I'll keep the specialized logic but allow a custom footer/header if possible.
            // Actually, let's keep the specialized build for receipt for now as it has loops.
            return $this->sendSpecializedReceipt($transaksi);
        }

        // If user provided a template, we try to parse it, but standard receipt is complex.
        return $this->sendSpecializedReceipt($transaksi);
    }

    protected function sendSpecializedReceipt(Transaksi $transaksi)
    {
        $alamat = Setting::where('key', 'alamat')->value('value') ?? '';
        
        $pesan = "*FAKTUR ELEKTRONIK TRANSAKSI*\n";
        $pesan .= "*" . strtoupper($this->namaUsaha) . "*\n";
        if ($alamat) $pesan .= $alamat . "\n";
        if ($this->teleponUsaha) $pesan .= $this->teleponUsaha . "\n\n";

        $pesan .= "Nomor Nota :\n";
        $pesan .= $transaksi->invoice . "\n\n";
        $pesan .= "Pelanggan Yth :\n";
        $pesan .= strtoupper($transaksi->nama) . "\n\n";
        $pesan .= "Tanggal : " . $transaksi->created_at->format('d/m/Y H:i') . "\n";
        $pesan .= "Kapster : " . ($transaksi->kapster->nama ?? '-') . "\n";
        $pesan .= "======================\n";
        $pesan .= "Detail pesanan:\n";
        $pesan .= "Layanan:\n";

        foreach ($transaksi->jasa as $j) {
            $pesan .= "✅ " . $j->nama . " (Rp" . number_format($j->harga, 0, ',', '.') . ")\n";
        }

        if ($transaksi->barangs->count() > 0) {
            $pesan .= "\nProduk:\n";
            foreach ($transaksi->barangs as $b) {
                $jml = $b->pivot->jumlah ?? 1;
                $pesan .= "🛒 " . $b->nama . " (x" . $jml . ") = Rp" . number_format($b->harga_jual * $jml, 0, ',', '.') . "\n";
            }
        }

        $pesan .= "\n==============\n";
        $pesan .= "Subtotal : Rp" . number_format($transaksi->total_harga + $transaksi->diskon_total, 0, ',', '.') . "\n";
        if ($transaksi->diskon_total > 0) {
            $pesan .= "Potongan : -Rp" . number_format($transaksi->diskon_total, 0, ',', '.') . "\n";
        }
        $pesan .= "Grand total : Rp" . number_format($transaksi->total_harga, 0, ',', '.') . "\n\n";
        
        if ($transaksi->poin_earned > 0) {
            $pesan .= "🎁 Anda mendapat " . $transaksi->poin_earned . " Poin!\n";
        }
        if ($transaksi->member) {
            $pesan .= "⭐ Level Member: " . $transaksi->member->level . "\n";
            $pesan .= "💰 Total Poin: " . $transaksi->member->poin . "\n";
        }
        $pesan .= "Pembayaran:\n";
        $pesan .= "Uang Bayar : Rp" . number_format($transaksi->uang_bayar, 0, ',', '.') . "\n";
        $pesan .= "Kembali : Rp" . number_format($transaksi->uang_kembali, 0, ',', '.') . "\n\n";
        $pesan .= "Status: " . ($transaksi->uang_bayar >= $transaksi->total_harga ? "Lunas" : "Belum lunas") . "\n";
        $pesan .= "\n=================\n";
        $pesan .= "Kritik, saran dan layanan hubungi: \n" . $this->teleponUsaha . "\n\n";
        $pesan .= $this->websiteUrl . "\n";
        $pesan .= "Terima kasih\n";

        return $this->sendMessage($transaksi->no_hp, $pesan);
    }

    /**
     * Send welcome message to new member.
     */
    public function sendWelcomeMember(Member $member)
    {
        $template = Setting::where('key', 'wa_tpl_welcome')->value('value');

        if (!$template) {
            $template = "*SELAMAT DATANG DI PROGRAM LOYALTY - {{NAMA_USAHA}}*\n\n" .
                       "Halo Kak *{{NAMA}}*! Selamat! Anda kini resmi terdaftar sebagai member kami.\n\n" .
                       "🎁 Benefit Member:\n" .
                       "- Kumpulkan poin setiap transaksi\n" .
                       "- Diskon khusus hari ulang tahun\n" .
                       "- Akses ke promo terbatas (Voucher)\n\n" .
                       "💰 Poin Awal: *{{POIN}}*\n" .
                       "⭐ Level: *{{LEVEL}}*\n\n" .
                       "Kumpulkan terus poinnya dan tukarkan dengan layanan gratis! Terima kasih telah mempercayakan ketampanan Anda pada kami. 🙏\n\n" .
                       "{{WEBSITE}}";
        }

        $message = $this->parseTemplate($template, [
            '{{NAMA}}' => $member->nama,
            '{{POIN}}' => $member->poin,
            '{{LEVEL}}' => $member->level ?? 'Silver',
        ]);

        return $this->sendMessage($member->nomor_wa, $message);
    }

    /**
     * Send rating request after service.
     */
    public function sendRatingRequest(Transaksi $transaksi)
    {
        $template = Setting::where('key', 'wa_tpl_rating')->value('value');

        if (!$template) {
            $template = "*GIMANA HASIL POTONGANNYA, KAK? 💇‍♂️*\n\n" .
                       "Halo Kak *{{NAMA}}*,\n" .
                       "Terima kasih sudah berkunjung ke {{NAMA_USAHA}} hari ini. Kami ingin mendengar pendapat Kakak tentang layanan kami agar kami bisa memberikan yang terbaik ke depannya.\n\n" .
                       "Boleh minta waktu 1 menit untuk memberi rating?\n" .
                       "⭐ {{WEBSITE}}/rate/{{INVOICE}}\n\n" .
                       "Masukan Kakak sangat berarti bagi kami. Sampai jumpa di kunjungan berikutnya! 🙏";
        }

        $message = $this->parseTemplate($template, [
            '{{NAMA}}' => $transaksi->nama,
            '{{INVOICE}}' => $transaksi->invoice,
        ]);

        return $this->sendMessage($transaksi->no_hp, $message);
    }

    /**
     * Send re-activation message for inactive customers.
     */
    public function sendReactivation(Member $member)
    {
        $template = Setting::where('key', 'wa_tpl_reactivation')->value('value');

        if (!$template) {
            $template = "*KAMI RINDU KAKAK! 🥺 - {{NAMA_USAHA}}*\n\n" .
                       "Halo Kak *{{NAMA}}*,\n" .
                       "Sudah 30 hari nih sejak kunjungan terakhir Kakak di {{NAMA_USAHA}}. Rambut sepertinya sudah mulai panjang lagi nih Kak? 😁\n\n" .
                       "Khusus buat Kakak, gunakan kode promo: *RINDU* untuk dapatkan potongan Rp5.000 pada kunjungan berikutnya!\n\n" .
                       "Booking sekarang biar nggak antri:\n" .
                       "📅 {{WEBSITE}}\n\n" .
                       "Sampai ketemu lagi di kursi barber! ✂️";
        }

        $message = $this->parseTemplate($template, [
            '{{NAMA}}' => $member->nama,
        ]);

        return $this->sendMessage($member->nomor_wa, $message);
    }

    /**
     * Send generic test message.
     */
    public function sendTestMessage($to)
    {
        $pesan = "*TEST KONEKSI WA GATEWAY - " . strtoupper($this->namaUsaha) . "*\n\n";
        $pesan .= "Halo! Ini adalah pesan pengetesan untuk memastikan sistem WhatsApp Gateway Anda sudah terhubung dengan benar.\n\n";
        $pesan .= "Waktu Test: " . now()->format('d/m/Y H:i:s') . "\n";
        $pesan .= "Status: SUKSES ✅";

        return $this->sendMessage($to, $pesan);
    }
}
