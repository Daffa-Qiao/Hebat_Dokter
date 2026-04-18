@extends('layouts.app')
@section('title', 'Dashboard Pasien')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row">
        @include('layouts.sidebars.dashboard')
        <div class="col-xl-9">
            <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0 bg-gradient-success text-white">
                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div>
                        <h3 class="mb-1">Halo, {{ auth()->user()->name }}</h3>
                        <p class="mb-0">Lihat reservasi Anda, temukan dokter terbaik, dan kelola kesehatan dengan mudah.</p>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('pasien.reservations.create') }}" class="btn btn-green btn-sm me-2" style="background:white; color:green;">Buat Reservasi</a>
                        <a href="{{ route('doctors.index') }}" class="btn btn-green btn-sm" style="background:white; color:green;">Cari Dokter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x text-success mb-3"></i>
                    <h6 class="text-muted">Reservasi Anda</h6>
                    <p class="display-6 mb-0">{{ $jumlahReservasi ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-success mb-3"></i>
                    <h6 class="text-muted">Janji Mendatang</h6>
                    <p class="display-6 mb-0">{{ $upcomingReservation ? 1 : 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-2x text-success  mb-3"></i>
                    <h6 class="text-muted">Dokter Populer</h6>
                    <p class="display-6 mb-0">{{ $latestDoctors->count() }}</p>
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
                            <p class="text-muted mb-0">Performa reservasi Anda sepanjang tahun.</p>
                        </div>
                        <span class="badge bg-success">Ringkasan</span>
                    </div>
                    <canvas id="chartReservasiPasien"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Janji Mendatang</h6>
                </div>
                <div class="card-body">
                    @if($upcomingReservation)
                        <div class="mb-3">
                            <h5 class="mb-1">{{ $upcomingReservation->dokter->name ?? 'Dokter tidak tersedia' }}</h5>
                            <p class="text-muted mb-1">{{ $upcomingReservation->dokter->specialization ?? 'Spesialisasi tidak tersedia' }}</p>
                            <p class="mb-1"><strong>{{ \Carbon\Carbon::parse($upcomingReservation->jadwal)->translatedFormat('d M Y H:i') }}</strong></p>
                            <p class="text-muted">{{ $upcomingReservation->keterangan }}</p>
                        </div>
                        <a href="{{ route('pasien.reservations.show', $upcomingReservation) }}" class="btn btn-success btn-sm">Lihat Detail Reservasi</a>
                    @else
                        <div class="alert alert-info mb-0">Belum ada jadwal konsultasi mendatang. Silakan buat reservasi baru.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Dokter Populer</h6>
                </div>
                <div class="card-body">
                    @forelse($latestDoctors as $doctor)
                        <div class="mb-3">
                            <h6 class="mb-1">{{ $doctor->name }}</h6>
                            <p class="text-muted mb-0">{{ $doctor->specialization ?? 'Dokter Umum' }}</p>
                        </div>
                    @empty
                        <p class="text-muted">Tidak ada dokter terbaru saat ini.</p>
                    @endforelse
                    <a href="{{ route('doctors.index') }}" class="btn btn-outline-success btn-sm">Lihat Semua Dokter</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Event Terkini</h6>
                </div>
                <div class="card-body">
                    @forelse($latestEvents as $event)
                        <div class="mb-3">
                            <h6 class="mb-1">{{ $event->title }}</h6>
                            <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit($event->description, 70, '...') }}</p>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada event tersedia.</p>
                    @endforelse
                    <a href="{{ route('events.index') }}#event" class="btn btn-outline-success btn-sm">Lihat Event</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Diet Tips</h6>
                </div>
                <div class="card-body">
                    @forelse($latestDietTips as $tip)
                        <div class="mb-3">
                            <h6 class="mb-1">{{ $tip->title }}</h6>
                            <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit($tip->description, 70, '...') }}</p>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada tips diet tersedia.</p>
                    @endforelse
                    <a href="{{ route('home') }}#tips" class="btn btn-outline-success btn-sm">Lihat Tips</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxPasien = document.getElementById('chartReservasiPasien').getContext('2d');
    new Chart(ctxPasien, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(40, 167, 69, 0.5)',
                borderColor: 'rgba(40, 167, 69, 1)',
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

