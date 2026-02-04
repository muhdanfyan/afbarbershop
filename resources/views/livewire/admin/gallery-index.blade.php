<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Gallery Foto & Video</h4>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12 d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-primary" wire:click="showForm" wire:loading.attr="disabled">
                    <span wire:loading wire:target="showForm" class="spinner-border spinner-border-sm me-1"></span>
                    Tambah Gallery
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tipe</th>
                                        <th>Preview</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $gallery->title }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $gallery->type == 'image' ? 'badge-info' : 'badge-warning' }}">
                                                    {{ ucfirst($gallery->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($gallery->type == 'image')
                                                    <img src="{{ asset('storage/' . $gallery->file) }}" width="80"
                                                        class="img-thumbnail">
                                                @else
                                                    <video src="{{ asset('storage/' . $gallery->file) }}" width="100" controls
                                                        class="img-thumbnail" style="max-height: 80px;"></video>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($gallery->description, 50) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" wire:click="edit({{ $gallery->id }})">
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="confirmDelete({{ $gallery->id }})">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data gallery.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    @if($isFormOpen)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block" tabindex="-1" role="dialog" style="z-index: 1050; overflow-y: auto;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Edit Gallery' : 'Tambah Gallery' }}</h5>
                        <button type="button" class="close" wire:click="batal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="save">
                        <div class="modal-body" style="overflow-y:auto; max-height:75vh;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" wire:model="title">
                                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tipe</label>
                                    <select class="form-control" wire:model="type">
                                        <option value="image">Foto</option>
                                        <option value="video">Video</option>
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>File (Foto/Video)</label>
                                    <input type="file" class="form-control" wire:model="file">
                                    <div wire:loading wire:target="file" class="text-info">Uploading...</div>
                                    @error('file') <span class="text-danger">{{ $message }}</span> @enderror

                                    @if ($file)
                                        <div class="mt-2 text-center">
                                            @if ($type == 'image')
                                                Preview: <img src="{{ $file->temporaryUrl() }}" width="150" class="img-thumbnail">
                                            @else
                                                Preview: <video src="{{ $file->temporaryUrl() }}" width="200" muted></video>
                                            @endif
                                        </div>
                                    @elseif($file_lama)
                                        <div class="mt-2 text-center">
                                            <p class="mb-1 text-muted">File Saat Ini:</p>
                                            @if ($type == 'image')
                                                <img src="{{ asset('storage/' . $file_lama) }}" width="150" class="img-thumbnail">
                                            @else
                                                <video src="{{ asset('storage/' . $file_lama) }}" width="200" controls muted
                                                    class="img-thumbnail"></video>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" wire:model="description" rows="3"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="batal">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Hapus -->
    @if($showDeleteModal)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Batal</button>
                        <button type="button" class="btn btn-danger" wire:click="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('backend.template.footer')
</div>