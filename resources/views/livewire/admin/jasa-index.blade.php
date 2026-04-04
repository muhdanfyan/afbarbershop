<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #CF9E1C, #B8860B);">
                    <i class="mdi mdi-cut-rhombus text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Menu Layanan & Jasa</h4>
                    <p class="text-muted small mb-0">Atur katalog perlakuan rambut dan perawatan eksklusif</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Layanan Baru
            </button>
        </div>
    </div>

    <!-- Stats & Filters Bar (Optional but nice for Premium look) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama atau deskripsi jasa...">
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 120px;">Visual</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Layanan</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Investasi Harga</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataJasa as $dtjasa)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            @if($dtjasa->foto)
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ asset('storage/' . $dtjasa->foto) }}" class="rounded shadow-sm border" style="width: 80px; height: 60px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="width: 80px; height: 60px;">
                                                    <i class="mdi mdi-image-off-outline text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold text-dark d-block fs-5">{{ $dtjasa->nama }}</span>
                                                <span class="text-muted small d-block" style="max-width: 400px;">{{ Str::limit($dtjasa->deskripsi, 80) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge border-0 rounded-pill px-3 py-2 bg-light text-dark fw-bold border shadow-sm">
                                                Rp {{ number_format($dtjasa->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $dtjasa->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $dtjasa->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-content-cut text-muted mdi-48px"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Layanan Belum Terarsip</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat Anda belum mendaftarkan menu layanan ke dalam sistem Anda.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Daftarkan Layanan Pertama
                                                </button>
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
        {{ $dataJasa->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-briefcase-edit-outline text-warning fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $jasaIdEdit ? 'Sempurnakan Layanan' : 'Formulasi Layanan Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="batal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Nama Layanan</label>
                                    <input type="text" class="form-control" wire:model.defer="nama" placeholder="Cth: Signature Fade Cut">
                                    @error('nama') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Investasi Layanan (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold border-end-0">Rp</span>
                                        <input type="number" class="form-control border-start-0" wire:model.defer="harga" placeholder="0">
                                    </div>
                                    @error('harga') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Deskripsi Detail</label>
                                    <textarea class="form-control" wire:model.defer="deskripsi" rows="4" placeholder="Detail treatment, durasi, dll..."></textarea>
                                    @error('deskripsi') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-uppercase text-muted">Visual Profile</label>
                                <div class="p-3 border border-dashed rounded bg-light text-center">
                                    <input type="file" class="form-control mb-3" wire:model="foto" accept="image/*">
                                    @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail shadow-sm mb-2" style="max-height: 150px; width: 100%; object-fit: cover; border-radius: 12px;">
                                        <p class="text-success small mb-0"><i class="mdi mdi-check-circle me-1"></i>Siap unggah</p>
                                    @elseif ($foto_lama)
                                        <img src="{{ asset('storage/' . $foto_lama) }}" class="img-thumbnail shadow-sm mb-2" style="max-height: 150px; width: 100%; object-fit: cover; border-radius: 12px;">
                                        <p class="text-muted small mb-0">Visual tersimpan</p>
                                    @else
                                        <div class="py-4 opacity-50">
                                            <i class="mdi mdi-camera-plus mdi-48px text-muted"></i>
                                            <p class="small mb-0">Upload foto layanan</p>
                                        </div>
                                    @endif
                                    @error('foto') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click.prevent="batal">Batal</button>
                        <button type="button" class="btn btn-premium-add text-dark px-4 rounded-pill fw-bold shadow-sm" wire:click.prevent="simpan"
                            wire:loading.attr="disabled" wire:target="simpan">
                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-content-save-check me-1"></i> Simpan Katalog
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if ($showDeleteModal ?? false)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__zoomIn" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-body p-5 text-center">
                        <div class="bg-danger-subtle d-inline-flex p-4 rounded-circle mb-4" style="background: #ffebee;">
                            <i class="mdi mdi-delete-off text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Lepas Layanan dari Menu?</h4>
                        <p class="text-muted mb-4">Layanan "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen dari katalog studio.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus({{ $deleteId }})"
                                wire:loading.attr="disabled" wire:target="hapus">
                                <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Lepaskan Sekarang
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
            background-color: #fff9eb !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>