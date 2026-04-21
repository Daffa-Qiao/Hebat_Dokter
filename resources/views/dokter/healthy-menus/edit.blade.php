@extends('layouts.app')
@section('title', 'Edit Menu Sehat')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-utensils me-2"></i>Edit Menu Sehat</h3>
                <p class="mb-0 opacity-75">Perbarui menu sehat: <strong>{{ $healthyMenu->title }}</strong></p>
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
                    <form method="POST" action="{{ route('dokter.healthy-menus.update', $healthyMenu) }}" enctype="multipart/form-data">
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
                            <label class="form-label">Resep</label>
                            <textarea name="recipe" rows="5" class="form-control @error('recipe') is-invalid @enderror">{{ old('recipe', $healthyMenu->recipe) }}</textarea>
                            @error('recipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>  
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat ini</label>
                            @if($healthyMenu->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $healthyMenu->image) }}" alt="Menu" class="img-fluid rounded" style="max-height: 200px;"
                                         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
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
