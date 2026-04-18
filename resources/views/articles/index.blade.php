@extends('layouts.app')
@section('title', 'Artikel Kesehatan')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5" style="background-color: white;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 style="color: green;">Artikel Kesehatan</h2>
            <p class="text-muted">Artikel kesehatan dari dokter-dokter kami sesuai spesialisasi.</p>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-success btn-sm me-2">Kelola Artikel</a>
                @elseif(auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.articles.index') }}" class="btn btn-success btn-sm me-2">Artikel Saya</a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Filter by Specialization -->
    @if($specializations->count())
    <div class="row mb-4">
        <div class="col-12 text-center">
            <a href="{{ route('articles.index') }}" class="btn btn-sm {{ !$specialization ? 'btn-success' : 'btn-outline-success' }} me-1 mb-1">Semua</a>
            @foreach($specializations as $spec)
                <a href="{{ route('articles.index', ['specialization' => $spec]) }}"
                   class="btn btn-sm {{ $specialization === $spec ? 'btn-success' : 'btn-outline-success' }} me-1 mb-1">
                   {{ $spec }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top" alt="{{ $article->title }}" style="height:200px; object-fit:cover;">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <i class="fas fa-newspaper text-success" style="font-size:3rem;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex gap-2 mb-2 flex-wrap">
                            @if($article->specialization)
                                <span class="badge bg-success">{{ $article->specialization }}</span>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120, '...') }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <small class="text-muted">Dr. {{ $article->author->name ?? '-' }}</small>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-outline-success btn-sm">Baca</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <h5 class="mb-0">Belum ada artikel tersedia.</h5>
                    <p class="text-muted">Silakan kembali lagi nanti.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@push('css')
<style>
.card { transition: transform 0.3s ease; }
.card:hover { transform: translateY(-5px); }
.btn-success { background-color: green; border-color: green; }
.btn-success:hover { background-color: darkgreen; border-color: darkgreen; }
</style>
@endpush
@endsection
