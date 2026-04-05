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
                                            @if($trx->member_id)
                                                <span class="badge bg-primary-subtle text-primary border border-primary small rounded-pill ms-1" style="font-size: 0.65rem;">MEMBER</span>
                                            @endif
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
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-receipt text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">Rician Transaksi</h5>
                        <button type="button" class="btn-close" wire:click="$set('detailId', null)"></button>
                    </div>
                    @php
                        $detailTrx = \App\Models\Transaksi::with(['jasa', 'kapster', 'member'])->find($detailId);
                    @endphp
                    @if($detailTrx)
                        <div class="modal-body p-4 pt-2">
                            <div class="card bg-light border-0 mb-4" style="border-radius: 15px;">
                                <div class="card-body p-3 text-center">
                                    <h6 class="text-muted text-uppercase small fw-bold mb-1">Nomor Invoice</h6>
                                    <h4 class="text-primary fw-bold mb-0">{{ $detailTrx->invoice ?? 'INV-' . str_pad($detailTrx->id, 5, '0', STR_PAD_LEFT) }}</h4>
                                    <hr class="my-3 opacity-10">
                                    <div class="row">
                                        <div class="col-6 border-end">
                                            <span class="text-muted small d-block">Operator</span>
                                            <span class="fw-bold text-dark">{{ $detailTrx->kapster->nama ?? '-' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted small d-block">Tanggal</span>
                                            <span class="fw-bold text-dark">{{ $detailTrx->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Item Layanan</h6>
                                @foreach($detailTrx->jasa as $j)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary p-1 rounded me-2" style="width: 8px; height: 8px;"></div>
                                            <span class="text-dark">{{ $j->nama }}</span>
                                        </div>
                                        <span class="fw-bold">Rp {{ number_format($j->harga, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="p-3 bg-secondary-subtle rounded-lg mb-4" style="background: #f8f9fa;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Tagihan:</span>
                                    <span class="fw-bold text-dark">Rp {{ number_format($detailTrx->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Dibayarkan:</span>
                                    <span class="fw-bold text-success">Rp {{ number_format($detailTrx->uang_bayar, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Kembalian:</span>
                                    <span class="fw-bold text-info">Rp {{ number_format($detailTrx->uang_kembali, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @if($detailTrx->catatan)
                                <div class="mb-0">
                                    <h6 class="small fw-bold text-muted text-uppercase mb-2">Catatan Transaksi</h6>
                                    <div class="p-3 bg-light rounded italic text-muted" style="border-left: 4px solid #dee2e6;">
                                        "{{ $detailTrx->catatan }}"
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm" wire:click="$set('detailId', null)">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Tutup Informasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Modal (Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-pencil-box-multiple text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">Edit Data Transaksi</h5>
                        <button type="button" class="btn-close" wire:click="$set('showForm', false)"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Nama Pelanggan</label>
                                    <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model.defer="form.nama">
                                    @error('form.nama') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Status Pesanan</label>
                                    <select class="form-select shadow-sm border-0 bg-light fw-bold" wire:model.defer="form.status">
                                        <option value="menunggu">Menunggu</option>
                                        <option value="proses">Proses</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    @error('form.status') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Tim Kapster</label>
                                    <select class="form-select shadow-sm border-0 bg-light" wire:model.defer="form.kapster_id">
                                        <option value="">Pilih Kapster...</option>
                                        @foreach($allKapster as $kapster)
                                            <option value="{{ $kapster->id }}">{{ $kapster->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.kapster_id') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Kursi (Seat)</label>
                                    <select class="form-select shadow-sm border-0 bg-light" wire:model.defer="form.kursi_id">
                                        <option value="">Pilih Kursi...</option>
                                        @foreach($allKursi as $kursi)
                                            <option value="{{ $kursi->id }}">{{ $kursi->nama }} ({{ $kursi->status }})</option>
                                        @endforeach
                                    </select>
                                    @error('form.kursi_id') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Catatan Layanan</label>
                                    <textarea class="form-control shadow-sm border-0 bg-light" wire:model.defer="form.catatan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="$set('showForm', false)">Batal</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm" wire:loading.attr="disabled" style="background: linear-gradient(135deg, #4b6cb7, #182848); border: none;">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                <i class="mdi mdi-content-save-check me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($confirmingDelete)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__zoomIn" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-body p-5 text-center">
                        <div class="bg-danger-subtle d-inline-flex p-4 rounded-circle mb-4" style="background: #ffebee;">
                            <i class="mdi mdi-credit-card-remove-outline text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Hapus Arsip Transaksi?</h4>
                        <p class="text-muted mb-4">Invoice "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen. Tindakan ini akan memengaruhi laporan keuangan.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus"
                                wire:loading.attr="disabled" wire:target="hapus">
                                <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Hapus Sekarang
                            </button>
                        </div>
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
            background-color: #f5f8ff !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>