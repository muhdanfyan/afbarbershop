<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #6a11cb, #2575fc);">
                    <i class="mdi mdi-account-lock-outline text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Akses Pengguna</h4>
                    <p class="text-muted small mb-0">Atur hak akses admin dan petugas operasional</p>
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
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 460px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-account-key-outline fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $userIdEdit ? 'Sempurnakan Kredensial' : 'Buat Akses Baru' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click.prevent="batal">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="name" placeholder="cth: Ahmad Suhendar">
                            @error('name') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none"><i class="mdi mdi-email-outline text-muted"></i></span>
                                <input type="email" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="email" placeholder="tim@afbarber.id">
                            </div>
                            @error('email') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Username Login</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none"><i class="mdi mdi-at text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="username" placeholder="kasir_afbarber">
                            </div>
                            @error('username') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="small fw-bold d-block mb-1" style="color: #475569;">Hak Akses</label>
                                <select class="form-select rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="level">
                                    <option value="">Pilih Level...</option>
                                    <option value="admin">Administrator</option>
                                    <option value="kasir">Kasir Toko</option>
                                    <option value="kapster">Tim Kapster</option>
                                </select>
                                @error('level') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold d-block mb-1" style="color: #475569;">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 shadow-none"><i class="mdi mdi-lock-outline text-muted"></i></span>
                                    <input type="password" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="password" placeholder="{{ $userIdEdit ? 'Opsional' : 'Min. 6 Karakter' }}">
                                </div>
                                @error('password') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-2"></span>
                                Simpan Akses
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" wire:click.prevent="batal">
                                Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @if ($showDeleteModal ?? false)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1060;">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="text-center mb-4 pt-2">
                        <div class="mb-3">
                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center" style="width: 56px; height: 56px; background-color: #f1f5f9;">
                                <i class="mdi mdi-account-remove-outline" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Hapus Akses Pengguna?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Akun milik <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen. Pengguna tidak akan dapat login kembali.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="hapus({{ $deleteId }})" wire:loading.attr="disabled" wire:target="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Sekarang
                        </button>
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