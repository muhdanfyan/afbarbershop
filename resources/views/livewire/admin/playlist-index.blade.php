<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ff0844, #ffb199);">
                    <i class="mdi mdi-youtube-subscription text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Studio Playlist</h4>
                    <p class="text-muted small mb-0">Atur suasana musik dan video untuk kenyamanan pelanggan</p>
                </div>
            </div>
            <button wire:click="create()" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Playlist Baru
            </button>
        </div>
    </div>

    <!-- Alert Section -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show mb-4 animate__animated animate__fadeInDown" role="alert" style="border-radius: 15px; background: #e8f5e9;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-check-alpha text-success mdi-24px me-3"></i>
                <span class="text-success fw-bold">{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 80px;">Urutan</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Konten</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Tipe Media</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Media ID</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Kelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($playlists as $row)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center justify-content-center bg-light fw-bold rounded-3" style="width: 35px; height: 35px; color: #444; border: 1px solid #eee;">
                                                {{ $row->urutan }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 position-relative shadow-sm rounded overflow-hidden" 
                                                    style="width: 65px; height: 48px; background: #222; border: 1px solid #ddd;">
                                                    @if($row->jenis === 'youtube_video' && strlen($row->url_id) == 11)
                                                        <img src="https://img.youtube.com/vi/{{ $row->url_id }}/mqdefault.jpg" 
                                                            style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;"
                                                            onerror="this.parentElement.innerHTML='<div class=\'d-flex align-items-center justify-content-center h-100\'><i class=\'mdi mdi-play-circle text-muted\'></i></div>';">
                                                    @elseif(str_contains($row->jenis, 'spotify'))
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark text-white-50" style="background: #191414 !important;">
                                                            <i class="mdi mdi-spotify fs-3" style="color: #1DB954;"></i>
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100 bg-dark text-white-50">
                                                            <i class="mdi {{ $row->jenis == 'youtube_playlist' ? 'mdi-playlist-play' : 'mdi-video-off' }} fs-5"></i>
                                                        </div>
                                                    @endif
                                                    <div class="position-absolute hover-overlay w-100 h-100 top-0 start-0 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.2); transition: 0.3s; pointer-events: none;">
                                                        <i class="mdi mdi-play text-white opacity-0" style="font-size: 14px;"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block mb-0">{{ $row->judul }}</span>
                                                    <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">{{ str_replace('_', ' ', $row->jenis) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($row->jenis === 'youtube_playlist')
                                                <span class="badge border-0 rounded-pill px-3 py-2 bg-gradient-danger text-white shadow-sm" style="background: linear-gradient(45deg, #f44336, #e91e63);">
                                                    <i class="mdi mdi-youtube me-1"></i> YT Playlist
                                                </span>
                                            @elseif($row->jenis === 'spotify_playlist')
                                                <span class="badge border-0 rounded-pill px-3 py-2 text-white shadow-sm" style="background: linear-gradient(45deg, #1DB954, #191414);">
                                                    <i class="mdi mdi-spotify me-1"></i> Spotify Playlist
                                                </span>
                                            @elseif($row->jenis === 'spotify_track')
                                                <span class="badge border-0 rounded-pill px-3 py-2 text-white shadow-sm" style="background: linear-gradient(45deg, #18ac4d, #14c8d4);">
                                                    <i class="mdi mdi-play-network me-1"></i> Spotify Track
                                                </span>
                                            @else
                                                <span class="badge border-0 rounded-pill px-3 py-2 bg-gradient-primary text-white shadow-sm" style="background: linear-gradient(45deg, #2196f3, #00BCD4);">
                                                    <i class="mdi mdi-video me-1"></i> YT Video
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <code class="bg-light p-2 rounded text-primary small fw-bold border">{{ $row->url_id }}</code>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input custom-switch-gold" type="checkbox" role="switch" 
                                                    {{ $row->status ? 'checked' : '' }}
                                                    wire:click="toggleStatus({{ $row->id }})" style="cursor: pointer; width: 45px; height: 22px;">
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden" style="border: 1px solid #eee;">
                                                <button wire:click="edit({{ $row->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-box-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $row->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
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
                                                    <i class="mdi mdi-youtube-subscription text-muted mdi-48px"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Alunan Studio Belum Tersedia</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Belum ada konten Media (YouTube/Spotify) yang dikonfigurasi untuk tampilan layar antrean. 
                                                    Tambahkan konten pertama Anda sekarang untuk menghidupkan suasana barbershop.
                                                </p>
                                                <button wire:click="create()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Konfigurasi Sekarang
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

    <!-- Modal Form (Tambah/Edit) -->
    @if($isModalOpen)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-television-guide fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $playlist_id ? 'Perbarui Konten Studio' : 'Konfigurasi Konten Baru' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click="closeModal()">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama Konten Studio</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="judul" placeholder="Cth: Barber Music Night">
                            @error('judul') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-8">
                                <label class="small fw-bold d-block mb-1" style="color: #475569;">Tipe Konten Media</label>
                                <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model="jenis">
                                    <optgroup label="YouTube">
                                        <option value="youtube_video">Single Video</option>
                                        <option value="youtube_playlist">Playlist Link</option>
                                    </optgroup>
                                    <optgroup label="Spotify">
                                        <option value="spotify_playlist">Spotify Playlist</option>
                                        <option value="spotify_track">Spotify Track</option>
                                    </optgroup>
                                </select>
                                @error('jenis') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-4">
                                <label class="small fw-bold d-block mb-1" style="color: #475569;">Urutan</label>
                                <input type="number" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium text-center" style="background-color: #f8fafc;" wire:model="urutan">
                                @error('urutan') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Media Content URL / ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none"><i class="mdi {{ str_contains($jenis, 'spotify') ? 'mdi-spotify' : 'mdi-youtube' }} text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.lazy="url_id" placeholder="Paste URL dari browser">
                            </div>
                            @error('url_id') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                            
                            @if($url_id)
                                <div class="mt-3 text-center p-3 rounded-3" style="background-color: #f8fafc; border: 1px dashed #cbd5e1;">
                                    @if(str_contains($jenis, 'spotify'))
                                        <div class="text-dark small fw-medium">
                                            <i class="mdi mdi-check-circle text-success me-1"></i> Format Spotify Terdeteksi
                                        </div>
                                    @else
                                        <div class="text-dark small fw-medium text-truncate px-2">
                                            <i class="mdi mdi-link-variant text-muted me-1"></i> youtube.com/{{ $jenis == 'youtube_playlist' ? 'playlist?list=' : 'watch?v=' }}{{ $url_id ?: '...' }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled" wire:target="store">
                                <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-2"></span>
                                Aktifkan Konten
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" wire:click="closeModal()">
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
                                <i class="mdi mdi-delete-variant" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Lepas Konten Studio?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Konten <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen dari daftar putar.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="delete({{ $deleteId }})" wire:loading.attr="disabled" wire:target="delete">
                            <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .custom-switch-gold:checked {
            background-color: #B8860B !important;
            border-color: #B8860B !important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #fffaf0 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .bg-gradient-danger {
            background: linear-gradient(45deg, #f44336, #e91e63) !important;
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #2196f3, #00BCD4) !important;
        }
    </style>
</div>

