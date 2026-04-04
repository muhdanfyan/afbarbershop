<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #6a11cb, #2575fc);">
                    <i class="mdi mdi-shield-account text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Manajemen Akses User</h4>
                    <p class="text-muted small mb-0">Kelola kredensial login, hak akses, dan profil tim AF Barbershop</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-account-plus-outline me-1"></i> Tambah User Baru
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama, email, atau hak akses...">
            </div>
        </div>
    </div>

    <!-- Alert Section -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show mb-4 animate__animated animate__fadeInDown" role="alert" style="border-radius: 15px; background: #e8f5e9;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-check-circle text-success mdi-24px me-3"></i>
                <span class="text-success fw-bold">{{ session('message') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Informasi Akun</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Email</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Hak Akses</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataUser as $dtuser)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border shadow-sm" style="width: 45px; height: 45px;">
                                                    <i class="mdi mdi-account-circle text-muted fs-4"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block fs-6 leading-tight">{{ $dtuser->name }}</span>
                                                    <span class="text-muted small">@@{{ $dtuser->username }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="mdi mdi-email-outline text-muted me-2"></i>
                                                <span class="small text-dark">{{ $dtuser->email }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($dtuser->level == 'admin')
                                                <span class="badge border-0 rounded-pill px-3 py-1 bg-primary-subtle text-primary fw-bold border border-primary">
                                                    <i class="mdi mdi-shield-crown-outline me-1"></i> ADMIN
                                                </span>
                                            @elseif($dtuser->level == 'kasir')
                                                <span class="badge border-0 rounded-pill px-3 py-1 bg-info-subtle text-info fw-bold border border-info">
                                                    <i class="mdi mdi-cash-register me-1"></i> KASIR
                                                </span>
                                            @else
                                                <span class="badge border-0 rounded-pill px-3 py-1 bg-secondary-subtle text-secondary fw-bold border border-secondary">
                                                    <i class="mdi mdi-account-cog-outline me-1"></i> {{ strtoupper($dtuser->level) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $dtuser->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $dtuser->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-account-group-outline mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Data Pengguna Kosong</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat belum ada pengguna tambahan yang terdaftar. Segera tambahkan tim Anda untuk kolaborasi.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Daftarkan User Baru
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $dataUser->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-account-key text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $userIdEdit ? 'Sempurnakan Kredensial User' : 'Buat Akses User Baru' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="batal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Username Login</label>
                                <div class="input-group shadow-sm rounded overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i class="mdi mdi-at text-muted"></i></span>
                                    <input type="text" class="form-control border-0 bg-light" wire:model.defer="username" placeholder="cth: kasir_afbarber">
                                </div>
                                @error('username') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model.defer="name" placeholder="cth: Ahmad Suhendar">
                                @error('name') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                                <div class="input-group shadow-sm rounded overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i class="mdi mdi-email-outline text-muted"></i></span>
                                    <input type="email" class="form-control border-0 bg-light" wire:model.defer="email" placeholder="tim@afbarber.id">
                                </div>
                                @error('email') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Kata Sandi</label>
                                <div class="input-group shadow-sm rounded overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i class="mdi mdi-lock-outline text-muted"></i></span>
                                    <input type="password" class="form-control border-0 bg-light" wire:model.defer="password" placeholder="{{ $userIdEdit ? 'Opsional' : 'Min. 6 Karakter' }}">
                                </div>
                                @error('password') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                @if($userIdEdit) <p class="text-muted italic small mt-1">Kosongkan jika tidak diubah</p> @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Level Hak Akses</label>
                                <select class="form-select shadow-sm border-0 bg-light fw-bold" wire:model.defer="level">
                                    <option value="">Pilih Member...</option>
                                    <option value="admin">Administrator</option>
                                    <option value="kasir">Kasir Toko</option>
                                    <option value="kapster">Tim Kapster</option>
                                </select>
                                @error('level') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click.prevent="batal">Batal</button>
                        <button type="button" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm" wire:click.prevent="simpan"
                            wire:loading.attr="disabled" wire:target="simpan" style="background: linear-gradient(135deg, #6a11cb, #2575fc); border: none;">
                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-content-save-check me-1"></i> Simpan Akses
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if ($showDeleteModal ?? false)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__zoomIn" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-body p-5 text-center">
                        <div class="bg-danger-subtle d-inline-flex p-4 rounded-circle mb-4" style="background: #ffebee;">
                            <i class="mdi mdi-account-remove-outline text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Hapus Akses Pengguna?</h4>
                        <p class="text-muted mb-4">Akun milik "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen. Pengguna tidak akan dapat login kembali.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus({{ $deleteId }})"
                                wire:loading.attr="disabled" wire:target="hapus">
                                <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Hapus Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f0f7ff !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>