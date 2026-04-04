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

        /* --- Sidebar Premium Enhancements --- */
        .premium-sidebar {
            border: 2px solid var(--accent-primary);
            box-shadow: 0 15px 50px -10px rgba(212, 175, 55, 0.2);
            position: relative;
        }

        .dark .premium-sidebar {
            box-shadow: 0 15px 50px -10px rgba(212, 175, 55, 0.15);
        }

        .receipt-ticket {
            background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: inset 0 0 0 1px var(--border-color), 0 10px 20px -5px rgba(0,0,0,0.05);
            position: relative;
        }

        .dark .receipt-ticket {
            background: linear-gradient(135deg, #1f1f1f, #0a0a0a);
            box-shadow: inset 0 0 0 1px rgba(212, 175, 55, 0.2), 0 10px 30px rgba(0,0,0,0.5);
        }

        .receipt-table th { font-size: 0.65rem; color: var(--text-secondary); border-bottom: 1px dashed var(--border-color); padding-bottom: 0.5rem; }
        .receipt-table td { padding: 0.6rem 0; border-bottom: 1px dashed var(--border-color); color: var(--text-primary); }
        .receipt-table tr:last-child td { border-bottom: none; }

        .payment-method-btn {
            flex: 1;
            padding: 0.75rem 0.5rem;
            border-radius: 10px;
            border: 2px solid var(--border-color);
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
        }
        .payment-method-btn:hover { border-color: var(--accent-primary); }
        .payment-method-btn.active {
            border-color: var(--accent-primary);
            color: var(--accent-primary);
            background: rgba(212, 175, 55, 0.1);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }

        .huge-input {
            font-size: 2.2rem !important;
            font-family: var(--font-display) !important;
            color: var(--accent-primary) !important;
            border: none !important;
            border-bottom: 2px dashed var(--border-color) !important;
            background: transparent !important;
            border-radius: 0 !important;
            padding: 0.5rem 0 !important;
            box-shadow: none !important;
            text-align: right;
            transition: border-color 0.3s ease;
        }
        .huge-input:focus { border-bottom-color: var(--accent-primary) !important; outline: none; }
        .huge-input::placeholder { color: var(--border-color); }

        .btn-gold-premium {
            background: linear-gradient(45deg, #FFC107, #FF9800, #FFC107);
            background-size: 200% auto;
            color: #000;
            font-weight: 900;
            font-size: 1.15rem;
            letter-spacing: 2px;
            padding: 1rem 0.5rem;
            border-radius: 12px;
            border: 2px solid #fff;
            width: 100%;
            text-transform: uppercase;
            box-shadow: 0 10px 20px rgba(255, 152, 0, 0.4), inset 0 2px 5px rgba(255,255,255,0.5);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            animation: gradientShine 3s linear infinite, ctaPulse 2s ease-in-out infinite;
            text-shadow: 0 1px 2px rgba(255,255,255,0.5);
            margin-top: 5px;
        }

        .dark .btn-gold-premium {
            border: 2px solid #000;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3), inset 0 2px 5px rgba(255,255,255,0.2);
            color: #111;
        }

        .btn-gold-premium:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255, 152, 0, 0.6);
            background-position: right center;
        }

        @keyframes gradientShine {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        
        @keyframes ctaPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        .ultra-small { font-size: 0.65rem; }
        .text-accent { color: var(--accent-primary) !important; }
    </style>
    <!-- Add animate.css if not present -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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

        <div class="d-flex align-items-center gap-2">
            <!-- Fullscreen Toggle -->
            <button onclick="toggleFullscreen(this)" class="btn p-2 rounded-circle border-0 text-secondary hover:text-accent transition-colors" title="Toggle Fullscreen">
                <i class="fas fa-expand"></i>
            </button>

            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="btn p-2 rounded-circle border-0 text-secondary hover:text-accent transition-colors" title="Toggle Theme">
                <i class="fas fa-moon dark:hidden"></i>
                <i class="fas fa-sun hidden dark:inline text-warning"></i>
            </button>

            <div class="text-end ms-3">
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
        <aside class="panel premium-sidebar">
            <div class="panel-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-invoice-dollar me-2"></i> RINGKASAN</span>
                @if(count($jasa) > 0 || count($barangSelected) > 0)
                    <span class="badge bg-warning text-dark border-0 animate__animated animate__pulse animate__infinite">AKTIF</span>
                @endif
            </div>
            <div class="panel-body d-flex flex-column" style="overflow:-moz-hidden-unscrollable; height: calc(100% - 50px);">
                <div class="receipt-ticket flex-grow-1 d-flex flex-column mb-3">
                    <div class="text-center pb-3 mb-3" style="border-bottom: 2px dashed var(--border-color);">
                        <div class="h5 fw-bold text-accent mb-0" style="font-family: var(--font-display); letter-spacing: 1px;">#{{ $invoice ?: 'DRAFT-' . date('Ymd') }}</div>
                        <h6 class="fw-bold mb-1 mt-2 text-primary" style="font-family: var(--font-heading); font-size: 1.1rem;">{{ $nama_usaha }}</h6>
                        <span class="ultra-small text-secondary"><i class="far fa-clock me-1"></i>{{ date('d-M-Y | H:i') }}</span>
                    </div>

                    <div class="receipt-items flex-grow-1" style="max-height: 250px; overflow-y: auto; scrollbar-width: none;">
                        <table class="receipt-table w-100">
                            <thead>
                                <tr><th class="text-start">ITEM DESCRIPTION</th><th class="text-end">PRICE</th></tr>
                            </thead>
                            <tbody>
                                @foreach($selectedJasaItems as $item)
                                    <tr wire:key="receipt-jasa-{{ $item->id }}">
                                        <td class="ultra-small"><span class="d-block fw-bold" style="font-size: 0.75rem;">{{ $item->nama }}</span></td>
                                        <td class="text-end ultra-small fw-bold" style="font-size: 0.8rem;">{{ number_format($item->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                @foreach($selectedBarangItems as $item)
                                    <tr wire:key="receipt-barang-{{ $item->id }}">
                                        <td class="ultra-small"><span class="d-block fw-bold" style="font-size: 0.75rem;">{{ $item->nama }}</span><span class="text-secondary">x{{ $jumlahBarang[$item->id] ?? 1 }}</span></td>
                                        <td class="text-end ultra-small fw-bold" style="font-size: 0.8rem;">{{ number_format($item->harga_jual * ($jumlahBarang[$item->id] ?? 1), 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="receipt-total d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top: 2px dashed var(--border-color);">
                        <span class="text-secondary fw-bold text-uppercase" style="letter-spacing: 2px;">Total Bayar</span>
                        <span class="text-accent h3 mb-0 fw-bold" style="font-family: var(--font-display);">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Area: Only show if items selected or done -->
                <div class="mt-auto">
                    @if(count($jasa) > 0 || count($barangSelected) > 0 || $status === 'selesai')
                        @if($status !== 'selesai')
                            <div class="mb-2">
                                <label class="ultra-small text-secondary fw-bold text-uppercase mb-1 d-block"><i class="fas fa-wallet me-1"></i> Metode Pembayaran</label>
                                <div class="d-flex gap-2">
                                    <div class="payment-method-btn py-2 {{ $metode_pembayaran === 'cash' ? 'active' : '' }}" wire:click="$set('metode_pembayaran', 'cash')">
                                        <i class="fas fa-money-bill-wave d-block mb-1 fs-6"></i> Tunai (Cash)
                                    </div>
                                    <div class="payment-method-btn py-2 {{ $metode_pembayaran === 'transfer' ? 'active' : '' }}" wire:click="$set('metode_pembayaran', 'transfer')">
                                        <i class="fas fa-qrcode d-block mb-1 fs-6"></i> Transfer QRIS
                                    </div>
                                </div>
                            </div>
                            
                            <div class="payment-controls animate__animated animate__fadeInUp">
                                @if($metode_pembayaran === 'cash')
                                    <div class="mb-1 position-relative">
                                        <label class="ultra-small text-secondary fw-bold text-uppercase position-absolute top-0 start-0 pt-1 z-1">Nominal Uang</label>
                                        <input type="number" wire:model.live="bayar" class="form-control huge-input w-100 placeholder-glow" style="font-size: 1.8rem !important;" placeholder="0">
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between align-items-center p-2 rounded-3" style="background: rgba(212,175,55,0.05); border: 1px solid var(--border-color);">
                                        <span class="ultra-small text-secondary fw-bold text-uppercase mb-0"><i class="fas fa-exchange-alt me-1"></i> Kembalian</span>
                                        <span class="fw-bold {{ $kembali < 0 ? 'text-danger' : 'text-success' }}" style="font-size: 1.25rem; font-family: var(--font-display);">
                                            Rp{{ number_format($kembali, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endif

                                <button wire:click="simpanTransaksi" class="btn-gold-premium animate__animated animate__pulse animate__infinite">
                                    <i class="fas fa-check-circle me-1"></i> SIMPAN & SELESAI
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success text-center py-2 mb-2 ultra-small fw-bold animate__animated animate__bounceIn" style="border-radius: 12px; font-size: 0.8rem;">
                                <i class="fas fa-check-double fa-2x d-block mb-1 text-success"></i>
                                LUNAS DASHBOARD
                            </div>
                            <div class="d-flex gap-2">
                                <button onclick="window.print()" class="btn btn-outline-secondary w-50 py-2" style="border-radius: 12px; font-weight: bold;"><i class="fas fa-print me-1"></i> CETAK</button>
                                <button wire:click="resetForm" class="btn btn-gold-premium w-50" style="padding: 0.5rem 1rem; margin-top: 0;"><i class="fas fa-plus me-1"></i> BARU</button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4 text-muted animate__animated animate__fadeIn" style="border: 2px dashed var(--border-color); border-radius: 16px;">
                            <i class="fas fa-shopping-basket fa-3x mb-3 opacity-25 text-accent"></i>
                            <p class="ultra-small fw-bold text-uppercase mb-0" style="letter-spacing: 1px;">Belum Ada Layanan</p>
                            <span style="font-size: 0.65rem;">Pilih jasa atau produk di sebelah kiri</span>
                        </div>
                    @endif
                </div>
            </div>
        </aside>
    </main>
</div>

@push('scripts')
    <script>
        function toggleFullscreen(btn) {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                btn.querySelector('i').className = 'fas fa-compress';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                    btn.querySelector('i').className = 'fas fa-expand';
                }
            }
        }

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