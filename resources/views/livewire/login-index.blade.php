<div>
    <form id="member-login" wire:submit="proses_login">
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="form-group">
            <input class="form-control" type="text" id="email" wire:model="email" placeholder="Email">
        </div>
        @error('email')
            <span class="text-danger" style="font-size:12px; margin-left:15px;">{{ $message }}</span>
        @enderror

        <div class="form-group position-relative">
            <input class="form-control" id="psw-input" type="password" wire:model="password"
                placeholder="Enter Password">
            <div class="position-absolute" id="password-visibility">
                <i class="bi bi-eye"></i>
                <i class="bi bi-eye-slash"></i>
            </div>
        </div>
        @error('password')
            <span class="text-danger" style="font-size:12px; margin-left:15px;">{{ $message }}</span>
        @enderror


        <button class="btn btn-primary w-100" type="submit">Sign In</button>
    </form>
</div>