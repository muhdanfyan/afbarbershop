@extends('backend.template.content')

@section('title', 'Dashboard')

@section('content')
    <style>
        .stat-card {
            border-radius: 20px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,0.02) !important;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1) !important;
        }
        .stat-icon-wrapper {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px !important;
        }
        .table-premium th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 1.25rem 1rem !important;
        }
        .table-premium td {
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            padding: 0.6rem !important;
        }
        .table td { 
            padding: 0.6rem 0.75rem !important;
            font-size: 0.8rem;
        }
        .table th {
            padding: 0.75rem !important;
            font-size: 0.7rem !important;
        }
        .card-title {
            font-size: 0.9rem !important;
            margin-bottom: 0.5rem !important;
        }
        .badge { font-size: 0.65rem !important; }
        .rounded-xl { border-radius: 16px !important; }
        
        @media (max-width: 768px) {
            .stat-card .card-body { padding: 0.75rem !important; }
            .stat-icon-wrapper { width: 36px !important; height: 36px !important; }
            .stat-icon-wrapper i { font-size: 1rem !important; }
            .counter { font-size: 1.1rem !important; }
            h4 { font-size: 1rem !important; }
            .content-wrapper { padding: 0.75rem !important; }
        }
    </style>
    <!-- partial -->
    <div class="row align-items-center mb-2 pt-0">
        <div class="col-md-6 col-7">
            <h4 class="font-weight-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.5px; font-size: 1.1rem;">
                Dashboard Overview
            </h4>
            <p class="text-muted mb-0" style="font-size: 0.75rem;">
                Halo <span class="font-weight-bold text-primary">{{ explode(' ', auth()->user()->name)[0] }}</span>
            </p>
        </div>
        <div class="col-md-6 col-5 text-right">
            <div class="d-inline-flex align-items-center bg-white shadow-sm px-2 py-1 rounded-xl border border-gray-100">
                <i class="mdi mdi-calendar-range text-primary mr-1" style="font-size: 0.8rem;"></i>
                <span class="font-weight-bold text-dark" style="font-size: 0.75rem;">{{ date('d M') }}</span>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-3 col-md-6 col-12 mb-2">
            <div class="card stat-card border-0 h-100 overflow-hidden" style="background: linear-gradient(to bottom right, #ffffff, #f8fafc);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="bg-light-primary stat-icon-wrapper rounded-xl shadow-sm" style="width: 42px; height: 42px;">
                            <i class="mdi mdi-account-multiple text-primary" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">Pelanggan</p>
                            <h4 class="mb-0 font-weight-bold text-dark counter" style="font-size: 1.2rem;">{{ number_format($jumlahUser) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12 mb-2">
            <div class="card stat-card border-0 h-100 overflow-hidden" style="background: linear-gradient(to bottom right, #ffffff, #f8fafc);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="bg-light-success stat-icon-wrapper rounded-xl shadow-sm" style="width: 42px; height: 42px;">
                            <i class="mdi mdi-account-star text-success" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">Kapster</p>
                            <h4 class="mb-0 font-weight-bold text-dark counter" style="font-size: 1.2rem;">{{ number_format($jumlahKapster) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12 mb-2">
            <div class="card stat-card border-0 h-100 overflow-hidden" style="background: linear-gradient(to bottom right, #ffffff, #f8fafc);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="bg-light-info stat-icon-wrapper rounded-xl shadow-sm" style="width: 42px; height: 42px;">
                            <i class="mdi mdi-calendar-today text-info" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">Booking</p>
                            <h4 class="mb-0 font-weight-bold text-dark counter" style="font-size: 1.2rem;">{{ number_format($jumlahBookingHariIni) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12 mb-2">
            <div class="card stat-card border-0 h-100 overflow-hidden" style="background: linear-gradient(to bottom right, #ffffff, #f8fafc);">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="bg-light-danger stat-icon-wrapper rounded-xl shadow-sm" style="width: 42px; height: 42px;">
                            <i class="mdi mdi-cash-multiple text-danger" style="font-size: 1.2rem;"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-muted mb-0 text-uppercase font-weight-bold" style="font-size: 0.6rem; letter-spacing: 0.5px;">Omzet Hari Ini</p>
                            <h4 class="mb-0 font-weight-bold text-dark" style="font-size: 1.1rem;">Rp {{ number_format($pendapatanHariIni/1000) }}K</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <div class="row mb-2">
                <div class="col-xl-4 col-md-12 col-12 mb-2">
                    <div class="card border-0 shadow-sm card-stat-fixed-blue" style="background: #4361ee !important; border-radius: 20px !important;">
                        <div class="card-body p-3 text-white">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="mb-0 font-weight-bold opacity-75 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px; color: rgba(255,255,255,0.8) !important;">Total Omzet</p>
                                <i class="mdi mdi-wallet text-white-50" style="font-size: 1.2rem;"></i>
                            </div>
                            <h3 class="font-weight-bold mb-0 text-white" style="color: #ffffff !important; font-size: 1.3rem;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-12 mb-2">
                     <div class="card border-0 shadow-sm card-stat-fixed-dark" style="background: #111827 !important; border-radius: 20px !important;">
                        <div class="card-body p-3 text-white">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="mb-0 font-weight-bold opacity-75 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px; color: rgba(255,255,255,0.8) !important;">Fee Kapster (40%)</p>
                                <i class="mdi mdi-account-star text-white-50" style="font-size: 1.2rem;"></i>
                            </div>
                            <h3 class="font-weight-bold mb-0 text-white" style="color: #ffffff !important; font-size: 1.3rem;">Rp {{ number_format($totalFeeKapster, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-12 mb-2">
                    <div class="card border-0 shadow-sm card-stat-fixed-gold" style="background: #d4af37 !important; border-radius: 20px !important;">
                        <div class="card-body p-3 text-dark">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <p class="mb-0 font-weight-bold opacity-75 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px; color: rgba(0,0,0,0.6) !important;">Manajemen (60%)</p>
                                <i class="mdi mdi-briefcase-account text-dark-50" style="font-size: 1.2rem;"></i>
                            </div>
                            <h3 class="font-weight-bold mb-0 text-dark" style="color: #111827 !important; font-size: 1.3rem;">Rp {{ number_format($penghasilanManajemen, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="card stat-card border-0 mb-2">
                        <div class="card-body py-3 px-3">
                            <h5 class="card-title mb-2" style="font-size: 0.95rem;">5 Booking Terbaru</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">#</th>
                                            <th class="border-0">Nama</th>
                                            <th class="border-0">Tanggal</th>
                                            <th class="border-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookingTerbaru as $b)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $b->nama ?? '-' }}</td>
                                                <td class="text-muted">{{ $b->created_at->format('d-m-Y H:i') }}</td>
                                                <td>
                                                    <span class="badge badge-pill {{ $b->status == 'selesai' ? 'badge-success' : 'badge-info' }} px-3">
                                                        {{ ucfirst($b->status ?? '-') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card stat-card border-0 mb-2">
                        <div class="card-body py-3 px-3">
                            <h5 class="card-title mb-2" style="font-size: 0.95rem;">Statistik Penjualan (7 Hari)</h5>
                            <div style="position: relative; height: 180px; width: 100%; overflow: hidden;">
                                <canvas id="statistikPenjualanHarian"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dataServer = @json($statistikPenjualanHarian ?? []);
                const labels = [];
                const values = [];

                for (let i = 6; i >= 0; i--) {
                    const d = new Date();
                    d.setDate(d.getDate() - i);

                    // Fix format tanggal lokal (YYYY-MM-DD) agar sesuai dengan PHP DATE()
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const key = `${year}-${month}-${day}`;

                    const label = d.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short'
                    });

                    labels.push(label);
                    values.push(dataServer[key] ?? 0);
                }

                const ctx = document.getElementById('statistikPenjualanHarian').getContext('2d');
                const isDarkMode = document.body.classList.contains('admin-dark');
                const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
                const tickColor = isDarkMode ? '#94a3b8' : '#64748b';

                // Create Gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(67, 97, 238, 0.25)');
                gradient.addColorStop(1, 'rgba(67, 97, 238, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: values,
                            borderColor: '#4361ee',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#4361ee',
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#111827',
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                callbacks: {
                                    label: ctx => ` Rp ${new Intl.NumberFormat('id-ID').format(ctx.raw)}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor, drawBorder: false },
                                ticks: { 
                                    color: tickColor,
                                    callback: value => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value)
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: tickColor, font: { size: 11 } }
                            }
                        }
                    }
                });
            });
    </script>
@endsection