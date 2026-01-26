<div class="main-panel">
    <div class="content-wrapper">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="font-weight-bold text-dark">Pengaturan Aplikasi</h4>
            </div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form wire:submit.prevent="simpanSetting" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama_usaha" class="form-label">Nama Usaha</label>
                    <input type="text" class="form-control" id="nama_usaha" wire:model.defer="nama_usaha">
                </div>
                <div class="col-md-6">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="telepon" wire:model.defer="telepon">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" wire:model.defer="email">
                </div>
                <div class="col-md-6">
                    <label for="jam_buka" class="form-label">Jam Buka</label>
                    <textarea class="form-control" id="jam_buka" wire:model.defer="jam_buka"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" wire:model.defer="alamat"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="slogan" class="form-label">Slogan</label>
                    <input type="text" class="form-control" id="slogan" wire:model.defer="slogan">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logo" wire:model="logo" accept="image/*">
                    @if ($logo)
                        @if (is_object($logo) && method_exists($logo, 'temporaryUrl'))
                            {{-- Preview untuk file yang baru saja dipilih --}}
                            <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail mt-2" width="100">
                        @else
                            {{-- Preview untuk gambar lama yang sudah ada di storage (database) --}}
                            <img src="{{ asset('storage/' . $logo) }}" class="img-thumbnail mt-2" width="100">
                        @endif
                    @endif
                    @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>