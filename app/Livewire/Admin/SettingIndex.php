<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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

        $this->checkWaConnection();
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

        // Format nomor jika diawali dengan 0 atau +
        $number = $this->testNumber;
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        } elseif (str_starts_with($number, '+')) {
            $number = substr($number, 1);
        }

        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            $response = Http::withHeaders(['x-api-key' => $apiKey])->post($baseUrl . '/api/send-message', [
                        'number' => $number,
                        'message' => $this->testMessage,
                    ]);

            if ($response->successful()) {
                session()->flash('success_wa', 'Pesan test berhasil dikirim!');
                $this->testMessage = '';
            } else {
                $data = $response->json();
                session()->flash('error_wa', 'Gagal kirim: ' . ($data['message'] ?? 'Unknown error'));
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
