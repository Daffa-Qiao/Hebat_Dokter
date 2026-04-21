@extends('layouts.app')
@section('title', 'Buat Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#198754,#20c997);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-calendar-plus me-2"></i>Buat Reservasi</h3>
                <p class="mb-0 opacity-75">Konsultasikan keluhan kesehatan Anda dengan dokter spesialis</p>
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
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>Pilih jenis penyakit/keluhan Anda. Sistem akan otomatis mencarikan dokter spesialis yang sesuai.
                    </div>
                    <form method="POST" action="{{ route('pasien.reservations.store') }}">
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
                        <button type="submit" class="btn btn-success">Buat Reservasi</button>
                        <a href="{{ route('pasien.reservations.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
(function () {
    const diseaseSelect  = document.getElementById('disease');
    const hint           = document.getElementById('disease-hint');
    const previewWrap    = document.getElementById('doctor-preview');
    const loadingEl      = document.getElementById('doctor-loading');
    const resultEl       = document.getElementById('doctor-result');
    const jadwalInput    = document.getElementById('jadwal');
    const conflictAlert  = document.getElementById('jadwal-conflict');
    const scheduleInfo   = document.getElementById('schedule-info');
    const submitBtn      = document.querySelector('button[type="submit"]');
    const endpoint       = '{{ route('pasien.reservations.doctorsByDisease') }}';
    const slotsEndpoint  = '{{ route('pasien.reservations.bookedSlots') }}';

    let recommendedDoctorId   = null;
    let lastFetchedDate       = null;
    let lastBookedHours       = [];

    function fetchAndShowSlots(date, selectedHour) {
        if (!recommendedDoctorId) return;

        fetch(`${slotsEndpoint}?doctor_id=${recommendedDoctorId}&date=${date}`)
            .then(r => r.json())
            .then(data => {
                lastBookedHours = data.booked_hours || [];

                // Conflict check
                if (selectedHour !== null && lastBookedHours.includes(selectedHour)) {
                    conflictAlert.style.display = 'block';
                    jadwalInput.classList.add('is-invalid');
                    submitBtn.disabled = true;
                } else {
                    conflictAlert.style.display = 'none';
                    jadwalInput.classList.remove('is-invalid');
                    submitBtn.disabled = false;
                }

                // Show schedule panel
                if (lastBookedHours.length === 0) {
                    scheduleInfo.style.display = 'block';
                    scheduleInfo.innerHTML = `
                        <div class="alert alert-success py-2 small mb-0">
                            <i class="fas fa-calendar-check me-1"></i>
                            Tidak ada jadwal yang sudah dipesan pada tanggal ini. Semua jam tersedia.
                        </div>`;
                } else {
                    const slots = lastBookedHours
                        .sort()
                        .map(h => `<span class="badge bg-danger me-1">${h}:00</span>`)
                        .join('');
                    scheduleInfo.style.display = 'block';
                    scheduleInfo.innerHTML = `
                        <div class="card border-warning">
                            <div class="card-body py-2 px-3">
                                <div class="fw-semibold small mb-1">
                                    <i class="fas fa-clock text-warning me-1"></i>
                                    Jam sudah terisi pada tanggal ini:
                                </div>
                                <div>${slots}</div>
                                <div class="text-muted small mt-1">Pilih jam selain di atas agar reservasi dapat dibuat.</div>
                            </div>
                        </div>`;
                }
            })
            .catch(() => {
                // silently ignore, backend will validate
            });
    }

    // Check booked slots whenever jadwal changes
    jadwalInput.addEventListener('change', function () {
        if (!recommendedDoctorId || !this.value) return;

        const dt   = new Date(this.value);
        const date = dt.toISOString().slice(0, 10);
        const hour = String(dt.getHours()).padStart(2, '0');

        fetchAndShowSlots(date, hour);
    });

    diseaseSelect.addEventListener('change', function () {
        // Reset conflict state on disease change
        conflictAlert.style.display = 'none';
        scheduleInfo.style.display  = 'none';
        scheduleInfo.innerHTML      = '';
        jadwalInput.classList.remove('is-invalid');
        submitBtn.disabled = false;
        recommendedDoctorId = null;
        lastBookedHours     = [];
        const disease = this.value;
        if (!disease) return;

        hint.textContent = 'Mencari dokter spesialis yang tersedia...';
        previewWrap.style.display = 'block';
        loadingEl.style.display   = 'block';
        resultEl.innerHTML        = '';

        fetch(`${endpoint}?disease=${encodeURIComponent(disease)}`)
            .then(r => r.json())
            .then(data => {
                loadingEl.style.display = 'none';

                if (!data.doctors || data.doctors.length === 0) {
                    resultEl.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Belum ada dokter spesialis <strong>${data.specialization || disease}</strong> yang tersedia.
                            Reservasi tetap bisa dibuat dan akan diproses oleh admin.
                        </div>`;
                    hint.textContent = 'Dokter spesialis belum tersedia, reservasi akan diproses admin.';
                    return;
                }

                const best = data.doctors[0];
                recommendedDoctorId = best.id;
                hint.textContent = `Ditemukan ${data.doctors.length} dokter spesialis ${data.specialization}.`;

                // If jadwal already filled (old input), fetch slots right away
                if (jadwalInput.value) {
                    const dt   = new Date(jadwalInput.value);
                    const date = dt.toISOString().slice(0, 10);
                    const hour = String(dt.getHours()).padStart(2, '0');
                    fetchAndShowSlots(date, hour);
                }

                let cards = data.doctors.map((d, i) => {
                    const avatar = d.photo
                        ? `<img src="${d.photo}" class="rounded-circle me-3" width="52" height="52" style="object-fit:cover;" alt="${d.name}">`
                        : `<div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width:52px;height:52px;font-size:1.3rem;font-weight:600;">${d.name.charAt(0)}</div>`;
                    const badge = i === 0
                        ? `<span class="badge bg-success ms-2">Rekomendasi</span>`
                        : '';
                    const busyText = d.pending_count > 0
                        ? `<small class="text-muted">${d.pending_count} reservasi pending</small>`
                        : `<small class="text-success"><i class="fas fa-check-circle me-1"></i>Tersedia sekarang</small>`;
                    return `
                        <div class="d-flex align-items-center p-3 ${i === 0 ? 'border-success border' : 'border-top'} ${i === 0 ? 'bg-light' : ''}">
                            ${avatar}
                            <div class="flex-grow-1">
                                <div class="fw-semibold">${d.name}${badge}</div>
                                <div class="text-muted small">${d.specialization}</div>
                                ${d.experience ? `<div class="text-muted small">${d.experience}</div>` : ''}
                                ${busyText}
                            </div>
                        </div>`;
                }).join('');

                resultEl.innerHTML = `
                    <div class="card border-success">
                        <div class="card-header bg-success text-white py-2">
                            <i class="fas fa-user-md me-2"></i>
                            Dokter Spesialis <strong>${data.specialization}</strong> yang Tersedia
                        </div>
                        ${cards}
                        <div class="card-footer text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Sistem akan otomatis memilih dokter dengan antrian paling sedikit saat Anda submit.
                        </div>
                    </div>`;
            })
            .catch(() => {
                loadingEl.style.display = 'none';
                resultEl.innerHTML = `<div class="alert alert-danger">Gagal memuat data dokter. Silakan coba lagi.</div>`;
            });
    });

    // Trigger on page load if old value exists (validation fail)
    if (diseaseSelect.value) diseaseSelect.dispatchEvent(new Event('change'));
})();
</script>
@endpush
@endsection
 