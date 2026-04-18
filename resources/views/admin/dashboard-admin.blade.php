@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                    <i class="fas fa-user-shield fa-2x me-2"></i>
                    <span class="ms-2">Dashboard Admin</span>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">Selamat datang, <strong>{{ auth()->user()->name }}</strong>!</h4>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                    <h5 class="card-title">Total User</h5>
                                    <p class="display-6">{{ $totalUser ?? 120 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <i class="fas fa-user-md fa-2x text-warning mb-2"></i>
                                    <h5 class="card-title">Total Dokter</h5>
                                    <p class="display-6">{{ $totalDoctors ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <i class="fas fa-calendar-check fa-2x text-success mb-2"></i>
                                    <h5 class="card-title">Total Reservasi</h5>
                                    <p class="display-6">{{ $totalReservasi ?? 350 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <i class="fas fa-book-medical fa-2x text-info mb-2"></i>
                                    <h5 class="card-title">Total Diet Tips</h5>
                                    <p class="display-6">{{ $totalDietTips ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Quick Access -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <a href="{{ route('admin.articles.index') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-left:4px solid #198754 !important;">
                                    <i class="fas fa-newspaper fa-2x text-success mb-2"></i>
                                    <div class="fw-semibold">Artikel Kesehatan</div>
                                    <small class="text-muted">Tambah &amp; kelola artikel</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.events.index') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-left:4px solid #0d6efd !important;">
                                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                                    <div class="fw-semibold">Event</div>
                                    <small class="text-muted">Kelola event kesehatan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.diet-tips.index') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-left:4px solid #ffc107 !important;">
                                    <i class="fas fa-video fa-2x text-warning mb-2"></i>
                                    <div class="fw-semibold">Tips Diet</div>
                                    <small class="text-muted">Kelola video tips diet</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.healthy-menus.index') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 text-center p-3" style="border-left:4px solid #20c997 !important;">
                                    <i class="fas fa-carrot fa-2x text-success mb-2"></i>
                                    <div class="fw-semibold">Menu Sehat</div>
                                    <small class="text-muted">Kelola menu per penyakit</small>
                                </div>
                            </a>
                        </div>
                    </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Statistik Reservasi per Bulan</h5>
                                    <canvas id="chartReservasiAdmin2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxAdmin2 = document.getElementById('chartReservasiAdmin2').getContext('2d');
    new Chart(ctxAdmin2, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Reservasi',
                data: [12, 19, 3, 5, 2, 3, 7, 8, 6, 10, 15, 9],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush 