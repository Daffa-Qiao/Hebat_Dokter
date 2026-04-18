@extends('layouts.app')
@section('title', 'Daftar Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Reservasi</h4>
        @if(auth()->user()->role === 'pasien')
            <a href="{{ route('pasien.reservations.create') }}" class="btn btn-success">Buat Reservasi</a>
        @endif
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $reservation->pasien->name ?? '-' }}</td>
                        <td>{{ $reservation->dokter->name ?? '-' }}</td>
                        <td>{{ $reservation->jadwal }}</td>
                        <td>
                            @if($reservation->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($reservation->status === 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $reservation->keterangan }}</td>
                        <td>
                            <a href="{{ route(auth()->user()->role.'.reservations.show', $reservation) }}" class="btn btn-info btn-sm">Detail</a>
                            @if(auth()->user()->role === 'dokter' && $reservation->status === 'pending')
                                <form action="{{ route('dokter.reservations.accept', $reservation) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                </form>
                                <form action="{{ route('dokter.reservations.reject', $reservation) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            @endif
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus reservasi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada reservasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 