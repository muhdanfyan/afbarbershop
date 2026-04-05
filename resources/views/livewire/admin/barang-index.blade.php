<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2193b0, #6dd5ed);">
                    <i class="mdi mdi-package-variant text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Stok & Inventaris Barang</h4>
                    <p class="text-muted small mb-0">Manajemen produk retail, pomade, dan peralatan studio</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Barang Baru
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama atau deskripsi barang...">
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 100px;">Produk</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Barang</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Stok</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Harga Beli</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Harga Jual</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataBarang as $dtbarang)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            @if($dtbarang->foto)
                                                <img src="{{ asset('storage/' . $dtbarang->foto) }}" class="rounded shadow-sm border" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="width: 60px; height: 60px;">
                                                    <i class="mdi mdi-package-variant text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block fs-6">{{ $dtbarang->nama }}</span>
                                            <span class="text-muted small d-block">{{ Str::limit($dtbarang->deskripsi, 50) }}</span>
                                        </td>
                                        <td>
                                            @if($dtbarang->stok <= 5)
                                                <span class="badge border-0 rounded-pill px-3 py-2 bg-danger-subtle text-danger fw-bold border border-danger">
                                                    Low: {{ $dtbarang->stok }}
                                                </span>
                                            @else
                                                <span class="badge border-0 rounded-pill px-3 py-2 bg-info-subtle text-info fw-bold border border-info">
                                                    {{ $dtbarang->stok }} Items
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">Rp {{ number_format($dtbarang->harga_beli, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">Rp {{ number_format($dtbarang->harga_jual, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $dtbarang->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $dtbarang->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-package-variant mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Gudang Inventaris Kosong</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Belum ada barang atau produk yang terdaftar di sistem inventaris Anda.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Mulai Stok Barang
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
        {{ $dataBarang->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-package-variant-plus text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $barangIdEdit ? 'Sempurnakan Data Barang' : 'Input Barang Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="batal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Nama Barang / Produk</label>
                                    <input type="text" class="form-control" wire:model.defer="nama_barang" placeholder="Cth: Suavecito Pomade Firme Hold">
                                    @error('nama_barang') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Stok Awal</label>
                                        <input type="number" class="form-control" wire:model.defer="stok" placeholder="0">
                                        @error('stok') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Harga Beli</label>
                                        <input type="number" class="form-control" wire:model.defer="harga_beli" placeholder="Rp">
                                        @error('harga_beli') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Harga Jual Konsumen</label>
                                    <input type="number" class="form-control font-weight-bold text-primary" wire:model.defer="harga_jual" placeholder="Rp">
                                    @error('harga_jual') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Detail Produk</label>
                                    <textarea class="form-control" wire:model.defer="deskripsi" rows="3" placeholder="Aroma, kelebihan produk, dll..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-uppercase text-muted">Preview Visual</label>
                                <div class="p-3 border border-dashed rounded bg-light text-center">
                                    <input type="file" class="form-control mb-3" wire:model="foto" accept="image/*">
                                    @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail shadow-sm mb-2" style="max-height: 180px; width: 100%; object-fit: cover; border-radius: 12px;">
                                        <p class="text-success small mb-0"><i class="mdi mdi-check-circle me-1"></i>Visual OK</p>
                                    @elseif ($foto_lama)
                                        <img src="{{ asset('storage/' . $foto_lama) }}" class="img-thumbnail shadow-sm mb-2" style="max-height: 180px; width: 100%; object-fit: cover; border-radius: 12px;">
                                        <p class="text-muted small mb-0">Visual exist</p>
                                    @else
                                        <div class="py-5 opacity-50">
                                            <i class="mdi mdi-camera-plus mdi-48px text-muted"></i>
                                            <p class="small mb-0">Upload Foto Barang</p>
                                        </div>
                                    @endif
                                    @error('foto') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click.prevent="batal">Batal</button>
                        <button type="button" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm" wire:click.prevent="simpan"
                            wire:loading.attr="disabled" wire:target="simpan" style="background: #2a5298;">
                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-content-save-check me-1"></i> Simpan Inventaris
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
                            <i class="mdi mdi-package-variant-remove text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Musnahkan Data Barang?</h4>
                        <p class="text-muted mb-4">Produk "<strong>{{ $deleteNama }}</strong>" akan dihapus permanen. Data stok ini tidak dapat dipulihkan.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus({{ $deleteId }})"
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
            background-color: #f0f7ff !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>