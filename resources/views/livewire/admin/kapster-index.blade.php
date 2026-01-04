<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Data Kapster</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="cari" wire:model.live="search" id="search" placeholder="Cari..."
                    class="form-control">
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" wire:click.prevent="showCreateForm" wire:loading.attr="disabled"
                    wire:target="showCreateForm">
                    <span wire:loading wire:target="showCreateForm" class="spinner-border spinner-border-sm me-1"
                        role="status" aria-hidden="true"></span>
                    Tambah
                </button>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>No. WA</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataKapster as $dtkapster)
                                        <tr>
                                            <td>
                                                @if($dtkapster->foto)
                                                    <img src="{{ asset('storage/' . $dtkapster->foto) }}" width="60"
                                                        class="img-thumbnail">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $dtkapster->nama }}</td>
                                            <td>{{ $dtkapster->nik }}</td>
                                            <td>{{ $dtkapster->no_wa }}</td>
                                            <td>{{ $dtkapster->alamat }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" wire:click="edit({{ $dtkapster->id }})"
                                                    wire:loading.attr="disabled" wire:target="edit({{ $dtkapster->id }})">
                                                    <span wire:loading wire:target="edit({{ $dtkapster->id }})"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="confirmDelete({{ $dtkapster->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="confirmDelete({{ $dtkapster->id }})">
                                                    <span wire:loading wire:target="confirmDelete({{ $dtkapster->id }})"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true"></span>
                                                    Hapus
                                                </button>
                                                @if ($showDeleteModal ?? false)
                                                    <div class="modal d-block" tabindex="-1" role="dialog"
                                                        style="background:rgba(0,0,0,0.01);">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus
                                                                        <b>{{ $dtkapster->nama }}</b>
                                                                        ini?
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        wire:click="cancelDelete">Batal</button>
                                                                    <button type="button" class="btn btn-danger"
                                                                        wire:click="hapus({{ $deleteId }})"
                                                                        wire:loading.attr="disabled" wire:target="hapus">
                                                                        <span wire:loading wire:target="hapus"
                                                                            class="spinner-border spinner-border-sm me-1"
                                                                            role="status" aria-hidden="true"></span>
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-12">
                {{ $dataKapster->links() }}
            </div>
        </div>
    </div>

    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $kapsterIdEdit ? 'Edit Kapster' : 'Tambah Kapster' }}</h5>
                    </div>
                    <div class="modal-body" style="overflow-y:auto; max-height:70vh;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" wire:model.defer="nama">
                                        @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>NIK</label>
                                        <input type="text" class="form-control" wire:model.defer="nik">
                                        @error('nik') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>No. WA</label>
                                        <input type="text" class="form-control" wire:model.defer="no_wa">
                                        @error('no_wa') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label>Alamat</label>
                                        <textarea class="form-control" wire:model.defer="alamat"></textarea>
                                        @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" wire:model="foto" accept="image/*">
                                        @if ($foto)
                                            <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail mt-2" width="100">
                                        @elseif ($foto_lama)
                                            <img src="{{ asset('storage/' . $foto_lama) }}" class="img-thumbnail mt-2"
                                                width="100">
                                        @endif
                                        @error('foto') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click.prevent="batal">Batal</button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="simpan"
                            wire:loading.attr="disabled" wire:target="simpan">
                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"
                                role="status" aria-hidden="true"></span>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- content-wrapper ends -->
    @include('backend.template.footer')
</div>
<!-- main-panel ends -->