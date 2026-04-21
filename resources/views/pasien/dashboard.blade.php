@extends('layouts.app')
@section('title', 'Dashboard Pasien')
@section('content')
@include('layouts.navbars.dashboardnav')

<div class="container py-5">
    <div class="card border-0 shadow-sm bg-gradient-success text-white mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 py-4">
            <div>
                <h4 class="fw-bold mb-1">Halo, {{ auth()->user()->name }} 👋</h4>
                <p class="mb-0 opacity-75">Lihat reservasi Anda, temukan dokter terbaik, dan kelola kesehatan dengan mudah.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('pasien.reservations.index') }}" class="btn btn-outline-light btn-sm fw-semiboldd">
                    <i class="fas fa-calendar-check me-1"></i>Reservasi Saya
                </a>
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="fas fa-stethoscope me-1"></i>Cari Dokter
                </a>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-calendar-check fa-2x text-success mb-2"></i>
                <div class="fs-4 fw-bold">{{ $jumlahReservasi ?? 0 }}</div>
                <div class="text-muted small">Reservasi Saya</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <div class="fs-4 fw-bold">{{ $upcomingReservation ? 1 : 0 }}</div>
                <div class="text-muted small">Janji Mendatang</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100 text-center py-3">
                <i class="fas fa-user-md fa-2x text-info mb-2"></i>
                <div class="fs-4 fw-bold">{{ $latestDoctors->count() }}</div>
                <div class="text-muted small">Dokter Tersedia</div>
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
                            <small class="text-muted">Performa reservasi Anda sepanjang tahun</small>
                        </div>
                        <span class="badge bg-success">Ringkasan</span>
                    </div>
                    <canvas id="chartReservasiPasien"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-clock me-2 text-warning"></i>Janji Mendatang</h6>
                </div>
                <div class="card-body">
                    @if($upcomingReservation)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if($upcomingReservation->dokter?->photo)
                                <img src="{{ asset('storage/' . $upcomingReservation->dokter->photo) }}"
                                     class="rounded-circle flex-shrink-0 object-fit-cover"
                                     style="width:52px;height:52px;" alt=""
                                     onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                            @else
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:52px;height:52px;font-size:1.2rem;font-weight:700;color:#fff;">
                                    {{ strtoupper(substr($upcomingReservation->dokter->name ?? 'D', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $upcomingReservation->dokter->name ?? 'Dokter tidak tersedia' }}</div>
                                <div class="text-muted small">{{ $upcomingReservation->dokter->specialization ?? 'Spesialisasi tidak tersedia' }}</div>
                            </div>
                        </div>
                        <div class="mb-2 small">
                            <i class="fas fa-calendar-alt text-success me-2"></i>
                            <strong>{{ \Carbon\Carbon::parse($upcomingReservation->jadwal)->translatedFormat('d M Y, H:i') }} WIB</strong>
                        </div>
                        @if($upcomingReservation->keterangan)
                            <div class="text-muted small mb-3">{{ $upcomingReservation->keterangan }}</div>
                        @endif
                        <a href="{{ route('pasien.reservations.show', $upcomingReservation) }}" class="btn btn-success btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>Lihat Detail
                        </a>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-2x text-muted mb-2 d-block"></i>
                            <p class="text-muted small mb-3">Belum ada jadwal konsultasi mendatang.</p>
                            <a href="{{ route('pasien.reservations.index') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Buat Reservasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-user-md me-2 text-info"></i>Dokter Populer</h6>
                    <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-outline-info">Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse($latestDoctors as $doctor)
                        <a href="{{ route('doctors.show', $doctor) }}" class="text-decoration-none text-dark">
                        <div class="d-flex align-items-center gap-3 px-3 py-2 border-bottom" style="transition:background .15s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background=''">
                            @if($doctor->photo)
                                <img src="{{ asset('storage/' . $doctor->photo) }}"
                                     class="rounded-circle flex-shrink-0 object-fit-cover"
                                     style="width:38px;height:38px;" alt=""
                                     onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                            @else
                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:38px;height:38px;font-size:14px;font-weight:700;color:#fff;">
                                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $doctor->name }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $doctor->specialization ?? 'Dokter Umum' }}</div>
                            </div>
                            <i class="fas fa-chevron-right text-muted" style="font-size:.7rem;"></i>
                        </div>
                        </a>
                    @empty
                        <div class="text-center py-4 text-muted small">Tidak ada dokter saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-warning"></i>Event Terkini</h6>
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-warning">Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse($latestEvents as $event)
                        <div class="px-3 py-2 border-bottom">
                            <a href="{{ route('events.index') }}" class="fw-semibold small text-decoration-none text-dark">{{ $event->title }}</a>
                            <div class="text-muted" style="font-size:.75rem;">{{ \Illuminate\Support\Str::limit($event->description, 70, '...') }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">Belum ada event tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-carrot me-2 text-danger"></i>Diet Tips</h6>
                    <a href="{{ route('home') }}#tips" class="btn btn-sm btn-outline-danger">Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse($latestDietTips as $tip)
                        <div class="px-3 py-2 border-bottom">
                            <a href="{{ route('diet-tips.index') }}" class="fw-semibold small">{{ $tip->title }}</a>
                            <div class="text-muted" style="font-size:.75rem;">{{ \Illuminate\Support\Str::limit($tip->description, 70, '...') }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted small">Belum ada tips diet tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function () {
    const ctx = document.getElementById('chartReservasiPasien').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData),
                backgroundColor: 'rgba(25,135,84,0.4)',
                borderColor: 'rgba(25,135,84,1)',
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

