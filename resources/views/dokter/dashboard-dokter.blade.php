@extends('layouts.app')
@section('title', 'Dashboard Dokter')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-user-md me-2"></i>Dashboard Dokter
        </div>
        <div class="card-body">
            <h4>Selamat datang, Dr. {{ auth()->user()->name }}!</h4>
            <p class="text-muted mb-4">Spesialisasi: <strong>{{ auth()->user()->specialization ?? 'Umum' }}</strong></p>

            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('dokter.reservations.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-left:4px solid #dc3545 !important;">
                            <i class="fas fa-calendar-check fa-2x text-danger mb-2"></i>
                            <div class="fw-semibold">Reservasi Masuk</div>
                            <small class="text-muted">Lihat & tangani reservasi pasien</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('dokter.articles.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-left:4px solid #198754 !important;">
                            <i class="fas fa-newspaper fa-2x text-success mb-2"></i>
                            <div class="fw-semibold">Artikel Kesehatan</div>
                            <small class="text-muted">Tulis artikel sesuai spesialisasi</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('dokter.healthy-menus.index') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-left:4px solid #20c997 !important;">
                            <i class="fas fa-carrot fa-2x text-success mb-2"></i>
                            <div class="fw-semibold">Menu Sehat</div>
                            <small class="text-muted">Kelola menu sehat pasien</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 