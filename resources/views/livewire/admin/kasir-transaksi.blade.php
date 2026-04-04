@push('styles')
    <!-- Google Fonts untuk tema premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Montserrat:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap');

        /* --- Theme Variables --- */
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f1f5f9;
            --accent-primary: #d4af37;
            --accent-hover: #b8972e;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --font-heading: 'Cinzel', serif;
            --font-body: 'Montserrat', sans-serif;
            --font-display: 'Playfair Display', serif;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .dark {
            --bg-primary: #050505;
            --bg-secondary: #121212;
            --bg-tertiary: #1e1e1e;
            --accent-primary: #d4af37;
            --accent-hover: #f4e4a6;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --border-color: #262626;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }

        body, html {
            height: 100vh;
            margin: 0;
            padding: 0;
            background: var(--bg-primary);
            font-family: var(--font-body);
            color: var(--text-primary);
            overflow: hidden;
            transition: background-color 0.3s ease;
        }

        .cashier-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg-primary);
        }

        .cashier-header {
            background: var(--bg-secondary);
            border-bottom: 2px solid var(--border-color);
            padding: 0.5rem 1.5rem; /* Tighter header */
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .cashier-body {
            flex: 1;
            display: grid;
            grid-template-columns: 280px 1fr 340px; /* Precise widths */
            gap: 0.75rem; /* Tighter gap */
            padding: 0.75rem;
            overflow: hidden;
        }

        @media (max-width: 1400px) {
            .cashier-body { grid-template-columns: 240px 1fr 320px; }
        }

        /* --- Panel Structure (No Scroll on Main Panels) --- */
        .panel {
            background: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 100%;
        }

        .panel-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            font-family: var(--font-heading);
            color: var(--accent-primary);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-secondary);
            font-weight: bold;
        }

        .panel-body {
            padding: 0.75rem;
            overflow-y: auto;
            flex: 1;
            scrollbar-width: thin;
        }

        /* --- High Density Cards --- */
        .service-grid, .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .premium-card, .service-card, .staff-card {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100px; /* Reduced for high density */
        }

        .premium-card:hover, .service-card:hover, .staff-card:hover {
            border-color: var(--accent-primary);
            background: var(--bg-secondary);
        }

        .premium-card.selected, .service-card.selected, .staff-card.selected {
            background: rgba(212, 175, 55, 0.1);
            border-color: var(--accent-primary);
            border-width: 2px;
        }

        .service-card img, .staff-card img {
            width: 45px; /* Smaller images */
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.5rem;
            border: 2px solid var(--border-color);
        }

        .service-card h6, .staff-card .staff-name {
            font-size: 0.8rem; /* Smaller font */
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        /* --- Forms (Compact) --- */
        .form-control, .form-select {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 6px;
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
        }

        /* --- List Items --- */
        .list-group-item {
            padding: 0.6rem;
            margin-bottom: 0.5rem;
            border-radius: 8px !important;
            background: var(--bg-tertiary);
            font-size: 0.85rem;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-left: 3px solid transparent;
        }

        .list-group-item:hover {
            border-left-color: var(--accent-primary);
            background: var(--bg-secondary);
        }

        /* --- Receipt (Fixed High Precision) --- */
        .receipt-section {
            background: white;
            color: #1a1a1a;
            border-radius: 8px;
            padding: 1rem;
            font-family: 'Montserrat', sans-serif;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            font-size: 0.85rem;
        }

        .receipt-table th { font-size: 0.65rem; color: #64748b; }
        .receipt-table td { padding: 0.4rem 0; border-bottom: 1px solid #f1f5f9; }

        .btn-gold {
            background: var(--accent-primary);
            color: #000;
            font-weight: 800;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            border: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .ultra-small { font-size: 0.65rem; }
        .text-accent { color: var(--accent-primary) !important; }
    </style>
    </style>
@endpush

<!-- ... sisanya dari kode HTML dan PHP Anda tetap sama ... -->
<div class="cashier-container animate-fade">
    <!-- Header -->
    <header class="cashier-header">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary py-1 px-3" style="font-size: 0.75rem; border-radius: 6px;">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <button wire:click="resetForm" class="btn btn-gold py-1 px-3" style="font-size: 0.75rem; border-radius: 6px; width: auto;">
                <i class="fas fa-plus me-1"></i> Baru
            </button>
            @if($trxId && $status !== 'selesai')
                <button wire:click="hapusTransaksi" wire:confirm="Batalkan?" class="btn btn-danger py-1 px-3" style="font-size: 0.75rem; border-radius: 6px; background: #ef4444;">
                    <i class="fas fa-trash me-1"></i> Batal
                </button>
            @endif
            <h5 class="mb-0 font-heading text-accent d-none d-lg-block ms-3" style="letter-spacing: 2px;">
                <i class="fas fa-cut me-2"></i> {{ $nama_usaha }}
            </h5>
        </div>

        <div class="d-flex align-items-center gap-4">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="btn p-2 rounded-circle border-0 text-secondary hover:text-accent transition-colors" title="Toggle Theme">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:inline text-warning"></i>
            </button>

            <div class="text-end">
                <span class="text-secondary ultra-small fw-bold text-uppercase d-block mb-0">TOTAL</span>
                <span class="h3 mb-0 fw-bold text-accent font-display">
                    Rp {{ is_numeric($total) ? number_format($total, 0, ',', '.') : 0 }}
                </span>
            </div>
        </div>
    </header>

    <main class="cashier-body">
        <!-- 1. QUEUE SIDEBAR -->
        <aside class="panel">
            <div class="panel-header">
                <i class="fas fa-layer-group"></i> Antrean
            </div>
            <div class="panel-body" wire:poll.10s>
                <div class="mb-4">
                    <span class="badge bg-accent text-dark ultra-small mb-2 fw-bold">BOOKING</span>
                    <div class="list-group">
                        @php $estimasiPerOrang = 30; $bookingIds = collect($transaksiBooking)->sortBy('created_at')->pluck('id')->values(); @endphp
                        @forelse($transaksiBooking as $trx)
                            @php $antrian = $bookingIds->search($trx->id) !== false ? $bookingIds->search($trx->id) + 1 : 1; @endphp
                            <div wire:key="booking-{{ $trx->id }}" class="list-group-item {{ $trxId == $trx->id ? 'active' : '' }}" wire:click="isiFormDariTransaksi({{ $trx->id }})" style="cursor:pointer;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="fw-bold text-truncate" style="max-width: 150px;">#{{ $antrian }} {{ $trx->nama }}</div>
                                    <span class="badge bg-warning text-dark ultra-small">{{ $trx->status }}</span>
                                </div>
                                <div class="text-secondary ultra-small mt-1 d-flex gap-2">
                                    <span><i class="fas fa-clock me-1"></i> {{ $trx->waktu }}</span>
                                    <span><i class="fas fa-hourglass-half me-1"></i> {{ ($antrian - 1) * $estimasiPerOrang }}m</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 opacity-30 ultra-small">Belum ada antrean</div>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <span class="badge bg-primary ultra-small mb-2 fw-bold">PROSES</span>
                    <div class="list-group">
                        @forelse($transaksiProses as $trx)
                            <div wire:key="proses-{{ $trx->id }}" class="list-group-item {{ $trxId == $trx->id ? 'active' : '' }}" wire:click="isiFormDariTransaksi({{ $trx->id }})" style="cursor:pointer;">
                                <div class="fw-bold">{{ $trx->nama }}</div>
                                <div class="text-accent ultra-small animate-pulse"><i class="fas fa-spinner fa-spin me-1"></i> Sedang dikerjakan...</div>
                            </div>
                        @empty
                            <div class="text-center py-3 opacity-30 ultra-small">-</div>
                        @endforelse
                    </div>
                </div>

                <div>
                    <span class="badge bg-success ultra-small mb-2 fw-bold">SELESAI</span>
                    <div class="list-group">
                        @forelse($transaksiSelesai as $trx)
                            <div wire:key="selesai-{{ $trx->id }}" class="list-group-item py-1 opacity-60 ultra-small text-truncate" wire:click="isiFormDariTransaksi({{ $trx->id }})" style="cursor:pointer;">
                                {{ $trx->nama }} | {{ date('H:i', strtotime($trx->updated_at)) }}
                            </div>
                        @empty
                            <div class="text-center py-3 opacity-30 ultra-small">-</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </aside>

        <!-- 2. SELECTION (CENTER) -->
        <section class="panel">
            <div class="panel-header">
                <i class="fas fa-cash-register"></i> Detail Transaksi
            </div>
            <div class="panel-body">
                @if (session()->has('success')) <div class="alert alert-success ultra-small py-2 mb-2">{{ session('success') }}</div> @endif
                @if (session()->has('error')) <div class="alert alert-danger ultra-small py-2 mb-2">{{ session('error') }}</div> @endif

                <!-- Compact Metadata -->
                <div class="row g-2 mb-4">
                    <div class="col-3">
                        <label class="ultra-small fw-bold text-secondary text-uppercase mb-1">Invoice</label>
                        <div class="form-control bg-tertiary fw-bold text-accent border-0">{{ $invoice ?: 'OTW-' . date('Ymd') }}</div>
                    </div>
                    <div class="col-5">
                        <label class="ultra-small fw-bold text-secondary text-uppercase mb-1">Nama</label>
                        <input type="text" wire:model.live="nama" list="memberList" class="form-control" placeholder="Nama..." {{ $status === 'selesai' ? 'disabled' : '' }}>
                        <datalist id="memberList">
                            @foreach($listMember as $m)
                                <option wire:key="member-opt-{{ $loop->index }}" value="{{ $m->nama }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-4">
                        <label class="ultra-small fw-bold text-secondary text-uppercase mb-1">WA</label>
                        <input type="text" wire:model.live="no_hp" class="form-control" placeholder="08..." {{ $status === 'selesai' ? 'disabled' : '' }}>
                    </div>
                </div>

                <!-- High Density Sections -->
                <div class="mb-4">
                    <label class="ultra-small fw-bold text-secondary text-uppercase mb-2 d-block border-bottom pb-1"><i class="fas fa-cut me-1"></i> Layanan</label>
                    <div class="service-grid">
                        @foreach($listJasa as $j)
                            <div wire:key="jasa-card-{{ $j->id }}" class="service-card {{ in_array($j->id, (array)$jasa) ? 'selected' : '' }}" 
                                 wire:click="{{ $status === 'selesai' ? '' : 'toggleJasa(' . $j->id . ')' }}">
                                <img src="{{ $j->foto ? asset('storage/' . $j->foto) : 'https://ui-avatars.com/api/?name='.urlencode($j->nama).'&background=d4af37&color=000' }}" alt="">
                                <h6>{{ $j->nama }}</h6>
                                <span class="text-accent ultra-small fw-bold">Rp{{ number_format($j->harga, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="ultra-small fw-bold text-secondary text-uppercase mb-2 d-block border-bottom pb-1"><i class="fas fa-user-tie me-1"></i> Kapster</label>
                    <div class="staff-grid" style="grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));">
                        @foreach($listKapster as $k)
                            <div wire:key="kapster-card-{{ $k->id }}" class="staff-card {{ $kapster_id == $k->id ? 'selected' : '' }}" 
                                 wire:click="{{ $status === 'selesai' ? '' : '$set(\'kapster_id\', ' . $k->id . ')' }}">
                                <img src="{{ $k->foto ? asset('storage/' . $k->foto) : 'https://ui-avatars.com/api/?name='.urlencode($k->nama).'&background=333&color=fff' }}" alt="">
                                <span class="staff-name">{{ $k->nama }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="ultra-small fw-bold text-secondary text-uppercase mb-2 d-block border-bottom pb-1"><i class="fas fa-shopping-bag me-1"></i> Produk</label>
                    <div class="service-grid">
                        @foreach($listBarang as $b)
                            <div wire:key="barang-card-{{ $b->id }}" class="service-card {{ in_array($b->id, $barangSelected) ? 'selected' : '' }}" 
                                 wire:click="{{ $status === 'selesai' ? '' : 'toggleBarang(' . $b->id . ')' }}">
                                @if($b->stok < 5) <span class="badge bg-danger position-absolute top-0 start-0 m-1 ultra-small">!</span> @endif
                                <img src="{{ $b->foto ? asset('storage/' . $b->foto) : 'https://ui-avatars.com/api/?name='.urlencode($b->nama).'&background=222&color=d4af37' }}" alt="">
                                <h6>{{ $b->nama }}</h6>
                                <span class="text-accent ultra-small fw-bold">Rp{{ number_format($b->harga_jual, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. SUMMARY (RIGHT) -->
        <aside class="panel">
            <div class="panel-header">
                <i class="fas fa-file-invoice-dollar"></i> Ringkasan
            </div>
            <div class="panel-body d-flex flex-column" style="overflow: hidden; height: calc(100% - 50px);">
                <div class="receipt-section flex-grow-1 shadow-sm mb-3">
                    <div class="text-center border-bottom pb-2 mb-2">
                        <div class="h5 fw-bold text-accent mb-0" style="font-family: monospace;">#{{ $invoice ?: 'DRAFT' }}</div>
                        <h6 class="fw-bold mb-0 text-dark" style="font-family: var(--font-heading);">{{ $nama_usaha }}</h6>
                        <span class="ultra-small text-muted">{{ date('d/m/Y | H:i') }}</span>
                    </div>

                    <div class="receipt-items" style="max-height: 250px; overflow-y: auto;">
                        <table class="receipt-table w-100">
                            <thead>
                                <tr><th class="text-start">Item</th><th class="text-end">Total</th></tr>
                            </thead>
                            <tbody>
                                @foreach($selectedJasaItems as $item)
                                    <tr wire:key="receipt-jasa-{{ $item->id }}"><td class="ultra-small">{{ $item->nama }}</td><td class="text-end ultra-small fw-bold">{{ number_format($item->harga, 0, ',', '.') }}</td></tr>
                                @endforeach
                                @foreach($selectedBarangItems as $item)
                                    <tr wire:key="receipt-barang-{{ $item->id }}"><td class="ultra-small">{{ $item->nama }} (x{{ $jumlahBarang[$item->id] ?? 1 }})</td><td class="text-end ultra-small fw-bold">{{ number_format($item->harga_jual * ($jumlahBarang[$item->id] ?? 1), 0, ',', '.') }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="receipt-total d-flex justify-content-between align-items-center mt-3 pt-2">
                        <span class="ultra-small fw-bold">TOTAL</span>
                        <span class="text-accent h4 mb-0 fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Area: Only show if items selected or done -->
                <div class="mt-auto">
                    @if(count($jasa) > 0 || count($barangSelected) > 0 || $status === 'selesai')
                        @if($status !== 'selesai')
                            <div class="mb-2 p-2 border rounded-3 bg-light dark:bg-black/20">
                                <label class="ultra-small text-secondary fw-bold text-uppercase mb-1">Metode Pembayaran</label>
                                <select wire:model.live="metode_pembayaran" class="form-select border-accent">
                                    <option value="cash">Tunai (Cash)</option>
                                    <option value="transfer">Transfer QRIS</option>
                                </select>
                            </div>
                            
                            <div class="payment-controls animate__animated animate__fadeInUp">
                                @if($metode_pembayaran === 'cash')
                                    <div class="mb-2">
                                        <label class="ultra-small text-secondary fw-bold text-uppercase mb-1 px-1">Uang Bayar</label>
                                        <input type="number" wire:model.live="bayar" class="form-control h3 text-end fw-bold border-accent bg-transparent" placeholder="0">
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between align-items-center px-1">
                                        <span class="ultra-small text-secondary fw-bold text-uppercase">Kembalian</span>
                                        <span class="fw-bold {{ $kembali < 0 ? 'text-danger' : 'text-success' }}" style="font-size: 1.25rem;">
                                            Rp{{ number_format($kembali, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif

                                <button wire:click="simpanTransaksi" class="btn-gold py-3 shadow w-100 animate-pulse">
                                    <i class="fas fa-check-circle me-1"></i> SIMPAN & SELESAI
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success text-center py-2 mb-2 ultra-small fw-bold animate__animated animate__bounceIn">
                                <i class="fas fa-check-double me-1"></i> LUNAS via {{ strtoupper($metode_pembayaran) }}
                            </div>
                            <div class="d-flex gap-2">
                                <button onclick="window.print()" class="btn btn-outline-dark w-100 py-2"><i class="fas fa-print me-1"></i> Struk</button>
                                <button wire:click="resetForm" class="btn btn-gold w-100 py-2">Transaksi Baru</button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4 text-muted animate__animated animate__fadeIn">
                            <i class="fas fa-shopping-basket fa-2x mb-2 opacity-50"></i>
                            <p class="ultra-small fw-bold">Belum ada item dipilih</p>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
    </main>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('swal-success', (e) => {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: e.message, timer: 1500, showConfirmButton: false, background: 'var(--bg-secondary)', color: 'var(--text-primary)' });
            });
            Livewire.on('swal-error', (e) => {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: e.message, timer: 2000, showConfirmButton: false, background: 'var(--bg-secondary)', color: 'var(--text-primary)' });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush