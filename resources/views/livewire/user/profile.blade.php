<div class="container py-4">
    <h4 class="mb-4">Profil Saya</h4>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="mb-3">
                @if ($foto)
                    <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail rounded-circle" width="120">
                @elseif ($foto_lama)
                    <img src="{{ asset('storage/' . $foto_lama) }}" class="img-thumbnail rounded-circle" width="120">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}" class="img-thumbnail rounded-circle"
                        width="120">
                @endif
            </div>
            <input type="file" class="form-control mb-2" wire:model="foto" accept="image/*">
            @error('foto') <span class="text-danger">{{ $message }}</span> @enderror
            <button class="btn btn-primary w-100" wire:click="updateProfile" wire:loading.attr="disabled" wire:target="updateProfile,foto">
                <span wire:loading wire:target="updateProfile,foto" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Simpan Profil
            </button>
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" class="form-control" wire:model.defer="name" autocomplete="off">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" wire:model.defer="email" autocomplete="off">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <hr>
            <h5>Ubah Password</h5>
            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" class="form-control" wire:model.defer="password" autocomplete="new-password">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control" wire:model.defer="password_confirmation" autocomplete="new-password">
            </div>
            <button class="btn btn-warning" wire:click="updatePassword" wire:loading.attr="disabled" wire:target="updatePassword">
                <span wire:loading wire:target="updatePassword" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Ubah Password
            </button>
        </div>
    </div>
</div>