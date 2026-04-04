<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #0f3443, #34e89e);">
                    <i class="mdi mdi-account-star text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Manajemen Kapster (Barberman)</h4>
                    <p class="text-muted small mb-0">Kelola tim profesional, kualifikasi, dan ketersediaan mereka</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Tim Baru
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama, NIK, atau no WhatsApp...">
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Barber / Tim</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted text-center">Status</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Kredensial</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Kontak</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataKapster as $dtkapster)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($dtkapster->foto)
                                                    <img src="{{ asset('storage/' . $dtkapster->foto) }}" class="rounded-circle me-3 border border-2 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border border-2" style="width: 50px; height: 50px;">
                                                        <i class="mdi mdi-account text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-bold text-dark d-block fs-6 leading-tight">{{ $dtkapster->nama }}</span>
                                                    <span class="text-muted small">NIK: {{ $dtkapster->nik }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div wire:click="toggleStatus({{ $dtkapster->id }})" class="cursor-pointer">
                                                @if($dtkapster->status == 'bekerja')
                                                    <span class="badge border-0 rounded-pill px-3 py-1 bg-success-subtle text-success fw-bold border border-success">
                                                        <i class="mdi mdi-circle-medium me-1"></i> AKTIF
                                                    </span>
                                                @else
                                                    <span class="badge border-0 rounded-pill px-3 py-1 bg-danger-subtle text-danger fw-bold border border-danger">
                                                        <i class="mdi mdi-circle-medium me-1"></i> LIBUR
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($dtkapster->sertifikat)
                                                <a href="{{ asset('storage/' . $dtkapster->sertifikat) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small text-primary">
                                                    <i class="mdi mdi-certificate me-1"></i> Lihat Lisensi
                                                </a>
                                            @else
                                                <span class="text-muted small italic">Sertifikat belum diunggah</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success-subtle p-2 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                                    <i class="mdi mdi-whatsapp text-success small"></i>
                                                </div>
                                                <span class="small fw-medium text-dark">{{ $dtkapster->no_wa }}</span>
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $dtkapster->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $dtkapster->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
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
                                                <h5 class="fw-bold text-dark">Barber Studio Masih Kosong</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat Anda belum mendaftarkan tim kapster atau barber ke dalam studio Anda.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Daftarkan Tim Pertama
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
        {{ $dataKapster->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show"></div>
        <div class="modal d-block animate__animated animate__fadeIn" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 25px;">
                    <div class="modal-header border-0 p-4 pb-0">
                        <div class="bg-light p-2 rounded-circle me-3">
                            <i class="mdi mdi-account-plus text-success fs-3"></i>
                        </div>
                        <h5 class="modal-title font-weight-bold text-dark">{{ $kapsterIdEdit ? 'Sempurnakan Profil Tim' : 'Registrasi Tim Profesional' }}</h5>
                        <button type="button" class="btn-close" wire:click.prevent="batal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-3 text-center border-end">
                                <label class="form-label small fw-bold text-uppercase text-muted d-block">Pas Foto Profile</label>
                                <div class="position-relative d-inline-block p-1 border rounded-circle bg-white shadow-sm mb-3">
                                    @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    @elseif ($foto_lama)
                                        <img src="{{ asset('storage/' . $foto_lama) }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                            <i class="mdi mdi-account mdi-48px text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3 px-3">
                                    <input type="file" class="form-control form-control-sm" wire:model="foto" accept="image/*">
                                    @error('foto') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                                
                                <label class="form-label small fw-bold text-uppercase text-muted d-block mt-4 text-start ms-3">Unggah Lisensi / Sertifikat</label>
                                <div class="px-3">
                                    <div class="bg-light p-3 rounded text-center border border-dashed">
                                        <input type="file" class="form-control form-control-sm mb-2" wire:model="sertifikat">
                                        @if ($sertifikat_lama)
                                            <p class="small text-info mb-0"><i class="mdi mdi-file-check me-1"></i>Sertifikat tersimpan</p>
                                        @endif
                                    </div>
                                    @error('sertifikat') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap Profesional</label>
                                        <input type="text" class="form-control shadow-sm border-0 bg-light" wire:model.defer="nama" placeholder="Masukkan nama lengkap barber...">
                                        @error('nama') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Status Kepegawaian</label>
                                        <select class="form-select shadow-sm border-0 bg-light fw-bold" wire:model.defer="status">
                                            <option value="bekerja">🟢 Aktif Bekerja</option>
                                            <option value="libur">🔴 Sedang Libur</option>
                                        </select>
                                        @error('status') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Nomor Identitas (NIK)</label>
                                        <div class="input-group shadow-sm rounded overflow-hidden">
                                            <span class="input-group-text bg-white border-0"><i class="mdi mdi-card-account-details-outline text-muted"></i></span>
                                            <input type="text" class="form-control border-0 bg-light" wire:model.defer="nik" placeholder="KTP / ID Card Number">
                                        </div>
                                        @error('nik') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Nomor WhatsApp Aktif</label>
                                        <div class="input-group shadow-sm rounded overflow-hidden">
                                            <span class="input-group-text bg-white border-0"><i class="mdi mdi-whatsapp text-success"></i></span>
                                            <input type="text" class="form-control border-0 bg-light" wire:model.defer="no_wa" placeholder="08xxxxxxxxxxx">
                                        </div>
                                        @error('no_wa') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12 mt-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Alamat Domisili Lengkap</label>
                                        <textarea class="form-control shadow-sm border-0 bg-light" wire:model.defer="alamat" rows="4" placeholder="Tuliskan alamat lengkap tempat tinggal saat ini..."></textarea>
                                        @error('alamat') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click.prevent="batal">Batal</button>
                        <button type="button" class="btn btn-premium-add text-dark px-4 rounded-pill fw-bold shadow-sm animate__animated animate__headShake" wire:click.prevent="simpan"
                            wire:loading.attr="disabled" wire:target="simpan">
                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-1"></span>
                            <i class="mdi mdi-account-check me-1"></i> Simpan Registrasi
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
                        <h4 class="font-weight-bold text-dark mb-2">Non-Aktifkan Keanggotaan?</h4>
                        <p class="text-muted mb-4">Profil Barber "<strong>{{ $deleteNama }}</strong>" akan dihapus permanen dari tim Anda.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" wire:click="cancelDelete">Batalkan</button>
                            <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold shadow-sm" wire:click="hapus({{ $deleteId }})"
                                wire:loading.attr="disabled" wire:target="hapus">
                                <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-1"></span>
                                Ya, Lepaskan Keanggotaan
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
            background-color: #f6fff9 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</div>