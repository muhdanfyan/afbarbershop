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
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah User</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahUser }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-account-multiple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Kapster
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKapster }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-account-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Booking Hari Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahBookingHariIni }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-calendar-today fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pendapatan Hari
                                        Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-cash-multiple fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Omzet</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-cash-register fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Penghasilan Kapster
                                        (40% Jasa)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($totalFeeKapster, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-account-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Penghasilan
                                        Manajemen (60% Omzet)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($penghasilanManajemen, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-briefcase-account fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">5 Booking Terbaru</div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookingTerbaru as $b)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $b->nama ?? '-' }}</td>
                                            <td>{{ $b->created_at->format('d-m-Y H:i') }}</td>
                                            <td>{{ $b->status ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Statistik
                                        Penjualan Harian
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <canvas id="statistikPenjualanHarian" height="150"></canvas>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="mdi mdi-chart-bar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            document.addEventListener('DOMContentLoaded', function () {

                const dataServer = @json($statistikPenjualanHarian ?? []);

                // Ambil 7 hari terakhir
                const labels = [];
                const values = [];

                for (let i = 6; i >= 0; i--) {
                    const d = new Date();
                    d.setDate(d.getDate() - i);

                    const key = d.toISOString().slice(0, 10);
                    const label = d.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short'
                    });

                    labels.push(label);
                    values.push(dataServer[key] ?? 0);
                }

                const ctx = document.getElementById('statistikPenjualanHarian');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Penjualan',
                            data: values,
                            backgroundColor: '#f6c23e',
                            borderRadius: 6,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ` ${ctx.raw} transaksi`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
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