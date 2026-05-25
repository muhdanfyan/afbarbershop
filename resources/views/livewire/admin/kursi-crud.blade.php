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
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-chair-school fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $editId ? 'Edit Kursi' : 'Tambah Kursi Baru' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click="$set('showForm', false)">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama/Nomor Kursi</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.nama" placeholder="Contoh: Kursi 1">
                            @error('form.nama') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Lokasi</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.lokasi" placeholder="Contoh: Lantai 1, Dekat Jendela">
                            @error('form.lokasi') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Status</label>
                            <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.status">
                                <option value="aktif">Aktif (Tersedia untuk Booking)</option>
                                <option value="nonaktif">Nonaktif (Dalam Perbaikan/Libur)</option>
                            </select>
                            @error('form.status') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Deskripsi</label>
                            <textarea class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="form.deskripsi" rows="3" placeholder="Informasi tambahan tentang kursi ini..."></textarea>
                            @error('form.deskripsi') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                Simpan Data
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" wire:click="$set('showForm', false)">
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
                                <i class="mdi mdi-trash-can-outline" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Hapus Data Kursi?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Kursi <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen. Booking yang sudah menggunakan kursi ini akan kehilangan referensi.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="hapus" wire:loading.attr="disabled" wire:target="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Sekarang
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
            background-color: #f5f8ff !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>
