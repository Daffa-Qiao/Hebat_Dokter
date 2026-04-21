@extends('layouts.app')
@section('title', 'Dashboard Dokter')
@section('content')
@include('layouts.navbars.dashboardnav')

<div class="container py-5">

    {{-- Welcome Banner --}}
    <div class="card border-0 shadow-sm text-white mb-4" style="background:linear-gradient(135deg,#dc3545,#ff6200);">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 py-4">
            <div>
                <h4 class="fw-bold mb-1">Halo, {{ auth()->user()->name }} 👨‍⚕️</h4>
                <p class="mb-0 opacity-75">Kelola jadwal konsultasi, lihat reservasi pending, dan awasi performa layanan Anda.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dokter.reservations.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-calendar-alt me-1"></i>Reservasi
                </a>
                <a href="{{ route('dokter.healthy-menus.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-utensils me-1"></i>Menu Sehat
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-user-edit me-1"></i>Edit Profil
                </a>
                <a href="{{ route('dokter.articles.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="fas fa-newspaper me-1"></i>Artikel Saya
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                <div class="fs-4 fw-bold">{{ $menunggu ?? 0 }}</div>
                <div class="text-muted small">Menunggu</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <div class="fs-4 fw-bold">{{ $diterima ?? 0 }}</div>
                <div class="text-muted small">Diterima</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                <div class="fs-4 fw-bold">{{ $ditolak ?? 0 }}</div>
                <div class="text-muted small">Ditolak</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-clock fa-2x text-info mb-2"></i>
                <div class="fs-4 fw-bold">{{ $upcomingAppointments->count() }}</div>
                <div class="text-muted small">Janji Berikutnya</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="fw-bold mb-0">Statistik Reservasi</h6>
                            <small class="text-muted">Performa reservasi Anda dalam satu tahun terakhir</small>
                        </div>
                        <span class="badge bg-danger">Ringkasan</span>
                    </div>
                    <canvas id="chartReservasiDokter"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-check me-2 text-danger"></i>Janji Berikutnya</h6>
                    <a href="{{ route('dokter.reservations.index') }}" class="btn btn-sm btn-outline-danger">Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Pasien</th>
                                    <th class="d-none d-sm-table-cell">Jadwal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingAppointments as $reservation)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-2">
                                                @if($reservation->pasien?->photo)
                                                    <img src="{{ asset('storage/' . $reservation->pasien->photo) }}"
                                                         class="rounded-circle flex-shrink-0 object-fit-cover"
                                                         style="width:30px;height:30px;" alt=""
                                                         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                                                @else
                                                    <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center flex-shrink-0"
                                                         style="width:30px;height:30px;font-size:12px;font-weight:700;color:#fff;">
                                                        {{ strtoupper(substr($reservation->pasien->name ?? 'P', 0, 1)) }}
                                                    </div>
                                                @endif
                                                <span class="fw-semibold small">{{ $reservation->pasien->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="d-none d-sm-table-cell text-nowrap small text-muted">
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
                                        <td colspan="3" class="text-center py-4 text-muted">Tidak ada janji temu mendatang.</td>
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
    const ctx = document.getElementById('chartReservasiDokter').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(220,53,69,0.4)',
                borderColor: 'rgba(220,53,69,1)',
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

