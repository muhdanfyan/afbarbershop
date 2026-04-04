<div>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 mb-4 mb-xl-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-dark">Playlist Studio</h4>
                        <p class="font-weight-normal mb-2 text-muted">Kelola Daftar Putar YouTube untuk Layar Antrean</p>
                    </div>
                    <button wire:click="create()" class="btn px-4 py-2" style="background: linear-gradient(135deg, #d4af37, #b8972e); color: #000; font-weight: 700; border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);">
                        <i class="mdi mdi-plus me-1"></i> Tambah Playlist
                    </button>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success mt-3" style="border-radius: 12px; font-weight: 600;">
                    <i class="mdi mdi-check-circle me-1"></i> {{ session('message') }}
                </div>
            @endif

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card stat-card border-0" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead style="background: #111827; color: #fff;">
                                        <tr>
                                            <th class="border-0 px-4 py-3" style="border-top-left-radius: 12px; border-bottom-left-radius: 12px;">#</th>
                                            <th class="border-0 px-4 py-3">Urutan</th>
                                            <th class="border-0 px-4 py-3">Nama Playlist</th>
                                            <th class="border-0 px-4 py-3">Jenis</th>
                                            <th class="border-0 px-4 py-3">Videl / Playlist ID</th>
                                            <th class="border-0 px-4 py-3">Status</th>
                                            <th class="border-0 px-4 py-3" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; text-align:right;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($playlists as $index => $row)
                                            <tr>
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: bold; padding: 0.5rem 0.8rem; border-radius: 8px;">
                                                        {{ $row->urutan }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 fw-bold">{{ $row->judul }}</td>
                                                <td class="px-4 py-3">
                                                    @if($row->jenis === 'youtube_playlist')
                                                        <span class="badge" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;"><i class="mdi mdi-playlist-play"></i> YT Playlist</span>
                                                    @else
                                                        <span class="badge" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;"><i class="mdi mdi-video"></i> YT Video</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-muted code" style="font-family: monospace;">{{ $row->url_id }}</td>
                                                <td class="px-4 py-3">
                                                    <button wire:click="toggleStatus({{ $row->id }})" class="btn btn-sm d-flex align-items-center justify-content-center" style="border-radius: 8px; width: 40px; height: 35px; background: {{ $row->status ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $row->status ? '#22c55e' : '#ef4444' }}; border: none;">
                                                        <i class="mdi {{ $row->status ? 'mdi-toggle-switch' : 'mdi-toggle-switch-off' }}" style="font-size: 1.5rem;"></i>
                                                    </button>
                                                </td>
                                                <td class="px-4 py-3 text-end" style="text-align: right;">
                                                    <button wire:click="edit({{ $row->id }})" class="btn btn-sm btn-icon" style="background: #f8fafc; color: #3b82f6; border-radius: 8px;">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                    <button wire:click="delete({{ $row->id }})" class="btn btn-sm btn-icon ms-1" style="background: #f8fafc; color: #ef4444; border-radius: 8px;" onclick="confirm('Apakah Anda yakin ingin menghapus data ini?') || event.stopImmediatePropagation()">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5 text-muted">
                                                    <i class="mdi mdi-music-note-off mdi-48px d-block mb-3 opacity-25"></i>
                                                    <p class="mb-0">Belum ada kompilasi Playlist yang ditambahkan.</p>
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
        </div>
        @include('backend.template.footer')
    </div>

    @if($isModalOpen)
    <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 1.5rem;">
                    <h5 class="modal-title fw-bold">{{ $playlist_id ? 'Edit Playlist' : 'Tambah Playlist Baru' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" style="border: none; background: transparent;"><i class="mdi mdi-close fs-4"></i></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Judul Playlist</label>
                        <input type="text" class="form-control" wire:model="judul" placeholder="Contoh: Barber Lofi Mix 1" style="border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('judul') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Jenis Tayangan</label>
                        <select class="form-control" wire:model="jenis" style="border-radius: 8px; padding: 0.6rem 1rem; appearance: auto;">
                            <option value="youtube_video">Satu Video Youtube (Bisa Digabung ke Antrean Video Lain)</option>
                            <option value="youtube_playlist">YouTube Playlist (Satu Tautan Penuh)</option>
                        </select>
                        @error('jenis') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Youtube Video/Playlist ID</label>
                        <input type="text" class="form-control" wire:model="url_id" placeholder="Cth: jfKfPfyJRdk" style="border-radius: 8px; padding: 0.6rem 1rem;">
                        <small class="text-muted mt-1 d-block">Ambil dari huruf di akhir link youtube (setelah ?v= atau &list=)</small>
                        @error('url_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Urutan Putar</label>
                        <input type="number" class="form-control" wire:model="urutan" style="border-radius: 8px; padding: 0.6rem 1rem;">
                        @error('urutan') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 1.5rem;">
                    <button type="button" class="btn text-muted" wire:click="closeModal()" style="font-weight: 600;">Batal</button>
                    <button type="button" class="btn btn-primary px-4" wire:click="store()" style="border-radius: 8px; font-weight: 600;">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
