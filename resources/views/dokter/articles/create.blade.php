@extends('layouts.app')
@section('title', 'Tulis Artikel')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">Tulis Artikel Kesehatan</div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>Artikel Anda akan ditampilkan dengan spesialisasi: <strong>{{ auth()->user()->specialization ?? 'Umum' }}</strong>
                    </div>
                    <form method="POST" action="{{ route('dokter.articles.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thumbnail (opsional)</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Artikel</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="12" required>{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="published" id="published" value="1" checked>
                                <label class="form-check-label fw-semibold" for="published">Publish Artikel</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Simpan Artikel</button>
                            <a href="{{ route('dokter.articles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
