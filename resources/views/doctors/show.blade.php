@extends('layouts.app')
@section('title', 'Profil Dokter – {{ $doctor->name }}')
@section('content')
@include('layouts.navbars.dashboardnav')
@php $initial = mb_strtoupper(mb_substr($doctor->name, 0, 1)); @endphp

{{-- Profile Hero Banner --}}
<div style="background:linear-gradient(135deg,#1a6b3c 0%,#28a745 100%);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('doctors.index') }}" class="text-white-50 text-decoration-none">Dokter</a>
                </li>
                <li class="breadcrumb-item text-white active" aria-current="page">Profil</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4 align-items-start">

        {{-- LEFT: Main profile card --}}
        <div class="col-lg-8">

            {{-- Header card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;overflow:hidden;">
                <div style="height:6px;background:linear-gradient(90deg,#28a745,#20c997);"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-4">
                        {{-- Avatar --}}
                        @if($doctor->photo)
                            <img src="{{ asset('storage/'.$doctor->photo) }}"
                                 class="rounded-circle flex-shrink-0 border border-3 border-success"
                                 style="width:90px;height:90px;object-fit:cover;"
                                 alt="{{ $doctor->name }}"
                                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                        @else
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:90px;height:90px;font-size:2.2rem;font-weight:700;">
                                {{ $initial }}
                            </div>
                        @endif

                        {{-- Identity --}}
                        <div class="min-w-0">
                            <h3 class="fw-bold mb-1">{{ $doctor->name }}</h3>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="badge bg-success">
                                    <i class="fas fa-stethoscope me-1"></i>{{ $doctor->specialization ?? 'Dokter Umum' }}
                                </span>
                                @if($doctor->experience)
                                    <span class="badge bg-light text-secondary border">
                                        <i class="fas fa-briefcase-medical me-1"></i>{{ $doctor->experience }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- About card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-id-card text-success me-2"></i>Tentang Dokter</h5>
                    <p class="text-muted mb-0">
                        {{ $doctor->bio ?? 'Dokter ahli siap membantu Anda dengan sesi konsultasi yang nyaman, cepat, dan terpercaya.' }}
                    </p>
                </div>
            </div>

            {{-- Services card --}}
            <div class="card border-0 shadow-sm" style="border-radius:14px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fas fa-clinic-medical text-success me-2"></i>Layanan yang Tersedia</h5>
                    <div class="row g-3">
                        @foreach([
                            ['fas fa-video','Konsultasi Online','Konsultasi langsung melalui platform digital kami.'],
                            ['fas fa-calendar-check','Reservasi Mudah','Jadwalkan kunjungan kapan saja dan di mana saja.'],
                            ['fas fa-shield-alt','Terpercaya & Aman','Dokter berlisensi dengan rekam jejak klinis yang baik.'],
                        ] as [$icon, $title, $desc])
                            <div class="col-sm-4">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width:40px;height:40px;">
                                        <i class="{{ $icon }} small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $title }}</div>
                                        <div class="text-muted" style="font-size:.8rem;">{{ $desc }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Info & CTA card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius:14px;overflow:hidden;position:sticky;top:80px;">
                <div style="background:linear-gradient(135deg,#1a6b3c,#28a745);" class="p-4 text-center text-white">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/'.$doctor->photo) }}"
                             class="rounded-circle border border-3 border-white mb-3"
                             style="width:80px;height:80px;object-fit:cover;"
                             alt="{{ $doctor->name }}"
                             onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                    @else
                        <div class="rounded-circle bg-white text-success d-inline-flex align-items-center justify-content-center mb-3"
                             style="width:80px;height:80px;font-size:2rem;font-weight:700;">
                            {{ $initial }}
                        </div>
                    @endif
                    <h6 class="fw-bold mb-0">{{ $doctor->name }}</h6>
                    <small style="opacity:.8;">{{ $doctor->specialization ?? 'Dokter Umum' }}</small>
                </div>

                <div class="card-body p-4">
                    {{-- Info rows --}}
                    <ul class="list-unstyled mb-4">
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="fas fa-stethoscope text-success mt-1 flex-shrink-0"></i>
                            <div>
                                <div class="text-muted" style="font-size:.78rem;">Spesialisasi</div>
                                <div class="fw-semibold small">{{ $doctor->specialization ?? 'Umum' }}</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="fas fa-briefcase-medical text-success mt-1 flex-shrink-0"></i>
                            <div>
                                <div class="text-muted" style="font-size:.78rem;">Pengalaman</div>
                                <div class="fw-semibold small">{{ $doctor->experience ?? 'Lebih dari 5 tahun' }}</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="fas fa-envelope text-success mt-1 flex-shrink-0"></i>
                            <div class="min-w-0">
                                <div class="text-muted" style="font-size:.78rem;">Email</div>
                                <div class="fw-semibold small text-truncate">{{ $doctor->email }}</div>
                            </div>
                        </li>
                    </ul>

                    {{-- CTA --}}
                    @auth
                        @if(auth()->user()->role === 'pasien')
                            <a href="{{ route('pasien.reservations.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-calendar-plus me-2"></i>Buat Reservasi
                            </a>
                        @else
                            <div class="alert alert-info small mb-0">
                                <i class="fas fa-info-circle me-1"></i>Login sebagai pasien untuk membuat reservasi.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Reservasi
                        </a>
                    @endauth

                    <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Dokter
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
