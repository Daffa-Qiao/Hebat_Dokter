@extends('layouts.app')
@section('title', 'Semua Event')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Semua Event Kesehatan</h1>
            <p class="text-muted">Lihat seluruh event yang tersedia untuk meningkatkan kesehatan dan gaya hidup Anda.</p>
        </div>
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
                        <p class="card-text text-muted"><i class="fas fa-map-marker-alt me-2 text-success"></i>{{ $event->location ?? 'Lokasi belum ditentukan' }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 140, '...') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h5 class="mb-0">Belum ada event kesehatan tersedia.</h5>
                    <p class="text-muted">Silakan kunjungi kembali nanti untuk informasi terbaru.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
