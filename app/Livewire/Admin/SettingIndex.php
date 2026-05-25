<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Services\WAService;

class SettingIndex extends Component
{
    use WithFileUploads;

    public $nama_usaha;
    public $alamat;
    public $telepon;
    public $email;
    public $jam_buka;
    public $slogan;
    public $youtube_playlist_id;
    public $logo;
    public $logo_lama;

    public $qrImage;
    public $waStatus;
    public $waConnected = false;
    public $waNumber;
    public $testNumber;
    public $testMessage;

    // WA Templates
    public $wa_tpl_confirmation;
    public $wa_tpl_reminder;
    public $wa_tpl_receipt;
    public $wa_tpl_welcome;
    public $wa_tpl_rating;
    public $wa_tpl_reactivation;

    // UI States for Modal
    public $editingTplKey;
    public $editingTplTitle;
    public $editingTplIcon;

    public function mount()
    {
        $this->nama_usaha = Setting::where('key', 'nama_usaha')->value('value') ?? '';
        $this->alamat = Setting::where('key', 'alamat')->value('value') ?? '';
        $this->telepon = Setting::where('key', 'telepon')->value('value') ?? '';
        $this->email = Setting::where('key', 'email')->value('value') ?? '';
        $this->jam_buka = Setting::where('key', 'jam_buka')->value('value') ?? '';
        $this->slogan = Setting::where('key', 'slogan')->value('value') ?? '';
        $this->youtube_playlist_id = Setting::where('key', 'youtube_playlist_id')->value('value') ?? 'PLx0sYbCqOb8TBPRdmBHs5Iftvv9TPboYG';
        $this->logo = Setting::where('key', 'logo')->value('value') ?? null;
        $this->logo_lama = $this->logo;

        $this->wa_tpl_confirmation = Setting::where('key', 'wa_tpl_confirmation')->value('value');
        if (!$this->wa_tpl_confirmation) {
            $this->wa_tpl_confirmation = "*KONFIRMASI BOOKING - {{NAMA_USAHA}}*\n\nHalo Kak *{{NAMA}}*! Terima kasih telah melakukan booking di {{NAMA_USAHA}}.\n\nDetail Booking:\n📅 Tanggal: *{{TANGGAL}}*\n⏰ Jam: *{{JAM}}*\n✂️ Layanan: *{{LAYANAN}}*\n💇‍♂️ Barber: *{{BARBER}}*\n\nMohon datang 10 menit sebelum jadwal ya Kak. Kami tunggu kedatangannya! 🙏\n\n{{WEBSITE}}";
        }

        $this->wa_tpl_reminder = Setting::where('key', 'wa_tpl_reminder')->value('value');
        if (!$this->wa_tpl_reminder) {
            $this->wa_tpl_reminder = "*PENGINGAT JADWAL BOOKING ({{INTERVAL}}) - {{NAMA_USAHA}}*\n\nHalo Kak *{{NAMA}}*,\nKami ingin mengingatkan jadwal booking Kakak pada:\n\n⏰ Jam: *{{JAM}}*\n✂️ Layanan: *{{LAYANAN}}*\n💇‍♂️ Barber: *{{BARBER}}*\n\nMohon datang 10 menit sebelum jadwal ya Kak. Terima kasih! 🙏\n\n{{WEBSITE}}";
        }

        $this->wa_tpl_receipt = Setting::where('key', 'wa_tpl_receipt')->value('value') ?? "";
        
        $this->wa_tpl_welcome = Setting::where('key', 'wa_tpl_welcome')->value('value');
        if (!$this->wa_tpl_welcome) {
            $this->wa_tpl_welcome = "*SELAMAT DATANG DI PROGRAM LOYALTY - {{NAMA_USAHA}}*\n\nHalo Kak *{{NAMA}}*! Selamat! Anda kini resmi terdaftar sebagai member kami.\n\n🎁 Benefit Member:\n- Kumpulkan poin setiap transaksi\n- Diskon khusus hari ulang tahun\n- Akses ke promo terbatas (Voucher)\n\n💰 Poin Awal: *{{POIN}}*\n⭐ Level: *{{LEVEL}}*\n\nKumpulkan terus poinnya dan tukarkan dengan layanan gratis! Terima kasih telah mempercayakan ketampanan Anda pada kami. 🙏\n\n{{WEBSITE}}";
        }

        $this->wa_tpl_rating = Setting::where('key', 'wa_tpl_rating')->value('value');
        if (!$this->wa_tpl_rating) {
            $this->wa_tpl_rating = "*GIMANA HASIL POTONGANNYA, KAK? 💇‍♂️*\n\nHalo Kak *{{NAMA}}*,\nTerima kasih sudah berkunjung ke {{NAMA_USAHA}} hari ini. Kami ingin mendengar pendapat Kakak tentang layanan kami agar kami bisa memberikan yang terbaik ke depannya.\n\nBoleh minta waktu 1 menit untuk memberi rating?\n⭐ {{WEBSITE}}/rate/{{INVOICE}}\n\nMasukan Kakak sangat berarti bagi kami. Sampai jumpa di kunjungan berikutnya! 🙏";
        }

        $this->wa_tpl_reactivation = Setting::where('key', 'wa_tpl_reactivation')->value('value');
        if (!$this->wa_tpl_reactivation) {
            $this->wa_tpl_reactivation = "*KAMI RINDU KAKAK! 🥺 - {{NAMA_USAHA}}*\n\nHalo Kak *{{NAMA}}*,\nSudah 30 hari nih sejak kunjungan terakhir Kakak di {{NAMA_USAHA}}. Rambut sepertinya sudah mulai panjang lagi nih Kak? 😁\n\nKhusus buat Kakak, gunakan kode promo: *RINDU* untuk dapatkan potongan Rp5.000 pada kunjungan berikutnya!\n\nBooking sekarang biar nggak antri:\n📅 {{WEBSITE}}\n\nSampai ketemu lagi di kursi barber! ✂️";
        }

        $this->checkWaConnection();
    }

    public function editTemplate($key, $title, $icon)
    {
        $this->editingTplKey = $key;
        $this->editingTplTitle = $title;
        $this->editingTplIcon = $icon;
        
        $this->dispatch('open-wa-modal');
    }

    public function checkWaConnection()
    {
        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');
            $response = Http::withHeaders(['x-api-key' => $apiKey])->get($baseUrl . '/');
            if ($response->successful()) {
                $data = $response->json();
                $this->waStatus = $data['status'];
                $this->waConnected = $data['connected'];
                $this->waNumber = $data['user']['id'] ?? null;

                if ($this->waNumber) {
                    $this->waNumber = explode(':', $this->waNumber)[0];
                }

                if (!$this->waConnected && $data['hasQr']) {
                    $this->getQrCode();
                }
            } else {
                $this->waStatus = 'Error connecting to Gateway';
                $this->waConnected = false;
            }
        } catch (\Exception $e) {
            $this->waStatus = 'Gateway Offline';
            $this->waConnected = false;
        }
    }

    public function getQrCode()
    {
        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            $response = Http::withHeaders(['x-api-key' => $apiKey])->get($baseUrl . '/api/qr');

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    $this->qrImage = $data['qrImage'];
                }
            }
        } catch (\Exception $e) {
            // Handle error
        }
    }

    public function reconnectWa()
    {
        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            Http::withHeaders(['x-api-key' => $apiKey])->post($baseUrl . '/api/reconnect');

            $this->checkWaConnection();
        } catch (\Exception $e) {
            // Handle error
        }
    }

    public function logoutWa()
    {
        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            Http::withHeaders(['x-api-key' => $apiKey])->post($baseUrl . '/api/logout');

            $this->qrImage = null;
            $this->checkWaConnection();
        } catch (\Exception $e) {
            // Handle error
        }
    }

    public function testSendWa()
    {
        if (!$this->testNumber || !$this->testMessage) {
            session()->flash('error_wa', 'Nomor dan pesan harus diisi!');
            return;
        }

        try {
            $waService = app(WAService::class);
            if ($waService->sendMessage($this->testNumber, $this->testMessage)) {
                session()->flash('success_wa', 'Pesan test berhasil dikirim!');
                $this->testMessage = '';
            } else {
                session()->flash('error_wa', 'Gagal kirim: Cek koneksi Gateway atau API Key');
            }
        } catch (\Exception $e) {
            session()->flash('error_wa', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatedTestNumber($value)
    {
        if ($value === '081242871122') {
            if (!$this->testMessage) {
                $this->testMessage = 'Halo! Ini adalah pesan test otomatis dari sistem ' . ($this->nama_usaha ?? 'AF Barbershop') . '.';
            }
            $this->testSendWa();
        }
    }

    public function simpanSetting()
    {
        $fields = [
            'nama_usaha' => $this->nama_usaha,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'jam_buka' => $this->jam_buka,
            'slogan' => $this->slogan,
            'youtube_playlist_id' => $this->youtube_playlist_id,
            'wa_tpl_confirmation' => $this->wa_tpl_confirmation,
            'wa_tpl_reminder' => $this->wa_tpl_reminder,
            'wa_tpl_receipt' => $this->wa_tpl_receipt,
            'wa_tpl_welcome' => $this->wa_tpl_welcome,
            'wa_tpl_rating' => $this->wa_tpl_rating,
            'wa_tpl_reactivation' => $this->wa_tpl_reactivation,
        ];
        // Handle upload logo
        $logoPath = $this->logo_lama;
        if ($this->logo) {
            if ($this->logo_lama && \Storage::disk('public')->exists($this->logo_lama)) {
                \Storage::disk('public')->delete($this->logo_lama);
            }
            $logoPath = $this->logo->store('logos', 'public');
        }
        $fields['logo'] = $logoPath;
        foreach ($fields as $key => $value) {
            Setting::updateOrInsert(['key' => $key], ['value' => $value]);
        }
        session()->flash('success', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        $logo_lama = Setting::where('key', 'logo')->value('value') ?? null;
        return view('livewire.admin.setting', ['logo_lama' => $logo_lama]);
    }
}
