@extends('layouts.app')
@section('title', 'Artikel Saya')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Artikel Saya</h3>
            <small class="text-muted">Spesialisasi: {{ auth()->user()->specialization ?? 'Umum' }}</small>
        </div>
        <a href="{{ route('dokter.articles.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i>Tulis Artikel</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top" style="height:180px; object-fit:cover;" alt="">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-success">{{ $article->specialization ?? 'Umum' }}</span>
                            @if($article->published)
                                <span class="badge bg-primary">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="text-muted small">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex gap-2">
                        <a href="{{ route('dokter.articles.edit', $article) }}" class="btn btn-sm btn-warning flex-grow-1">Edit</a>
                        <form method="POST" action="{{ route('dokter.articles.destroy', $article) }}" class="flex-grow-1"
                              onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="fas fa-newspaper text-muted mb-3" style="font-size:3rem;"></i>
                    <h5>Belum ada artikel.</h5>
                    <a href="{{ route('dokter.articles.create') }}" class="btn btn-success mt-2">Tulis Artikel Pertama</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
