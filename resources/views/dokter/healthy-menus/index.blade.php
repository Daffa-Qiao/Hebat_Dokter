@extends('layouts.app')
@section('title', 'Manajemen Menu Sehat Dokter')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-utensils me-2"></i>Menu Sehat Saya</h3>
                <p class="mb-0 opacity-75">Menu makanan sehat berdasarkan spesialisasi Anda</p>
            </div>
            <button class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createDokterMenuModal">
                <i class="fas fa-plus me-1"></i>Tambah Menu Sehat
            </button>
        </div>
    </div>
    <div class="card shadow-sm border-0" style="border-top:4px solid #dc3545;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Kalori</th>
                            <th>Resep</th>
                            <th class="text-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $index => $menu)
                        <tr>
                            <td>{{ $menus->firstItem() + $index }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $menu->category ?? '-' }}</td>
                            <td>{{ $menu->calories ? $menu->calories . ' kkal' : '-' }}</td>
                            <td>{{ $menu->recipe ?? '-' }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-warning btn-edit-dokter-menu" title="Edit"
                                    data-action="{{ route('dokter.healthy-menus.update', $menu) }}"
                                    data-id="{{ $menu->id }}"
                                    data-title="{{ e($menu->title) }}"
                                    data-category="{{ e($menu->category) }}"
                                    data-calories="{{ $menu->calories }}"
                                    data-description="{{ e($menu->description) }}"
                                    data-image="{{ $menu->image ? asset('storage/'.$menu->image) : '' }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger btn-swal-delete" title="Hapus"
                                    data-action="{{ route('dokter.healthy-menus.destroy', $menu) }}"
                                    data-name="{{ e($menu->title) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada menu sehat yang Anda buat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center p-3">{{ $menus->links() }}</div>
        </div>
    </div>
</div>

<form id="formDeleteDokterMenu" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

{{-- ===== MODAL TAMBAH MENU ===== --}}
<div class="modal fade" id="createDokterMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
                <h5 class="modal-title fw-bold"><i class="fas fa-utensils me-2"></i>Tambah Menu Sehat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('dokter.healthy-menus.store') }}" enctype="multipart/form-data" id="createDokterMenuForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Menu</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kalori per Porsi <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="number" name="calories" class="form-control" value="{{ old('calories') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Resep</label>
                        <textarea name="recipe" class="form-control" rows="4">{{ old('recipe') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
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

<div class="modal fade" id="editDokterMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#dc3545,#c62828);">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Menu Sehat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" id="editDokterMenuForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editDokterMenuAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Menu</label>
                        <input type="text" name="title" id="edit_dm_title" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="category" id="edit_dm_category" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kalori per Porsi</label>
                            <input type="number" name="calories" id="edit_dm_calories" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" id="edit_dm_desc" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Resep</label>
                        <textarea name="recipe" id="edit_dm_recipe" class="form-control" rows="4">{{ old('recipe') }}</textarea>
                    </div>
                    <div class="mb-3" id="editDmImageWrap">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div id="editDmImagePreview"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Gambar <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
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

@push('css')
<style>
    #createDokterMenuModal .modal-body,
    #editDokterMenuModal .modal-body {
        overflow-y: auto !important;
        max-height: 65vh !important;
    }
    #createDokterMenuModal .modal-dialog,
    #editDokterMenuModal .modal-dialog {
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    #createDokterMenuModal .modal-content,
    #editDokterMenuModal .modal-content {
        max-height: 90vh;
        overflow: hidden;
    }
</style>
@endpush

@push('js')
<script>
    (function() {
        @if($errors -> any())
        const _ea = @json(old('edit_action'));
        if (_ea) {
            document.getElementById('editDokterMenuForm').action = _ea;
            new bootstrap.Modal(document.getElementById('editDokterMenuModal')).show();
        } else {
            new bootstrap.Modal(document.getElementById('createDokterMenuModal')).show();
        }
        @endif

        document.getElementById('createDokterMenuModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('createDokterMenuForm').reset();
        });

        document.querySelectorAll('.btn-edit-dokter-menu').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const form = document.getElementById('editDokterMenuForm');
                form.action = this.dataset.action;
                document.getElementById('editDokterMenuAction').value = this.dataset.action;
                document.getElementById('edit_dm_title').value = this.dataset.title;
                document.getElementById('edit_dm_category').value = this.dataset.category;
                document.getElementById('edit_dm_calories').value = this.dataset.calories;
                document.getElementById('edit_dm_desc').value = this.dataset.description;
                const wrap = document.getElementById('editDmImageWrap');
                const prev = document.getElementById('editDmImagePreview');
                if (this.dataset.image) {
                    prev.innerHTML = `<img src="${this.dataset.image}" style="height:80px;border-radius:6px;margin-bottom:6px;" onerror="this.style.display='none'">`;
                    wrap.style.display = 'block';
                } else {
                    wrap.style.display = 'none';
                }
                new bootstrap.Modal(document.getElementById('editDokterMenuModal')).show();
            });
        });

        document.querySelectorAll('.btn-swal-delete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const action = this.dataset.action,
                    name = this.dataset.name;
                Swal.fire({
                    title: 'Hapus Menu Sehat?',
                    html: `Menu <strong>"${name}"</strong> akan dihapus permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then(function(r) {
                    if (r.isConfirmed) {
                        const f = document.getElementById('formDeleteDokterMenu');
                        f.action = action;
                        f.submit();
                    }
                });
            });
        });
    })();
</script>
@endpush

</div>
@push('js')
<script>
    document.querySelectorAll('.delete-menu-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus menu sehat?',
                text: 'Menu yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection