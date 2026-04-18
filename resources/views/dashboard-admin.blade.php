@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row">
        @include('layouts.sidebars.dashboard')
        <div class="col-xl-9">
            <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0 bg-gradient-primary text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div>
                        <h3 class="mb-1">Halo, {{ auth()->user()->name }}</h3>
                        <p class="mb-0">Lihat ringkasan cepat sistem, kelola pengguna, reservasi, event, dan tips diet dari satu tempat.</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-white btn-sm me-2">Kelola Akun</a>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-light btn-sm">Kelola Reservasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-primary mb-3"></i>
                    <h6 class="text-muted">Total Pengguna</h6>
                    <p class="display-6 mb-0">{{ $totalUser }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-2x text-success mb-3"></i>
                    <h6 class="text-muted">Dokter Terdaftar</h6>
                    <p class="display-6 mb-0">{{ $totalDoctors }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x text-success mb-3"></i>
                    <h6 class="text-muted">Reservasi</h6>
                    <p class="display-6 mb-0">{{ $totalReservasi }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x text-warning mb-3"></i>
                    <h6 class="text-muted">Event</h6>
                    <p class="display-6 mb-0">{{ $totalEvents }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-carrot fa-2x text-danger mb-3"></i>
                    <h6 class="text-muted">Diet Tips</h6>
                    <p class="display-6 mb-0">{{ $totalDietTips }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="mb-1">Statistik Reservasi</h6>
                            <p class="text-muted mb-0">Grafik per bulan untuk melihat tren reservasi.</p>
                        </div>
                        <span class="badge bg-success">Realtime</span>
                    </div>
                    <canvas id="chartReservasiAdmin"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="mb-3">Tautan Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm text-start">Manajemen Pengguna</a>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-success btn-sm text-start">Manajemen Reservasi</a>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-warning btn-sm text-start">Manajemen Event</a>
                        <a href="{{ route('admin.diet-tips.index') }}" class="btn btn-outline-danger btn-sm text-start">Manajemen Diet Tips</a>
                        <a href="{{ route('admin.healthy-menus.index') }}" class="btn btn-outline-success btn-sm text-start">Manajemen Menu Sehat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Pengguna Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-capitalize">{{ $user->role }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Belum ada pengguna baru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Reservasi Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->pasien->name ?? '-' }}</td>
                                        <td>{{ $reservation->dokter->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->jadwal)->translatedFormat('d M Y H:i') }}</td>
                                        <td class="text-capitalize">{{ $reservation->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">Belum ada reservasi terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxAdmin = document.getElementById('chartReservasiAdmin').getContext('2d');
    new Chart(ctxAdmin, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        callback: value => Number.isInteger(value) ? value : null
                    }
                }
            }
        }
    });
</script>
@endsection
