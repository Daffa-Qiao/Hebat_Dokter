@extends('layouts.app')
@section('title', 'Manajemen Menu Sehat')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manajemen Menu Sehat</h4>
                    <a href="{{ route('admin.healthy-menus.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Menu Sehat
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Spesialisasi</th>
                                    <th>Kalori</th>
                                    <th>Dokter</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menus as $index => $menu)
                                    <tr>
                                        <td>{{ $menus->firstItem() + $index }}</td>
                                        <td>{{ $menu->title }}</td>
                                        <td>{{ $menu->specialization ?? 'Umum' }}</td>
                                        <td>{{ $menu->calories ? $menu->calories . ' kkal' : '-' }}</td>
                                        <td>{{ $menu->doctor->name ?? 'Admin' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.healthy-menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.healthy-menus.destroy', $menu) }}" class="delete-menu-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada menu sehat yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $menus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
