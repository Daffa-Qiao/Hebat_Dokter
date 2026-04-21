@extends('layouts.app')
@section('title', 'Edit Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#198754,#20c997);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-calendar-edit me-2"></i>Edit Reservasi</h3>
                <p class="mb-0 opacity-75">Perbarui jadwal atau keterangan reservasi Anda</p>
            </div>
            <a href="{{ route('pasien.reservations.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-top:4px solid #198754;">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="dokter_id" class="form-label">Pilih Dokter</label>
                            <select name="dokter_id" id="dokter_id" class="form-select" required>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ $reservation->dokter_id == $dokter->id ? 'selected' : '' }}>{{ $dokter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Konsultasi</label>
                            <input type="datetime-local" name="jadwal" id="jadwal" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($reservation->jadwal)) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control">{{ $reservation->keterangan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $reservation->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning">Update Reservasi</button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 