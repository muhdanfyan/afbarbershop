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
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-television-guide text-warning fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $playlist_id ? 'Perbarui Konten Studio' : 'Konfigurasi Konten Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal()"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Tampilan Studio</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="mdi mdi-format-title text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" wire:model="judul" placeholder="Cth: Barber Music Night">
                            </div>
                            @error('judul') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Tipe Konten Media</label>
                                <select class="form-select" wire:model="jenis">
                                    <optgroup label="YouTube">
                                        <option value="youtube_video">Single Video</option>
                                        <option value="youtube_playlist">Playlist Link</option>
                                    </optgroup>
                                    <optgroup label="Spotify">
                                        <option value="spotify_playlist">Spotify Playlist</option>
                                        <option value="spotify_track">Spotify Track</option>
                                    </optgroup>
                                </select>
                                @error('jenis') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Urutan</label>
                                <input type="number" class="form-control" wire:model="urutan">
                                @error('urutan') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">Media Content URL / ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="mdi {{ str_contains($jenis, 'spotify') ? 'mdi-spotify text-success' : 'mdi-youtube text-danger' }}"></i></span>
                                <input type="text" class="form-control border-start-0" wire:model="url_id" placeholder="Copy-paste URL dari browser">
                            </div>
                            <div class="mt-2 text-center p-3 rounded bg-light border border-dashed">
                                @if(str_contains($jenis, 'spotify'))
                                    <span class="text-muted small">Target: <strong>Spotify {{ str_replace('spotify_', '', $jenis) }}</strong></span>
                                @else
                                    <span class="text-muted small">Preview: <strong>https://youtube.com/{{ $jenis == 'youtube_playlist' ? 'playlist?list=' : 'watch?v=' }}{{ $url_id ?: '...' }}</strong></span>
                                @endif
                            </div>
                            @error('url_id') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="closeModal()">Batal</button>
                        <button type="button" class="btn btn-premium-add text-dark px-4 rounded-pill fw-bold shadow-sm" wire:click="store()"
                            wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading wire:target="store" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-content-save-check me-1"></i> Aktifkan Konten
                        </button>
                    </div>
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
                            <i class="mdi mdi-delete-variant text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Lepas Konten Studio?</h4>
                        <p class="text-muted mb-4">Konten "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen dari daftar putar.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="delete({{ $deleteId }})"
                                wire:loading.attr="disabled" wire:target="delete">
                                <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Hapus Sekarang
                            </button>
                        </div>
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

