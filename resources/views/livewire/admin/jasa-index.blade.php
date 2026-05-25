<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #11998e, #38ef7d);">
                    <i class="mdi mdi-content-cut text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Menu Layanan & Jasa</h4>
                    <p class="text-muted small mb-0">Atur katalog perlakuan rambut dan perawatan eksklusif</p>
                </div>
            </div>
            <button wire:click.prevent="showCreateForm" class="btn btn-premium-add px-4 py-2 shadow-sm animate__animated animate__pulse animate__infinite">
                <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Layanan Baru
            </button>
        </div>
    </div>

    <!-- Stats & Filters Bar (Optional but nice for Premium look) -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0 ps-3"><i class="mdi mdi-magnify text-muted"></i></span>
                <input type="text" wire:model.live="search" class="form-control border-0 py-2" placeholder="Cari nama atau deskripsi jasa...">
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
                                    <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 120px;">Visual</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Informasi Layanan</th>
                                    <th class="py-3 text-uppercase small fw-bold text-muted">Investasi Harga</th>
                                    <th class="pe-4 py-3 text-uppercase small fw-bold text-muted text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataJasa as $dtjasa)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            @if($dtjasa->foto)
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ asset('storage/' . $dtjasa->foto) }}" class="rounded shadow-sm border" style="width: 80px; height: 60px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded border" style="width: 80px; height: 60px;">
                                                    <i class="mdi mdi-image-off-outline text-muted fs-4"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold text-dark d-block fs-5">{{ $dtjasa->nama }}</span>
                                                <span class="text-muted small d-block" style="max-width: 400px;">{{ Str::limit($dtjasa->deskripsi, 80) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge border-0 rounded-pill px-3 py-2 bg-light text-dark fw-bold border shadow-sm">
                                                Rp {{ number_format($dtjasa->harga, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                                <button wire:click="edit({{ $dtjasa->id }})" class="btn bg-white text-info border-end p-2 px-3" title="Edit">
                                                    <i class="mdi mdi-pencil-outline fs-5"></i>
                                                </button>
                                                <button wire:click="confirmDelete({{ $dtjasa->id }})" class="btn bg-white text-danger p-2 px-3" title="Hapus">
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
                                                    <i class="mdi mdi-content-cut text-muted mdi-48px"></i>
                                                </div>
                                                <h5 class="fw-bold text-dark">Layanan Belum Terarsip</h5>
                                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                                    Terlihat Anda belum mendaftarkan menu layanan ke dalam sistem Anda.
                                                </p>
                                                <button wire:click.prevent="showCreateForm()" class="btn btn-premium-add px-4 shadow-sm">
                                                    <i class="mdi mdi-plus me-1"></i> Daftarkan Layanan Pertama
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
        {{ $dataJasa->links() }}
    </div>

    <!-- Modal Form (Tambah/Edit) -->
    <!-- Modal Form (Tambah/Edit) -->
    @if ($showForm)
        <div class="modal-backdrop fade show" style="backdrop-filter: blur(4px); background-color: rgba(15, 23, 42, 0.3);"></div>
        <div class="modal d-block animate__animated animate__fadeIn animate__faster" tabindex="-1" role="dialog" style="z-index: 1050;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
                <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                                <i class="mdi mdi-briefcase-edit-outline fs-5" style="color: #d97706;"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">{{ $jasaIdEdit ? 'Sempurnakan Layanan' : 'Formulasi Layanan Baru' }}</h6>
                        </div>
                        <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" wire:click.prevent="batal">
                            <i class="mdi mdi-close fs-4"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="simpan">
                        <div class="mb-4 text-center">
                            <label class="small fw-bold d-block mb-3 text-start" style="color: #475569;">Visual Profile</label>
                            <div class="p-3 border border-dashed rounded-3" style="background-color: #f8fafc;">
                                <input type="file" class="form-control form-control-sm mb-3 shadow-none border" wire:model="foto" accept="image/*">
                                @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail shadow-sm mb-2" style="max-height: 120px; width: 100%; object-fit: cover; border-radius: 12px;">
                                    <p class="text-success small fw-medium mb-0"><i class="mdi mdi-check-circle me-1"></i>Siap unggah</p>
                                @elseif ($foto_lama)
                                    <img src="{{ asset('storage/' . $foto_lama) }}" class="img-thumbnail shadow-sm mb-2 border" style="max-height: 120px; width: 100%; object-fit: cover; border-radius: 12px;">
                                    <p class="small fw-medium mb-0" style="color: #64748b;">Visual tersimpan</p>
                                @else
                                    <div class="py-3 opacity-50">
                                        <i class="mdi mdi-camera-plus mdi-36px" style="color: #64748b;"></i>
                                        <p class="small fw-medium mb-0" style="color: #475569;">Upload foto layanan</p>
                                    </div>
                                @endif
                                @error('foto') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Nama Layanan</label>
                            <input type="text" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="nama" placeholder="Cth: Signature Fade Cut">
                            @error('nama') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Investasi Layanan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-end-0 shadow-none text-dark">Rp</span>
                                <input type="number" class="form-control rounded-end-3 py-2 border-start-0 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="harga" placeholder="0">
                            </div>
                            @error('harga') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold d-block mb-1" style="color: #475569;">Deskripsi Detail</label>
                            <textarea class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" wire:model.defer="deskripsi" rows="3" placeholder="Detail treatment, durasi..."></textarea>
                            @error('deskripsi') <div class="text-danger small mt-1 fw-medium">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex flex-column gap-2 mt-4 pt-2">
                            <button type="submit" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:loading.attr="disabled">
                                <span wire:loading wire:target="simpan" class="spinner-border spinner-border-sm me-2"></span>
                                Simpan Layanan
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
                                <i class="mdi mdi-delete-outline" style="font-size: 28px; color: #0f172a;"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-2" style="color: #0f172a;">Lepas Layanan?</h6>
                        <p class="small mb-0 lh-base px-2 fw-medium" style="color: #475569;">
                            Layanan <strong>"{{ $deleteNama }}"</strong> akan dihapus permanen. Aksi tidak dapat dibatalkan.
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
            background-color: #fff9eb !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
    </style>
</div>