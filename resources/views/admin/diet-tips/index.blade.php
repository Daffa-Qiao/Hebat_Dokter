@extends('layouts.app')
@section('title', 'Manajemen Tips Diet')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-apple-alt me-2"></i>Manajemen Tips Diet</h3>
                <p class="mb-0 opacity-75">Kelola semua tips dan panduan diet sehat</p>
            </div>
            <button class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createDietTipModal">
                <i class="fas fa-plus me-1"></i>Tambah Tips Diet
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
                            <th class="d-none d-md-table-cell">Video</th>
                            <th class="d-none d-lg-table-cell">Deskripsi</th>
                            <th class="text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dietTips as $index => $tip)
                            <tr>
                                <td>{{ $dietTips->firstItem() + $index }}</td>
                                <td>{{ $tip->title }}</td>
                                <td class="d-none d-md-table-cell">
                                    @if($tip->video_url)
                                        <span class="badge bg-success"><i class="fas fa-play me-1"></i>Ada</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="d-none d-lg-table-cell text-muted small">{{ \Illuminate\Support\Str::limit($tip->description, 70) }}</td>
                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit-diet" title="Edit"
                                        data-action="{{ route('admin.diet-tips.update', $tip) }}"
                                        data-id="{{ $tip->id }}"
                                        data-title="{{ e($tip->title) }}"
                                        data-video_url="{{ e($tip->video_url) }}"
                                        data-source_url="{{ e($tip->source_url) }}"
                                        data-description="{{ e($tip->description) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-swal-delete" title="Hapus"
                                        data-action="{{ route('admin.diet-tips.destroy', $tip) }}"
                                        data-name="{{ e($tip->title) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada tips diet yang dibuat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center p-3">{{ $dietTips->links() }}</div>
        </div>
    </div>
</div>

<form id="formDeleteDiet" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

{{-- ===== MODAL TAMBAH TIPS DIET ===== --}}
<div class="modal fade" id="createDietTipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-apple-alt me-2"></i>Tambah Tips Diet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.diet-tips.store') }}" id="createDietForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Tips</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Video <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="url" name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://youtube.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Sumber <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="url" name="source_url" class="form-control" value="{{ old('source_url') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
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

{{-- ===== MODAL EDIT TIPS DIET ===== --}}
<div class="modal fade" id="editDietTipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Tips Diet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="editDietForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editDietAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Tips</label>
                        <input type="text" name="title" id="edit_diet_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Video <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="url" name="video_url" id="edit_diet_video" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Sumber <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="url" name="source_url" id="edit_diet_source" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" id="edit_diet_desc" class="form-control" rows="5"></textarea>
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
    if (_ea) { document.getElementById('editDietForm').action = _ea; new bootstrap.Modal(document.getElementById('editDietTipModal')).show(); }
    else { new bootstrap.Modal(document.getElementById('createDietTipModal')).show(); }
    @endif

    document.getElementById('createDietTipModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('createDietForm').reset();
    });

    document.querySelectorAll('.btn-edit-diet').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editDietForm');
            form.action = this.dataset.action;
            document.getElementById('editDietAction').value   = this.dataset.action;
            document.getElementById('edit_diet_title').value  = this.dataset.title;
            document.getElementById('edit_diet_video').value  = this.dataset.video_url;
            document.getElementById('edit_diet_source').value = this.dataset.source_url;
            document.getElementById('edit_diet_desc').value   = this.dataset.description;
            new bootstrap.Modal(document.getElementById('editDietTipModal')).show();
        });
    });

    document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const action = this.dataset.action, name = this.dataset.name;
            Swal.fire({
                title: 'Hapus Tips Diet?',
                html: `Tips <strong>"${name}"</strong> akan dihapus permanen.`,
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
                cancelButtonText: 'Batal', reverseButtons: true,
            }).then(function (r) {
                if (r.isConfirmed) { const f = document.getElementById('formDeleteDiet'); f.action = action; f.submit(); }
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
