@extends('layouts.app')
@section('title', 'Artikel Kesehatan')
@section('content')
@include('layouts.navbars.dashboardnav')

<div style="background:linear-gradient(135deg,#1b5e20,#388e3c); padding:3rem 0 2.5rem;">
    <div class="container text-center text-white">
        <i class="fas fa-newspaper mb-3" style="font-size:2.5rem;opacity:.8;"></i>
        <h1 class="fw-bold mb-2" style="color:white;">Artikel Kesehatan</h1>
        <p class="mb-4 opacity-75">Temukan informasi kesehatan terpercaya dari dokter-dokter kami</p>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.articles.index') }}" class="btn btn-light btn-sm fw-semibold me-2"><i class="fas fa-cog me-1"></i>Kelola Artikel</a>
            @elseif(auth()->user()->role === 'dokter')
                <a href="{{ route('dokter.articles.index') }}" class="btn btn-light btn-sm fw-semibold me-2"><i class="fas fa-pen me-1"></i>Artikel Saya</a>
            @endif
        @endauth

        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('articles.index') }}" class="d-flex gap-2">
                    @if($specialization)<input type="hidden" name="specialization" value="{{ $specialization }}">@endif
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-0 ps-0" placeholder="Cari judul atau isi artikel..." value="{{ $search ?? '' }}">
                        @if($search || $specialization)
                            <a href="{{ route('articles.index') }}" class="btn btn-light border-0" title="Reset"><i class="fas fa-times text-muted"></i></a>
                        @endif
                        <button type="submit" class="btn fw-semibold" style="background:#fff3;color:#fff;border:1px solid rgba(255,255,255,.4);">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if($specializations->count())
    <div class="text-center mb-4">
        <a href="{{ route('articles.index', $search ? ['search'=>$search] : []) }}"
           class="btn btn-sm rounded-pill me-1 mb-2 {{ !$specialization ? 'btn-success' : 'btn-outline-success' }}">
            <i class="fas fa-th me-1"></i>Semua
        </a>
        @foreach($specializations as $spec)
            <a href="{{ route('articles.index', array_filter(['specialization'=>$spec,'search'=>$search])) }}"
               class="btn btn-sm rounded-pill me-1 mb-2 {{ $specialization === $spec ? 'btn-success' : 'btn-outline-success' }}">
                {{ $spec }}
            </a>
        @endforeach
    </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <p class="mb-0 text-muted small">
            @if($search)
                Hasil pencarian <strong>"{{ $search }}"</strong>:
            @endif
            <strong>{{ $articles->total() }}</strong> artikel ditemukan
            @if($specialization) &bull; spesialisasi <strong>{{ $specialization }}</strong>@endif
        </p>
        <p class="mb-0 text-muted small">Halaman {{ $articles->currentPage() }} dari {{ $articles->lastPage() }}</p>
    </div>
    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm article-card">
                    <div style="position:relative;overflow:hidden;height:190px;">
                        <img src="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : asset('img/logo.png') }}"
                             class="w-100 h-100" style="object-fit:cover;transition:transform .4s;"
                             alt="{{ $article->title }}"
                             onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                        @if($article->specialization)
                            <span class="badge bg-success position-absolute" style="top:10px;left:10px;">{{ $article->specialization }}</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold mb-2 lh-sm">{{ $article->title }}</h6>
                        <p class="card-text text-muted small flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100, '...') }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:28px;height:28px;font-size:.7rem;flex-shrink:0;">
                                    {{ strtoupper(substr($article->author->name ?? 'D', 0, 1)) }}
                                </div>
                                <small class="text-muted text-truncate" style="max-width:110px;">{{ $article->author->name ?? '-' }}</small>
                            </div>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-success rounded-pill px-3">Baca</a>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i>{{ $article->created_at->translatedFormat('d M Y') }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search text-muted mb-3" style="font-size:3rem;opacity:.4;"></i>
                    <h5 class="text-muted">{{ $search ? 'Tidak ada artikel yang cocok.' : 'Belum ada artikel tersedia.' }}</h5>
                    @if($search || $specialization)
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-success mt-2">Lihat semua artikel</a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>
    @if($articles->hasPages())
    <div class="d-flex justify-content-center mt-5">
        <nav>
            <ul class="pagination pagination-sm gap-1">
                {{-- Prev --}}
                <li class="page-item {{ $articles->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link rounded-pill px-3" href="{{ $articles->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                </li>
                {{-- Pages --}}
                @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $articles->currentPage() ? 'active' : '' }}">
                        <a class="page-link rounded-pill" href="{{ $url }}" style="{{ $page == $articles->currentPage() ? 'background:#198754;border-color:#198754;' : '' }}">{{ $page }}</a>
                    </li>
                @endforeach
                {{-- Next --}}
                <li class="page-item {{ !$articles->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link rounded-pill px-3" href="{{ $articles->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>
@push('css')
<style>
.article-card { transition: transform .3s, box-shadow .3s; }
.article-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(0,0,0,.12) !important; }
.article-card:hover img { transform: scale(1.05); }
.btn-success { background-color: #198754; border-color: #198754; }
.btn-success:hover { background-color: #146c43; border-color: #146c43; }
.btn-outline-success { color: #198754; border-color: #198754; }
.btn-outline-success:hover { background-color: #198754; border-color: #198754; }
.card { transition: transform 0.3s ease; }
.card:hover { transform: translateY(-5px); }
.btn-success { background-color: green; border-color: green; }
.btn-success:hover { background-color: darkgreen; border-color: darkgreen; }
</style>
@endpush
@endsection
