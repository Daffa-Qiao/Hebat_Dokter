@extends('layouts.app')
@section('title', 'Manajemen Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-calendar-check me-2 text-warning"></i>Manajemen Reservasi</h4>
            <p class="text-muted mb-0 small">Kelola dan pantau seluruh reservasi konsultasi</p>
        </div>
        <button class="btn btn-warning text-dark px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#createReservationModal">
            <i class="fas fa-plus me-1"></i> Tambah Reservasi
        </button>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3 h-100">
                <div class="fs-4 fw-bold text-secondary">{{ $totalCount }}</div>
                <div class="text-muted small">Total</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3 h-100">
                <div class="fs-4 fw-bold text-warning">{{ $pendingCount }}</div>
                <div class="text-muted small">Pending</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3 h-100">
                <div class="fs-4 fw-bold text-success">{{ $acceptedCount }}</div>
                <div class="text-muted small">Diterima</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3 h-100">
                <div class="fs-4 fw-bold text-danger">{{ $rejectedCount }}</div>
                <div class="text-muted small">Ditolak</div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Search & Filter --}}
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-5">
                    <form method="GET" action="{{ route('admin.reservations.index') }}" class="d-flex gap-2">
                        @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari nama pasien / dokter..."
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-secondary text-nowrap"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="col-6 col-md-3">
                    <form method="GET" action="{{ route('admin.reservations.index') }}">
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="accepted"  {{ request('status') == 'accepted'  ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected"  {{ request('status') == 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>
                </div>
                @if(request('search') || request('status'))
                <div class="col-6 col-md-2">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>Reset
                    </a>
                </div>
                @endif
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width:50px">No</th>
                            <th><i class="fas fa-user me-1"></i>Pasien</th>
                            <th class="d-none d-md-table-cell"><i class="fas fa-user-md me-1"></i>Dokter</th>
                            <th class="d-none d-sm-table-cell"><i class="fas fa-clock me-1"></i>Jadwal</th>
                            <th>Status</th>
                            <th class="d-none d-lg-table-cell">Keterangan</th>
                            <th class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $index => $reservation)
                            <tr>
                                <td class="ps-3 text-muted">{{ $reservations->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($reservation->pasien?->photo)
                                            <img src="{{ asset('storage/' . $reservation->pasien->photo) }}"
                                                 class="rounded-circle flex-shrink-0 object-fit-cover"
                                                 style="width:34px;height:34px;border:2px solid #ffc107;"
                                                 alt="{{ $reservation->pasien->name }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                                        @else
                                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center flex-shrink-0"
                                                 style="width:34px;height:34px;font-size:14px;font-weight:700;color:#000;">
                                                {{ strtoupper(substr($reservation->pasien->name ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $reservation->pasien->name ?? '-' }}</div>
                                            @if($reservation->disease)
                                                <small class="text-muted">{{ $reservation->disease }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    <div class="fw-semibold">{{ $reservation->dokter->name ?? '-' }}</div>
                                    @if($reservation->dokter?->specialization)
                                        <small class="text-muted">{{ $reservation->dokter->specialization }}</small>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell text-nowrap">
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($reservation->jadwal)->translatedFormat('d M Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->jadwal)->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    @php
                                        [$sc, $si] = match($reservation->status) {
                                            'pending'  => ['warning text-dark', 'fa-hourglass-half'],
                                            'accepted' => ['success', 'fa-check'],
                                            default    => ['danger', 'fa-times'],
                                        };
                                        $sl = ['pending'=>'Pending','accepted'=>'Diterima','rejected'=>'Ditolak'][$reservation->status] ?? ucfirst($reservation->status);
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $sc }} px-3 py-2">
                                        <i class="fas {{ $si }} me-1"></i>{{ $sl }}
                                    </span>
                                </td>
                                <td class="d-none d-lg-table-cell text-muted small" style="max-width:160px;">
                                    {{ \Illuminate\Support\Str::limit($reservation->keterangan, 55, '...') ?: '-' }}
                                </td>
                                <td class="text-center pe-3">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        <a href="{{ route('admin.reservations.show', $reservation) }}"
                                           class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-edit-reservation" title="Edit"
                                            data-pasien="{{ $reservation->pasien_id }}"
                                            data-dokter="{{ $reservation->dokter_id }}"
                                            data-jadwal="{{ date('Y-m-d\TH:i', strtotime($reservation->jadwal)) }}"
                                            data-keterangan="{{ $reservation->keterangan }}"
                                            data-status="{{ $reservation->status }}"
                                            data-action="{{ route('admin.reservations.update', $reservation) }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}"
                                              class="d-inline swal-delete"
                                              data-title="Hapus reservasi ini?"
                                              data-text="Reservasi yang dihapus tidak dapat dikembalikan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-swal-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">Tidak ada data reservasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $reservations->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>

{{-- ===== MODAL TAMBAH RESERVASI ===== --}}
<div class="modal fade" id="createReservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-calendar-plus me-2"></i>Tambah Reservasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.reservations.store') }}" id="createReservationForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pasien</label>
                            <select class="form-select @error('pasien_id') is-invalid @enderror" name="pasien_id" required>
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>
                                        {{ $pasien->name }} ({{ $pasien->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pasien_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Dokter</label>
                            <select class="form-select @error('dokter_id') is-invalid @enderror" name="dokter_id" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                                        {{ $dokter->name }}{{ $dokter->specialization ? ' ('.$dokter->specialization.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jadwal Konsultasi</label>
                            <input type="datetime-local" class="form-control @error('jadwal') is-invalid @enderror"
                                   name="jadwal" value="{{ old('jadwal') }}" required>
                            @error('jadwal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="pending"  {{ old('status','pending') == 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                      name="keterangan" rows="3"
                                      placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT RESERVASI ===== --}}
<div class="modal fade" id="editReservationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="formEditReservasi" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pasien</label>
                            <select class="form-select" name="pasien_id" id="edit_pasien_id" required>
                                @foreach($pasiens as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Dokter</label>
                            <select class="form-select" name="dokter_id" id="edit_dokter_id" required>
                                @foreach($dokters as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}{{ $d->specialization ? ' ('.$d->specialization.')' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jadwal Konsultasi</label>
                            <input type="datetime-local" class="form-control" name="jadwal" id="edit_jadwal" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status" id="edit_status" required>
                                <option value="pending">Pending</option>
                                <option value="accepted">Diterima</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
(function () {
    // Auto-open create modal on validation errors
    @if($errors->any())
    new bootstrap.Modal(document.getElementById('createReservationModal')).show();
    @endif

    // Reset create form on close
    document.getElementById('createReservationModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('createReservationForm').reset();
        this.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
    });

    // Edit modal population
    document.querySelectorAll('.btn-edit-reservation').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('formEditReservasi');
            form.action = this.dataset.action;
            document.getElementById('edit_pasien_id').value  = this.dataset.pasien;
            document.getElementById('edit_dokter_id').value  = this.dataset.dokter;
            document.getElementById('edit_jadwal').value     = this.dataset.jadwal;
            document.getElementById('edit_keterangan').value = this.dataset.keterangan;
            document.getElementById('edit_status').value     = this.dataset.status;
            new bootstrap.Modal(document.getElementById('editReservationModal')).show();
        });
    });

    // Swal delete
    document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = this.closest('.swal-delete');
            Swal.fire({
                title: form.dataset.title || 'Hapus data ini?',
                text: form.dataset.text || 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
})();
</script>
@endpush

@endsection

