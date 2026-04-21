@extends('layouts.app')
@section('title', 'Manajemen Akun')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container py-5">
    <div class="rounded-3 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-users-cog me-2"></i>Manajemen Akun</h3>
                <p class="mb-0 opacity-75">Kelola semua akun pengguna: admin, dokter, dan pasien</p>
            </div>
            <button type="button" class="btn btn-light fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-plus me-1"></i>Tambah User
            </button>
        </div>
    </div>
    <div class="card shadow-sm border-0" style="border-top:4px solid #ffc107;">
        <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
                                @if(request('role'))<input type="hidden" name="role" value="{{ request('role') }}">@endif
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama atau email..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-outline-primary text-nowrap"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <div class="col-6 col-md-3">
                            <form method="GET" action="{{ route('admin.users.index') }}">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select name="role" class="form-select" onchange="this.form.submit()">
                                    <option value="">Semua Role</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                    <option value="pasien" {{ request('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                                </select>
                            </form>
                        </div>
                        @if(request('search') || request('role'))
                        <div class="col-6 col-md-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th>Role</th>
                                    <th class="d-none d-sm-table-cell">Dibuat</th>
                                    <th class="text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                            <br><small class="text-muted d-md-none">{{ $user->email }}</small>
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                        <td>
                                            @php
                                                $rc = match($user->role) { 'admin'=>'danger','dokter'=>'warning text-dark',default=>'info text-dark' };
                                            @endphp
                                            <span class="badge bg-{{ $rc }}">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td class="d-none d-sm-table-cell text-nowrap">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="text-nowrap">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit-user" title="Edit"
                                                data-action="{{ route('admin.users.update', $user) }}"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ e($user->name) }}"
                                                data-email="{{ e($user->email) }}"
                                                data-role="{{ $user->role }}"
                                                data-specialization="{{ e($user->specialization) }}"
                                                data-experience="{{ e($user->experience) }}"
                                                data-bio="{{ e($user->bio) }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($user->id !== auth()->id())
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-swal-delete" title="Hapus"
                                                    data-action="{{ route('admin.users.destroy', $user) }}"
                                                    data-name="{{ e($user->name) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Akun Anda">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada data user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
        </div>
    </div>
</div>

<form id="formDeleteUser" method="POST" action="" style="display:none;">@csrf @method('DELETE')</form>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}" id="createUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="modal_name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="modal_email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_role" class="form-label">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="modal_role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                    <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_specialization" class="form-label">Spesialisasi (Dokter)</label>
                                <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                                       id="modal_specialization" name="specialization" value="{{ old('specialization') }}">
                                @error('specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_experience" class="form-label">Pengalaman (misal 10 tahun)</label>
                                <input type="text" class="form-control @error('experience') is-invalid @enderror"
                                       id="modal_experience" name="experience" value="{{ old('experience') }}">
                                @error('experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modal_password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="modal_password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modal_password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                               id="modal_password_confirmation" name="password_confirmation" required>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-dark" style="background:linear-gradient(135deg,#ffc107,#ff8f00);">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-edit me-2"></i>Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="editUserForm">
                @csrf @method('PUT')
                <input type="hidden" name="edit_action" id="editUserAction" value="{{ old('edit_action') }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" id="edit_user_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="edit_user_email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" id="edit_user_role" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="dokter">Dokter</option>
                                <option value="pasien">Pasien</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Spesialisasi <span class="text-muted fw-normal">(opsional)</span></label>
                            <input type="text" name="specialization" id="edit_user_spec" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pengalaman <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="text" name="experience" id="edit_user_exp" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bio <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="bio" id="edit_user_bio" class="form-control" rows="3"></textarea>
                    </div>
                    <hr>
                    <p class="text-muted small"><i class="fas fa-info-circle me-1"></i>Kosongkan password jika tidak ingin mengubah.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const createUserModal = document.getElementById('createUserModal');
    const createUserForm = document.getElementById('createUserForm');

    createUserModal.addEventListener('hidden.bs.modal', function () {
        createUserForm.reset();
        createUserForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    });

    @if($errors->any())
    const _ea = @json(old('edit_action'));
    if (_ea) {
        document.getElementById('editUserForm').action = _ea;
        new bootstrap.Modal(document.getElementById('editUserModal')).show();
    } else {
        new bootstrap.Modal(createUserModal).show();
    }
    @endif

    document.querySelectorAll('.btn-edit-user').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('editUserForm');
            form.action = this.dataset.action;
            document.getElementById('editUserAction').value  = this.dataset.action;
            document.getElementById('edit_user_name').value  = this.dataset.name;
            document.getElementById('edit_user_email').value = this.dataset.email;
            document.getElementById('edit_user_spec').value  = this.dataset.specialization;
            document.getElementById('edit_user_exp').value   = this.dataset.experience;
            document.getElementById('edit_user_bio').value   = this.dataset.bio;
            const role = document.getElementById('edit_user_role');
            for (let opt of role.options) { opt.selected = opt.value === this.dataset.role; }
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        });
    });
});
</script>

@push('js')
<script>
document.querySelectorAll('.btn-swal-delete').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const action = this.dataset.action, name = this.dataset.name;
        Swal.fire({
            title: 'Hapus Akun?',
            html: `Akun <strong>"${name}"</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, hapus!',
            cancelButtonText: 'Batal', reverseButtons: true,
        }).then(function (r) {
            if (r.isConfirmed) { const f = document.getElementById('formDeleteUser'); f.action = action; f.submit(); }
        });
    });
});
</script>
@endpush

@endsection