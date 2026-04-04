<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF512F, #DD2476);">
                    <i class="mdi mdi-account-star text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Data Membership Pelanggan</h4>
                    <p class="text-muted small mb-0">Kelola riwayat kunjungan dan status loyalitas member AF Barbershop</p>
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
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-account-star text-primary fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $memberIdEdit ? 'Ubah Data Membership' : 'Pendaftaran Member Premium' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="resetForm" wire:click="$set('showForm', false)"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap Pelanggan</label>
                            <div class="input-group shadow-sm rounded overflow-hidden">
                                <span class="input-group-text bg-white border-0"><i class="mdi mdi-account-outline text-muted"></i></span>
                                <input type="text" class="form-control border-0 bg-light" wire:model.defer="nama" placeholder="Masukkan nama (mis: Ahmad Dani)">
                            </div>
                            @error('nama') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nomor WhatsApp Aktif</label>
                            <div class="input-group shadow-sm rounded overflow-hidden">
                                <span class="input-group-text bg-white border-0"><i class="mdi mdi-whatsapp text-success"></i></span>
                                <input type="text" class="form-control border-0 bg-light" wire:model.defer="nomor_wa" placeholder="08xxxxxxxxxxx">
                            </div>
                            @error('nomor_wa') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat Domisili (Opsional)</label>
                            <textarea class="form-control shadow-sm border-0 bg-light" wire:model.defer="alamat" rows="3" placeholder="Tuliskan alamat singkat pelanggan..."></textarea>
                            @error('alamat') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click.prevent="resetForm" wire:click="$set('showForm', false)">Batal</button>
                        <button type="button" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm" wire:click="save"
                            wire:loading.attr="disabled" wire:target="save" style="background: linear-gradient(135deg, #FF512F, #DD2476); border: none;">
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-check-decagram me-1"></i> Simpan Membership
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
                            <i class="mdi mdi-account-off-outline text-danger mdi-48px"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-2">Hentikan Membership?</h4>
                        <p class="text-muted mb-4">Member "<strong>{{ $deleteNama }}</strong>" akan dihapus secara permanen dari sistem loyalitas Anda.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="delete({{ $deleteId }})"
                                wire:loading.attr="disabled" wire:target="delete">
                                <span wire:loading wire:target="delete" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Hapus Permanen
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
            background-color: #fff5f8 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>