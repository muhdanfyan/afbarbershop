<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #8E2DE2, #4A00E0);">
                    <i class="mdi mdi-card-account-details text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Manajemen Member</h4>
                    <p class="text-muted small mb-0">Kelola database pelanggan setia dan poin reward</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-account-plus-outline me-1"></i> Registrasi Member Baru
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama atau nomor WhatsApp...">
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 80px;">ID</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Profil Member</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Kontak</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Loyalty Info</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Level</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Domisili</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $i => $m)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">
                                                #{{ ($members->firstItem() ?? 0) + $i }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border shadow-sm" style="width: 40px; height: 40px;">
                                                    <i class="mdi mdi-account text-muted fs-5"></i>
                                                </div>
                                                <span class="fw-bold text-dark fs-6">{{ $m->nama }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $m->nomor_wa) }}" target="_blank" class="text-success text-decoration-none d-flex align-items-center">
                                                <div class="bg-success-subtle p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                    <i class="mdi mdi-whatsapp small"></i>
                                                </div>
                                                <span class="small fw-medium">{{ $m->nomor_wa }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-warning small"><i class="mdi mdi-star me-1"></i>{{ number_format($m->poin, 0, ',', '.') }} Poin</span>
                                                <span class="text-secondary" style="font-size: 0.7rem;">{{ $m->total_kunjungan }} Kunjungan</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $levelClass = match(strtolower($m->level)) {
                                                    'platinum' => 'bg-dark text-warning border-warning',
                                                    'gold' => 'bg-warning-subtle text-warning border-warning',
                                                    default => 'bg-light text-secondary border'
                                                };
                                            @endphp
                                            <span class="badge rounded-pill px-3 py-2 border {{ $levelClass }} fw-bold" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px;">
                                                {{ $m->level ?: 'Silver' }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $m->alamat ?? 'Alamat tidak terdata' }}
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $m->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $m->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
                                                    <i class="mdi mdi-trash-can-outline fs-5"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="empty-state py-5">
                                                <div class="mb-4 bg-light d-inline-flex p-4 rounded-circle border shadow-sm">
                                                    <i class="mdi mdi-account-multiple-outline mdi-48px text-muted"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Data Member Masih Kosong</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat belum ada pelanggan yang terdaftar sebagai member. Loyalitas pelanggan dimulai di sini.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Registrasi Member Perdana
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
        {{ $members->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-account-star fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $memberIdEdit ? 'Ubah Data Membership' : 'Pendaftaran Member Premium' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click.prevent="resetForm" wire:click="$set('showForm', false)">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama Lengkap Pelanggan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none"><i class="mdi mdi-account-outline text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="nama" placeholder="Masukkan nama (mis: Ahmad Dani)">
                            </div>
                            @error('nama') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nomor WhatsApp Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none"><i class="mdi mdi-whatsapp text-muted"></i></span>
                                <input type="text" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="nomor_wa" placeholder="08xxxxxxxxxxx">
                            </div>
                            @error('nomor_wa') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Alamat Domisili (Opsional)</label>
                            <textarea class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="alamat" rows="2" placeholder="Tuliskan alamat singkat pelanggan..."></textarea>
                            @error('alamat') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                                Simpan Membership
                            </button>
                            <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" wire:click.prevent="resetForm" wire:click="$set('showForm', false)">
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
                                <i class="mdi mdi-account-off-outline" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Hentikan Membership?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Member <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen dari sistem loyalitas Anda.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="delete({{ $deleteId }})" wire:loading.attr="disabled" wire:target="delete">
                            <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Permanen
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
            background-color: #fff5f8 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>