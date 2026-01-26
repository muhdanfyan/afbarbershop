<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="font-weight-bold text-dark">Data Member</h4>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="cari" wire:model.live="search" id="search" placeholder="Cari..."
                    class="form-control">
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" wire:click.prevent="showCreateForm">Tambah</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor WA</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members as $i => $m)
                                        <tr>
                                            <td>{{ ($members->firstItem() ?? 0) + $i }}</td>
                                            <td>{{ $m->nomor_wa }}</td>
                                            <td>{{ $m->nama }}</td>
                                            <td>{{ $m->alamat ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info"
                                                    wire:click="edit({{ $m->id }})">Edit</button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="delete({{ $m->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($showForm)
            <div class="modal-backdrop fade show"></div>
            <div class="modal d-block" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $memberIdEdit ? 'Edit Member' : 'Tambah Member' }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" class="form-control" wire:model.defer="nama">
                                @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-2">
                                <label>Nomor WA</label>
                                <input type="text" class="form-control" wire:model.defer="nomor_wa">
                                @error('nomor_wa') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-2">
                                <label>Alamat</label>
                                <textarea class="form-control" wire:model.defer="alamat"></textarea>
                                @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('showForm', false)">Batal</button>
                            <button type="button" class="btn btn-primary" wire:click="save">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>