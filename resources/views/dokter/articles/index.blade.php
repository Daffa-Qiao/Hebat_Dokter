@extends('layouts.app')
@section('title', 'Artikel Saya')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-newspaper me-2"></i>Artikel Saya</h3>
                <p class="mb-0 opacity-75">Spesialisasi: {{ auth()->user()->specialization ?? 'Umum' }}</p>
            </div>
            <button class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createDokterArticleModal">
                <i class="fas fa-plus me-1"></i>Tulis Artikel
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">
        @forelse($articles as $article)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top" style="height:180px;object-fit:cover;" alt=""
                             onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}'">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-success">{{ $article->specialization ?? 'Umum' }}</span>
                            @if($article->published)
                                <span class="badge bg-primary">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="text-muted small">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-warning flex-grow-1 btn-edit-dokter-article"
                            data-action="{{ route('dokter.articles.update', $article) }}"
                            data-id="{{ $article->id }}"
                            data-title="{{ e($article->title) }}"
                            data-content="{{ e($article->content) }}"
                            data-published="{{ $article->published ? '1' : '0' }}"
                            data-thumbnail="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : '' }}">
                            <i class="fas fa-edit me-1"></i>Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger flex-grow-1 btn-swal-delete"
                            data-action="{{ route('dokter.articles.destroy', $article) }}"
                            data-name="{{ e($article->title) }}">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="fas fa-newspaper text-muted mb-3" style="font-size:3rem;"></i>
                    <h5>Belum ada artikel.</h5>
                    <button class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#createDokterArticleModal">Tulis Artikel Pertama</button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<form id="formDeleteDokterArticle" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

{{-- ===== MODAL TULIS ARTIKEL ===== --}}
<div class="modal fade" id="createDokterArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
                <h5 class="modal-title fw-bold"><i class="fas fa-pen-nib me-2"></i>Tulis Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('dokter.articles.store') }}" enctype="multipart/form-data" id="createDokterArticleForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info py-2"><i class="fas fa-info-circle me-1"></i>Spesialisasi artikel mengikuti profil Anda: <strong>{{ auth()->user()->specialization ?? 'Umum' }}</strong></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Artikel</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Artikel</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="8" required>{{ old('content') }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="published" id="create_da_published" value="1" {{ old('published', true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="create_da_published">Publish Artikel</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4"><i class="fas fa-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT ARTIKEL ===== --}}
<div class="modal fade" id="editDokterArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Artikel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="editDokterArticleForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editDokterArticleAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Artikel</label>
                        <input type="text" name="title" id="edit_da_title" class="form-control" required>
                    </div>
                    <div class="mb-3" id="editDaThumbnailWrap">
                        <label class="form-label fw-semibold">Thumbnail Saat Ini</label>
                        <div id="editDaThumbnailPreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Thumbnail <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Artikel</label>
                        <textarea name="content" id="edit_da_content" class="form-control" rows="8" required></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="published" id="edit_da_published" value="1">
                        <label class="form-check-label fw-semibold" for="edit_da_published">Publish Artikel</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger fw-semibold px-4"><i class="fas fa-save me-1"></i>Perbarui</button>
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
    if (_ea) { document.getElementById('editDokterArticleForm').action = _ea; new bootstrap.Modal(document.getElementById('editDokterArticleModal')).show(); }
    else { new bootstrap.Modal(document.getElementById('createDokterArticleModal')).show(); }
    @endif

    document.getElementById('createDokterArticleModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('createDokterArticleForm').reset();
    });

    document.querySelectorAll('.btn-edit-dokter-article').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editDokterArticleForm');
            form.action = this.dataset.action;
            document.getElementById('editDokterArticleAction').value = this.dataset.action;
            document.getElementById('edit_da_title').value           = this.dataset.title;
            document.getElementById('edit_da_content').value         = this.dataset.content;
            document.getElementById('edit_da_published').checked     = this.dataset.published === '1';
            const wrap = document.getElementById('editDaThumbnailWrap');
            const prev = document.getElementById('editDaThumbnailPreview');
            if (this.dataset.thumbnail) {
                prev.innerHTML = `<img src="${this.dataset.thumbnail}" style="height:80px;border-radius:6px;margin-bottom:6px;" onerror="this.style.display='none'">`;
                wrap.style.display = 'block';
            } else { wrap.style.display = 'none'; }
            new bootstrap.Modal(document.getElementById('editDokterArticleModal')).show();
        });
    });

    document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const action = this.dataset.action, name = this.dataset.name;
            Swal.fire({
                title: 'Hapus Artikel?',
                html: `Artikel <strong>"${name}"</strong> akan dihapus permanen.`,
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
                cancelButtonText: 'Batal', reverseButtons: true,
            }).then(function (r) {
                if (r.isConfirmed) { const f = document.getElementById('formDeleteDokterArticle'); f.action = action; f.submit(); }
            });
        });
    });
})();
</script>
@endpush
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
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