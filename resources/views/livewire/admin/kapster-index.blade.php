<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #0f3443, #34e89e);">
                    <i class="mdi mdi-account-star text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Tim Professional</h4>
                    <p class="text-muted small mb-0">Kelola kapster andalan untuk layanan terbaik</p>
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
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(8px); background-color: rgba(15, 23, 42, 0.5);"></div>
        <div class="modal d-block animate__animated animate__zoomIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 850px;">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary-subtle p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #f1f5f9;">
                                <i class="mdi mdi-account-star fs-3 text-dark"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 font-premium">{{ $kapsterIdEdit ? 'Edit Profil Tim' : 'Registrasi Tim Profesional' }}</h5>
                                <p class="text-muted small mb-0">Lengkapi data untuk kredibilitas layanan</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close shadow-none" wire:click.prevent="batal"></button>
                    </div>

                    <div class="modal-body p-4 pt-4">
                        <form wire:submit.prevent="simpan">
                            <div class="row g-4">
                                <!-- Bagian Kiri: Profile & Media -->
                                <div class="col-md-4 border-end-md">
                                    <div class="profile-upload-zone text-center p-4 rounded-4" style="background: #f8fafc; border: 2px dashed #e2e8f0;">
                                        <label class="small fw-bold d-block mb-3 text-uppercase tracking-wider text-muted">Foto Profile</label>
                                        <div class="position-relative d-inline-block p-1 border border-2 rounded-circle bg-white shadow-sm mb-4">
                                            @if ($foto)
                                                <img src="{{ $foto->temporaryUrl() }}" class="rounded-circle shadow-sm" style="width: 140px; height: 140px; object-fit: cover;">
                                            @elseif ($foto_lama)
                                                <img src="{{ asset('storage/' . $foto_lama) }}" class="rounded-circle shadow-sm" style="width: 140px; height: 140px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 140px; height: 140px;">
                                                    <i class="mdi mdi-account mdi-48px text-muted opacity-50"></i>
                                                </div>
                                            @endif
                                            <label for="upload-foto" class="position-absolute bottom-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 36px; height: 36px; cursor: pointer; border: 3px solid #fff;">
                                                <i class="mdi mdi-camera small"></i>
                                                <input type="file" id="upload-foto" class="d-none" wire:model="foto" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="small text-muted mb-0">Gunakan foto formal terbaik</p>
                                        @error('foto') <span class="text-danger small mt-2 d-block fw-bold">{{ $message }}</span> @enderror
                                        
                                        <div class="mt-4 pt-3 border-top w-100 text-start">
                                            <label class="small fw-bold d-block mb-2 text-muted text-uppercase tracking-wider">Dokumen Sertifikasi</label>
                                            <div class="input-group input-group-sm">
                                                <input type="file" class="form-control rounded-3" wire:model="sertifikat">
                                            </div>
                                            @if ($sertifikat_lama) <p class="small text-success mt-1 mb-0"><i class="mdi mdi-check-circle me-1"></i>Sertifikat Terverifikasi</p> @endif
                                            @error('sertifikat') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Kanan: Data Identitas -->
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-dark text-uppercase tracking-wider mb-1">Nama Lengkap Tim Profesional</label>
                                            <div class="input-group border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0"><i class="mdi mdi-account-outline text-muted"></i></span>
                                                <input type="text" class="form-control border-0 py-2 fw-bold text-dark" style="background: #fff;" wire:model.defer="nama" placeholder="Masukkan nama kapster / barber...">
                                            </div>
                                            @error('nama') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-dark text-uppercase tracking-wider mb-1">Status Kepegawaian</label>
                                            <select class="form-select border shadow-sm rounded-3 py-2 fw-semibold" wire:model.defer="status">
                                                <option value="bekerja">Aktif Bekerja</option>
                                                <option value="libur">Izin / Libur</option>
                                            </select>
                                            @error('status') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-dark text-uppercase tracking-wider mb-1">Nomor Identitas (NIK)</label>
                                            <div class="input-group border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0"><i class="mdi mdi-card-account-details-outline text-muted"></i></span>
                                                <input type="text" class="form-control border-0 py-2 fw-medium" wire:model.defer="nik" placeholder="KTP / Kartu Identitas">
                                            </div>
                                            @error('nik') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-dark text-uppercase tracking-wider mb-1">WhatsApp / No. Telepon Aktif</label>
                                            <div class="input-group border rounded-3 overflow-hidden shadow-sm">
                                                <span class="input-group-text bg-light border-0"><i class="mdi mdi-whatsapp text-success"></i></span>
                                                <input type="text" class="form-control border-0 py-2 fw-bold" wire:model.defer="no_wa" placeholder="Contoh: 08123456789">
                                            </div>
                                            @error('no_wa') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold text-dark text-uppercase tracking-wider mb-1">Alamat Lengkap Saat Ini</label>
                                            <textarea class="form-control border shadow-sm rounded-3 py-2" rows="3" wire:model.defer="alamat" placeholder="Tuliskan alamat domisili lengkap..."></textarea>
                                            @error('alamat') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons - Integrated in Column 2 -->
                                    <div class="d-flex gap-2 mt-4 pt-2">
                                        <button type="submit" class="btn btn-dark px-4 py-2 rounded-3 fw-bold flex-grow-1 shadow d-flex align-items-center justify-content-center gap-2" wire:loading.attr="disabled">
                                            <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm"></span>
                                            <i class="mdi mdi-content-save-check-outline fs-5" wire:loading.remove></i>
                                            {{ $kapsterIdEdit ? 'Simpan Perubahan' : 'Terbitkan Profil Tim' }}
                                        </button>
                                        <button type="button" class="btn btn-light px-4 py-2 rounded-3 border fw-bold text-dark" wire:click.prevent="batal">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Non-Aktifkan Keanggotaan?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Profil Barber <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen. Aksi ini tidak dapat dibatalkan.
                        </p>
                    </div>
                    
                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a;" wire:click="cancelDelete">
                            Batalkan
                        </button>
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="background-color: #0f172a; color: #f8fafc;" wire:click="hapus({{ $deleteId }})" wire:loading.attr="disabled" wire:target="hapus">
                            <span wire:loading wire:target="hapus" class="spinner-border spinner-border-sm me-2"></span>
                            Ya, Hapus Keanggotaan
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
            background-color: #f6fff9 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</div>