@extends('layouts.app')
@section('title', 'Detail Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-calendar-check me-2"></i>Detail Reservasi</h3>
                <p class="mb-0 opacity-75">Informasi lengkap reservasi #{{ $reservation->id }}</p>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #ffc107;">
                <div class="card-body">
                    <h6 class="fw-bold text-warning mb-3"><i class="fas fa-user me-2"></i>Data Pasien</h6>
                    <div class="d-flex align-items-center mb-3">
                        @if($reservation->pasien->photo)
                            <img src="{{ asset('storage/' . $reservation->pasien->photo) }}" class="rounded-circle me-3" style="width:56px;height:56px;object-fit:cover;" alt=""
                                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                        @else
                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3 text-white fw-bold" style="width:56px;height:56px;font-size:1.2rem;">{{ strtoupper(substr($reservation->pasien->name,0,1)) }}</div>
                        @endif
                        <div>
                            <div class="fw-semibold">{{ $reservation->pasien->name }}</div>
                            <small class="text-muted">{{ $reservation->pasien->email }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-top:4px solid #17a2b8;">
                <div class="card-body">
                    <h6 class="fw-bold text-info mb-3"><i class="fas fa-user-md me-2"></i>Data Dokter</h6>
                    <div class="d-flex align-items-center mb-3">
                        @if($reservation->dokter->photo)
                            <img src="{{ asset('storage/' . $reservation->dokter->photo) }}" class="rounded-circle me-3" style="width:56px;height:56px;object-fit:cover;" alt=""
                                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                        @else
                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center me-3 text-white fw-bold" style="width:56px;height:56px;font-size:1.2rem;">{{ strtoupper(substr($reservation->dokter->name,0,1)) }}</div>
                        @endif
                        <div>
                            <div class="fw-semibold">{{ $reservation->dokter->name }}</div>
                            <small class="text-muted">{{ $reservation->dokter->specialization ?? 'Dokter Umum' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #6c757d;">
                <div class="card-body">
                    <h6 class="fw-bold text-secondary mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Reservasi</h6>
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-3">
                            <div class="bg-light rounded p-3 text-center">
                                <div class="text-muted small mb-1">Jadwal</div>
                                <div class="fw-bold">{{ $reservation->jadwal->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $reservation->jadwal->format('H:i') }} WIB</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="bg-light rounded p-3 text-center">
                                <div class="text-muted small mb-1">Status</div>
                                @php
                                    $badge = match($reservation->status) {
                                        'accepted' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning text-dark'
                                    };
                                    $label = match($reservation->status) {
                                        'accepted' => 'Diterima',
                                        'rejected' => 'Ditolak',
                                        default => 'Menunggu'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }} fs-6 px-3">{{ $label }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="bg-light rounded p-3 text-center">
                                <div class="text-muted small mb-1">Dibuat</div>
                                <div class="fw-bold">{{ $reservation->created_at->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $reservation->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="bg-light rounded p-3 text-center">
                                <div class="text-muted small mb-1">Keterangan</div>
                                <div class="small">{{ $reservation->keterangan ?: '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i>Edit Reservasi
        </a>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list me-1"></i>Semua Reservasi
        </a>
    </div>
</div>
@endsection
 