@extends('layouts.app')
@section('title', 'Tambah Menu Sehat')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-utensils me-2"></i>Tambah Menu Sehat</h3>
                <p class="mb-0 opacity-75">Buat menu makanan sehat untuk spesialisasi Anda</p>
            </div>
            <a href="{{ route('dokter.healthy-menus.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #dc3545;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('dokter.healthy-menus.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Judul Menu</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" value="{{ old('category') }}" class="form-control @error('category') is-invalid @enderror">
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kalori per Porsi</label>
                            <input type="number" name="calories" value="{{ old('calories') }}" class="form-control @error('calories') is-invalid @enderror">
                            @error('calories')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Resep</label>
                            <textarea name="recipe" rows="5" class="form-control @error('recipe') is-invalid @enderror">{{ old('recipe') }}</textarea>
                            @error('recipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar (opsional)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Menu Sehat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
