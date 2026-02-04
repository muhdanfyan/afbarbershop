@push('styles')
    <!-- Google Fonts untuk tema premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Montserrat:wght@400;500;700&display=swap"
        rel="stylesheet">
    <style>
        /* --- CSS Variables for Gold & Black Theme --- */
        :root {
            --bg-primary: #0a0a0a;
            /* Hitam pekat */
            --bg-secondary: #1a1a1a;
            /* Abu-abu sangat gelap untuk panel */
            --bg-tertiary: #2a2a2a;
            /* Abu-abu gelap untuk hover/item */
            --accent-primary: #d4af37;
            /* Emas klasik */
            --accent-hover: #f4e4a6;
            /* Emas lebih terang untuk hover */
            --text-primary: #f0f0f0;
            /* Teks utama putih */
            --text-secondary: #a0a0a0;
            /* Teks sekunder abu-abu */
            --border-color: #333333;
            /* Batas abu-abu gelap */
            --font-heading: 'Cinzel', serif;
            --font-body: 'Montserrat', sans-serif;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--bg-primary);
            font-family: var(--font-body);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        .cashier-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg-primary);
        }

        .cashier-header {
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .cashier-body {
            flex: 1;
            display: flex;
            padding: 1.5rem;
            gap: 1.5rem;
            max-height: calc(100vh - 70px);
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .queue-section {
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            height: 100%;
            overflow-y: auto;
            border: 1px solid var(--border-color);
        }

        .form-section,
        .receipt-section {
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
            overflow-y: auto;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--accent-primary);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: var(--accent-primary);
        }

        /* --- GAYA INPUT TEXT YANG DIPERBAIKI --- */
        .form-control,
        .form-select {
            background-color: var(--bg-tertiary);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            /* Padding sedikit lebih besar untuk kenyamanan */
            color: var(--text-primary);
            transition: all 0.3s ease;
            /* Transisi lebih halus */
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--bg-tertiary);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.4);
            /* Efek glow emas lebih menonjol */
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }

        /* --- GAYA TOMBOL YANG DIPERBAIKI --- */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            /* Padding horizontal lebih lebar */
            transition: all 0.3s ease;
            /* Transisi halus untuk semua properti */
            font-family: var(--font-body);
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:focus {
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.4);
            outline: none;
        }

        /* Tombol Sukses / Utama */
        .btn-save,
        .btn-success {
            background: linear-gradient(135deg, var(--accent-primary), #c5a028);
            /* Gradasi emas */
            color: var(--bg-primary);
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        .btn-save:hover,
        .btn-success:hover {
            background: linear-gradient(135deg, var(--accent-hover), var(--accent-primary));
            transform: translateY(-3px);
            /* Efek mengangkat lebih tinggi */
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.5);
            color: var(--bg-primary);
        }

        /* Tombol Warning / Sekunder */
        .btn-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: var(--bg-primary);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #f5b041, #f39c12);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(243, 156, 18, 0.5);
            color: var(--bg-primary);
        }

        /* Tombol Secondary / Netral */
        .btn-secondary {
            background: linear-gradient(135deg, #7f8c8d, #95a5a6);
            color: var(--bg-primary);
            box-shadow: 0 4px 10px rgba(149, 165, 166, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #95a5a6, #bdc3c7);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(149, 165, 166, 0.5);
            color: var(--bg-primary);
        }

        /* Gaya untuk input yang readonly (Uang Kembali) */
        .form-control[readonly] {
            background-color: #1e1e1e;
            /* Sedikit lebih gelap */
            cursor: not-allowed;
            opacity: 0.8;
        }


        .service-grid,
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .service-card,
        .staff-card {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 1rem 0.5rem;
            background: var(--bg-tertiary);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 120px;
        }

        .service-card:hover,
        .staff-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-primary);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
            background: var(--bg-secondary);
        }

        .service-card.selected,
        .staff-card.selected {
            border-color: var(--accent-primary);
            background: rgba(212, 175, 55, 0.15);
            box-shadow: inset 0 0 10px rgba(212, 175, 55, 0.2);
        }

        .service-card.selected::before,
        .staff-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-primary);
        }

        .service-card.selected::after,
        .staff-card.selected::after {
            content: '✓';
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--accent-primary);
            color: var(--bg-primary);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .service-card img,
        .staff-card img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 0.75rem;
            border: 3px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .service-card:hover img,
        .staff-card:hover img {
            border-color: var(--accent-primary);
            transform: scale(1.05);
        }

        .service-card h6,
        .staff-card .staff-name {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .payment-section {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 2px solid var(--border-color);
        }

        .payment-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .payment-input label {
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            display: block;
        }

        .payment-input .form-control {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px dashed var(--border-color);
        }

        .receipt-header h5 {
            margin: 0;
            color: var(--accent-primary);
            font-weight: 700;
            font-family: var(--font-heading);
            font-size: 1.5rem;
        }

        .receipt-header p {
            margin: 0.25rem 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .receipt-items {
            flex: 1;
            overflow-y: auto;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table th {
            text-align: left;
            padding: 0.5rem;
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 600;
        }

        .receipt-table td {
            padding: 0.5rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        .receipt-table .text-right {
            text-align: right;
        }

        .receipt-table .text-center {
            text-align: center;
        }

        .receipt-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed var(--border-color);
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--accent-primary);
            font-family: var(--font-heading);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1rem;
            border: none;
        }

        .alert-success {
            background-color: #2d5016;
            color: #a8e6cf;
        }

        .alert-danger {
            background-color: #5a1e1e;
            color: #f8b4b4;
        }

        .invoice-display {
            background: var(--bg-tertiary);
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 700;
            color: var(--accent-primary);
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
        }

        /* Styling untuk List Transaksi Hari Ini */
        .list-group {
            background-color: var(--bg-tertiary);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .list-group-item {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            border-radius: 12px !important;
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 4px solid transparent;
        }

        .list-group-item:hover {
            background-color: var(--bg-tertiary);
            border-left: 4px solid var(--accent-primary);
            transform: translateX(5px);
        }

        .receipt-section {
            background: #ffffff;
            color: #333;
            border: none;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .receipt-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--accent-primary), #f4e4a6, var(--accent-primary));
        }

        .receipt-header h5 {
            color: #000;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .receipt-header p {
            color: #666;
            font-weight: 500;
        }

        .receipt-table th {
            color: #000;
            border-bottom: 2px solid #333;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        .receipt-table td {
            color: #444;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 0.75rem 0.5rem;
        }

        .receipt-total {
            color: #000;
            border-top: 2px solid #333;
            padding-top: 1.5rem;
            font-size: 1.6rem;
        }

        .payment-section {
            background: var(--bg-tertiary);
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
            border: 1px solid var(--border-color);
        }

        /* --- Custom Scrollbar --- */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-primary);
        }

        /* --- Responsive Styles --- */
        @media (max-width: 992px) {
            .cashier-body {
                flex-direction: column;
                max-height: none;
                overflow: visible;
                padding: 1rem;
            }

            .queue-section,
            .form-section,
            .receipt-section {
                height: auto;
                margin-bottom: 1.5rem;
                max-height: none;
            }

            .receipt-section {
                order: 3;
            }
        }

        @media (max-width: 480px) {

            .service-grid,
            .staff-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cashier-header {
                padding: 1rem;
            }

            .cashier-header h3 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .cashier-body {
                padding: 1rem;
            }

            .service-grid,
            .staff-grid {
                grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
            }
        }

        .ultra-small {
            font-size: 0.65rem;
        }

        .text-accent {
            color: var(--accent-primary) !important;
        }

        .bg-tertiary {
            background-color: var(--bg-tertiary) !important;
        }

        .bg-accent {
            background-color: var(--accent-primary) !important;
            color: var(--bg-primary) !important;
        }

        /* --- Modal Custom Styles --- */
        .modal-content {
            background-color: var(--bg-secondary) !important;
            border: 2px solid var(--accent-primary) !important;
            border-radius: 20px !important;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
            padding: 1.5rem !important;
        }

        .modal-body {
            background-color: var(--bg-secondary) !important;
            border-radius: 0 0 20px 20px !important;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%) !important;
        }
    </style>
@endpush

<!-- ... sisanya dari kode HTML dan PHP Anda tetap sama ... -->
<div class="cashier-container">
    <!-- Header Total -->
    <div class="cashier-header d-flex justify-content-between align-items-center px-4 py-2"
        style="border-bottom: 1px solid var(--border-color); background: var(--bg-secondary);">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary py-1 px-3 me-2"
                style="font-size: 0.8rem;">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <button wire:click="resetForm" class="btn btn-save py-1 px-3 me-2"
                style="font-size: 0.8rem;">
                <i class="fas fa-plus me-1"></i> Transaksi Baru
            </button>
            @if($trxId && $status !== 'selesai')
                <button wire:click="hapusTransaksi" 
                        wire:confirm="Apakah Anda yakin ingin membatalkan dan menghapus transaksi ini dari antrian?"
                        class="btn btn-danger py-1 px-3 me-3"
                        style="font-size: 0.8rem; background: #dc3545;">
                    <i class="fas fa-trash me-1"></i> Batal
                </button>
            @endif
            <h4 class="mb-0 font-heading text-accent d-none d-md-block" style="letter-spacing: 2px;">
                <i class="fas fa-cut me-2"></i> {{ $nama_usaha }}
            </h4>
        </div>

        <div class="text-end d-flex align-items-center gap-3">
            <div class="d-flex flex-column text-end">
                <span class="text-secondary small fw-bold tracking-wider"
                    style="font-size: 0.7rem; text-transform: uppercase;">Total Pembayaran</span>
                <span class="h2 mb-0 fw-bold text-accent font-heading">
                    Rp {{ is_numeric($total) ? number_format($total, 0, ',', '.') : 0 }}
                </span>
            </div>
        </div>
    </div>

    <div class="cashier-body row g-3" style="padding: 1.5rem; max-width: 100vw; margin: 0;">
        <form wire:submit.prevent="simpanTransaksi" id="transaksiForm" class="row g-3 m-0 p-0">
            <!-- Sidebar Transaksi Hari Ini -->
            <div class="col-lg-3 col-md-12 mb-3">
                <div class="queue-section" wire:poll.5s style="min-height:300px; max-height:85vh; overflow-y:auto;">
                    <div class="section-title"><i class="fas fa-list"></i> Antrian</div>
                    <div class="mb-2"><span class="badge bg-warning text-dark">Booking</span></div>
                    <ul class="list-group mb-3">
                        @php
$estimasiPerOrang = 30;
$bookingIds = collect($transaksiBooking)->sortBy('created_at')->pluck('id')->values();
                        @endphp
                        @forelse($transaksiBooking as $trx)
                            @php
    $antrian = $bookingIds->search($trx->id) !== false ? $bookingIds->search($trx->id) + 1 : 1;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="cursor:pointer;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                                <div>
                                    <span class="fw-bold">#{{ $antrian }} {{ $trx->nama }}
                                        @if($trx->status === 'menunggu' && $trx->invoice)
                                            <span class="text-muted small">&nbsp;({{ substr($trx->invoice, -4) }})</span>
                                        @endif
                                    </span>
                                    @if($trx->kapster && $trx->kapster->nama)
                                        <div class="text-muted small">Kapster: {{ $trx->kapster->nama }}</div>
                                    @endif
                                    @if($trx->waktu)
                                        <div class="text-muted small">Waktu: {{ $trx->waktu }}</div>
                                    @endif
                                    <div class="text-muted small">Estimasi menunggu:
                                        {{ ($antrian - 1) * $estimasiPerOrang }}
                                        menit
                                    </div>
                                </div>
                                <span class="badge bg-warning text-dark">{{ $trx->status }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 opacity-50">
                                <i class="fas fa-calendar-times d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="small uppercase tracking-widest">Belum Ada Antrian</span>
                            </li>
                        @endforelse
                    </ul>

                    <div class="mb-2 d-flex align-items-center"><span class="badge bg-primary px-3 py-1">SEDANG
                            PROSES</span>
                        <div class="flex-grow-1 ms-2 border-bottom border-secondary opacity-25"></div>
                    </div>
                    <ul class="list-group mb-3">
                        @forelse($transaksiProses as $trx)
                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                style="cursor:pointer;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                                <div>
                                    <span class="fw-bold">{{ $trx->nama }}</span>
                                    @if($trx->kapster && $trx->kapster->nama)
                                        <div class="text-muted ultra-small">Kapster: {{ $trx->kapster->nama }}</div>
                                    @endif
                                    <div class="text-accent ultra-small"><i class="fas fa-spinner fa-spin me-1"></i> Sedang
                                        dikerjakan...</div>
                                </div>
                                <span class="badge bg-primary">{{ $trx->status }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-3 opacity-50">
                                <span class="small">Tidak ada proses</span>
                            </li>
                        @endforelse
                    </ul>

                    <div class="mb-2 d-flex align-items-center"><span class="badge bg-success px-3 py-1">SELESAI HARI
                            INI</span>
                        <div class="flex-grow-1 ms-2 border-bottom border-secondary opacity-25"></div>
                    </div>
                    <ul class="list-group">
                        @forelse($transaksiSelesai as $trx)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2"
                                style="cursor:pointer; opacity: 0.8;" wire:click="isiFormDariTransaksi({{ $trx->id }})">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $trx->nama }}</span>
                                </div>
                                <span class="small text-secondary">{{ date('H:i', strtotime($trx->updated_at)) }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-3 opacity-50">
                                <span class="small">Belum Ada Selesai</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Form Section -->
            <div class="col-lg-5 col-md-12 form-section mb-3"
                style="max-height:85vh; overflow-y:auto; scrollbar-width: thin;">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row m-0 p-0">
                    <div class="invoice-display d-flex justify-content-between align-items-center mb-4 px-3 py-2"
                        style="background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); border-radius: 10px;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-invoice text-accent me-2"></i>
                            <span class="text-accent fw-bold">
                                @if($trxId)
                                    {{ $invoice }}
                                @else
                                    TRANSAKSI BARU
                                @endif
                            </span>
                        </div>
                        <span class="text-secondary small fw-bold">
                            <i class="fas fa-clock me-1"></i> {{ date('H:i') }} | {{ date('d M Y') }}
                        </span>
                    </div>

                    <div class="section-title">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="text-secondary ultra-small mb-1 fw-bold"
                                style="font-size: 0.65rem; text-transform: uppercase;">Pelanggan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-tertiary border-0 text-accent"><i
                                        class="fas fa-user"></i></span>
                                <input type="text" class="form-control" wire:model.defer="nama" required
                                    placeholder="Nama Lengkap" list="datalist-member" id="input-nama-member"
                                    @if($status === 'selesai') readonly @endif>
                            </div>
                            <datalist id="datalist-member">
                                @foreach($listMember as $member)
                                    <option value="{{ $member->nama }}" data-wa="{{ $member->nomor_wa }}">
                                        {{ $member->nama }} -
                                        {{ $member->nomor_wa }}
                                    </option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-6">
                            <label class="text-secondary ultra-small mb-1 fw-bold"
                                style="font-size: 0.65rem; text-transform: uppercase;">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-tertiary border-0 text-accent"><i
                                        class="fab fa-whatsapp"></i></span>
                                <input type="text" class="form-control" wire:model.defer="no_hp" placeholder="6281xxx"
                                    required id="input-wa-member"
                                    @if($status === 'selesai') readonly @endif>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const inputNama = document.getElementById('input-nama-member');
                            const inputWa = document.getElementById('input-wa-member');
                            const datalist = document.getElementById('datalist-member');
                            inputNama.addEventListener('input', function () {
                                const val = inputNama.value;
                                const option = Array.from(datalist.options).find(opt => opt.value === val);
                                if (option && option.dataset.wa) {
                                    inputWa.value = option.dataset.wa;
                                    // Untuk Livewire agar sinkron
                                    inputWa.dispatchEvent(new Event('input', { bubbles: true }));
                                }
                            });
                        });
                    </script>

                    <div class="section-title d-flex justify-content-between align-items-center mt-4">
                        <span><i class="fas fa-cut"></i> Pilih Layanan</span>
                        <span class="badge bg-accent text-dark" style="font-size: 0.6rem;">{{ count((array) $jasa) }}
                            Terpilih</span>
                    </div>

                    <div class="service-grid" style="{{ $status === 'selesai' ? 'pointer-events: none; opacity: 0.8;' : '' }}">
                        @foreach($listJasa as $j)
                            <div class="service-card{{ in_array($j->id, (array) $jasa) ? ' selected' : '' }}"
                                @if($status !== 'selesai') wire:click="toggleJasa({{ $j->id }})" @endif>
                                <div class="card-image-wrapper">
                                    @if($j->foto)
                                        <img src="{{ asset('storage/' . $j->foto) }}" alt="{{ $j->nama }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($j->nama) }}&background=d4af37&color=0a0a0a"
                                            alt="{{ $j->nama }}">
                                    @endif
                                </div>
                                <h6>{{ $j->nama }}</h6>
                                <div class="small text-accent fw-bold mt-1">Rp {{ number_format($j->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-title d-flex justify-content-between align-items-center mt-2">
                        <span><i class="fas fa-user-tie"></i> Pilih Kapster</span>
                        @if($kapster)
                            <span class="badge bg-success" style="font-size: 0.6rem;">Sudah Dipilih</span>
                        @endif
                    </div>

                    <div class="staff-grid" style="{{ $status === 'selesai' ? 'pointer-events: none; opacity: 0.8;' : '' }}">
                        @foreach($listKapster as $k)
                            <div class="staff-card{{ $kapster == $k->id ? ' selected' : '' }}"
                                @if($status !== 'selesai') wire:click="$set('kapster', {{ $k->id }})" @endif>
                                <div class="card-image-wrapper">
                                    @if($k->foto)
                                        <img src="{{ asset('storage/' . $k->foto) }}" alt="{{ $k->nama }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($k->nama) }}&background=d4af37&color=0a0a0a"
                                            alt="{{ $k->nama }}">
                                    @endif
                                </div>
                                <div class="staff-name mt-1">{{ $k->nama }}</div>
                            </div>
                        @endforeach
                    </div>
                    @error('kapster') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Receipt Section -->
            <div class="col-lg-4 col-md-12 receipt-section mb-3"
                style="min-height: 600px; display: flex; flex-direction: column; max-height:85vh; overflow-y:auto; scrollbar-width: thin; background-color: #fdfdfd;">
                <div class="receipt-header">
                    <h5>STRUK PEMBAYARAN</h5>
                    <p class="fw-bold" style="color: var(--accent-primary);">{{ $nama_usaha }}</p>
                    <p>Tanggal: {{ date('d-m-Y') }}</p>
                </div>

                <div class="receipt-items mt-3" style="flex: 1;">
                    <table class="receipt-table w-100">
                        <thead>
                            <tr>
                                <th class="pb-2 text-start">LAYANAN</th>
                                <th class="pb-2 text-right">HARGA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedJasaItems as $item)
                                <tr wire:key="selected-jasa-{{ $item->id }}">
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $item->nama }}</div>
                                        <small class="text-muted text-uppercase tracking-tighter"
                                            style="font-size: 0.7rem;">Professional Service</small>
                                    </td>
                                    <td class="text-right fw-bold text-dark" style="font-size: 1rem;">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">
                                        <i class="fas fa-cut mb-2 d-block" style="font-size: 2rem; opacity: 0.3;"></i>
                                        Belum ada layanan dipilih
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="receipt-footer mt-auto">
                    <div class="receipt-total p-2 d-flex justify-content-between align-items-center">
                        <span class="font-heading" style="font-size: 1.1rem; color: #666;">Total Tagihan</span>
                        <span class="font-heading fw-bold" style="font-size: 1.8rem; color: #000;">
                            Rp {{ is_numeric($total) ? number_format($total, 0, ',', '.') : 0 }}
                        </span>
                    </div>

                    <div class="mt-4 text-center border-top pt-3">
                        <div class="font-heading text-dark fw-bold mb-1" style="letter-spacing: 3px;">TERIMA KASIH</div>
                        <p class="text-muted small mb-0">Atas Kunjungan Anda di {{ $nama_usaha }}</p>
                        <div class="small text-secondary mt-1">#TheGentlemensChoice</div>
                    </div>
                </div>
                <div class="payment-trigger-section mt-auto pt-3 border-top border-2 border-dashed">
                    <button type="button" class="btn btn-save w-100 py-3 shadow-lg"
                        data-bs-target="#paymentModal" 
                        @if(!$kapster || empty((array) $jasa) || $status === 'selesai') 
                            disabled 
                            style="pointer-events: none; opacity: 0.5;"
                        @else
                            data-bs-toggle="modal"
                        @endif>
                        <i class="fas fa-money-bill-wave me-2"></i>
                        <span class="h5 mb-0">BAYAR SEKARANG</span>
                    </button>
                    @if($status === 'selesai')
                        <div class="text-center mt-1">
                            <span class="badge bg-success w-100 py-2">
                                <i class="fas fa-check-double me-1"></i> TRANSAKSI SELESAI
                            </span>
                        </div>
                    @elseif(!$kapster || empty((array) $jasa))
                        <div class="text-center mt-1">
                            <small class="text-danger fw-bold" style="font-size: 0.65rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i> Pilih layanan & kapster
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Pembayaran (Di luar form agar tidak terpotong overflow) -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-heading text-accent" id="paymentModalLabel">
                        <i class="fas fa-credit-card me-2"></i> KONFIRMASI PEMBAYARAN
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="row mb-4">
                        <div class="col-12 mb-4">
                            <label class="fw-bold text-secondary ultra-small mb-2 d-block"
                                style="font-size: 0.75rem; text-transform: uppercase;">Jumlah Bayar
                                (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-0 text-white px-3"
                                    style="border-radius: 12px 0 0 12px;">Rp</span>
                                <input type="number" class="form-control form-control-lg text-end fw-bold"
                                    wire:model.live="uang_bayar" min="0" id="uang_bayar_input"
                                    style="font-size: 2.2rem; border-radius: 0 12px 12px 0; background: #222; color: var(--accent-primary); border: 1px solid var(--border-color);">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="fw-bold text-secondary ultra-small mb-2 d-block"
                                style="font-size: 0.75rem; text-transform: uppercase;">Kembalian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-0 text-accent font-heading px-3"
                                    style="border-radius: 12px 0 0 12px;">Rp</span>
                                <input type="text"
                                    class="form-control form-control-lg text-end fw-bold bg-dark text-accent"
                                    value="{{ is_numeric($uang_kembali) ? number_format($uang_kembali, 0, ',', '.') : 0 }}"
                                    readonly
                                    style="font-size: 2.2rem; border-radius: 0 12px 12px 0; border: 1px solid var(--border-color);">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <button type="button"
                                class="btn btn-warning w-100 py-3 d-flex flex-column align-items-center"
                                wire:click="prosesTransaksi" name="proses" @if($status === 'selesai')
                                disabled @endif>
                                <i class="fas fa-spinner fa-spin mb-1"></i>
                                <span>PROSES</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button"
                                class="btn btn-secondary w-100 py-3 d-flex flex-column align-items-center"
                                wire:click="menungguTransaksi" name="menunggu" @if($status === 'selesai') disabled @endif>
                                <i class="fas fa-clock mb-1"></i>
                                <span>MENUNGGU</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" form="transaksiForm"
                        class="btn btn-success w-100 py-4 d-flex flex-column align-items-center shadow-lg mt-2"
                        style="height: auto;" @if($status === 'selesai') disabled @endif>
                        <i class="fas fa-check-circle mb-2 fa-2x"></i>
                        <span class="h4 mb-0 fw-bold">SIMPAN & SELESAI</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('transaksi-updated', () => {
                Livewire.dispatch('refresh');
            });

            // Handle modal closure from backend
            window.addEventListener('close-modal', event => {
                var modalElement = document.getElementById('paymentModal');
                if (modalElement) {
                    var modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal-success', function (e) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: e.detail && e.detail.message ? e.detail.message : 'Transaksi berhasil disimpan!',
                timer: 1800,
                showConfirmButton: false,
                background: '#1a1a1a',
                color: '#f0f0f0',
            });
        });
        window.addEventListener('swal-error', function (e) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: e.detail && e.detail.message ? e.detail.message : 'Transaksi gagal!',
                timer: 2200,
                showConfirmButton: false,
                background: '#1a1a1a',
                color: '#f0f0f0',
            });
        });
        window.addEventListener('print-struk', function (e) {
            window.print();
        });
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = document.getElementById('paymentModal');
            if (myModal) {
                myModal.addEventListener('shown.bs.modal', function () {
                    const input = document.getElementById('uang_bayar_input');
                    if (input) {
                        input.focus();
                        input.select();
                    }
                });
            }
        });
    </script>
@endpush