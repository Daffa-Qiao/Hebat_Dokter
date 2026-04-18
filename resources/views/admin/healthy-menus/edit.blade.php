@extends('layouts.app')
@section('title', 'Edit Menu Sehat')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Menu Sehat</h4>
                    <a href="{{ route('admin.healthy-menus.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.healthy-menus.update', $healthyMenu) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Judul Menu</label>
                            <input type="text" name="title" value="{{ old('title', $healthyMenu->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" value="{{ old('category', $healthyMenu->category) }}" class="form-control @error('category') is-invalid @enderror">
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="specialization" value="{{ old('specialization', $healthyMenu->specialization) }}" class="form-control @error('specialization') is-invalid @enderror">
                            @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kalori per Porsi</label>
                            <input type="number" name="calories" value="{{ old('calories', $healthyMenu->calories) }}" class="form-control @error('calories') is-invalid @enderror">
                            @error('calories')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $healthyMenu->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat ini</label>
                            @if($healthyMenu->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $healthyMenu->image) }}" alt="Menu" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            @else
                                <div class="text-muted mb-2">Belum ada gambar.</div>
                            @endif
                            <label class="form-label">Ubah Gambar (opsional)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Perbarui Menu Sehat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
