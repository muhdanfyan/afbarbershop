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
                <div class="card-header bg-white border-0 p-3 pb-0">
                    <h6 class="fw-bold text-dark mb-0"><i class="mdi mdi-store-outline text-primary me-2"></i>Identitas Usaha</h6>
                </div>
                <div class="card-body p-3">
                    <form wire:submit.prevent="simpanSetting">
                        <div class="row g-2 mb-2">
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

                        <div class="row g-2 mb-2">
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

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat Lengkap</label>
                            <div class="bg-light rounded-20 p-1 border shadow-inner">
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 fw-medium" wire:model.defer="alamat" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">Slogan / Headline</label>
                            <div class="bg-light rounded-pill p-1 border shadow-inner">
                                <input type="text" class="form-control border-0 bg-transparent px-3 py-2 fw-medium italic" wire:model.defer="slogan">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">YouTube Playlist ID</label>
                            <div class="input-group bg-light rounded-pill px-3 py-1 border shadow-inner">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="mdi mdi-youtube"></i></span>
                                <input type="text" class="form-control border-0 bg-transparent fw-bold" wire:model.defer="youtube_playlist_id">
                            </div>
                            <p class="text-muted small mt-2 ms-2"><i class="mdi mdi-information-outline me-1"></i>Kode unik setelah <code>&list=</code> pada URL playlist untuk memutar video di display antrian.</p>
                        </div>

                        <div class="mb-2">
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

                        <hr class="my-4 opacity-25">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-dark mb-0"><i class="mdi mdi-whatsapp text-success me-2"></i>Master Template WhatsApp</h6>
                            <span class="badge bg-light text-muted border rounded-pill fw-normal">Dikelola via Pop-up</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Template 1: Konfirmasi -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_confirmation', 'Konfirmasi Booking', 'mdi-calendar-check')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-calendar-check fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Konfirmasi</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Pesanan Baru</span>
                                </div>
                            </div>
                            <!-- Template 2: Reminder -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_reminder', 'Pengingat Jadwal', 'mdi-bell-ring')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-bell-ring fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Pengingat</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Antrian Dekat</span>
                                </div>
                            </div>
                            <!-- Template 3: Receipt -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_receipt', 'Struk Pembayaran', 'mdi-file-document-outline')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-info-subtle text-info rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-file-document-outline fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Struk</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Nota Digital</span>
                                </div>
                            </div>
                            <!-- Template 4: Welcome -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_welcome', 'Welcome Member', 'mdi-account-star-outline')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-account-star-outline fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Welcome</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Pendaftaran Member</span>
                                </div>
                            </div>
                            <!-- Template 5: Rating -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_rating', 'Rating & Review', 'mdi-star-circle-outline')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-star-circle-outline fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Rating</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Ulasan Selesai</span>
                                </div>
                            </div>
                            <!-- Template 6: Reactivation -->
                            <div class="col-md-4 col-6">
                                <div class="card border border-light shadow-sm text-center p-3 h-100 hover-shadow transition-all" style="border-radius: 18px; cursor: pointer;" wire:click="editTemplate('wa_tpl_reactivation', 'Re-aktivasi (Kangen)', 'mdi-heart-flash')">
                                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center bg-secondary-subtle text-secondary rounded-circle" style="width: 45px; height: 45px;">
                                        <i class="mdi mdi-heart-flash fs-4"></i>
                                    </div>
                                    <h6 class="small fw-bold mb-1">Re-aktivasi</h6>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Kunjungan Lama</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-lg w-100" style="background: linear-gradient(135deg, #FF512F, #DD2476); border: none;">
                                <i class="mdi mdi-content-save-check me-2"></i> Simpan Semua Konfigurasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- WhatsApp Column -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="bg-success p-3 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #11998e, #38ef7d) !important;">
                    <div>
                        <h6 class="fw-bold mb-0">WhatsApp Gateway</h6>
                        <p class="small mb-0 opacity-75" style="font-size: 0.7rem;">Integrasi Notifikasi</p>
                    </div>
                    <i class="mdi mdi-whatsapp fs-3 opacity-50"></i>
                </div>
                <div class="card-body p-3">
                    <div class="mb-3 text-center">
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

                    <div class="bg-light rounded-20 p-2 border mb-3 shadow-inner text-center d-flex align-items-center justify-content-center" style="height: 180px;">
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
                        @elseif($waStatus == 'Gateway Offline' || $waStatus == 'Error connecting to Gateway')
                            <div class="text-danger opacity-75">
                                <i class="mdi mdi-server-off mdi-48px"></i>
                                <p class="small fw-bold mt-2 mb-0">Gateway Offline</p>
                                <span style="font-size: 0.65rem;">Jalankan: <code>npm run dev</code> di folder wagateway</span>
                            </div>
                        @else
                            <div class="text-muted opacity-50">
                                <i class="mdi mdi-qrcode-scan mdi-48px"></i>
                                <p class="small mt-2 mb-0">QR Code Siap Digunakan</p>
                                <span class="small">Klik tombol di bawah</span>
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
    <div class="modal fade animate__animated animate__fadeIn animate__faster" id="TesKirimPesanModal" tabindex="-1" role="dialog" wire:ignore.self style="z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 440px;">
            <div class="modal-content border-0 p-4" style="border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fef3c7;">
                            <i class="mdi mdi-whatsapp fs-5" style="color: #d97706;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">Test Gateway WA</h6>
                    </div>
                    <button type="button" class="btn btn-sm bg-transparent border-0 text-muted shadow-none" data-dismiss="modal" aria-label="Close">
                        <i class="mdi mdi-close fs-4"></i>
                    </button>
                </div>

                <div class="modal-body p-0">
                    @if (session()->has('success_wa'))
                        <div class="alert alert-success border-0 rounded-3 mb-3 small fw-medium" style="background-color: #f0fdf4; color: #166534;">
                            <i class="mdi mdi-check-circle me-1"></i> {{ session('success_wa') }}
                        </div>
                    @elseif (session()->has('error_wa'))
                        <div class="alert alert-danger border-0 rounded-3 mb-3 small fw-medium" style="background-color: #fef2f2; color: #991b1b;">
                            <i class="mdi mdi-alert-circle me-1"></i> {{ session('error_wa') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="small fw-bold d-block mb-1" style="color: #475569;">Nomor WhatsApp Tujuan</label>
                        <input type="text" wire:model="testNumber" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" placeholder="Contoh: 62812xxx">
                        <div class="text-muted mt-1" style="font-size: 0.75rem;">Gunakan kode negara (62)</div>
                    </div>
                    <div class="mb-4">
                        <label class="small fw-bold d-block mb-1" style="color: #475569;">Isi Pesan Test</label>
                        <textarea wire:model.defer="testMessage" class="form-control rounded-3 py-2 shadow-none text-dark fw-medium" style="background-color: #f8fafc;" rows="3" placeholder="Halo, ini test dari sistem..."></textarea>
                    </div>

                    <div class="d-flex flex-column gap-2 mt-2">
                        <button type="button" class="btn w-100 rounded-3 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center" style="font-size: 0.95rem; background-color: #0f172a; color: #f8fafc;" wire:click="testSendWa" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="mdi mdi-send me-2"></i> Kirim Sekarang</span>
                            <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span> Mengirim...</span>
                        </button>
                        <button type="button" class="btn bg-white border w-100 rounded-3 py-2 fw-bold shadow-none" style="color: #0f172a; font-size: 0.95rem;" data-dismiss="modal">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Template WA -->
    <div class="modal fade animate__animated animate__fadeIn animate__faster" id="WAEditTemplateModal" tabindex="-1" role="dialog" wire:ignore.self style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
            <div class="modal-content border-0 p-4 shadow-lg" style="border-radius: 24px;">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light border" style="width: 50px; height: 50px;">
                            <i class="mdi {{ $editingTplIcon }} fs-3 text-primary"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">{{ $editingTplTitle }}</h5>
                            <p class="small text-muted mb-0">Ubah teks pesan WhatsApp otomatis</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="alert alert-info border-0 rounded-15 shadow-sm small py-2 px-3 mb-4" style="background: #f0f7ff; color: #004a99; border: 1px solid #cce3ff !important;">
                        <i class="mdi mdi-information-outline me-1"></i> <strong>Panduan Kode:</strong><br>
                        <div class="mt-1 opacity-75">
                            {NAMA}, {JAM}, {TANGGAL}, {LAYANAN}, {BARBER}, {INVOICE}, {POIN}, {LEVEL}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Isi Pesan WhatsApp</label>
                        <div class="bg-light rounded-20 p-1 border shadow-inner">
                            @if($editingTplKey == 'wa_tpl_confirmation')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_confirmation" rows="10" placeholder="Tulis pesan konfirmasi di sini..."></textarea>
                            @elseif($editingTplKey == 'wa_tpl_reminder')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_reminder" rows="10" placeholder="Tulis pesan pengingat di sini..."></textarea>
                            @elseif($editingTplKey == 'wa_tpl_receipt')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_receipt" rows="10" placeholder="Tulis penutup struk digital di sini..."></textarea>
                            @elseif($editingTplKey == 'wa_tpl_welcome')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_welcome" rows="10" placeholder="Tulis pesan selamat datang member di sini..."></textarea>
                            @elseif($editingTplKey == 'wa_tpl_rating')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_rating" rows="10" placeholder="Tulis permintaan rating di sini..."></textarea>
                            @elseif($editingTplKey == 'wa_tpl_reactivation')
                                <textarea class="form-control border-0 bg-transparent px-3 py-2 small" wire:model.defer="wa_tpl_reactivation" rows="10" placeholder="Tulis pesan re-aktivasi di sini..."></textarea>
                            @endif
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="button" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #11998e, #38ef7d); border: none;" wire:click="simpanSetting" data-dismiss="modal">
                            <i class="mdi mdi-content-save-check me-1"></i> Simpan Perubahan Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
           Livewire.on('open-wa-modal', (event) => {
               $('#WAEditTemplateModal').modal('show');
           });
        });
    </script>

    <style>
        .rounded-20 { border-radius: 20px !important; }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important; }
        .rounded-15 { border-radius: 15px !important; }
        .italic { font-style: italic; }
        .transition-all { transition: all 0.3s ease; }
        .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    </style>
</div>