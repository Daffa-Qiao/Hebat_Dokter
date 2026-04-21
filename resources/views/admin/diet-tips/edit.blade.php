@extends('layouts.app')
@section('title', 'Edit Tips Diet')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-apple-alt me-2"></i>Edit Tips Diet</h3>
                <p class="mb-0 opacity-75">Perbarui informasi tips diet: <strong>{{ $dietTip->title }}</strong></p>
            </div>
            <a href="{{ route('admin.diet-tips.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #ffc107;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.diet-tips.update', $dietTip) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Judul Tips</label>
                            <input type="text" name="title" value="{{ old('title', $dietTip->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Video (embed atau watch)</label>
                            <input type="url" name="video_url" value="{{ old('video_url', $dietTip->video_url) }}" class="form-control @error('video_url') is-invalid @enderror">
                            @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL Sumber</label>
                            <input type="url" name="source_url" value="{{ old('source_url', $dietTip->source_url) }}" class="form-control @error('source_url') is-invalid @enderror">
                            @error('source_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $dietTip->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Tips Diet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
