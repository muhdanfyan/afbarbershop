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
        if ($this->status === 'selesai') {
            $this->dispatch('swal-error', ['message' => 'Transaksi sudah selesai, tidak bisa diubah!']);
            return;
        }
        try {
            $this->validate([
                'nama' => 'required',
                'no_hp' => 'required',
                'jasa' => 'required|array|min:1',
                'kapster' => 'required',
            ]);
            if ($this->uang_bayar === null || $this->uang_bayar === '' || !is_numeric($this->uang_bayar)) {
                $this->uang_bayar = 0;
            }
            if ($this->uang_kembali === null || $this->uang_kembali === '' || !is_numeric($this->uang_kembali)) {
                $this->uang_kembali = 0;
            }
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
                $transaksi = Transaksi::findOrFail($this->trxId);
                $transaksi->update([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'status' => 'menunggu',
                ]);
                $transaksi->jasa()->sync($this->jasa);
            } else {
                $transaksi = Transaksi::create([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'jasa_id' => is_array($this->jasa) && count($this->jasa) === 1 ? $this->jasa[0] : null,
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'jumlah' => 1,
                    'status' => 'menunggu',
                ]);
                $transaksi->jasa()->attach($this->jasa);
            }
            $this->dispatch('swal-success', ['message' => 'Transaksi disimpan sebagai MENUNGGU!']);
            $this->dispatch('transaksi-updated');
            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }
    public function prosesTransaksi()
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
                'kapster' => 'required',
            ]);
            if ($this->uang_bayar === null || $this->uang_bayar === '' || !is_numeric($this->uang_bayar)) {
                $this->uang_bayar = 0;
            }
            if ($this->uang_kembali === null || $this->uang_kembali === '' || !is_numeric($this->uang_kembali)) {
                $this->uang_kembali = 0;
            }
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
                $transaksi = Transaksi::findOrFail($this->trxId);
                $transaksi->update([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'status' => 'proses',
                ]);
                $transaksi->jasa()->sync($this->jasa);
            } else {
                $transaksi = Transaksi::create([
                    'invoice' => $this->invoice,
                    'nama' => $this->nama,
                    'no_hp' => $this->no_hp,
                    'jasa_id' => is_array($this->jasa) && count($this->jasa) === 1 ? $this->jasa[0] : null,
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
                    'kasir_id' => Auth::id(),
                    'tanggal' => now()->toDateString(),
                    'jumlah' => 1,
                    'status' => 'proses',
                ]);
                $transaksi->jasa()->attach($this->jasa);
            }
            $this->dispatch('swal-success', ['message' => 'Transaksi disimpan sebagai PROSES!']);
            $this->dispatch('transaksi-updated');
            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }
    public $trxId = null;
    public $showRandomInvoice = false;
    public $randomInvoiceDisplay = null;

    public function isiFormDariTransaksi($id)
    {
        $trx = Transaksi::with(['jasa'])->findOrFail($id);
        $this->trxId = $trx->id;
        $this->invoice = $trx->invoice;
        $this->nama = $trx->nama;
        $this->no_hp = $trx->no_hp;
        $this->jasa = $trx->jasa->pluck('id')->toArray();
        $this->kapster = $trx->kapster_id;
        $this->uang_bayar = $trx->uang_bayar;
        $this->uang_kembali = $trx->uang_kembali;
        $this->total = $trx->total_harga;
        $this->status = $trx->status;
        // Generate random invoice for display only
        $this->showRandomInvoice = true;
        $this->randomInvoiceDisplay = 'NOTA-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }
    public $invoice;
    public $nama;
    public $no_hp;
    public $jasa = [];
    public $kapster;
    public $uang_bayar;
    public $uang_kembali;
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

    public function updatedUangBayar()
    {
        $uangBayar = is_numeric($this->uang_bayar) ? (float) $this->uang_bayar : 0;
        $total = is_numeric($this->total) ? (float) $this->total : 0;
        $this->uang_kembali = $uangBayar - $total;
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
        $this->updatedUangBayar();
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
                'kapster' => 'required',
                'uang_bayar' => 'required|numeric|min:' . $this->total,
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
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
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
                    'kapster_id' => $this->kapster,
                    'total_harga' => $this->total,
                    'uang_bayar' => $this->uang_bayar,
                    'uang_kembali' => $this->uang_kembali,
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
        $this->kapster = '';
        $this->uang_bayar = 0;
        $this->uang_kembali = 0;
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
            $baseUrl = env('WA_GATEWAY_URL', 'http://127.0.0.1:3001');
            $apiKey = env('WA_GATEWAY_API_KEY', 'AFBARBERSHOP_SECRET_KEY_123');

            $namaUsaha = \App\Models\Setting::where('key', 'nama_usaha')->value('value') ?? 'AF Barbershop';
            $alamat = \App\Models\Setting::where('key', 'alamat')->value('value') ?? '';
            $telepon = \App\Models\Setting::where('key', 'telepon')->value('value') ?? '';

            $pesan = "*FAKTUR ELEKTRONIK TRANSAKSI*\n";
            $pesan .= "*" . strtoupper($namaUsaha) . "*\n";
            if ($alamat)
                $pesan .= $alamat . "\n";
            if ($telepon)
                $pesan .= $telepon . "\n\n";

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

            // Format nomor hp
            $no_hp = $transaksi->no_hp;
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
            \Log::error('Gagal kirim struk WA: ' . $e->getMessage());
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
        // Booking selain hari ini juga tampil (Item 6) & Urut DESC berdasarkan jam (Item 7)
        $transaksiBooking = Transaksi::where('status', 'menunggu')
            ->where('tanggal', '>=', $today)
            ->orderBy('tanggal', 'desc')
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
