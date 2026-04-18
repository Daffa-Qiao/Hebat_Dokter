@extends('layouts.app')

@section('title', 'Manajemen Reservasi')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manajemen Reservasi</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReservationModal">
                        <i class="fas fa-plus"></i> Tambah Reservasi
                    </button>
                </div>
                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('admin.reservations.index') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="Cari nama pasien/dokter..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary">Cari</button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('admin.reservations.index') }}">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Reset Filter
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Reservations Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $index => $reservation)
                                    <tr>
                                        <td>{{ $reservations->firstItem() + $index }}</td>
                                        <td>{{ $reservation->pasien->name }}</td>
                                        <td>{{ $reservation->dokter->name }}</td>
                                        <td>{{ $reservation->jadwal->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $reservation->status == 'pending' ? 'warning' : ($reservation->status == 'accepted' ? 'success' : 'danger') }}">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($reservation->keterangan, 50) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('admin.reservations.edit', $reservation) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data reservasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $reservations->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Reservation Modal -->
<div class="modal fade" id="createReservationModal" tabindex="-1" aria-labelledby="createReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createReservationModalLabel">Tambah Reservasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.reservations.store') }}" id="createReservationForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pasien_id" class="form-label">Pasien</label>
                                <select class="form-select @error('pasien_id') is-invalid @enderror" 
                                        id="pasien_id" name="pasien_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                            {{ $pasien->name }} ({{ $pasien->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pasien_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dokter_id" class="form-label">Dokter</label>
                                <select class="form-select @error('dokter_id') is-invalid @enderror" 
                                        id="dokter_id" name="dokter_id" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                            {{ $dokter->name }} ({{ $dokter->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('dokter_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jadwal" class="form-label">Jadwal Konsultasi</label>
                                <input type="datetime-local" class="form-control @error('jadwal') is-invalid @enderror" 
                                       id="jadwal" name="jadwal" value="{{ old('jadwal') }}" required>
                                @error('jadwal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk reset form modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createReservationModal = document.getElementById('createReservationModal');
    const createReservationForm = document.getElementById('createReservationForm');
    
    // Reset form ketika modal ditutup
    createReservationModal.addEventListener('hidden.bs.modal', function () {
        createReservationForm.reset();
        // Hapus semua class is-invalid
        const invalidInputs = createReservationForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    });
    
    // Reset form ketika modal dibuka
    createReservationModal.addEventListener('show.bs.modal', function () {
        createReservationForm.reset();
        // Hapus semua class is-invalid
        const invalidInputs = createReservationForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    });
    
    // Jika ada error validation, buka modal otomatis
    @if($errors->any())
        const modal = new bootstrap.Modal(createReservationModal);
        modal.show();
    @endif
});
</script>

@endsection 