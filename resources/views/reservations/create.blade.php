@extends('layouts.app')
@section('title', 'Buat Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">Buat Reservasi</div>
                <div class="card-body">
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
                            <input type="datetime-local" name="jadwal" id="jadwal" class="form-control @error('jadwal') is-invalid @enderror" required>
                            @error('jadwal')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
    const diseaseSelect = document.getElementById('disease');
    const hint          = document.getElementById('disease-hint');
    const previewWrap   = document.getElementById('doctor-preview');
    const loadingEl     = document.getElementById('doctor-loading');
    const resultEl      = document.getElementById('doctor-result');
    const endpoint      = '{{ route('pasien.reservations.doctorsByDisease') }}';

    diseaseSelect.addEventListener('change', function () {
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
                hint.textContent = `Ditemukan ${data.doctors.length} dokter spesialis ${data.specialization}.`;

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
 