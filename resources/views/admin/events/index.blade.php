@extends('layouts.app')
@section('title', 'Manajemen Event')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-calendar-alt me-2"></i>Manajemen Event</h3>
                <p class="mb-0 opacity-75">Kelola semua event kesehatan yang tersedia</p>
            </div>
            <button class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createEventModal">
                <i class="fas fa-plus me-1"></i>Tambah Event
            </button>
        </div>
    </div>
    <div class="card shadow-sm border-0" style="border-top:4px solid #ffc107;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th class="d-none d-sm-table-cell">Tanggal</th>
                            <th class="d-none d-md-table-cell">Waktu</th>
                            <th class="d-none d-md-table-cell">Lokasi</th>
                            <th class="text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $index => $event)
                            <tr>
                                <td>{{ $events->firstItem() + $index }}</td>
                                <td>{{ $event->title }}</td>
                                <td class="d-none d-sm-table-cell text-nowrap">{{ $event->date->format('d/m/Y') }}</td>
                                <td class="d-none d-md-table-cell">{{ $event->time ? substr($event->time, 0, 5) : '-' }}</td>
                                <td class="d-none d-md-table-cell">{{ $event->location ?? '-' }}</td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-event" title="Edit"
                                        data-action="{{ route('admin.events.update', $event) }}"
                                        data-id="{{ $event->id }}"
                                        data-title="{{ e($event->title) }}"
                                        data-date="{{ $event->date->format('Y-m-d') }}"
                                        data-time="{{ $event->time ? substr($event->time, 0, 5) : '' }}"
                                        data-location="{{ e($event->location) }}"
                                        data-description="{{ e($event->description) }}"
                                        data-image="{{ $event->image ? asset('storage/'.$event->image) : '' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-swal-delete" title="Hapus"
                                        data-action="{{ route('admin.events.destroy', $event) }}"
                                        data-name="{{ e($event->title) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada event yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center p-3">{{ $events->links() }}</div>
        </div>
    </div>
</div>

<form id="formDeleteEvent" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

{{-- ===== MODAL TAMBAH EVENT ===== --}}
<div class="modal fade" id="createEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-calendar-plus me-2"></i>Tambah Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" id="createEventForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Event</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Waktu <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="time" name="time" class="form-control" value="{{ old('time') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Event <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold px-4"><i class="fas fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT EVENT ===== --}}
<div class="modal fade" id="editEventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="editEventForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editEventAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Event</label>
                        <input type="text" name="title" id="edit_event_title" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="date" id="edit_event_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Waktu</label>
                            <input type="time" name="time" id="edit_event_time" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi</label>
                        <input type="text" name="location" id="edit_event_location" class="form-control">
                    </div>
                    <div class="mb-3" id="editEventImageWrap">
                        <label class="form-label fw-semibold">Foto Saat Ini</label>
                        <div id="editEventImagePreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Foto <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" id="edit_event_description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold px-4"><i class="fas fa-save me-1"></i>Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
(function () {
    @if($errors->any())
    const _ea = @json(old('edit_action'));
    if (_ea) { document.getElementById('editEventForm').action = _ea; new bootstrap.Modal(document.getElementById('editEventModal')).show(); }
    else { new bootstrap.Modal(document.getElementById('createEventModal')).show(); }
    @endif

    document.getElementById('createEventModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('createEventForm').reset();
    });

    document.querySelectorAll('.btn-edit-event').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editEventForm');
            form.action = this.dataset.action;
            document.getElementById('editEventAction').value       = this.dataset.action;
            document.getElementById('edit_event_title').value      = this.dataset.title;
            document.getElementById('edit_event_date').value       = this.dataset.date;
            document.getElementById('edit_event_time').value       = this.dataset.time;
            document.getElementById('edit_event_location').value   = this.dataset.location;
            document.getElementById('edit_event_description').value = this.dataset.description;
            const wrap = document.getElementById('editEventImageWrap');
            const prev = document.getElementById('editEventImagePreview');
            if (this.dataset.image) {
                prev.innerHTML = `<img src="${this.dataset.image}" style="height:80px;border-radius:6px;margin-bottom:6px;" onerror="this.style.display='none'">`;
                wrap.style.display = 'block';
            } else { wrap.style.display = 'none'; }
            new bootstrap.Modal(document.getElementById('editEventModal')).show();
        });
    });

    document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const action = this.dataset.action, name = this.dataset.name;
            Swal.fire({
                title: 'Hapus Event?',
                html: `Event <strong>"${name}"</strong> akan dihapus permanen.`,
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
                cancelButtonText: 'Batal', reverseButtons: true,
            }).then(function (r) {
                if (r.isConfirmed) { const f = document.getElementById('formDeleteEvent'); f.action = action; f.submit(); }
            });
        });
    });
})();
</script>
@endpush
</div>
@push('js')
<script>
document.querySelectorAll('.btn-swal-delete').forEach(function(btn) {
    btn.addEventListener('click', function() {
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
        }).then(function(result) {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
@endsection
