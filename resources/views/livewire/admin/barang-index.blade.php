<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
                <h4 class="font-weight-bold text-dark">Data Barang</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="cari" wire:model.live="search" id="search" placeholder="Cari..."
                    class="form-control">
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <!-- Button trigger modal -->
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
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataBarang as $dtbarang)
                                        <tr>
                                            <td>{{ $dtbarang->nama }}</td>
                                            <td>{{ $dtbarang->deskripsi }}</td>
                                            <td>{{ number_format($dtbarang->harga_beli, 0, ',', '.') }}</td>
                                            <td>{{ number_format($dtbarang->harga_jual, 0, ',', '.') }}</td>
                                            <td>{{ $dtbarang->stok }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" wire:click="edit({{ $dtbarang->id }})"
                                                    wire:loading.attr="disabled" wire:target="edit({{ $dtbarang->id }})">
                                                    <span wire:loading wire:target="edit({{ $dtbarang->id }})"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true"></span>
                                                    Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="confirmDelete({{ $dtbarang->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="confirmDelete({{ $dtbarang->id }})">
                                                    <span wire:loading wire:target="confirmDelete({{ $dtbarang->id }})"
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
                                                                        <b>{{ $dtbarang->nama }}</b>
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
                {{ $dataBarang->links() }}
            </div>
        </div>
    </div>

    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $barangIdEdit ? 'Edit Barang' : 'Tambah Barang' }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" wire:model.defer="nama_barang">
                            @error('nama_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" wire:model.defer="deskripsi">
                        </div>
                        <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="number" class="form-control" wire:model.defer="harga_beli">
                            @error('harga_beli') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" class="form-control" wire:model.defer="harga_jual">
                            @error('harga_jual') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" wire:model.defer="stok">
                            @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click.prevent="batal">Batal</button>
                        @if ($barangIdEdit)
                            <button type="button" class="btn btn-primary" wire:click.prevent="simpan"
                                wire:loading.attr="disabled" wire:target="simpan">
                                <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"
                                    role="status" aria-hidden="true"></span>
                                Simpan
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click.prevent="simpan"
                                wire:loading.attr="disabled" wire:target="simpan">
                                <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"
                                    role="status" aria-hidden="true"></span>
                                Simpan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- content-wrapper ends -->
    @include('backend.template.footer')
</div>
<!-- main-panel ends -->