@extends('layouts.app')
@section('title', 'Edit Artikel')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">Edit Artikel Kesehatan</div>
                <div class="card-body">
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
