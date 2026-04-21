@extends('layouts.app')
@section('title', 'Home')
@section('content')

<!-- Navigation Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Hebat Dokter" height="40">
            <span class="ms-2 fw-bold" style="color: green;">Hebat Dokter</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHome" aria-controls="navbarHome" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarHome">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#dokter">Dokter</a></li>
                <li class="nav-item"><a class="nav-link" href="#event">Event</a></li>
                <li class="nav-item"><a class="nav-link" href="#tips">Diet Tips</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('articles.index') }}">Artikel</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bmi.index') }}">BMI</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('health-challenge.index') }}">Tantangan</a></li>
            </ul>
            <div class="navbar-nav ms-auto">
                @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('dashboard.' . auth()->user()->role) }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Ubah Profil
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div class="hero-section bg-white" style="padding-top:70px;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="badge bg-success mb-3">Layanan Kesehatan Digital</span>
                <h1 class="display-4 fw-bold">Konsultasi Dokter & Kesehatan Holistik dalam Satu Platform</h1>
                <p class="lead text-muted">Hebat Dokter membantu Anda mengakses dokter, membuat reservasi, mengikuti event kesehatan, dan mendapatkan tips diet terpercaya.</p>
                <div class="mt-4">
                    @auth
                    <a href="{{ route('dashboard.' . auth()->user()->role) }}" class="btn btn-success btn-lg me-3">Dashboard Saya</a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg me-3">Mulai Konsultasi</a>
                    <a href="{{ route('doctors.index') }}" class="btn btn-outline-success btn-lg me-3">Cari Dokter</a>
                    <a href="{{ route('health-challenge.index') }}" class="btn btn-outline-success btn-lg">Ikuti Tantangan</a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('img/logo.png') }}" alt="Kesehatan" class="img-fluid" style="max-height: 480px;">
            </div>
        </div>
    </div>
</div>

<div class="container py-5" id="layanan">
    <div class="col-12">
        <h5 class="fw-bold text-success mb-3"><i class="fas fa-concierge-bell me-2"></i>Layanan Kami</h5>
    </div>
    <!-- Public Feature Cards -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <div class="icon mb-3 bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <h5>Konsultasi Online</h5>
                <p class="text-muted">Konsultasi dokter umum dan spesialis tanpa harus keluar rumah.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <div class="icon mb-3 bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h5>Reservasi Mudah</h5>
                <p class="text-muted">Pilih penyakit/keluhan, dokter spesialis ditugaskan otomatis.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100">
                <div class="icon mb-3 bg-success text-white rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h5>Event & Edukasi</h5>
                <p class="text-muted">Ikuti event kesehatan dan video diet untuk hidup lebih sehat.</p>
            </div>
        </div>
    </div>


    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100 bg-success text-white">
                <div class="icon mb-3 bg-white text-success rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-weight"></i>
                </div>
                <h5>Kalkulator BMI</h5>
                <p class="text-white-75">Ukur Indeks Massa Tubuh Anda, ketahui berat ideal dan kebutuhan kalori harian.</p>
                <a href="{{ route('bmi.index') }}" class="btn btn-light btn-sm mt-3">Hitung BMI</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100 bg-primary text-white">
                <div class="icon mb-3 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h5>Artikel Kesehatan</h5>
                <p class="text-white-75">Baca artikel kesehatan dari dokter-dokter kami sesuai spesialisasi.</p>
                <a href="{{ route('articles.index') }}" class="btn btn-light btn-sm mt-3">Baca Artikel</a>
            </div>
        </div>
    </div>

    <!-- Auth-only: Kalori, Menu Sehat, Tantangan -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <h5 class="fw-bold text-success mb-3"><i class="fas fa-lock-open me-2"></i>Fitur Khusus Member</h5>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100 bg-success text-white">
                <div class="icon mb-3 bg-white text-success rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-calculator"></i>
                </div>
                <h5>Hitung Kalori</h5>
                <p class="text-white-75">Gunakan kalkulator kalori untuk menyeimbangkan aktivitas dan nutrisi harian Anda.</p>
                <a href="{{ route('calories.index') }}" class="btn btn-light btn-sm mt-3">Buka Kalkulator</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100 bg-info text-white">
                <div class="icon mb-3 bg-white text-info rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-carrot"></i>
                </div>
                <h5>Menu Sehat</h5>
                @if(isset($lastReservationDisease) && $lastReservationDisease)
                <p class="text-white-75">Rekomendasi menu untuk kondisi <strong>{{ $lastReservationDisease }}</strong> berdasarkan reservasi terakhir Anda.</p>
                <a href="{{ route('healthy-menus.index', ['specialization' => $lastReservationDisease]) }}" class="btn btn-light btn-sm mt-3">Lihat Menu Saya</a>
                @else
                <p class="text-white-75">Temukan menu sehat yang direkomendasikan oleh dokter dan dikelola oleh admin.</p>
                <a href="{{ route('healthy-menus.index') }}" class="btn btn-light btn-sm mt-3">Lihat Menu Sehat</a>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card p-4 rounded-4 shadow-sm h-100" style="background:#7c3aed; color:white;">
                <div class="icon mb-3 bg-white rounded-circle d-flex align-items-center justify-content-center" style="color:#7c3aed;">
                    <i class="fas fa-bolt"></i>
                </div>
                <h5>Tantangan Sehat</h5>
                <p style="opacity:0.85;">Tantangan harian personal — selesaikan dan kumpulkan poin untuk hidup lebih sehat!</p>
                <a href="{{ route('health-challenge.index') }}" class="btn btn-light btn-sm mt-3">Mulai Tantangan</a>
            </div>
        </div>
    </div>
    <!-- Guest: teaser for locked features -->
</div>

<div id="dokter" class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Dokter Terpercaya</h2>
            <p class="text-muted">Cari dokter sesuai kebutuhan Anda, dari dokter umum hingga spesialis diet dan kesehatan.</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="btn btn-outline-success">Lihat Semua Dokter</a>
    </div>
    <div class="row g-4">
        @forelse($doctors as $doctor)
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="doctor-avatar rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $doctor->name }}</h5>
                            <small class="text-muted">{{ $doctor->specialization ?? 'Dokter Umum' }}</small>
                        </div>
                    </div>
                    <p class="text-muted flex-grow-1">{{ $doctor->bio ? Illuminate\Support\Str::limit($doctor->bio, 100, '...') : 'Dokter profesional siap membantu Anda melalui konsultasi online yang nyaman.' }}</p>
                    <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-success mt-3">Lihat Profil</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">Belum ada dokter tersedia. Silakan cek kembali nanti.</div>
        </div>
        @endforelse
    </div>
</div>
<div id="artikel" class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Artikel Kesehatan</h2>
            <p class="text-muted mb-0">Baca artikel kesehatan dari dokter-dokter kami sesuai spesialisasi.</p>
        </div>
        <a href="{{ route('articles.index') }}" class="btn btn-outline-success">Lihat Semua Artikel</a>
    </div>
    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('img/logo.png') }}"
                     class="card-img-top" alt="{{ $article->title }}"
                     onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title   mb-2">{{ $article->title }}</h5>
                    <div class="mb-2">
                        <span class="badge bg-success">{{ $article->specialization ?? 'Umum' }}</span>
                    </div>
                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($article->content), 90, '...') }}</p>
                    <div class="d-flex align-items-center mb-2">
                        <small class="text-muted me-2"><i class="fas fa-user-md me-1"></i>{{ $article->author->name ?? 'Admin' }}</small>
                        <small class="text-muted ms-auto"><i class="far fa-calendar-alt me-1"></i>{{ $article->created_at->format('d M Y') }}</small>
                    </div>
                    <a href="{{ route('articles.show', $article) }}" class="btn btn-success btn-sm mt-2">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Belum ada artikel tersedia.</div>
        </div>
        @endforelse
    </div>
</div>
<div id="tips" class="container-fluid bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Video Tips Diet</h2>
                <p class="text-muted">Pelajari prinsip diet sehat dan gaya hidup yang mendukung kesehatan tubuh.</p>
            </div>
            <a href="{{ route('diet-tips.index') }}" class="btn btn-outline-success">Lihat Seluruh Tips Diet</a>
        </div>
        <div class="row g-4">
            @forelse($dietTips as $tip)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ $tip->video_url }}" title="{{ $tip->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $tip->title }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($tip->description, 100, '...') }}</p>
                        @if($tip->source_url)
                        <a href="{{ $tip->source_url }}" target="_blank" rel="noopener" class="btn btn-success">Lihat Selengkapnya</a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h5 class="mb-0">Belum ada tips diet terbaru.</h5>
                    <p class="text-muted">Silakan kunjungi dashboard admin untuk menambahkan tips diet.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div id="event" class="container-fluid py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Event Kesehatan Terbaru</h2>
                <p class="text-muted">Ikuti event kesehatan yang membantu Anda hidup lebih produktif dan sehat.</p>
            </div>
            <a href="{{ route('events.index') }}" class="btn btn-outline-success">Lihat Seluruh Event</a>
        </div>
        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <img src="{{ $event->image ? asset('storage/' . $event->image) : asset('img/logo.png') }}"
                         class="card-img-top" alt="{{ $event->title }}"
                         style="width:100%;aspect-ratio:1/1;object-fit:cover;"
                         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-success">{{ $event->date->locale('id')->translatedFormat('l, d F Y') }}</span>
                            <span class="badge bg-secondary">{{ $event->time ? date('H:i', strtotime($event->time)) . ' WIB' : '-' }}</span>
                        </div>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt me-2 text-success"></i>{{ $event->location ?? 'Lokasi belum ditentukan' }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 110, '...') }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h5 class="mb-0">Belum ada event kesehatan saat ini.</h5>
                    <p class="text-muted">Silakan tunggu informasi terbaru dari admin.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
@push('css')
<style>
    .hero-section {}

    .feature-card,
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover,
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 40px rgba(0, 0, 0, 0.12);
    }

    .icon,
    .doctor-avatar {
        width: 60px;
        height: 60px;
        font-size: 1.25rem;
    }

    .doctor-avatar {
        background: #198754;
        color: white;
    }

    .card-img-top {
        object-fit: cover;
        height: 240px;
    }

    .navbar {
        width: 100%;
        z-index: 1030;
    }

    .navbar-brand {
        font-weight: bold;
    }

    .nav-link {
        color: #333 !important;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .nav-link:hover {
        color: green !important;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.55rem 0.85rem;
    }

    .dropdown-item {
        transition: background-color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item[style*="color: green"]:hover {
        color: green !important;
    }

    .dropdown-item[style*="color: #dc3545"]:hover {
        color: #dc3545 !important;
    }

    .dropdown-item[style*="color: #ffc107"]:hover {
        color: #ffc107 !important;
    }

    .dropdown-header {
        font-weight: bold;
        color: #6c757d;
        font-size: 0.875rem;
    }
</style>
@endpush

</html>