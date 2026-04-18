@extends('layouts.app')
@section('title', 'Edit Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">Edit Reservasi</div>
                <div class="card-body">
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