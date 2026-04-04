@extends('backend.template.content')

@section('title', 'Dashboard')

@section('content')
    <style>
        .stat-card {
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08) !important;
        }
        .stat-icon-wrapper {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .table-premium th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        .table-premium td {
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 mb-4 mb-xl-0 border-bottom pb-3">
                    <h4 class="font-weight-bold text-dark" style="font-family: 'Montserrat', sans-serif;">Hi {{ auth()->user()->name }}, selamat datang!</h4>
                    <p class="font-weight-normal mb-0 text-muted" style="font-size: 0.85rem;">{{ date('l, d F Y') }}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="bg-light-primary stat-icon-wrapper rounded-circle">
                                    <i class="mdi mdi-account-multiple text-primary" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Jumlah User</p>
                                    <h3 class="mb-0 font-weight-bold text-dark">{{ $jumlahUser }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="bg-light-success stat-icon-wrapper rounded-circle">
                                    <i class="mdi mdi-account-star text-success" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Jumlah Kapster</p>
                                    <h3 class="mb-0 font-weight-bold text-dark">{{ $jumlahKapster }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="bg-light-info stat-icon-wrapper rounded-circle">
                                    <i class="mdi mdi-calendar-today text-info" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Booking Hari Ini</p>
                                    <h3 class="mb-0 font-weight-bold text-dark">{{ $jumlahBookingHariIni }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="bg-light-danger stat-icon-wrapper rounded-circle">
                                    <i class="mdi mdi-cash-multiple text-danger" style="font-size: 1.8rem;"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Pendapatan Hari Ini</p>
                                    <h3 class="mb-0 font-weight-bold text-dark">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-light-primary stat-icon-wrapper rounded-circle mr-3">
                                    <i class="mdi mdi-cash-register text-primary" style="font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Total Omzet</p>
                                    <h4 class="mb-0 font-weight-bold text-dark">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-light-info stat-icon-wrapper rounded-circle mr-3">
                                    <i class="mdi mdi-account-star text-info" style="font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Fee Kapster (40%)</p>
                                    <h4 class="mb-0 font-weight-bold text-dark">Rp {{ number_format($totalFeeKapster, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-light-warning stat-icon-wrapper rounded-circle mr-3">
                                    <i class="mdi mdi-briefcase-account text-warning" style="font-size: 1.8rem;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">Manajemen (60%)</p>
                                    <h4 class="mb-0 font-weight-bold text-dark">Rp {{ number_format($penghasilanManajemen, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="card stat-card border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">5 Booking Terbaru</h5>
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
                    <div class="card stat-card border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Statistik Penjualan (7 Hari)</h5>
                            <div style="position: relative; height: 250px; width: 100%; overflow: hidden;">
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
                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                ticks: { 
                                    callback: value => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value)
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 } }
                            }
                        }
                    }
                });
            });
            </script>
        </div>
        <!-- content-wrapper ends -->
        @include('backend.template.footer')
    </div>
    <!-- main-panel ends -->
@endsection