@extends('layouts.app')
@section('title', 'Edit Artikel')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-pen-nib me-2"></i>Edit Artikel</h3>
                <p class="mb-0 opacity-75">Perbarui artikel: <strong>{{ Str::limit($article->title, 50) }}</strong></p>
            </div>
            <a href="{{ route('dokter.articles.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #dc3545;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('dokter.articles.update', $article) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $article->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thumbnail</label>
                            @if($article->thumbnail)
                                <div class="mb-2"><img src="{{ asset('storage/' . $article->thumbnail) }}" style="height:80px; border-radius:6px;" alt=""
                                     onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' "></div>
                            @endif
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Artikel</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="12" required>{{ old('content', $article->content) }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="published" id="published" value="1"
                                       {{ $article->published ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="published">Publish Artikel</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Perbarui</button>
                            <a href="{{ route('dokter.articles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
