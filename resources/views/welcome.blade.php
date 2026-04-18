@extends('layouts.app')
@section('title', 'Home')
@section('content')

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <!-- Hero Section -->
            <div class="container-fluid bg-primary1 py-5" style="background-color: white;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="text-black fw-bold">Selamat Datang</h1>
                            <h1 class="text-black fw-bold">di Hebat Dokter</h1>
                            <p class="text-black-50 mb-4">Temukan informasi kesehatan terpercaya dan konsultasi dengan dokter ahli untuk hidup lebih sehat.</p>
                            <a href="/login" class="btn btn-light btn-lg" style="background-color:green; color: white;">Mulai Konsultasi</a>
                        </div>
                        <div class="col-lg-6" style="width: 30%;margin-left: 100px;">
                            <img src="{{ asset('img/logo.png') }}" alt="Health Illustration" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layanan Section -->
            <div id="layanan" class="container py-5">
                <h2 class="text-center mb-5">Layanan Kami</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-user-md fa-3x mb-3" style="color: green;"></i>
                                <h4>Konsultasi Online</h4>
                                <p>Konsultasi dengan dokter ahli secara online kapan saja dan dimana saja.</p>
                                <a href="/admin/login" class="btn" style="background-color:green; color: white;">Konsultasi</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-calculator fa-3x mb-3" style="color: green;"></i>
                                <h4>Kalkulator Kalori Aktivitas Fisik</h4>
                                <p>Hitung kalori makanan Anda dengan mudah dan akurat.</p>
                                <a href="/hitung-kalori" class="btn" style="background-color:green; color: white;">Hitung Kalori Aktivitas Fisik</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-carrot fa-3x mb-3" style="color: green;"></i>
                                <h4>Menu Sehat</h4>
                                <p>Informasi lengkap tentang Menu Sehat yang bisa dibeli</p>
                                <a href="/menu-sehat" class="btn" style="background-color:green; color: white;">Menu Sehat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artikel Kesehatan -->
            <div class="container-fluid bg-light py-5">
                <div class="container">
                    <h2 class="text-center mb-5">Video Tips Kesehatan Diet</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <iframe width="420" height="315" src="https://www.youtube.com/embed/SsUmvFydj68" title="Intermittent Fasting : Cara Sehat Turunkan Berat Badan? - Darmo Hospital Podcast #1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                <div class="card-body">
                                    <h5 class="card-title">Intermittent Fasting</h5>
                                    <p class="card-text">Cara Sehat Turunkan Berat Badan.</p>
                                    <a href="https://www.youtube.com/watch?v=SsUmvFydj68" class="btn" style="background-color:green; color: white;">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <iframe width="420" height="315" src="https://www.youtube.com/embed/K6spoYJvr50" title="Cara Diet Anti Gagal! - Pahami Prinsip Menurunkan Berat Badan yang Benar!" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                <div class="card-body">
                                    <h5 class="card-title">Intermittent Fasting</h5>
                                    <p class="card-text">Cara Sehat Turunkan Berat Badan.</p>
                                    <a href="https://www.youtube.com/watch?v=SsUmvFydj68" class="btn" style="background-color:green; color: white;">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <iframe width="420" height="315" src="https://www.youtube.com/embed/rsZqOh6fR20" title="5 LANGKAH MUDAH TURUN BERAT BADAN DALAM WAKTU 1 MINGGU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                <div class="card-body">
                                    <h5 class="card-title">5 LANGKAH MUDAH TURUN BERAT BADAN DALAM WAKTU 1 MINGGU</h5>
                                    <a href="https://www.youtube.com/watch?v=rsZqOh6fR20" class="btn" style="background-color:green; color: white;">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Running Section -->
            <div class="container-fluid py-5" style="background-color: #f8f9fa;">
                <div class="container">
                    <h2 class="text-center mb-5">Event Kesehatan Terbaru</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('img/event1.jpg') }}" class="card-img-top" alt="Event Senam Pagi">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge" style="background-color: green;">Minggu, 28 April 2024</span>
                                        <span class="badge bg-secondary">06:00 WIB</span>
                                    </div>
                                    <h5 class="card-title">Senam Pagi Bersama</h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt me-2" style="color: green;"></i>
                                        Taman Bungkul, Surabaya
                                    </p>
                                    <p class="card-text">Senam aerobik dan zumba bersama instruktur profesional untuk memulai hari dengan semangat!</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('img/event2.jpg') }}" class="card-img-top" alt="Seminar Diet">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge" style="background-color: green;">Sabtu, 4 Mei 2024</span>
                                        <span class="badge bg-secondary">13:00 WIB</span>
                                    </div>
                                    <h5 class="card-title">Seminar Diet Sehat</h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt me-2" style="color: green;"></i>
                                        Hotel Shangri-La, Surabaya
                                    </p>
                                    <p class="card-text">Pelajari cara diet yang benar dan sehat dari pakar nutrisi terkemuka.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('img/event3.jpg') }}" class="card-img-top" alt="Yoga Class">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge" style="background-color: green;">Minggu, 12 Mei 2024</span>
                                        <span class="badge bg-secondary">07:00 WIB</span>
                                    </div>
                                    <h5 class="card-title">Yoga untuk Pemula</h5>
                                    <p class="card-text">
                                        <i class="fas fa-map-marker-alt me-2" style="color: green;"></i>
                                        Taman Prestasi, Surabaya
                                    </p>
                                    <p class="card-text">Kelas yoga dasar untuk pemula dengan instruktur berpengalaman.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@push('css')
<style>
    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .bg-primary {
        background: linear-gradient(45deg, #0d6efd, #0dcaf0) !important;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
</style>
@endpush