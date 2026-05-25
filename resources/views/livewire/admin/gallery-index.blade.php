<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #00b09b, #96c93d);">
                    <i class="mdi mdi-image-multiple text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Galeri Studio</h4>
                    <p class="text-muted small mb-0">Katalog visual hasil cukur dan suasana AF Barbershop</p>
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
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-image-multiple fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $editMode ? 'Penyuntingan Konten Visual' : 'Unggah Karya Visual Baru' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click="batal">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="mb-4 text-center">
                            <label class="small fw-bold d-block mb-2 text-start" style="color: #475569;">Karya Visual / Media</label>
                            <div class="p-3 border border-dashed rounded-3" style="background-color: #f8fafc;">
                                <div class="bg-white border rounded-3 shadow-sm d-flex justify-content-center align-items-center overflow-hidden mb-3 mx-auto" style="height: 140px; width: 100%;">
                                    @if ($file)
                                        @if ($type == 'image')
                                            <img src="{{ $file->temporaryUrl() }}" class="w-100 h-100 object-fit-cover shadow-sm">
                                        @else
                                            <div class="text-center">
                                                <i class="mdi mdi-video-check mdi-36px text-success mb-1"></i>
                                                <p class="small fw-bold text-dark mb-0">Video Siap Unggah</p>
                                            </div>
                                        @endif
                                    @elseif($file_lama)
                                        @if ($type == 'image')
                                            <img src="{{ asset('storage/' . $file_lama) }}" class="w-100 h-100 object-fit-cover shadow-sm">
                                        @else
                                            <video src="{{ asset('storage/' . $file_lama) }}" class="w-100 h-100 object-fit-cover" muted></video>
                                        @endif
                                    @else
                                        <div class="text-center opacity-50">
                                            <i class="mdi mdi-cloud-upload mdi-36px" style="color: #64748b;"></i>
                                            <p class="small fw-medium mb-0" style="color: #475569;">Pilih file media</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex flex-column mb-1">
                                    <input type="file" class="form-control form-control-sm shadow-none border" wire:model="file">
                                    <div wire:loading wire:target="file" class="text-muted small mt-2 fw-medium">
                                        <i class="mdi mdi-loading mdi-spin me-1"></i>Memproses berkas...
                                    </div>
                                    @error('file') <span class="text-danger small mt-1 text-center fw-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Judul Media</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="title" placeholder="cth: Interior Studio AF Barber">
                            @error('title') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Format Konten</label>
                            <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model="type">
                                <option value="image">Galleri Photo Image</option>
                                <option value="video">Koleksi Video Cinematic</option>
                            </select>
                            @error('type') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Catatan Media</label>
                            <textarea class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="description" rows="2" placeholder="Cerita singkat atau keterangan di balik konten ini..."></textarea>
                            @error('description') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                {{ $editMode ? 'Perbarui Media' : 'Publikasikan Sekarang' }}
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" wire:click="batal">
                                Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if($showDeleteModal)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="text-center mb-4 pt-2">
                        <div class="mb-3">
                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 56px; height: 56px; background-color: #f1f5f9;">
                                <i class="mdi mdi-image-remove" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Hapus Item Gallery?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Berkas media <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen dari server.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="hapus" wire:loading.attr="disabled" wire:target="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Berkas
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