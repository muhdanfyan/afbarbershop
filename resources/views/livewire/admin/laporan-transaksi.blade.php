<div>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-premium p-3 rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FBAB7E, #F7CE68);">
                    <i class="mdi mdi-chart-box-outline text-white fs-4"></i>
                </div>
                <div>
                    <h4 class="font-weight-bold text-dark mb-0">Laporan Keuangan</h4>
                    <p class="text-muted small mb-0">Rekapitulasi pendapatan, transaksi, dan performa bisnis</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success rounded-pill px-4 shadow-sm" wire:click="exportExcel">
                    <i class="mdi mdi-file-excel me-1"></i> Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-2">
                            <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Rentang Waktu</label>
                            <select wire:model.live="mode" class="form-select border-0 bg-light rounded-pill fw-bold text-dark shadow-inner">
                                <option value="harian">Harian</option>
                                <option value="mingguan">Mingguan</option>
                                <option value="bulanan">Bulanan</option>
                            </select>
                        </div>
                        
                        @if($mode === 'harian')
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Pilih Tanggal</label>
                                <input type="date" wire:model.live="tanggal" class="form-control border-0 bg-light rounded-pill shadow-inner">
                            </div>
                        @elseif($mode === 'mingguan')
                            <div class="col-md-2">
                                <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Minggu Ke-</label>
                                <input type="number" min="1" max="53" wire:model.live="minggu" class="form-control border-0 bg-light rounded-pill shadow-inner" placeholder="Pilih Minggu">
                            </div>
                            <div class="col-md-2">
                                <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Tahun</label>
                                <input type="number" min="2020" max="2100" wire:model.live="tahun" class="form-control border-0 bg-light rounded-pill shadow-inner">
                            </div>
                        @else
                            <div class="col-md-2">
                                <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Pilih Bulan</label>
                                <select wire:model.live="bulan" class="form-select border-0 bg-light rounded-pill shadow-inner">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="small fw-bold text-muted text-uppercase mb-1 ms-1">Tahun</label>
                                <input type="number" min="2020" max="2100" wire:model.live="tahun" class="form-control border-0 bg-light rounded-pill shadow-inner">
                            </div>
                        @endif

                        <div class="col-md-3 ms-auto text-end pt-3">
                            <div class="bg-success-subtle p-2 px-3 rounded-pill d-inline-block border border-success border-opacity-25" style="background: #e8f5e9;">
                                <span class="text-muted small fw-bold">Total Omzet:</span>
                                <span class="text-success fw-bold fs-5 ms-2">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="row g-4">
        <!-- Kapster Income Side Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="mdi mdi-account-cash text-primary me-2"></i>Komisi Kapster
                    </h5>
                    <p class="text-muted small">Alokasi 40% dari jasa layanan cukur</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small text-muted">Tim Kapster</th>
                                    <th class="pe-4 py-3 text-uppercase small text-muted text-end">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penghasilanKapster as $kapster)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light border me-3 overflow-hidden shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    @if(!empty($fotoKapster[$kapster['nama']]))
                                                        <img src="{{ asset('storage/' . $fotoKapster[$kapster['nama']]) }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <i class="mdi mdi-account text-muted fs-4"></i>
                                                    @endif
                                                </div>
                                                <span class="fw-bold text-dark">{{ $kapster['nama'] }}</span>
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <span class="fw-bold text-primary">Rp {{ number_format($kapster['fee'], 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted small">Tidak ada aktivitas jasa cukur</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Transaction Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">
                            <i class="mdi mdi-format-list-bulleted text-info me-2"></i>Rincian Transaksi
                        </h5>
                        <p class="text-muted small">Histori lengkap log transaksi pelanggan</p>
                    </div>
                    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                        {{ $data->total() }} Transaksi
                    </span>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small text-muted">Invoice & Tanggal</th>
                                    <th class="py-3 text-uppercase small text-muted">Pelanggan</th>
                                    <th class="py-3 text-uppercase small text-muted">Kapster</th>
                                    <th class="pe-4 py-3 text-uppercase small text-muted text-end">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $t)
                                    <tr class="transition-all">
                                        <td class="ps-4">
                                            <span class="fw-bold text-dark d-block mb-1">{{ $t->invoice }}</span>
                                            <span class="text-muted small"><i class="mdi mdi-clock-outline me-1"></i>{{ $t->created_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark d-block">{{ $t->nama }}</span>
                                            <span class="text-muted small">{{ $t->no_hp ?: '-' }}</span>
                                        </td>
                                        <td>
                                            @if($t->kapster)
                                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $t->kapster->nama }}</span>
                                            @else
                                                <span class="text-muted small">Auto/System</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end">
                                            <span class="fw-bold text-success">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-file-search-outline mdi-36px d-block mb-2"></i>
                                            <span class="small">Data transaksi tidak ditemukan untuk filter ini.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0 mt-3 d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f0fdf4 !important;
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
</div>