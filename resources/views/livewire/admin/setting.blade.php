<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF512F, #DD2476);">
                    <i class="mdi mdi-cog-outline text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Konfigurasi Sistem</h4>
                    <p class="text-muted small mb-0">Kelola identitas bisnis, integrasi media, dan konektivitas WhatsApp Gateway</p>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show mb-4 animate__animated animate__fadeInDown" role="alert" style="border-radius: 15px; background: #e8f5e9;">
            <div class="d-flex align-items-center">
                <i class="mdi mdi-check-circle text-success mdi-24px me-3"></i>
                <span class="text-success fw-bold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- App Settings Column -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold text-dark"><i class="mdi mdi-store-outline text-primary me-2"></i>Identitas Usaha</h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="simpanSetting">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Nama Barbershop</label>
                                <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-rename-box"></i></span>
                                    <input type="text" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="nama_usaha">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Nomor Telepon</label>
                                <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-phone-outline"></i></span>
                                    <input type="text" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="telepon">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Alamat Email</label>
                                <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-email-outline"></i></span>
                                    <input type="email" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-muted">Jadwal Operasional</label>
                                <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-calendar-clock"></i></span>
                                    <input type="text" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="jam_buka">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat Lengkap</label>
                            <div class="bg-light rounded-20 p-1 border shadow-inner">
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 fw-medium" wire:model.defer="alamat" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Slogan / Headline</label>
                            <div class="bg-light rounded-pill p-1 border shadow-inner">
                                <input type="text" class="form-control border-0 bg-transparent px-3 py-2 fw-medium italic" wire:model.defer="slogan">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">YouTube Playlist ID</label>
                            <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-youtube"></i></span>
                                <input type="text" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="youtube_playlist_id">
                            </div>
                            <p class="text-muted small mt-2 ms-2"><i class="mdi mdi-information-outline me-1"></i>Kode unik setelah <code>&list=</code> pada URL playlist untuk memutar video di display antrian.</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Logo Barbershop</label>
                            <div class="d-flex align-items-center bg-light rounded-20 p-3 border shadow-inner">
                                <div class="me-4 text-center">
                                    @if ($logo)
                                        @if (is_object($logo) && method_exists($logo, 'temporaryUrl'))
                                            <img src="{{ $logo->temporaryUrl() }}" class="rounded shadow-sm border" style="width: 80px; height: 80px; object-fit: contain; background: white;">
                                        @else
                                            <img src="{{ asset('storage/' . $logo) }}" class="rounded shadow-sm border" style="width: 80px; height: 80px; object-fit: contain; background: white;">
                                        @endif
                                    @else
                                        <div class="rounded shadow-sm border bg-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="mdi mdi-image-off-outline text-muted fs-3"></i>
                                        </div>
                                    @endif
                                    <span class="d-block small text-muted mt-1 fw-bold">Pratinjau</span>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control border-0 bg-white shadow-sm rounded-pill" wire:model="logo" accept="image/*">
                                    <div wire:loading wire:target="logo" class="text-primary small mt-2">
                                        <span class="spinner-border spinner-border-sm me-1"></span> Mengunggah...
                                    </div>
                                    @error('logo') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg" style="background: linear-gradient(135deg, #FF512F, #DD2476); border: none;">
                                <i class="mdi mdi-content-save-check me-2"></i> Simpan Semua Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- WhatsApp Column -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="bg-success p-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #11998e, #38ef7d) !important;">
                    <div>
                        <h5 class="fw-bold mb-0">WhatsApp Gateway</h5>
                        <p class="small mb-0 opacity-75">Integrasi Notifikasi & Broadcast</p>
                    </div>
                    <i class="mdi mdi-whatsapp fs-1 opacity-50"></i>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4 text-center">
                        <span class="small fw-bold text-muted text-uppercase d-block mb-2">Status Koneksi</span>
                        @if($waConnected)
                            <div class="badge bg-success-subtle text-success border border-success px-4 py-2 rounded-pill fs-6">
                                <i class="mdi mdi-check-circle-outline me-1"></i> TERHUBUNG
                            </div>
                            <div class="mt-2 fw-bold text-dark">{{ $waNumber }}</div>
                        @else
                            <div class="badge bg-danger-subtle text-danger border border-danger px-4 py-2 rounded-pill fs-6">
                                <i class="mdi mdi-close-circle-outline me-1"></i> TERPUTUS
                            </div>
                        @endif
                    </div>

                    <div class="bg-light rounded-20 p-3 border mb-4 shadow-inner text-center d-flex align-items-center justify-content-center" style="height: 250px;">
                        @if($waConnected)
                            <div class="animate__animated animate__pulse animate__infinite text-success">
                                <i class="mdi mdi-shield-check-outline mdi-48px"></i>
                                <p class="fw-bold mt-2 mb-0">Keamanan Aktif</p>
                                <span class="small text-muted">Layanan berjalan normal</span>
                            </div>
                        @elseif($qrImage)
                            <div class="p-2 bg-white rounded shadow-sm">
                                <img src="{{ $qrImage }}" class="img-fluid" style="max-height: 210px;">
                            </div>
                        @else
                            <div class="text-muted opacity-50">
                                <i class="mdi mdi-qrcode-scan mdi-48px"></i>
                                <p class="small mt-2 mb-0">QR Code Siap Digunakan</p>
                            </div>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        @if(!$waConnected)
                            <button wire:click="getQrCode" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm" style="background: #25D366; border: none;">
                                <i class="mdi mdi-refresh me-1"></i> Dapatkan QR Code Baru
                            </button>
                            <button wire:click="reconnectWa" class="btn btn-outline-success rounded-pill py-2 fw-bold">
                                <i class="mdi mdi-sync me-1"></i> Reconnect Gateway
                            </button>
                        @else
                            <button wire:click="logoutWa" class="btn btn-danger rounded-pill py-2 fw-bold shadow-sm">
                                <i class="mdi mdi-logout me-1"></i> Putuskan Koneksi
                            </button>
                        @endif
                        
                        <button wire:click="checkWaConnection" class="btn btn-light rounded-pill py-2 fw-bold border text-muted mt-2">
                             Update Status & Signal
                        </button>

                        <button type="button" class="btn btn-info text-white rounded-pill py-2 fw-bold shadow-sm mt-2" data-toggle="modal" data-target="#TesKirimPesanModal">
                            <i class="mdi mdi-send-check me-1"></i> Uji Coba Pengiriman
                        </button>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm mt-4 bg-primary text-white" style="border-radius: 20px; background: linear-gradient(135deg, #1e3c72, #2a5298) !important;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="mdi mdi-lightbulb-on-outline me-2"></i>Tip Integrasi</h6>
                    <p class="small mb-0 opacity-75">Pastikan nomor yang digunakan adalah nomor aktif. Koneksi stabil akan menjamin notifikasi struk digital sampai ke pelanggan tepat waktu.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tes Kirim Pesan -->
    <div class="modal fade animate__animated animate__fadeIn" id="TesKirimPesanModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <div class="bg-info-subtle p-2 rounded-circle me-3">
                        <i class="mdi mdi-whatsapp text-info fs-3"></i>
                    </div>
                    <h5 class="modal-title font-weight-bold text-dark">Test Gateway</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if (session()->has('success_wa'))
                        <div class="alert alert-success border-0 shadow-sm rounded-15 mb-3">
                            <i class="mdi mdi-check-circle me-1"></i> {{ session('success_wa') }}
                        </div>
                    @elseif (session()->has('error_wa'))
                        <div class="alert alert-danger border-0 shadow-sm rounded-15 mb-3">
                            <i class="mdi mdi-alert-circle me-1"></i> {{ session('error_wa') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nomor WhatsApp Tujuan</label>
                        <input type="text" wire:model="testNumber" class="form-control bg-light border-0 rounded-pill shadow-inner px-3" placeholder="Contoh: 62812xxx">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Isi Pesan Test</label>
                        <textarea wire:model.defer="testMessage" class="form-control bg-light border-0 rounded-20 shadow-inner px-3 py-2" rows="3" placeholder="Halo, ini test dari sistem..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="testSendWa" class="btn btn-info text-white rounded-pill px-4 fw-bold shadow-sm" wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="mdi mdi-send me-1"></i> Kirim Sekarang</span>
                        <span wire:loading><span class="spinner-border spinner-border-sm me-1"></span> Mengirim...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rounded-20 { border-radius: 20px !important; }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important; }
        .rounded-15 { border-radius: 15px !important; }
        .italic { font-style: italic; }
    </style>
</div>