<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Data User</h4>
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
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataUser as $dtuser)
                                        <tr>
                                            <td>{{ $dtuser->name }}</td>
                                            <td>{{ $dtuser->email }}</td>
                                            <td>{{ ucfirst($dtuser->level) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" wire:click="edit({{ $dtuser->id }})"
                                                    wire:loading.attr="disabled" wire:target="edit({{ $dtuser->id }})">
                                                    <span wire:loading wire:target="edit({{ $dtuser->id }})"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="confirmDelete({{ $dtuser->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="confirmDelete({{ $dtuser->id }})">
                                                    <span wire:loading wire:target="confirmDelete({{ $dtuser->id }})"
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
                                                                        <b>{{ $dtuser->name }}</b>
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
                {{ $dataUser->links() }}
            </div>
        </div>
    </div>

    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $userIdEdit ? 'Edit User' : 'Tambah User' }}</h5>
                    </div>
                    <div class="modal-body" style="overflow-y:auto; max-height:70vh;">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" wire:model.defer="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" wire:model.defer="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" wire:model.defer="password"
                                placeholder="{{ $userIdEdit ? 'Kosongkan jika tidak diubah' : '' }}">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select class="form-control" wire:model.defer="level">
                                <option value="">Pilih Level</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="kapster">Kapster</option>
                            </select>
                            @error('level') <span class="text-danger">{{ $message }}</span> @enderror
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