<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Jasa;
use App\Models\Kapster;
use App\Models\Transaksi;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KasirTransaksi extends Component
{
    public function menungguTransaksi()
    {
        if ($this->trxId) {
            $transaksi = Transaksi::find($this->trxId);
            if ($transaksi && $transaksi->status === 'selesai') {
                $this->dispatch('swal-error', ['message' => 'Transaksi sudah selesai, tidak bisa diubah!']);
                return;
            }
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
        if ($this->trxId) {
            $transaksi = Transaksi::find($this->trxId);
            if ($transaksi && $transaksi->status === 'selesai') {
                $this->dispatch('swal-error', ['message' => 'Transaksi sudah selesai, tidak bisa diubah!']);
                return;
            }
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
        // Generate random invoice for display only
        $this->showRandomInvoice = true;
        $this->randomInvoiceDisplay = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
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

    public function mount()
    {
        $this->generateInvoice();
    }

    public function generateInvoice()
    {
        $this->invoice = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
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
        $this->updatedUangBayar();
    }

    public function simpanTransaksi()
    {
        try {
            $this->validate([
                'nama' => 'required',
                'no_hp' => 'required',
                'jasa' => 'required|array|min:1',
                'kapster' => 'required',
                'uang_bayar' => 'required|numeric|min:' . $this->total,
            ]);
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
            }
            $this->dispatch('print-struk', ['invoice' => $this->invoice]);
            $this->dispatch('swal-success', ['message' => 'Transaksi berhasil disimpan!']);
            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('swal-error', ['message' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }

    public function resetForm()
    {
        $this->trxId = null;
        $this->generateInvoice();
        $this->nama = '';
        $this->no_hp = '';
        $this->jasa = [];
        $this->kapster = '';
        $this->uang_bayar = 0;
        $this->uang_kembali = 0;
        $this->total = 0;
        $this->showRandomInvoice = false;
        $this->randomInvoiceDisplay = null;
    }

    public function toggleJasa($id)
    {
        $jasa = $this->jasa;
        if (($key = array_search($id, $jasa)) !== false) {
            unset($jasa[$key]);
        } else {
            $jasa[] = $id;
        }
        $this->jasa = array_values($jasa);
        $this->hitungTotal();
    }

    public function render()
    {
        $listMember = Member::select('nama', 'nomor_wa')->orderBy('nama')->get();
        $today = now()->toDateString();
        $transaksiBooking = Transaksi::where('status', 'menunggu')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $transaksiProses = Transaksi::where('status', 'proses')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $transaksiSelesai = Transaksi::where('status', 'selesai')->whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        return view('livewire.admin.kasir-transaksi', [
            'listJasa' => Jasa::all(),
            'listKapster' => Kapster::all(),
            'listMember' => $listMember,
            'transaksiBooking' => $transaksiBooking,
            'transaksiProses' => $transaksiProses,
            'transaksiSelesai' => $transaksiSelesai,
        ])->layout('layouts.fullscreen');
    }
}
