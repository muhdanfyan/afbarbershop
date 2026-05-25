<div>
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-dark p-3 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="mdi mdi-ticket-percent text-warning fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Manajemen Promo & Voucher</h4>
                    <p class="text-muted small mb-0">Kelola kupon diskon dan penawaran spesial</p>
                </div>
            </div>
            <button wire:click="showCreateForm" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="mdi mdi-plus-circle fs-5"></i>
                <span>Buat Voucher Baru</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-check-circle fs-5"></i>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-0 py-3">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="input-group bg-light rounded-pill px-3 border-0 shadow-none">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-magnify"></i></span>
                        <input type="text" class="form-control border-0 bg-transparent py-2" placeholder="Cari kode promo..." wire:model.live.debounce.300ms="search">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted border-0">Kode Promo</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted border-0">Reward</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted border-0">Min. Belanja</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted border-0">Kuota (Terpakai)</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted border-0">Validitas</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted border-0">Status</th>
                            <th class="pe-4 py-3 text-end text-uppercase small fw-bold text-muted border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $v)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark px-3 py-1 bg-warning-subtle rounded-pill border border-warning d-inline-block" style="font-family: 'Courier New', Courier, monospace; font-size: 0.9rem;">
                                        {{ $v->code }}
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $v->type == 'percent' ? 'text-primary' : 'text-success' }}">
                                        {{ $v->type == 'percent' ? $v->reward.'%' : 'Rp '.number_format($v->reward, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td><span class="text-muted">Rp {{ number_format($v->min_spend, 0, ',', '.') }}</span></td>
                                <td>
                                    @if($v->quota == 0)
                                        <span class="badge bg-light text-dark border rounded-pill px-3">Tak Terbatas ({{ $v->used_count }})</span>
                                    @else
                                        <div class="small fw-medium">{{ $v->used_count }} / {{ $v->quota }}</div>
                                        <div class="progress mt-1" style="height: 5px; width: 80px;">
                                            <div class="progress-bar bg-dark" style="width: {{ ($v->used_count / $v->quota) * 100 }}%"></div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($v->valid_from || $v->valid_until)
                                        <div class="small text-muted d-flex flex-column">
                                            <span><i class="mdi mdi-calendar-start me-1"></i>{{ $v->valid_from ? \Carbon\Carbon::parse($v->valid_from)->format('d M y') : '-' }}</span>
                                            <span><i class="mdi mdi-calendar-end me-1"></i>{{ $v->valid_until ? \Carbon\Carbon::parse($v->valid_until)->format('d M y') : '-' }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $v->is_active ? 'bg-success-subtle text-success border border-success' : 'bg-danger-subtle text-danger border border-danger' }} rounded-pill px-3">
                                        {{ $v->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-link link-dark text-decoration-none p-2 rounded-circle hover-bg-light" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                            <li><a class="dropdown-item py-2 d-flex align-items-center gap-2" href="#" wire:click="edit({{ $v->id }})">
                                                <i class="mdi mdi-pencil-outline text-primary"></i> Ubah Detail
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item py-2 d-flex align-items-center gap-2 text-danger" href="#" wire:click="confirmDelete({{ $v->id }})">
                                                <i class="mdi mdi-trash-can-outline"></i> Hapus Voucher
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-database-off-outline d-block fs-1 mb-2 opacity-50"></i>
                                    <span class="small">Belum ada data voucher ditemukan</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($vouchers->hasPages())
                <div class="p-4 border-top">
                    {{ $vouchers->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Form (Create/Edit) -->
    @if($showForm)
    <div class="modal fade show d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" style="background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 p-4" style="border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning-subtle p-2 rounded-circle">
                            <i class="mdi mdi-tag-text-outline text-warning fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">{{ $voucherIdEdit ? 'Ubah Voucher' : 'Buat Voucher Baru' }}</h5>
                    </div>
                    <button type="button" class="btn-close shadow-none" wire:click="resetForm"></button>
                </div>
                
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Kode Promo</label>
                        <input type="text" wire:model="code" class="form-control bg-light border-0 rounded-3 py-2 fw-bold text-dark" placeholder="Contoh: MERDEKA45" style="text-transform: uppercase;">
                        @error('code') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tipe Reward</label>
                            <select wire:model.live="type" class="form-select bg-light border-0 rounded-3 py-2 fw-medium">
                                <option value="fixed">Potongan (Rp)</option>
                                <option value="percent">Persentase (%)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nilai (Reward)</label>
                            <input type="number" wire:model="reward" class="form-control bg-light border-0 rounded-3 py-2 fw-bold text-dark" placeholder="{{ $type == 'fixed' ? '5000' : '10' }}">
                            @error('reward') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Min. Belanja</label>
                            <input type="number" wire:model="min_spend" class="form-control bg-light border-0 rounded-3 py-2 fw-medium" placeholder="0">
                            @error('min_spend') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Kuota Pakai</label>
                            <input type="number" wire:model="quota" class="form-control bg-light border-0 rounded-3 py-2 fw-medium" placeholder="0 (Unlimited)">
                            <div class="text-muted" style="font-size: 0.7rem;">Isi 0 untuk kuota tidak terbatas</div>
                            @error('quota') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Mulai</label>
                            <input type="date" wire:model="valid_from" class="form-control bg-light border-0 rounded-3 py-2 small">
                            @error('valid_from') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Berakhir</label>
                            <input type="date" wire:model="valid_until" class="form-control bg-light border-0 rounded-3 py-2 small">
                            @error('valid_until') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" wire:model="is_active" id="flexSwitchCheckDefault">
                        <label class="form-check-label fw-bold text-dark" for="flexSwitchCheckDefault">Status Voucher Aktif</label>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-bold shadow-sm">
                            <i class="mdi {{ $voucherIdEdit ? 'mdi-content-save-check' : 'mdi-plus-circle' }} me-2"></i>
                            {{ $voucherIdEdit ? 'Simpan Perubahan' : 'Terbitkan Voucher' }}
                        </button>
                        <button type="button" class="btn btn-link link-secondary text-decoration-none py-1 small" wire:click="resetForm">Batalkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
    <div class="modal fade show d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" style="background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(4px); z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
            <div class="modal-content border-0 p-4" style="border-radius: 20px;">
                <div class="text-center p-3">
                    <div class="bg-danger-subtle p-3 rounded-circle d-inline-block mb-3">
                        <i class="mdi mdi-alert-circle text-danger fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Hapus Voucher?</h5>
                    <p class="text-muted small">Anda akan menghapus voucher <b>{{ $deleteNama }}</b>. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="d-flex flex-column gap-2">
                    <button wire:click="delete" class="btn btn-dark w-100 rounded-pill py-2 fw-bold">Hapus Sekarang</button>
                    <button wire:click="$set('showDeleteModal', false)" class="btn btn-light w-100 rounded-pill py-2 fw-bold border">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .hover-bg-light:hover { background-color: #f8fafc; }
        .bg-warning-subtle { background-color: #fef3c7 !important; border: 1px solid #fde68a !important; }
        .text-warning { color: #d97706 !important; }
        .rounded-4 { border-radius: 1rem !important; }
    </style>
</div>
