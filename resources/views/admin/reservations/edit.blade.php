@extends('layouts.app')
@section('title', 'Edit Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-calendar-edit me-2"></i>Edit Reservasi</h3>
                <p class="mb-0 opacity-75">Perbarui status dan jadwal reservasi #{{ $reservation->id }}</p>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #ffc107;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Dokter</label>
                            <select name="dokter_id" class="form-select" required>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ $reservation->dokter_id == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }} — {{ $dokter->specialization ?? 'Umum' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jadwal Konsultasi</label>
                            <input type="datetime-local" name="jadwal" class="form-control"
                                   value="{{ $reservation->jadwal->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="accepted" {{ $reservation->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $reservation->keterangan }}</textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold">
                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-outline-secondary">
                                Detail Reservasi
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 