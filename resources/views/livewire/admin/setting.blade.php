<div class="main-panel">
    <div class="row">
        <div class="col-md-8">
            <div class="content-wrapper">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-dark">Pengaturan Aplikasi</h4>
                    </div>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form wire:submit.prevent="simpanSetting" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_usaha" class="form-label">Nama Usaha</label>
                            <input type="text" class="form-control" id="nama_usaha" wire:model.defer="nama_usaha">
                        </div>
                        <div class="col-md-6">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" wire:model.defer="telepon">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" wire:model.defer="email">
                        </div>
                        <div class="col-md-6">
                            <label for="jam_buka" class="form-label">Jam Buka</label>
                            <textarea class="form-control" id="jam_buka" wire:model.defer="jam_buka"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" wire:model.defer="alamat"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="slogan" class="form-label">Slogan</label>
                            <input type="text" class="form-control" id="slogan" wire:model.defer="slogan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="logo" wire:model="logo" accept="image/*">
                            @if ($logo)
                                @if (is_object($logo) && method_exists($logo, 'temporaryUrl'))
                                    {{-- Preview untuk file yang baru saja dipilih --}}
                                    <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail mt-2" width="100">
                                @else
                                    {{-- Preview untuk gambar lama yang sudah ada di storage (database) --}}
                                    <img src="{{ asset('storage/' . $logo) }}" class="img-thumbnail mt-2" width="100">
                                @endif
                            @endif
                            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-wrapper">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-dark">Koneksi Whatsapp</h4>
                        <p>Status: <strong>{{ ucfirst($waStatus) }}</strong></p>
                        @if($waConnected && $waNumber)
                            <p>Nomor: <strong>{{ $waNumber }}</strong></p>
                        @endif
                    </div>
                </div>

                <div id="qrcodewhatsapp" class="mb-3"
                    style="width: 100%; height: 300px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center;">
                    @if($waConnected)
                        <div class="text-center text-success">
                            <i class="fas fa-check-circle fa-5x"></i>
                            <h4>Koneksi Whatsapp Terhubung</h4>
                        </div>
                    @elseif($qrImage)
                        <img src="{{ $qrImage }}" alt="QR Code" style="width: 100%; height: 100%;">
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-qrcode fa-5x"></i>
                            <p class="mt-2">No QR Code available</p>
                        </div>
                    @endif
                </div>

                <div class="d-flex flex-column gap-2">
                    @if(!$waConnected)
                        <button wire:click="getQrCode" class="btn btn-primary mb-2">Refresh QR Code</button>
                        <button wire:click="reconnectWa" class="btn btn-outline-primary mb-2">Reconnect Gateway</button>
                    @else
                        <button wire:click="logoutWa" class="btn btn-danger mb-2">Logout WhatsApp</button>
                    @endif
                    <button wire:click="checkWaConnection" class="btn btn-info mb-2">Check Status</button>

                    <button type="button" class="btn btn-secondary" data-toggle="modal"
                        data-target="#TesKirimPesanModal">
                        Tes Kirim Pesan WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tes Kirim Pesan -->
    <div class="modal fade" id="TesKirimPesanModal" tabindex="-1" role="dialog"
        aria-labelledby="TesKirimPesanModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TesKirimPesanModalLabel">Tes Kirim Pesan WhatsApp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session()->has('success_wa'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success_wa') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    @elseif (session()->has('error_wa'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error_wa') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label>Nomor WhatsApp (62xxx)</label>
                        <input type="text" wire:model="testNumber" class="form-control"
                            placeholder="Contoh: 628123456789">
                    </div>
                    <div class="form-group mb-3">
                        <label>Pesan</label>
                        <textarea wire:model.defer="testMessage" class="form-control" rows="3"
                            placeholder="Isi pesan test"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="testSendWa" class="btn btn-success" wire:loading.attr="disabled">
                        <span wire:loading.remove>Kirim Pesan</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>