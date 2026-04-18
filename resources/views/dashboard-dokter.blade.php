@extends('layouts.app')
@section('title', 'Dashboard Dokter')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row">
        @include('layouts.sidebars.dashboard')
        <div class="col-xl-9">
            <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0 bg-gradient-danger text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div>
                        <h3 class="mb-1">Halo, Dr. {{ auth()->user()->name }}</h3>
                        <p class="mb-0">Kelola jadwal konsultasi, lihat reservasi pending, dan awasi performa layanan Anda.</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('dokter.reservations.index') }}" class="btn btn-white btn-sm me-2">Lihat Reservasi</a>
                        <a href="{{ route('dokter.healthy-menus.index') }}" class="btn btn-white btn-sm me-2">Menu Sehat</a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half fa-2x text-danger mb-3"></i>
                    <h6 class="text-muted">Menunggu</h6>
                    <p class="display-6 mb-0">{{ $menunggu ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                    <h6 class="text-muted">Diterima</h6>
                    <p class="display-6 mb-0">{{ $diterima ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x text-secondary mb-3"></i>
                    <h6 class="text-muted">Ditolak</h6>
                    <p class="display-6 mb-0">{{ $ditolak ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-3"></i>
                    <h6 class="text-muted">Janji Berikutnya</h6>
                    <p class="display-6 mb-0">{{ $upcomingAppointments->count() }}</p>
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
                            <p class="text-muted mb-0">Performa reservasi Anda dalam satu tahun terakhir.</p>
                        </div>
                        <span class="badge bg-success">Ringkasan</span>
                    </div>
                    <canvas id="chartReservasiDokter"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Janji Bertemu Berikutnya</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pasien</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingAppointments as $reservation)
                                    <tr>
                                        <td>{{ $reservation->pasien->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->jadwal)->translatedFormat('d M Y H:i') }}</td>
                                        <td class="text-capitalize">{{ $reservation->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">Tidak ada janji temu mendatang.</td>
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
    const ctxDokter = document.getElementById('chartReservasiDokter').getContext('2d');
    new Chart(ctxDokter, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
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