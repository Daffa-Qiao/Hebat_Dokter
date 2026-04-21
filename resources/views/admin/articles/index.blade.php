@extends('layouts.app')
@section('title', 'Kelola Artikel')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-newspaper me-2"></i>Manajemen Artikel</h3>
                <p class="mb-0 opacity-75">Kelola semua artikel kesehatan yang dipublikasikan</p>
            </div>
            <button class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createArticleModal">
                <i class="fas fa-plus me-1"></i>Tambah Artikel
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="card border-0 shadow-sm" style="border-top:4px solid #ffc107;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th class="d-none d-md-table-cell">Spesialisasi</th>
                        <th class="d-none d-lg-table-cell">Penulis</th>
                        <th>Status</th>
                        <th class="d-none d-sm-table-cell">Tanggal</th>
                        <th class="text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($article->title, 45) }}</td>
                            <td class="d-none d-md-table-cell">{{ $article->specialization ?? 'Umum' }}</td>
                            <td class="d-none d-lg-table-cell">{{ $article->author->name ?? '-' }}</td>
                            <td>
                                @if($article->published)
                                    <span class="badge bg-success">Publish</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">{{ $article->created_at->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-warning btn-edit-article" title="Edit"
                                    data-action="{{ route('admin.articles.update', $article) }}"
                                    data-id="{{ $article->id }}"
                                    data-title="{{ e($article->title) }}"
                                    data-specialization="{{ $article->specialization }}"
                                    data-content="{{ e($article->content) }}"
                                    data-published="{{ $article->published ? '1' : '0' }}"
                                    data-thumbnail="{{ $article->thumbnail ? asset('storage/'.$article->thumbnail) : '' }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-swal-delete" title="Hapus"
                                    data-action="{{ route('admin.articles.destroy', $article) }}"
                                    data-name="{{ e($article->title) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada artikel.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Hidden delete form --}}
<form id="formDeleteArticle" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

{{-- ===== MODAL TAMBAH ARTIKEL ===== --}}
<div class="modal fade" id="createArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-pen-nib me-2"></i>Tambah Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" id="createArticleForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Artikel</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Spesialisasi</label>
                        <select name="specialization" class="form-select">
                            <option value="">-- Umum (semua spesialisasi) --</option>
                            @foreach(['Jantung','Pencernaan','Ginjal','Paru-paru','Saraf','Kulit','Anak','Gigi','Mata','Ortopedi','Umum'] as $spec)
                                <option value="{{ $spec }}" {{ old('specialization') === $spec ? 'selected' : '' }}>{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Artikel</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="8" required>{{ old('content') }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="published" id="create_article_published" value="1" checked>
                        <label class="form-check-label fw-semibold" for="create_article_published">Publish Artikel</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold px-4">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT ARTIKEL ===== --}}
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="editArticleForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editArticleAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Artikel</label>
                        <input type="text" name="title" id="edit_article_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Spesialisasi</label>
                        <select name="specialization" id="edit_article_spec" class="form-select">
                            <option value="">-- Umum (semua spesialisasi) --</option>
                            @foreach(['Jantung','Pencernaan','Ginjal','Paru-paru','Saraf','Kulit','Anak','Gigi','Mata','Ortopedi','Umum'] as $spec)
                                <option value="{{ $spec }}">{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="editArticleThumbnailWrap">
                        <label class="form-label fw-semibold">Thumbnail Saat Ini</label>
                        <div id="editArticleThumbnailPreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Thumbnail <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Artikel</label>
                        <textarea name="content" id="edit_article_content" class="form-control" rows="8" required></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="published" id="edit_article_published" value="1">
                        <label class="form-check-label fw-semibold" for="edit_article_published">Publish Artikel</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold px-4">
                        <i class="fas fa-save me-1"></i>Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
(function () {
    @if($errors->any())
    const _editAction = @json(old('edit_action'));
    if (_editAction) {
        document.getElementById('editArticleForm').action = _editAction;
        new bootstrap.Modal(document.getElementById('editArticleModal')).show();
    } else {
        new bootstrap.Modal(document.getElementById('createArticleModal')).show();
    }
    @endif

    document.getElementById('createArticleModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('createArticleForm').reset();
    });

    document.querySelectorAll('.btn-edit-article').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editArticleForm');
            form.action = this.dataset.action;
            document.getElementById('editArticleAction').value      = this.dataset.action;
            document.getElementById('edit_article_title').value     = this.dataset.title;
            document.getElementById('edit_article_content').value   = this.dataset.content;
            document.getElementById('edit_article_published').checked = this.dataset.published === '1';
            const spec = document.getElementById('edit_article_spec');
            for (let o of spec.options) o.selected = o.value === this.dataset.specialization;
            const wrap = document.getElementById('editArticleThumbnailWrap');
            const prev = document.getElementById('editArticleThumbnailPreview');
            if (this.dataset.thumbnail) {
                prev.innerHTML = `<img src="${this.dataset.thumbnail}" style="height:80px;border-radius:6px;margin-bottom:6px;" onerror="this.style.display='none'">`;
                wrap.style.display = 'block';
            } else {
                wrap.style.display = 'none';
            }
            new bootstrap.Modal(document.getElementById('editArticleModal')).show();
        });
    });

    document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const action = this.dataset.action;
            const name   = this.dataset.name;
            Swal.fire({
                title: 'Hapus Artikel?',
                html: `Artikel <strong>"${name}"</strong> akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then(function (result) {
                if (result.isConfirmed) {
                    const f = document.getElementById('formDeleteArticle');
                    f.action = action;
                    f.submit();
                }
            });
        });
    });
})();
</script>
@endpush
@endsection
