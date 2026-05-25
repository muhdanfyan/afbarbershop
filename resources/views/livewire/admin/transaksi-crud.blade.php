<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #F09819, #EDDE5D);">
                    <i class="mdi mdi-cash-register text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Arsip Transaksi Lengkap</h4>
                    <p class="text-muted small mb-0">Database histori transaksi, audit pembayaran, dan status layanan</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button wire:click.prevent="$set('status', 'menunggu')" class="btn {{ $status == 'menunggu' ? 'btn-warning text-white shadow-sm fw-bold' : 'btn-light border text-muted' }} rounded-pill px-4">
                    Menunggu
                </button>
                <button wire:click.prevent="$set('status', 'proses')" class="btn {{ $status == 'proses' ? 'btn-primary shadow-sm fw-bold' : 'btn-light border text-muted' }} rounded-pill px-4">
                    Proses
                </button>
                <button wire:click.prevent="$set('status', 'selesai')" class="btn {{ $status == 'selesai' ? 'btn-success shadow-sm fw-bold' : 'btn-light border text-muted' }} rounded-pill px-4">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama pelanggan atau invoice...">
            </div>
        </div>
    </div>

    <!-- Alert Section -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show mb-4 animate__animated animate__fadeInDown" role="alert" style="border-radius: 15px; background: #e8f5e9;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-check-circle text-success mdi-24px me-3"></i>
                <span class="text-success fw-bold">{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">#</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Waktu & Invoice</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Pelanggan</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Layanan & Tim</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Kursi</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Pembayaran</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $trx)
                                    <tr class="transition-all">
                                        <td class="ps-4 text-muted small">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                                        <td>
                                            <span class="fw-bold text-primary d-block">{{ $trx->invoice ?? 'INV-' . str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                                            <span class="text-muted small"><i class="mdi mdi-clock-outline me-1"></i> {{ $trx->created_at->format('d M y, H:i') }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark fs-6">{{ $trx->nama }}</span>

                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                @foreach($trx->jasa as $j)
                                                    <span class="badge bg-light text-dark border rounded-pill me-1" style="font-size: 0.75rem;">{{ $j->nama }}</span>
                                                @endforeach
                                            </div>
                                            <span class="text-muted small"><i class="mdi mdi-account-star-outline me-1"></i>{{ $trx->kapster->nama ?? 'No Kapster' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-bold">{{ $trx->kursi->nama ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                                            <div class="text-muted small">Via: {{ ucfirst($trx->metode_pembayaran ?? 'Tunai') }}</div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = [
                                                    'menunggu' => 'bg-warning-subtle text-warning border-warning',
                                                    'proses' => 'bg-primary-subtle text-primary border-primary',
                                                    'selesai' => 'bg-success-subtle text-success border-success',
                                                ][$trx->status] ?? 'bg-secondary-subtle text-secondary border-secondary';
                                            @endphp
                                            <span class="badge rounded-pill px-3 py-1 fw-bold border {{ $statusClass }}">
                                                {{ strtoupper($trx->status) }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="$set('detailId', {{ $trx->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Detail">
                                                    <i class="mdi mdi-information-outline fs-5"></i>
                                                </button>
                                                <button wire:click="edit({{ $trx->id }})" class="btn bg-white text-primary border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $trx->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-cash-multiple mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Data Transaksi Tidak Ditemukan</h5>
                                                <p class="text-muted mx-auto mb-0" style="max-width: 400px;">
                                                    Tidak ada catatan transaksi untuk kategori status "{{ $status }}" pada kriteria pencarian ini.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $transaksis->links() }}
    </div>

    <!-- Detail Modal -->
    @if(isset($detailId) && $detailId)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    @php $detailTrx = \App\Models\Transaksi::with(['jasa', 'kapster', 'kursi'])->find($detailId); @endphp
                    @if($detailTrx)
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                    <i class="mdi mdi-receipt-text-outline fs-5" style="color: #d97706;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">Rincian Transaksi</h6>
                                    <p class="small fw-semibold mb-0" style="color: #64748b;">{{ $detailTrx->invoice ?? 'INV-' . str_pad($detailTrx->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click="$set('detailId', null)">
                                <i class="mdi mdi-close fs-4"></i>
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-2" style="color: #475569;">Informasi Umum</label>
                            <div class="d-flex flex-column gap-2 px-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small fw-semibold" style="color: #64748b;">Waktu Transaksi</span>
                                    <span class="small fw-bold" style="color: #0f172a;">{{ $detailTrx->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small fw-semibold" style="color: #64748b;">Operator Kapster</span>
                                    <span class="small fw-bold" style="color: #0f172a;">{{ $detailTrx->kapster->nama ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-2" style="color: #475569;">Rincian Item</label>
                            <div class="p-3 border rounded-3" style="background-color: #f8fafc;">
                                @foreach($detailTrx->jasa as $j)
                                    <div class="d-flex justify-content-between align-items-center mb-2 {{ $loop->last ? 'mb-0' : '' }}">
                                        <span class="small fw-bold" style="color: #0f172a;">{{ $j->nama }}</span>
                                        <span class="small fw-bold" style="color: #0f172a;">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4 px-1">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-semibold" style="color: #64748b;">Ringkasan Total</span>
                                <span class="fw-bold" style="color: #0f172a;">Rp {{ number_format($detailTrx->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-semibold" style="color: #64748b;">Jumlah Dibayar</span>
                                <span class="small fw-bold" style="color: #0f172a;">Rp {{ number_format($detailTrx->uang_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top">
                                <span class="small fw-bold" style="color: #475569;">Uang Kembalian</span>
                                <span class="small fw-bold" style="color: #0f172a;">Rp {{ number_format($detailTrx->uang_kembali, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($detailTrx->catatan)
                            <div class="mb-4">
                                <label class="small fw-bold d-block mb-1" style="color: #475569;">Catatan Pelanggan</label>
                                <p class="small fw-medium mb-0 p-3 rounded-3 border" style="background-color: #f8fafc; color: #334155;">{{ $detailTrx->catatan }}</p>
                            </div>
                        @endif

                        <div class="mt-4 pt-2">
                            <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="$set('detailId', null)">
                                Selesai
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Form Modal (Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-pencil-outline fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Perbarui Transaksi</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click="$set('showForm', false)">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama Pelanggan</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.nama" placeholder="Ketik nama di sini...">
                            @error('form.nama') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Status</label>
                            <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.status">
                                <option value="menunggu">Menunggu</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                            @error('form.status') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Kapster</label>
                            <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.kapster_id">
                                <option value="">Pilih Kapster</option>
                                @foreach($allKapster as $kapster)
                                    <option value="{{ $kapster->id }}">{{ $kapster->nama }}</option>
                                @endforeach
                            </select>
                            @error('form.kapster_id') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Kursi</label>
                            <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.kursi_id">
                                <option value="">Pilih Kursi</option>
                                @foreach($allKursi as $kursi)
                                    <option value="{{ $kursi->id }}">{{ $kursi->nama }} ({{ $kursi->status }})</option>
                                @endforeach
                            </select>
                            @error('form.kursi_id') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Catatan Tambahan</label>
                            <textarea class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.catatan" rows="3" placeholder="Opsional..."></textarea>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                Simpan Perubahan
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="$set('showForm', false)">
                                Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($confirmingDelete)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="text-center mb-4 pt-2">
                        <div class="mb-3">
                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 56px; height: 56px; background-color: #f1f5f9;">
                                <i class="mdi mdi-delete-outline" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Hapus Transaksi?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Tindakan ini akan menghapus data transaksi <strong>"{{ $deleteNama }}"</strong>. Aksi ini tidak dapat dibatalkan.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="hapus" wire:loading.attr="disabled" wire:target="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
            transform: translateY(-1px);
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1) !important;
            border-color: #2563eb !important;
        }
        
        .form-control, .form-select {
            border: 1px solid #e5e7eb;
        }
    </style>
</div>