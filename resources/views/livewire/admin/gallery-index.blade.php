<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF9966, #FF5E62);">
                    <i class="mdi mdi-image-multiple text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Visual Showcase Gallery</h4>
                    <p class="text-muted small mb-0">Kelola portofolio visual, dokumentasi studio, dan konten media sosial</p>
                </div>
            </div>
            <button wire:click.prevent="showForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-image-plus-outline me-1"></i> Upload Item Gallery
            </button>
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

    <!-- Filter Bar (Optional for Gallery) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari judul media...">
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: #f8f9fa;">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 280px;">Pratinjau Media</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Konten</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Tipe Media</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($galleries as $gallery)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            @if ($gallery->type == 'image')
                                                <div class="gallery-preview-card rounded shadow-sm overflow-hidden border border-2" 
                                                    style="width: 240px; height: 135px; background: #f0f0f0;">
                                                    <img src="{{ asset('storage/' . $gallery->file) }}" 
                                                        class="w-100 h-100 object-fit-cover transition-img">
                                                </div>
                                            @else
                                                <div class="gallery-preview-card rounded shadow-sm overflow-hidden position-relative border border-2" 
                                                    style="width: 240px; height: 135px; background: #000;">
                                                    <video src="{{ asset('storage/' . $gallery->file) }}" 
                                                        class="w-100 h-100 object-fit-cover" muted style="opacity: 0.6;"></video>
                                                    <div class="position-absolute top-50 start-50 translate-middle">
                                                        <i class="mdi mdi-play-circle text-white mdi-48px shadow-lg scale-hover"></i>
                                                    </div>
                                                    <span class="position-absolute bottom-0 end-0 m-2 badge bg-dark opacity-75 small">VIDEO</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block fs-5 mb-1 leading-tight">{{ $gallery->title ?: 'Dokumentasi #' . $gallery->id }}</span>
                                            <p class="text-muted small mb-0 pe-4" style="line-height: 1.4;">
                                                {{ Str::limit($gallery->description, 150) ?: 'Tidak ada deskripsi rinci untuk item galeri ini.' }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if($gallery->type == 'image')
                                                <span class="badge border-0 rounded-pill px-3 py-1 bg-info-subtle text-info fw-bold border border-info">
                                                    <i class="mdi mdi-image-outline me-1"></i> PHOTO
                                                </span>
                                            @else
                                                <span class="badge border-0 rounded-pill px-3 py-1 bg-warning-subtle text-warning fw-bold border border-warning" style="background: #fff8e1;">
                                                    <i class="mdi mdi-video-variant me-1"></i> CINEMATIC
                                                </span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $gallery->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $gallery->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
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
                                                    <i class="mdi mdi-image-multiple-outline mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Koleksi Gallery Masih Kosong</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat belum ada konten visual yang diunggah. Mulai tampilkan keindahan studio Anda sekarang.
                                                </p>
                                                <button wire:click.prevent="showForm" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Upload Foto Pertama
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
        {{ $galleries->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if($isFormOpen)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-image-move text-warning fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $editMode ? 'Penyuntingan Konten Visual' : 'Unggah Karya Visual Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="batal"></button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body p-4">
                            <div class="row g-4">
                                <div class="col-md-7">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Judul Media</label>
                                            <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model="title" placeholder="cth: Interior Studio AF Barber">
                                            @error('title') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Format Konten</label>
                                            <select class="form-select shadow-sm border-0 bg-light fw-bold" wire:model="type">
                                                <option value="image">🎞️ Galleri Photo</option>
                                                <option value="video">🎥 Koleksi Video</option>
                                            </select>
                                            @error('type') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Pilih Berkas</label>
                                            <div class="input-group shadow-sm rounded overflow-hidden">
                                                <input type="file" class="form-control border-0 bg-light small px-3" wire:model="file">
                                            </div>
                                            <div wire:loading wire:target="file" class="text-info italic small mt-1 animate__animated animate__flash animate__infinite">
                                                <i class="mdi mdi-cloud-upload animate__pulse"></i> Memproses berkas...
                                            </div>
                                            @error('file') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Catatan / Deskripsi Media</label>
                                            <textarea class="form-control shadow-sm border-0 bg-light" wire:model="description" rows="5" placeholder="Tuliskan cerita singkat atau keterangan di balik konten ini..."></textarea>
                                            @error('description') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-uppercase text-muted d-block ms-1">Pratinjau Publikasi</label>
                                    <div class="p-3 bg-white border border-2 border-dashed rounded-lg shadow-inner d-flex align-items-center justify-content-center overflow-hidden position-relative" 
                                        style="height: 320px; border-radius: 15px;">
                                        @if ($file)
                                            @if ($type == 'image')
                                                <img src="{{ $file->temporaryUrl() }}" class="w-100 h-100 shadow rounded-lg animate__animated animate__zoomIn" style="object-fit: contain;">
                                            @else
                                                <div class="text-center animate__animated animate__bounceIn">
                                                    <i class="mdi mdi-video-input-video mdi-48px text-warning mb-2"></i>
                                                    <p class="small fw-bold text-dark mt-1">Video Berhasil Dimuat</p>
                                                    <span class="badge bg-success shadow-sm">Ready to Upload</span>
                                                </div>
                                            @endif
                                        @elseif($file_lama)
                                            @if ($type == 'image')
                                                <img src="{{ asset('storage/' . $file_lama) }}" class="w-100 h-100 shadow rounded-lg" style="object-fit: contain;">
                                            @else
                                                <video src="{{ asset('storage/' . $file_lama) }}" class="w-100 shadow rounded-lg" height="280" controls muted></video>
                                            @endif
                                        @else
                                            <div class="text-center opacity-40">
                                                <i class="mdi mdi-image-filter mdi-64px text-muted"></i>
                                                <p class="small fw-medium mb-0">Belum ada media dipilih</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="batal">Batal</button>
                            <button type="submit" class="btn btn-warning text-dark px-5 rounded-pill fw-bold shadow-sm" wire:loading.attr="disabled" wire:target="save" style="background: linear-gradient(135deg, #FF9966, #FF5E62); border: none; color: white !important;">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                <i class="mdi mdi-cloud-upload-outline me-1"></i> {{ $editMode ? 'Perbarui Media' : 'Publikasikan Sekarang' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if($showDeleteModal)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__zoomIn" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-body p-5 text-center">
                        <div class="bg-danger-subtle d-inline-flex p-4 rounded-circle mb-4" style="background: #ffebee;">
                            <i class="mdi mdi-image-remove text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Hapus Item Gallery?</h4>
                        <p class="text-muted mb-4">Berkas fisik media milik "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen dari server.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus"
                                wire:loading.attr="disabled" wire:target="hapus">
                                <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Hapus Berkas
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
            background-color: #fffaf0 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .transition-img {
            transition: transform 0.5s ease;
        }
        .gallery-preview-card:hover .transition-img {
            transform: scale(1.1);
        }
        .scale-hover {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .gallery-preview-card:hover .scale-hover {
            transform: scale(1.2);
        }
    </style>
</div>