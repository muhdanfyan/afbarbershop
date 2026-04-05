<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #6a11cb, #2575fc);">
                    <i class="mdi mdi-chair-rolling text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Manajemen Kursi</h4>
                    <p class="text-muted small mb-0">Kelola ketersediaan kursi untuk booking layanan barbershop</p>
                </div>
            </div>
            <button wire:click="showCreateForm" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="mdi mdi-plus-circle me-1"></i> Tambah Kursi
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nomor atau nama kursi...">
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
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Nama Kursi</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Lokasi</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Terakhir Update</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kursis as $item)
                                    <tr wire:key="kursi-{{ $item->id }}" class="transition-all">
                                        <td class="ps-4 text-muted small">{{ $loop->iteration + ($kursis->currentPage() - 1) * $kursis->perPage() }}</td>
                                        <td>
                                            <span class="fw-bold text-dark fs-6">{{ $item->nama }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small">{{ $item->lokasi ?: '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = $item->status == 'aktif' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger';
                                            @endphp
                                            <span class="badge rounded-pill px-3 py-1 fw-bold border {{ $statusClass }}">
                                                {{ strtoupper($item->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted small"><i class="mdi mdi-clock-outline me-1"></i> {{ $item->updated_at->format('d M y, H:i') }}</span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $item->id }})" class="btn bg-white text-primary border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $item->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-chair-rolling mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Data Kursi Kosong</h5>
                                                <p class="text-muted mx-auto mb-0" style="max-width: 400px;">
                                                    Belum ada data kursi yang terdaftar. Silakan tambahkan kursi baru.
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
        {{ $kursis->links() }}
    </div>

    <!-- Form Modal -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-chair-school text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $editId ? 'Edit Kursi' : 'Tambah Kursi Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showForm', false)"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Nama/Nomor Kursi</label>
                                    <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model.defer="form.nama" placeholder="Contoh: Kursi 1">
                                    @error('form.nama') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Lokasi</label>
                                    <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model.defer="form.lokasi" placeholder="Contoh: Lantai 1, Dekat Jendela">
                                    @error('form.lokasi') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Deskripsi</label>
                                    <textarea class="form-control shadow-sm border-0 bg-light" wire:model.defer="form.deskripsi" rows="3" placeholder="Informasi tambahan tentang kursi ini..."></textarea>
                                    @error('form.deskripsi') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Status</label>
                                    <select class="form-select shadow-sm border-0 bg-light fw-bold" wire:model.defer="form.status">
                                        <option value="aktif">Aktif (Tersedia untuk Booking)</option>
                                        <option value="nonaktif">Nonaktif (Dalam Perbaikan/Libur)</option>
                                    </select>
                                    @error('form.status') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="$set('showForm', false)">Batal</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm" wire:loading.attr="disabled" style="background: linear-gradient(135deg, #6a11cb, #2575fc); border: none;">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                <i class="mdi mdi-content-save-check me-1"></i> Simpan Data
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
                            <i class="mdi mdi-trash-can-outline text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Hapus Data Kursi?</h4>
                        <p class="text-muted mb-4">Kursi "{{ $deleteNama }}" akan dihapus secara permanen. Booking yang sudah menggunakan kursi ini akan kehilangan referensi kursi.</p>
                        
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
