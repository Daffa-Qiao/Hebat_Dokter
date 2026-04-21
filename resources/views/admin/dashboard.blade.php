@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
@include('layouts.navbars.dashboardnav')

<div class="container py-5">

    {{-- Welcome Banner --}}
    <div class="card border-0 shadow-sm bg-gradient-primary text-white mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 py-4">
            <div>
                <h4 class="fw-bold mb-1">Halo, {{ auth()->user()->name }} 👋</h4>
                <p class="mb-0 opacity-75">Kelola pengguna, reservasi, konten, dan pantau statistik sistem dari satu tempat.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-users me-1"></i>Kelola Akun
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-calendar-check me-1"></i>Reservasi
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Row 1: People & Reservations --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalUser }}</div>
                <div class="text-muted small">Pengguna</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-user-md fa-2x text-success mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalDoctors }}</div>
                <div class="text-muted small">Dokter</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalReservasi }}</div>
                <div class="text-muted small">Reservasi</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalEvents }}</div>
                <div class="text-muted small">Event</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-utensils fa-2x text-success mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalMenuSehat }}</div>
                <div class="text-muted small">Menu Sehat</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-newspaper fa-2x text-danger mb-2"></i>
                <div class="fs-4 fw-bold">{{ $totalArtikel }}</div>
                <div class="text-muted small">Artikel</div>
            </div>
        </div>
    </div>

    {{-- Chart + Quick Links --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="fw-bold mb-0">Statistik Reservasi</h6>
                            <small class="text-muted">Jumlah reservasi per bulan tahun ini</small>
                        </div>
                        <span class="badge bg-success">Realtime</span>
                    </div>
                    <canvas id="chartReservasiAdmin"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-bolt me-2 text-warning"></i>Tautan Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-sm text-start">
                            <i class="fas fa-users me-2"></i>Manajemen Pengguna
                        </a>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-info btn-sm text-start">
                            <i class="fas fa-calendar-check me-2"></i>Manajemen Reservasi
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-warning btn-sm text-start">
                            <i class="fas fa-calendar-alt me-2"></i>Manajemen Event
                        </a>
                        <a href="{{ route('admin.diet-tips.index') }}" class="btn btn-outline-danger btn-sm text-start">
                            <i class="fas fa-video me-2"></i>Manajemen Diet Tips
                        </a>
                        <a href="{{ route('admin.healthy-menus.index') }}" class="btn btn-outline-success btn-sm text-start">
                            <i class="fas fa-utensils me-2"></i>Manajemen Menu Sehat
                        </a>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                            <i class="fas fa-newspaper me-2"></i>Manajemen Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tables --}}
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Pengguna Terbaru</h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Nama</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-2">
                                                @if($user->photo)
                                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                                         class="rounded-circle flex-shrink-0 object-fit-cover"
                                                         style="width:32px;height:32px;" alt="{{ $user->name }}"
                                                         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                                                @else
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                                         style="width:32px;height:32px;font-size:13px;font-weight:700;color:#fff;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <span class="fw-semibold">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted small">{{ $user->email }}</td>
                                        <td>
                                            @php $rc = match($user->role) { 'admin'=>'bg-warning text-dark','dokter'=>'bg-danger','pasien'=>'bg-success', default=>'bg-secondary' }; @endphp
                                            <span class="badge {{ $rc }}">{{ ucfirst($user->role) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada pengguna baru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-check me-2 text-info"></i>Reservasi Terbaru</h6>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-info">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Pasien</th>
                                    <th class="d-none d-md-table-cell">Dokter</th>
                                    <th class="d-none d-sm-table-cell">Jadwal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReservations as $reservation)
                                    <tr>
                                        <td class="ps-3 fw-semibold">{{ $reservation->pasien->name ?? '-' }}</td>
                                        <td class="d-none d-md-table-cell text-muted small">{{ $reservation->dokter->name ?? '-' }}</td>
                                        <td class="d-none d-sm-table-cell text-nowrap small">
                                            {{ \Carbon\Carbon::parse($reservation->jadwal)->translatedFormat('d M Y H:i') }}
                                        </td>
                                        <td>
                                            @php
                                                [$sc, $sl] = match($reservation->status ?? '') {
                                                    'accepted' => ['success', 'Diterima'],
                                                    'rejected' => ['danger', 'Ditolak'],
                                                    default    => ['warning text-dark', 'Pending'],
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $sc }}">{{ $sl }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada reservasi terbaru.</td>
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

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const ctx = document.getElementById('chartReservasiAdmin').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(54,162,235,0.45)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, callback: v => Number.isInteger(v) ? v : null }
                }
            }
        }
    });
})();
</script>
@endpush

@endsection

