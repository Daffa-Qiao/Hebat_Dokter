@extends('layouts.app')
@section('title', 'Semua Tips Diet')
@include ('layouts.navbars.dashboardnav')
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Semua Tips Diet</h1>
            <p class="text-muted">Temukan semua video tips diet yang bisa membantu Anda mencapai tujuan kesehatan.</p>
        </div>
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
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($tip->description, 140, '...') }}</p>
                        @if($tip->source_url)
                            <a href="{{ $tip->source_url }}" target="_blank" rel="noopener" class="btn btn-success">Lihat Selengkapnya</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h5 class="mb-0">Belum ada tips diet tersedia.</h5>
                    <p class="text-muted">Silakan cek kembali nanti untuk video baru.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
