@extends('layouts.app')
@section('title', 'Edit Artikel')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-pen-nib me-2"></i>Edit Artikel</h3>
                <p class="mb-0 opacity-75">Perbarui artikel kesehatan: <strong>{{ Str::limit($article->title, 50) }}</strong></p>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #ffc107;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        @include('admin.articles._form')
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">Perbarui Artikel</button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
