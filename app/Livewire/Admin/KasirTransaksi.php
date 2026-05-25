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
use App\Services\LoyaltyService;
use App\Services\PromoService;
use App\Services\WAService;

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
                ['nomor_wa' => $this->no_hp],
                ['nama' => $this->nama, 'alamat' => null]
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
                'tanggal' => $this->tanggal ?: now()->toDateString(),
                'waktu' => $this->waktu ?: now()->format('H:i'),
                'kursi_id' => $this->kursi_id,
                'status' => $newStatus,
                'member_id' => $member->id,
            ];

            // Validation: Kursi availability
            if ($this->kursi_id) {
                $exists = Transaksi::where('kursi_id', $this->kursi_id)
                    ->where('tanggal', $this->tanggal)
                    ->where('waktu', $this->waktu)
                    ->where('id', '!=', $this->trxId)
                    ->where('status', '!=', 'batal')
                    ->exists();
                if ($exists) {
                    $this->dispatch('swal-error', ['message' => 'Kursi sudah dipesan untuk waktu tersebut!']);
                    return;
                }
            }

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
        $this->kursi_id = $trx->kursi_id;
        $this->tanggal = $trx->tanggal;
        $this->waktu = $trx->waktu;
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
    public $kursi_id;
    public $tanggal;
    public $waktu;

    // Loyalty & Promo
    public $member_id;
    public $poinPunya = 0;
    public $poinGunakan = 0;
    public $voucherCode = '';
    public $diskonTotal = 0;
    public $diskonPoin = 0;
    public $diskonVoucher = 0;
    public $voucher_id = null;
    public $subtotal = 0;

    public function mount()
    {
        $this->tanggal = now()->toDateString();
        $this->waktu = now()->format('H:i');
    }

    public function generateInvoice()
    {
        $this->invoice = 'NOTA-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
    }

    public function updatedNoHp()
    {
        $member = Member::where('nomor_wa', $this->no_hp)->first();
        if ($member) {
            $this->member_id = $member->id;
            $this->nama = $member->nama;
            $this->poinPunya = $member->poin;
        } else {
            $this->member_id = null;
            $this->poinPunya = 0;
        }
    }

    public function applyVoucher(PromoService $promoService)
    {
        try {
            $voucher = $promoService->validateVoucher($this->voucherCode, $this->subtotal);
            $this->voucher_id = $voucher->id;
            $this->diskonVoucher = $promoService->calculateDiscount($voucher, $this->subtotal);
            $this->dispatch('swal-success', ['message' => 'Voucher berhasil digunakan! Potongan: Rp ' . number_format($this->diskonVoucher, 0, ',', '.')]);
            $this->hitungTotal();
        } catch (\Exception $e) {
            $this->voucher_id = null;
            $this->diskonVoucher = 0;
            $this->dispatch('swal-error', ['message' => $e->getMessage()]);
            $this->hitungTotal();
        }
    }

    public function updatedPoinGunakan()
    {
        if ($this->poinGunakan > $this->poinPunya) {
            $this->poinGunakan = $this->poinPunya;
        }
        if ($this->poinGunakan < 0) {
            $this->poinGunakan = 0;
        }
        
        // 1 poin = Rp 1.000
        $this->diskonPoin = $this->poinGunakan * 1000;
        
        // Cek agar diskon tidak melebihi subtotal
        if ($this->diskonPoin > ($this->subtotal - $this->diskonVoucher)) {
             $this->diskonPoin = max(0, $this->subtotal - $this->diskonVoucher);
             $this->poinGunakan = floor($this->diskonPoin / 1000);
             $this->diskonPoin = $this->poinGunakan * 1000;
        }

        $this->hitungTotal();
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
        $this->subtotal = 0;
        foreach ($this->jasa as $jasaId) {
            $jasa = Jasa::find($jasaId);
            if ($jasa) {
                $this->subtotal += $jasa->harga;
            }
        }
        foreach ($this->barangSelected as $barangId) {
            $barang = Barang::find($barangId);
            if ($barang) {
                $jumlah = $this->jumlahBarang[$barangId] ?? 1;
                $this->subtotal += ($barang->harga_jual * $jumlah);
            }
        }
        
        $this->diskonTotal = $this->diskonPoin + $this->diskonVoucher;
        $this->total = max(0, $this->subtotal - $this->diskonTotal);
        
        $this->updatedBayar();
    }

    public function simpanTransaksi(LoyaltyService $loyaltyService)
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
                ['nomor_wa' => $this->no_hp],
                ['nama' => $this->nama, 'alamat' => null]
            );

            $txData = [
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
                'member_id' => $member->id,
                'voucher_id' => $this->voucher_id,
                'poin_used' => $this->poinGunakan,
                'diskon_total' => $this->diskonTotal,
            ];

            if ($this->trxId) {
                // Update transaksi jika sudah ada
                $transaksi = Transaksi::findOrFail($this->trxId);
                $transaksi->update($txData);
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
                $txData['jumlah'] = 1;
                $txData['jasa_id'] = is_array($this->jasa) && count($this->jasa) === 1 ? $this->jasa[0] : null;
                $transaksi = Transaksi::create($txData);
                $transaksi->jasa()->attach($this->jasa);
                
                foreach ($this->barangSelected as $bId) {
                    $jml = $this->jumlahBarang[$bId] ?? 1;
                    $transaksi->barangs()->attach($bId, ['jumlah' => $jml]);
                }
            }

            // LOYALTY LOGIC
            // 1. Redeem Points
            if ($this->poinGunakan > 0) {
                $loyaltyService->redeemPoints($member, $this->poinGunakan, $transaksi->id);
            }

            // 2. Earn Points (1 poin per 10k subtotal sebelum diskon?)
            // Sesuaikan: Point dihitung dari total yang dibayar (subtotal - voucher)
            $potentialTotalForPoints = max(0, $this->subtotal - $this->diskonVoucher); 
            $earned = $loyaltyService->calculateEarnedPoints($potentialTotalForPoints);
            if ($earned > 0) {
                $loyaltyService->addPoints($member, $earned, 'earn', $transaksi->id, "Poin transaksi " . $transaksi->invoice);
                $transaksi->update(['poin_earned' => $earned]);
            }

            // 3. Increment Visit
            $member->increment('total_kunjungan');
            $loyaltyService->updateMemberLevel($member);

            // 4. Update Voucher usage
            if ($this->voucher_id) {
                \App\Models\Voucher::find($this->voucher_id)->increment('used_count');
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
        $this->kursi_id = null;
        $this->tanggal = now()->toDateString();
        $this->waktu = now()->format('H:i');
        $this->barangSelected = [];
        $this->jumlahBarang = [];
        $this->showRandomInvoice = false;
        $this->randomInvoiceDisplay = null;
        
        // Reset Loyalty & Promo
        $this->member_id = null;
        $this->poinPunya = 0;
        $this->poinGunakan = 0;
        $this->voucherCode = '';
        $this->diskonTotal = 0;
        $this->diskonPoin = 0;
        $this->diskonVoucher = 0;
        $this->voucher_id = null;
        $this->subtotal = 0;
        
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
            $waService = app(WAService::class);
            if ($waService->sendReceipt($transaksi)) {
                $this->dispatch('swal-success', ['message' => 'Struk WA berhasil dikirim!']);
            } else {
                throw new \Exception('Gagal mengirim pesan melalui gateway.');
            }
        } catch (\Exception $e) {
            \Log::error('Gagal kirim struk WA: ' . $e->getMessage());
            $this->dispatch('swal-error', ['message' => 'Gagal kirim struk: ' . $e->getMessage()]);
        }
    }

    public function kirimPengingatWa($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $waService = app(WAService::class);
            
            if ($waService->sendBookingReminder($transaksi, "Manual")) {
                $transaksi->update(['reminded_at' => now()]);
                $this->dispatch('swal-success', ['message' => 'Pengingat WA berhasil dikirim!']);
            } else {
                throw new \Exception('Gagal mengirim pesan melalui gateway.');
            }
        } catch (\Exception $e) {
            \Log::error('Gagal kirim pengingat WA: ' . $e->getMessage());
            $this->dispatch('swal-error', ['message' => 'Gagal kirim pengingat: ' . $e->getMessage()]);
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
            'listKursi' => \App\Models\Kursi::where('status', 'aktif')->get(),
            'listMember' => $listMember,
            'transaksiBooking' => $transaksiBooking,
            'transaksiProses' => $transaksiProses,
            'transaksiSelesai' => $transaksiSelesai,
            'nama_usaha' => $namaUsaha,
        ])->layout('layouts.fullscreen');
    }
}
