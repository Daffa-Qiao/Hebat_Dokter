@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                    <i class="fas fa-tachometer-alt fa-2x me-2"></i>
                    <span class="ms-2">Dashboard</span>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">Selamat datang di Dashboard!</h4>
                    <p class="mb-4">Anda login sebagai <strong>{{ auth()->user()->role }}</strong>.</p>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card text-center border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                    <h5 class="card-title">Total Reservasi</h5>
                                    <p class="display-6">{{ $jumlahReservasi ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Statistik Reservasi per Bulan</h5>
                                    <canvas id="chartReservasiUmum"></canvas>
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
    const ctxUmum = document.getElementById('chartReservasiUmum').getContext('2d');
    new Chart(ctxUmum, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Reservasi',
                data: @json($chartData ?? []),
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
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