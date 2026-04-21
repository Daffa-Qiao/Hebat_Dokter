@extends('layouts.app')
@section('title', $article->title)
@section('content')
<!-- Home Button -->
<div class="position-fixed" style="top: 20px; left: 20px; z-index: 1000;">
    <a href="{{ route('articles.index') }}" class="btn btn-primary rounded-circle shadow-sm" style="background-color:green;" title="Kembali ke Artikel">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>

<div class="container py-5" style="max-width: 860px;">
    <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : asset('img/logo.png') }}"
         alt="{{ $article->title }}" class="w-100 rounded-3 mb-4"
         style="max-height:380px; object-fit:cover;"
         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">

    <div class="d-flex gap-2 mb-3 flex-wrap">
        @if($article->specialization)
            <span class="badge bg-success fs-6">{{ $article->specialization }}</span>
        @endif
        <span class="badge bg-secondary">{{ $article->created_at->locale('id')->translatedFormat('d F Y') }}</span>
    </div>

    <h1 class="fw-bold mb-2" style="color: #1a1a1a;">{{ $article->title }}</h1>

    <div class="d-flex align-items-center mb-4">
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;">
            <i class="fas fa-user-md"></i>
        </div>
        <div>
            <p class="mb-0 fw-semibold">Dr. {{ $article->author->name ?? '-' }}</p>
            <small class="text-muted">{{ $article->author->specialization ?? 'Dokter Umum' }}</small>
        </div>
    </div>

    <div class="article-content" style="font-size:1.05rem; line-height:1.85; color:#333;">
        {!! nl2br(e($article->content)) !!}
    </div>

    <hr class="my-4">
    <a href="{{ route('articles.index') }}" class="btn btn-outline-success">← Kembali ke Semua Artikel</a>
    @auth
        @if(auth()->user()->role === 'pasien')
            <a href="{{ route('pasien.reservations.create') }}" class="btn btn-success ms-2">Buat Reservasi dengan Dokter</a>
        @endif
    @endauth
</div>
@endsection
