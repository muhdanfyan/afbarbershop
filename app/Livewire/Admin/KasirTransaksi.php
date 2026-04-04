<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Barang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class KasirTransaksi extends Component
{
    public function menungguTransaksi()
    {
        $this->saveTransactionWithStatus('menunggu');
    }

    public function prosesTransaksi()
    {
        $this->saveTransactionWithStatus('proses');
    }

    private function saveTransactionWithStatus($newStatus)
    {
        if ($this->status === 'selesai') {
            $this->dispatch('swal-error', ['message' => 'Transaksi sudah selesai, tidak bisa diubah!']);
            return;
        }

        try {
            $this->validate([
                'nama' => 'required',
                'no_hp' => 'required',
                'jasa' => 'required|array|min:1',
                'kapster_id' => 'required',
            ]);

            if ($this->bayar === null || $this->bayar === '' || !is_numeric($this->bayar)) {
                $this->bayar = 0;
            }
            if ($this->kembali === null || $this->kembali === '' || !is_numeric($this->kembali)) {
                $this->kembali = 0;
            }

            $member = Member::firstOrCreate(
                ['nama' => $this->nama, 'nomor_wa' => $this->no_hp],
                ['alamat' => null]
            );

            $data = [
                'invoice' => $this->invoice ?: 'OTW-' . now()->format('YmdHis'),
                'nama' => $this->nama,
                'no_hp' => $this->no_hp,
                'kapster_id' => $this->kapster_id,
                'total_harga' => $this->total,
                'uang_bayar' => $this->bayar,
                'uang_kembali' => $this->kembali,
                'metode_pembayaran' => $this->metode_pembayaran,
                'kasir_id' => Auth::id(),
                'tanggal' => now()->toDateString(),
                'status' => $newStatus,
            ];

            if ($this->trxId) {
                $transaksi = Transaksi::findOrFail($this->trxId);
                $transaksi->update($data);
                $transaksi->jasa()->sync($this->jasa);
            } else {
                $data['jumlah'] = 1;
                $data['jasa_id'] = count($this->jasa) === 1 ? $this->jasa[0] : null;
                $transaksi = Transaksi::create($data);
                $transaksi->jasa()->attach($this->jasa);
            }

            $this->dispatch('swal-success', ['message' => 'Transaksi disimpan sebagai ' . strtoupper($newStatus) . '!']);
            $this->dispatch('transaksi-updated');
            $this->resetForm();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }

    public $trxId = null;
    public $showRandomInvoice = false;
    public $randomInvoiceDisplay = null;

    public function isiFormDariTransaksi($id)
    {
        $trx = Transaksi::with(['jasa', 'barangs'])->findOrFail($id);
        $this->trxId = $trx->id;
        $this->invoice = $trx->invoice;
        $this->nama = $trx->nama;
        $this->no_hp = $trx->no_hp;
        $this->jasa = $trx->jasa->pluck('id')->toArray();
        $this->kapster_id = $trx->kapster_id;
        $this->bayar = $trx->uang_bayar;
        $this->kembali = $trx->uang_kembali;
        $this->metode_pembayaran = $trx->metode_pembayaran ?: 'cash';
        $this->total = $trx->total_harga;
        $this->status = $trx->status;
        $this->barangSelected = $trx->barangs->pluck('id')->toArray();
        $this->jumlahBarang = [];
        foreach($trx->barangs as $b) {
            $this->jumlahBarang[$b->id] = $b->pivot->jumlah;
        }

        // Generate random invoice for display only
        $this->showRandomInvoice = true;
        $this->randomInvoiceDisplay = 'NOTA-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
    public $invoice;
    public $nama;
    public $no_hp;
    public $jasa = [];
    public $kapster_id;
    public $bayar;
    public $kembali = 0;
    public $metode_pembayaran = 'cash';
    public $total = 0;
    public $memberSearch = '';
    public $status;
    public $barangSelected = [];
    public $jumlahBarang = []; // [id => jumlah]

    public function mount()
    {
        // Invoice tidak di-generate di sini lagi
    }

    public function generateInvoice()
    {
        $this->invoice = 'NOTA-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }

    public function updatedJasa()
    {
        $this->hitungTotal();
    }

    public function updatedBayar()
    {
        $bayar = is_numeric($this->bayar) ? (float) $this->bayar : 0;
        $total = is_numeric($this->total) ? (float) $this->total : 0;
        $this->kembali = $bayar - $total;
    }

    public function hitungTotal()
    {
        $this->total = 0;
        foreach ($this->jasa as $jasaId) {
            $jasa = Jasa::find($jasaId);
            if ($jasa) {
                $this->total += $jasa->harga;
            }
        }
        foreach ($this->barangSelected as $barangId) {
            $barang = Barang::find($barangId);
            if ($barang) {
                $jumlah = $this->jumlahBarang[$barangId] ?? 1;
                $this->total += ($barang->harga_jual * $jumlah);
            }
        }
        $this->updatedBayar();
    }

    public function simpanTransaksi()
    {
        if ($this->status === 'selesai') {
            $this->dispatch('swal-error', ['message' => 'Transaksi sudah selesai tidak bisa diubah!']);
            $this->resetForm();
            return;
        }
        try {
            $this->validate([
                'nama' => 'required',
                'no_hp' => 'required',
                'jasa' => 'required|array|min:1',
                'kapster_id' => 'required',
                'bayar' => 'required|numeric' . ($this->metode_pembayaran === 'cash' ? '|min:' . $this->total : ''),
            ]);

            // Generate invoice/nota hanya saat simpan jika ini transaksi baru
            if (!$this->trxId) {
                $this->generateInvoice();
            }

            // Tambahkan ke tabel members jika belum ada
            $member = Member::firstOrCreate(
                [
                    'nama' => $this->nama,
                    'nomor_wa' => $this->no_hp
                ],
                [
                    'alamat' => null
                ]
            );
            if ($this->trxId) {
                // Update transaksi jika sudah ada
                $transaksi = Transaksi::findOrFail($this->trxId);
                $transaksi->update([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'kapster_id' => $this->kapster_id,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->bayar,
                    'uang_kembali' => $this->kembali,
                    'metode_pembayaran' => $this->metode_pembayaran,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'status' => 'selesai',
                ]);
                $transaksi->jasa()->sync($this->jasa);
                
                // Sync barangs and reduce stock
                $barangSyncData = [];
                foreach ($this->barangSelected as $bId) {
                    $jml = $this->jumlahBarang[$bId] ?? 1;
                    $barangSyncData[$bId] = ['jumlah' => $jml];
                }
                $transaksi->barangs()->sync($barangSyncData);
            } else {
                // Buat transaksi baru
                $transaksi = Transaksi::create([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'jasa_id' => is_array($this->jasa) && count($this->jasa) === 1 ? $this->jasa[0] : null,
                    'kapster_id' => $this->kapster_id,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->bayar,
                    'uang_kembali' => $this->kembali,
                    'metode_pembayaran' => $this->metode_pembayaran,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'jumlah' => 1,
                    'status' => 'selesai',
                ]);
                $transaksi->jasa()->attach($this->jasa);
                
                foreach ($this->barangSelected as $bId) {
                    $jml = $this->jumlahBarang[$bId] ?? 1;
                    $transaksi->barangs()->attach($bId, ['jumlah' => $jml]);
                }
            }

            // REDUCE STOCK logic
            foreach ($this->barangSelected as $bId) {
                $barang = Barang::find($bId);
                if ($barang) {
                    $jml = $this->jumlahBarang[$bId] ?? 1;
                    $barang->stok = $barang->stok - $jml;
                    $barang->save();
                }
            }

            // $this->dispatch('print-struk', ['invoice' => $this->invoice]);
            $this->kirimStrukWa($transaksi);
            $this->dispatch('swal-success', ['message' => 'Transaksi berhasil disimpan & Stok dikurangi!']);
            $this->resetForm();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }

    public function resetForm()
    {
        $this->trxId = null;
        $this->invoice = null;
        $this->nama = '';
        $this->no_hp = '';
        $this->jasa = [];
        $this->kapster_id = '';
        $this->bayar = 0;
        $this->kembali = 0;
        $this->metode_pembayaran = 'cash';
        $this->total = 0;
        $this->status = null;
        $this->barangSelected = [];
        $this->jumlahBarang = [];
        $this->showRandomInvoice = false;
        $this->randomInvoiceDisplay = null;
        $this->dispatch('close-modal');
    }

    public function hapusTransaksi()
    {
        if ($this->trxId) {
            $transaksi = Transaksi::findOrFail($this->trxId);

            if ($transaksi->status === 'selesai') {
                $this->dispatch('swal-error', ['message' => 'Transaksi yang sudah selesai tidak bisa dihapus!']);
                return;
            }

            $transaksi->jasa()->detach();
            $transaksi->delete();

            $this->dispatch('swal-success', ['message' => 'Transaksi berhasil dibatalkan!']);
            $this->resetForm();
        } else {
            $this->resetForm();
        }
    }

    public function kirimStrukWa($transaksi)
    {
        try {
            $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';
            $alamat = \App\Models\Setting::where('key', 'alamat')->value('value') ?? '';
            $telepon = \App\Models\Setting::where('key', 'telepon')->value('value') ?? '';

            $pesan = "*FAKTUR ELEKTRONIK TRANSAKSI*\n";
            $pesan .= "*" . strtoupper($namaUsaha) . "*\n";
            if ($alamat) $pesan .= $alamat . "\n";
            if ($telepon) $pesan .= $telepon . "\n\n";

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
                $pesan .= "✅ " . $j->nama . "\n";
                $pesan .= "@ Rp" . number_format($j->harga, 0, ',', '.') . ", Total Rp" . number_format($j->harga, 0, ',', '.') . "\n";
            }

            if ($transaksi->barangs->count() > 0) {
                $pesan .= "\nProduk:\n";
                foreach ($transaksi->barangs as $b) {
                    $jml = $b->pivot->jumlah ?? 1;
                    $pesan .= "🛒 " . $b->nama . " (x" . $jml . ")\n";
                    $pesan .= "@ Rp" . number_format($b->harga_jual, 0, ',', '.') . ", Total Rp" . number_format($b->harga_jual * $jml, 0, ',', '.') . "\n";
                }
            }

            $pesan .= "\n==============\n";
            $pesan .= "Detail biaya :\n";
            $pesan .= "Total tagihan : Rp" . number_format($transaksi->total_harga, 0, ',', '.') . "\n";
            $pesan .= "Grand total : Rp" . number_format($transaksi->total_harga, 0, ',', '.') . "\n\n";
            $pesan .= "Pembayaran:\n";
            $pesan .= "Uang Bayar : Rp" . number_format($transaksi->uang_bayar, 0, ',', '.') . "\n";
            $pesan .= "Kembali : Rp" . number_format($transaksi->uang_kembali, 0, ',', '.') . "\n\n";
            $pesan .= "Status: " . ($transaksi->uang_bayar >= $transaksi->total_harga ? "Lunas" : "Belum lunas") . "\n";
            $pesan .= "\n=================\n";
            $pesan .= "Kritik, saran dan layanan hubungi: \n" . $telepon . "\n\n";
            $pesan .= " https://poseidonbarbershop.my.id \n";
            $pesan .= "Terima kasih\n";

            $this->sendWaMessage($transaksi->no_hp, $pesan);
        } catch (\Exception $e) {
            \Log::error('Gagal kirim struk WA: ' . $e->getMessage());
        }
    }

    public function kirimPengingatWa($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';
            
            $pesan = "*PENGINGAT BOOKING - " . strtoupper($namaUsaha) . "*\n\n";
            $pesan .= "Halo Kak *" . $transaksi->nama . "*,\n";
            $pesan .= "Kami ingin mengingatkan jadwal booking Kakak pada:\n\n";
            $pesan .= "📅 Tanggal: *" . \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') . "*\n";
            $pesan .= "⏰ Jam: *" . $transaksi->waktu . "*\n";
            $pesan .= "✂️ Layanan: *" . ($transaksi->jasa->pluck('nama')->implode(', ') ?: '-') . "*\n";
            $pesan .= "💇‍♂️ Barber: *" . ($transaksi->kapster->nama ?? 'Bebas') . "*\n\n";
            $pesan .= "Mohon datang 10 menit sebelum jadwal ya Kak. Terima kasih! 🙏\n";
            $pesan .= " https://poseidonbarbershop.my.id ";

            $this->sendWaMessage($transaksi->no_hp, $pesan);
            $transaksi->update(['reminded_at' => now()]);
            $this->dispatch('swal-success', ['message' => 'Pengingat WA berhasil dikirim!']);
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Gagal kirim pengingat: ' . $e->getMessage()]);
        }
    }

    private function sendWaMessage($no_hp, $pesan)
    {
        try {
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            // Format nomor hp
            if (str_starts_with($no_hp, '0')) {
                $no_hp = '62' . substr($no_hp, 1);
            } elseif (str_starts_with($no_hp, '+')) {
                $no_hp = substr($no_hp, 1);
            }

            Http::withHeaders([
                'x-api-key' => $apiKey
            ])->post($baseUrl . '/api/send-message', [
                'number' => $no_hp,
                'message' => $pesan,
            ]);
        } catch (\Exception $e) {
            \Log::error('WA API Error: ' . $e->getMessage());
        }
    }

    public function toggleJasa($id)
    {
        if ($this->status === 'selesai') {
            return;
        }
        $jasa = $this->jasa;
        if (($key = array_search($id, $jasa)) !== false) {
            unset($jasa[$key]);
        } else {
            $jasa[] = $id;
        }
        $this->jasa = array_values($jasa);
        $this->hitungTotal();
    }

    public function toggleBarang($id)
    {
        if ($this->status === 'selesai') {
            return;
        }
        if (($key = array_search($id, $this->barangSelected)) !== false) {
            unset($this->barangSelected[$key]);
            unset($this->jumlahBarang[$id]);
        } else {
            $this->barangSelected[] = $id;
            $this->jumlahBarang[$id] = 1;
        }
        $this->barangSelected = array_values($this->barangSelected);
        $this->hitungTotal();
    }

    public function updateJumlahBarang($id, $jumlah)
    {
        if ($this->status === 'selesai') {
            return;
        }
        $this->jumlahBarang[$id] = $jumlah;
        $this->hitungTotal();
    }

    public function render()
    {
        $listMember = Member::select('nama', 'nomor_wa')->orderBy('nama')->get();
        $today = now()->toDateString();
        // Booking selain hari ini juga tampil (Item 6) & Urut ASC berdasarkan jam (Item 7 - Improved for priority)
        $transaksiBooking = Transaksi::where('status', 'menunggu')
            ->where('tanggal', '>=', $today)
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'desc')
            ->get();
        $transaksiProses = Transaksi::where('status', 'proses')
            ->where('tanggal', $today)
            ->orderBy('waktu', 'desc')
            ->get();
        $transaksiSelesai = Transaksi::where('status', 'selesai')
            ->where('tanggal', $today)
            ->orderBy('waktu', 'desc')
            ->get();
        $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';

        return view('livewire.admin.kasir-transaksi', [
            'listJasa' => Jasa::all(),
            'selectedJasaItems' => Jasa::whereIn('id', collect($this->jasa)->map(fn($id) => (int) $id)->toArray())->get(),
            'listBarang' => Barang::where('stok', '>', 0)->get(),
            'selectedBarangItems' => Barang::whereIn('id', collect($this->barangSelected)->map(fn($id) => (int) $id)->toArray())->get(),
            'listKapster' => Kapster::where('status', 'bekerja')->get(),
            'listMember' => $listMember,
            'transaksiBooking' => $transaksiBooking,
            'transaksiProses' => $transaksiProses,
            'transaksiSelesai' => $transaksiSelesai,
            'nama_usaha' => $namaUsaha,
        ])->layout('layouts.fullscreen');
    }
}
