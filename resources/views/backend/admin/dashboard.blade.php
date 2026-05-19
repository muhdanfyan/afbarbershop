@extends('backend.template.content')

@section('title', 'Dashboard')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold text-dark">Hi {{ auth()->user()->name }}, selamat datang!</h4>
                    <p class="font-weight-normal mb-2 text-muted">{{ date('F j, Y') }}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-light-primary rounded-circle p-3">
                                    <i class="mdi mdi-account-multiple fa-2x"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Jumlah User</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $jumlahUser }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-light-success rounded-circle p-3">
                                    <i class="mdi mdi-account-star fa-2x"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Jumlah Kapster</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $jumlahKapster }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-light-info rounded-circle p-3">
                                    <i class="mdi mdi-calendar-today fa-2x"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Booking Hari Ini</p>
                                    <h3 class="mb-0 font-weight-bold">{{ $jumlahBookingHariIni }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-light-danger rounded-circle p-3">
                                    <i class="mdi mdi-cash-multiple fa-2x"></i>
                                </div>
                                <div class="text-right">
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Pendapatan Hari Ini</p>
                                    <h3 class="mb-0 font-weight-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
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
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light-primary rounded-circle p-3 mr-3">
                                    <i class="mdi mdi-cash-register fa-2x"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Total Omzet</p>
                                    <h4 class="mb-0 font-weight-bold">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light-info rounded-circle p-3 mr-3">
                                    <i class="mdi mdi-account-star fa-2x"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Fee Kapster (40%)</p>
                                    <h4 class="mb-0 font-weight-bold">Rp {{ number_format($totalFeeKapster, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stat-card border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light-warning rounded-circle p-3 mr-3">
                                    <i class="mdi mdi-briefcase-account fa-2x"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-1 text-uppercase font-weight-bold" style="font-size: 0.7rem;">Manajemen (60%)</p>
                                    <h4 class="mb-0 font-weight-bold">Rp {{ number_format($penghasilanManajemen, 0, ',', '.') }}</h4>
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