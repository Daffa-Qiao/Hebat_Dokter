@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Event</h4>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Judul Event</label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" class="form-control @error('date') is-invalid @enderror" required>
                                @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu</label>
                                <input type="time" name="time" value="{{ old('time', $event->time) }}" class="form-control @error('time') is-invalid @enderror">
                                @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="form-control @error('location') is-invalid @enderror">
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Event (opsional)</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if($event->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Foto Event" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Event</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
