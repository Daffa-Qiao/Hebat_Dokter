@extends('layouts.app')
@section('title', 'Daftar Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-success"><i class="fas fa-calendar-alt me-2"></i>Daftar Reservasi</h4>
            <p class="text-muted mb-0 small">Kelola dan pantau seluruh reservasi konsultasi</p>
        </div>
        @if(auth()->user()->role === 'pasien')
            <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalBuatReservasi">
                <i class="fas fa-plus me-1"></i> Buat Reservasi
            </button>
        @endif
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards (pasien only) --}}
    @if(auth()->user()->role === 'pasien')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="text-success fs-4 fw-bold">{{ $reservations->count() }}</div>
                <div class="text-muted small">Total</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="text-warning fs-4 fw-bold">{{ $reservations->where('status','pending')->count() }}</div>
                <div class="text-muted small">Pending</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="text-success fs-4 fw-bold">{{ $reservations->where('status','accepted')->count() }}</div>
                <div class="text-muted small">Diterima</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="text-danger fs-4 fw-bold">{{ $reservations->where('status','rejected')->count() }}</div>
                <div class="text-muted small">Ditolak</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th class="ps-4" style="width:50px">No</th>
                            <th><i class="fas fa-user me-1"></i>Pasien</th>
                            <th><i class="fas fa-user-md me-1"></i>Dokter</th>
                            <th><i class="fas fa-clock me-1"></i>Jadwal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($reservation->pasien?->photo)
                                            <img src="{{ asset('storage/' . $reservation->pasien->photo) }}"
                                                 class="rounded-circle flex-shrink-0 object-fit-cover"
                                                 style="width:34px;height:34px;border:2px solid #198754;"
                                                 alt="{{ $reservation->pasien->name }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                                        @else
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:34px;height:34px;font-size:14px;">
                                                {{ strtoupper(substr($reservation->pasien->name ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="fw-semibold">{{ $reservation->pasien->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $reservation->dokter->name ?? '-' }}</div>
                                    @if($reservation->dokter?->specialization)
                                        <div class="text-muted small">{{ $reservation->dokter->specialization }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($reservation->jadwal)->translatedFormat('d M Y') }}</div>
                                    <div class="text-muted small">{{ \Carbon\Carbon::parse($reservation->jadwal)->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    @if($reservation->status === 'pending')
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-hourglass-half me-1"></i>Pending
                                        </span>
                                    @elseif($reservation->status === 'accepted')
                                        <span class="badge rounded-pill bg-success px-3 py-2">
                                            <i class="fas fa-check me-1"></i>Diterima
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-danger px-3 py-2">
                                            <i class="fas fa-times me-1"></i>Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small" style="max-width:160px;">
                                    {{ \Illuminate\Support\Str::limit($reservation->keterangan, 60, '...') }}
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1 flex-wrap">
                                        <a href="{{ route(auth()->user()->role.'.reservations.show', $reservation) }}" class="btn btn-outline-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'dokter' && $reservation->status === 'pending')
                                            <form id="form-accept-{{ $reservation->id }}" action="{{ route('dokter.reservations.accept', $reservation) }}" method="POST" style="display:none;">
                                                @csrf
                                            </form>
                                            <form id="form-reject-{{ $reservation->id }}" action="{{ route('dokter.reservations.reject', $reservation) }}" method="POST" style="display:none;">
                                                @csrf
                                            </form>
                                            <button type="button" class="btn btn-success btn-sm btn-swal-accept" title="Terima"
                                                data-id="{{ $reservation->id }}"
                                                data-pasien="{{ $reservation->pasien->name ?? 'Pasien' }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-swal-reject" title="Tolak"
                                                data-id="{{ $reservation->id }}"
                                                data-pasien="{{ $reservation->pasien->name ?? 'Pasien' }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        @if(auth()->user()->role === 'admin')
                                            <button type="button" class="btn btn-warning btn-sm btn-edit-reservation" title="Edit"
                                                data-id="{{ $reservation->id }}"
                                                data-dokter="{{ $reservation->dokter_id }}"
                                                data-jadwal="{{ date('Y-m-d\TH:i', strtotime($reservation->jadwal)) }}"
                                                data-keterangan="{{ $reservation->keterangan }}"
                                                data-status="{{ $reservation->status }}"
                                                data-action="{{ route('admin.reservations.update', $reservation) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus-reservation" title="Hapus"
                                                data-action="{{ route('admin.reservations.destroy', $reservation) }}"
                                                data-pasien="{{ $reservation->pasien->name ?? 'Pasien' }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-1">Belum ada reservasi.</p>
                                    @if(auth()->user()->role === 'pasien')
                                        <button class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalBuatReservasi">
                                            Buat Reservasi Sekarang
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL BUAT RESERVASI (pasien) ===== --}}
@if(auth()->user()->role === 'pasien')
<div class="modal fade" id="modalBuatReservasi" tabindex="-1" aria-labelledby="modalBuatReservasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalBuatReservasiLabel"><i class="fas fa-calendar-plus me-2"></i>Buat Reservasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>Pilih jenis penyakit/keluhan Anda. Sistem akan otomatis mencarikan dokter spesialis yang sesuai.
                </div>
                <form method="POST" action="{{ route('pasien.reservations.store') }}" id="formBuatReservasi">
                    @csrf
                    <div class="mb-3">
                        <label for="disease" class="form-label fw-bold">Pilih Penyakit / Keluhan</label>
                        <select name="disease" id="disease" class="form-select form-select-lg @error('disease') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih jenis penyakit --</option>
                            @foreach($diseases as $disease => $specialization)
                                <option value="{{ $disease }}" {{ old('disease') === $disease ? 'selected' : '' }}>
                                    {{ $disease }} (Spesialis {{ $specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('disease')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text" id="disease-hint">Pilih penyakit untuk melihat dokter yang tersedia.</div>
                    </div>

                    {{-- Doctor Preview Panel --}}
                    <div id="doctor-preview" class="mb-4" style="display:none;">
                        <div id="doctor-loading" class="text-center py-3" style="display:none;">
                            <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                            <span class="text-muted">Mencari dokter spesialis...</span>
                        </div>
                        <div id="doctor-result"></div>
                    </div>

                    <div class="mb-3">
                        <label for="jadwal" class="form-label fw-bold">Jadwal Konsultasi</label>
                        <input type="datetime-local" name="jadwal" id="jadwal"
                            class="form-control @error('jadwal') is-invalid @enderror"
                            min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d\TH:i') }}"
                            required>
                        @error('jadwal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="jadwal-conflict" class="alert alert-danger mt-2 py-2 small" style="display:none;">
                            <i class="fas fa-ban me-1"></i> Dokter sudah memiliki jadwal pada jam tersebut. Silakan pilih jam lain.
                        </div>
                        <div id="schedule-info" class="mt-2" style="display:none;"></div>
                        <div class="form-text">Reservasi minimal dibuat untuk hari esok (H+1).</div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan / Gejala (opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Jelaskan gejala atau keluhan Anda...">{{ old('keterangan') }}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formBuatReservasi" id="btnSubmitReservasi" class="btn btn-success px-4">
                    <i class="fas fa-paper-plane me-1"></i> Buat Reservasi
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== MODAL EDIT RESERVASI (admin) ===== --}}
@if(auth()->user()->role === 'admin')
<div class="modal fade" id="modalEditReservasi" tabindex="-1" aria-labelledby="modalEditReservasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditReservasiLabel"><i class="fas fa-edit me-2"></i>Edit Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formEditReservasi" action="">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Dokter</label>
                        <select name="dokter_id" id="edit_dokter_id" class="form-select" required>
                            @foreach($dokters as $d)
                                <option value="{{ $d->id }}">{{ $d->name }} {{ $d->specialization ? '('.$d->specialization.')' : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jadwal Konsultasi</label>
                        <input type="datetime-local" name="jadwal" id="edit_jadwal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" id="edit_status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formEditReservasi" class="btn btn-warning px-4">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden delete form --}}
<form id="formHapusReservasi" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endif

@push('js')
<script>
(function () {
    // ============================
    // PASIEN: BUAT RESERVASI JS
    // ============================
    @if(auth()->user()->role === 'pasien')
    const diseaseSelect  = document.getElementById('disease');
    const hint           = document.getElementById('disease-hint');
    const previewWrap    = document.getElementById('doctor-preview');
    const loadingEl      = document.getElementById('doctor-loading');
    const resultEl       = document.getElementById('doctor-result');
    const jadwalInput    = document.getElementById('jadwal');
    const conflictAlert  = document.getElementById('jadwal-conflict');
    const scheduleInfo   = document.getElementById('schedule-info');
    const submitBtn      = document.getElementById('btnSubmitReservasi');
    const endpoint       = '{{ route('pasien.reservations.doctorsByDisease') }}';
    const slotsEndpoint  = '{{ route('pasien.reservations.bookedSlots') }}';

    let recommendedDoctorId = null;
    let lastBookedHours     = [];

    function fetchAndShowSlots(date, selectedHour) {
        if (!recommendedDoctorId) return;
        fetch(`${slotsEndpoint}?doctor_id=${recommendedDoctorId}&date=${date}`)
            .then(r => r.json())
            .then(data => {
                lastBookedHours = data.booked_hours || [];
                if (selectedHour !== null && lastBookedHours.includes(selectedHour)) {
                    conflictAlert.style.display = 'block';
                    jadwalInput.classList.add('is-invalid');
                    submitBtn.disabled = true;
                } else {
                    conflictAlert.style.display = 'none';
                    jadwalInput.classList.remove('is-invalid');
                    submitBtn.disabled = false;
                }
                if (lastBookedHours.length === 0) {
                    scheduleInfo.style.display = 'block';
                    scheduleInfo.innerHTML = `<div class="alert alert-success py-2 small mb-0"><i class="fas fa-calendar-check me-1"></i>Semua jam tersedia pada tanggal ini.</div>`;
                } else {
                    const slots = lastBookedHours.sort().map(h => `<span class="badge bg-danger me-1">${h}:00</span>`).join('');
                    scheduleInfo.style.display = 'block';
                    scheduleInfo.innerHTML = `<div class="card border-warning"><div class="card-body py-2 px-3"><div class="fw-semibold small mb-1"><i class="fas fa-clock text-warning me-1"></i>Jam sudah terisi:</div><div>${slots}</div><div class="text-muted small mt-1">Pilih jam selain di atas.</div></div></div>`;
                }
            }).catch(() => {});
    }

    jadwalInput && jadwalInput.addEventListener('change', function () {
        if (!recommendedDoctorId || !this.value) return;
        const dt   = new Date(this.value);
        const date = dt.toISOString().slice(0, 10);
        const hour = String(dt.getHours()).padStart(2, '0');
        fetchAndShowSlots(date, hour);
    });

    diseaseSelect && diseaseSelect.addEventListener('change', function () {
        conflictAlert.style.display = 'none';
        scheduleInfo.style.display  = 'none';
        scheduleInfo.innerHTML      = '';
        jadwalInput.classList.remove('is-invalid');
        submitBtn.disabled   = false;
        recommendedDoctorId  = null;
        lastBookedHours      = [];
        const disease = this.value;
        if (!disease) return;

        hint.textContent          = 'Mencari dokter spesialis yang tersedia...';
        previewWrap.style.display = 'block';
        loadingEl.style.display   = 'block';
        resultEl.innerHTML        = '';

        fetch(`${endpoint}?disease=${encodeURIComponent(disease)}`)
            .then(r => r.json())
            .then(data => {
                loadingEl.style.display = 'none';
                if (!data.doctors || data.doctors.length === 0) {
                    resultEl.innerHTML = `<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>Belum ada dokter spesialis <strong>${data.specialization || disease}</strong>. Reservasi akan diproses admin.</div>`;
                    hint.textContent   = 'Dokter spesialis belum tersedia.';
                    return;
                }
                const best = data.doctors[0];
                recommendedDoctorId = best.id;
                hint.textContent    = `Ditemukan ${data.doctors.length} dokter spesialis ${data.specialization}.`;
                if (jadwalInput.value) {
                    const dt   = new Date(jadwalInput.value);
                    const date = dt.toISOString().slice(0, 10);
                    const hour = String(dt.getHours()).padStart(2, '0');
                    fetchAndShowSlots(date, hour);
                }
                let cards = data.doctors.map((d, i) => {
                    const avatar = d.photo
                        ? `<img src="${d.photo}" class="rounded-circle me-3" width="52" height="52" style="object-fit:cover;">`
                        : `<div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width:52px;height:52px;font-size:1.3rem;font-weight:600;">${d.name.charAt(0)}</div>`;
                    const badge    = i === 0 ? `<span class="badge bg-success ms-2">Rekomendasi</span>` : '';
                    const busyText = d.pending_count > 0
                        ? `<small class="text-muted">${d.pending_count} reservasi pending</small>`
                        : `<small class="text-success"><i class="fas fa-check-circle me-1"></i>Tersedia sekarang</small>`;
                    return `<div class="d-flex align-items-center p-3 ${i===0?'border-success border bg-light':'border-top'}">${avatar}<div class="flex-grow-1"><div class="fw-semibold">${d.name}${badge}</div><div class="text-muted small">${d.specialization}</div>${d.experience?`<div class="text-muted small">${d.experience}</div>`:''}${busyText}</div></div>`;
                }).join('');
                resultEl.innerHTML = `<div class="card border-success"><div class="card-header bg-success text-white py-2"><i class="fas fa-user-md me-2"></i>Dokter Spesialis <strong>${data.specialization}</strong></div>${cards}<div class="card-footer text-muted small"><i class="fas fa-info-circle me-1"></i>Sistem memilih dokter dengan antrian paling sedikit.</div></div>`;
            }).catch(() => {
                loadingEl.style.display = 'none';
                resultEl.innerHTML = `<div class="alert alert-danger">Gagal memuat data dokter.</div>`;
            });
    });

    if (diseaseSelect && diseaseSelect.value) diseaseSelect.dispatchEvent(new Event('change'));

    // Auto-open modal if there are validation errors
    @if($errors->any() && old('disease'))
    const modalEl = document.getElementById('modalBuatReservasi');
    if (modalEl) new bootstrap.Modal(modalEl).show();
    @endif
    @endif

    // ============================
    // DOKTER: TERIMA / TOLAK SWAL
    // ============================
    @if(auth()->user()->role === 'dokter')
    document.querySelectorAll('.btn-swal-accept').forEach(btn => {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const pasien = this.dataset.pasien;
            Swal.fire({
                title: 'Terima Reservasi?',
                html: `Apakah Anda ingin menerima reservasi dari <strong>${pasien}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check me-1"></i> Ya, Terima',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) document.getElementById(`form-accept-${id}`).submit();
            });
        });
    });

    document.querySelectorAll('.btn-swal-reject').forEach(btn => {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const pasien = this.dataset.pasien;
            Swal.fire({
                title: 'Tolak Reservasi?',
                html: `Apakah Anda yakin ingin menolak reservasi dari <strong>${pasien}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-times me-1"></i> Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) document.getElementById(`form-reject-${id}`).submit();
            });
        });
    });
    @endif

    // ============================
    // ADMIN: EDIT MODAL JS
    // ============================
    @if(auth()->user()->role === 'admin')
    document.querySelectorAll('.btn-edit-reservation').forEach(btn => {
        btn.addEventListener('click', function () {
            const form   = document.getElementById('formEditReservasi');
            form.action  = this.dataset.action;
            document.getElementById('edit_dokter_id').value   = this.dataset.dokter;
            document.getElementById('edit_jadwal').value      = this.dataset.jadwal;
            document.getElementById('edit_keterangan').value  = this.dataset.keterangan;
            document.getElementById('edit_status').value      = this.dataset.status;
            new bootstrap.Modal(document.getElementById('modalEditReservasi')).show();
        });
    });

    // ADMIN: HAPUS SWAL
    document.querySelectorAll('.btn-hapus-reservation').forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.dataset.action;
            const pasien = this.dataset.pasien;
            Swal.fire({
                title: 'Hapus Reservasi?',
                html: `Reservasi pasien <strong>${pasien}</strong> akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) {
                    const form   = document.getElementById('formHapusReservasi');
                    form.action  = action;
                    form.submit();
                }
            });
        });
    });
    @endif
})();
</script>
@endpush
@endsection