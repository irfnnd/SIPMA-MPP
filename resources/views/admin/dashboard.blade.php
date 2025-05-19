@extends('admin.layout')

@section('content')
    <div class="container-fluid px-4 py-3">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">Dashboard Pengaduan</h2>
            <div class="date-time text-muted">
                <i class="fas fa-calendar-alt me-1"></i>
                <span id="currentDate">{{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Total Pengaduan Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-4 bg-primary py-4 text-center">
                                <i class="fas fa-clipboard-list fa-2x text-white"></i>
                            </div>
                            <div class="col-8 p-3">
                                <h6 class="text-muted mb-0">Total Pengaduan</h6>
                                <h2 class="fw-bold mb-0">{{ $pengaduanCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Selesai Card -->


            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-4 bg-warning py-4 text-center">
                                <i class="fas fa-clock fa-2x text-white"></i>
                            </div>
                            <div class="col-8 p-3">
                                <h6 class="text-muted mb-0">Menunggu</h6>
                                <h2 class="fw-bold mb-0">{{ $pendingPengaduan }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Diproses Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-4 bg-info py-4 text-center">
                                <i class="fas fa-spinner fa-2x text-white"></i>
                            </div>
                            <div class="col-8 p-3">
                                <h6 class="text-muted mb-0">Diproses</h6>
                                <h2 class="fw-bold mb-0">{{ $processedPengaduan }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Menunggu Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-4 bg-success py-4 text-center">
                                <i class="fas fa-check-circle fa-2x text-white"></i>
                            </div>
                            <div class="col-8 p-3">
                                <h6 class="text-muted mb-0">Selesai</h6>
                                <h2 class="fw-bold mb-0">{{ $completedPengaduan }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Data Row -->
        <div class="row g-4 mb-4">
            <!-- Chart - Statistik Pengaduan -->
            <div class="col-xl-8">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Statistik Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pengaduanChart" height="280"></canvas>
                    </div>
                </div>
            </div>

            <!-- User Stats -->
            <div class="col-xl-4">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Informasi Pengguna</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="userPieChart" height="280"></canvas>
                        <div class="row text-center mt-3">
                            <div class="col-3">
                                <h4 class="fw-bold mb-0">{{ $masyarakatCount }}</h4>
                                <small class="text-muted">Pengadu</small>
                            </div>
                            <div class="col-3">
                                <h4 class="fw-bold mb-0">{{ $petugasCount }}</h4>
                                <small class="text-muted">Petugas</small>
                            </div>
                            <div class="col-3">
                                <h4 class="fw-bold mb-0">{{ $adminCount }}</h4>
                                <small class="text-muted">Admin</small>
                            </div>
                            <div class="col-3">
                                <h4 class="fw-bold mb-0">{{ $userCount }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Complaints Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Pengaduan Terbaru</h5>
                        <a href="{{ route('data-pengaduan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th>Judul Pengaduan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduans as $pengaduan)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="fw-medium">{{ $pengaduan->judul }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y') }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill
                                        @if ($pengaduan->status == 'Menunggu') bg-warning text-dark
                                        @elseif($pengaduan->status == 'Diproses') bg-info text-white
                                        @elseif($pengaduan->status == 'Selesai') bg-success text-white @endif px-3 py-2">
                                                    <i
                                                        class="fas
                                        @if ($pengaduan->status == 'Menunggu') fa-clock
                                        @elseif($pengaduan->status == 'Diproses') fa-spinner fa-spin
                                        @elseif($pengaduan->status == 'Selesai') fa-check-circle @endif me-1"></i>
                                                    {{ ucfirst($pengaduan->status) }}
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
        </div>
    </div>
    <script>
        // Data Statistik Pengaduan
        const pengaduanCtx = document.getElementById('pengaduanChart').getContext('2d');
        const pengaduanChart = new Chart(pengaduanCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pengaduan Masuk',
                    data: {!! json_encode($chartData) !!},
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(54, 162, 235)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            precision: 0,
                            stepSize: 10
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Data Statistik Pengguna (Pie Chart)
        const userPieChart = document.getElementById('userPieChart').getContext('2d');
        new Chart(userPieChart, {
            type: 'pie',
            data: {
                labels: ['Pengadu', 'Petugas', 'Admin'],
                datasets: [{
                    label: 'Pengguna',
                    data: [{{ $masyarakatCount }}, {{ $petugasCount }}, {{ $adminCount }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
