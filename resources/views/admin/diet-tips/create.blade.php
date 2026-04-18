@extends('layouts.app')
@section('title', 'Tambah Tips Diet')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Tambah Tips Diet Baru</h4>
                    <a href="{{ route('admin.diet-tips.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.diet-tips.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul Tips</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Video (embed atau watch)</label>
                            <input type="url" name="video_url" value="{{ old('video_url') }}" class="form-control @error('video_url') is-invalid @enderror">
                            @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Sumber</label>
                            <input type="url" name="source_url" value="{{ old('source_url') }}" class="form-control @error('source_url') is-invalid @enderror">
                            @error('source_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Tips Diet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
