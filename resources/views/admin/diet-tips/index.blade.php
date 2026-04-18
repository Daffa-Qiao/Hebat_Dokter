@extends('layouts.app')
@section('title', 'Manajemen Tips Diet')

@section('content')
@include('layouts.navbars.dashboardnav')
@include('components.alert')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manajemen Tips Diet</h4>
                    <a href="{{ route('admin.diet-tips.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Tips Diet
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Video</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dietTips as $index => $tip)
                                    <tr>
                                        <td>{{ $dietTips->firstItem() + $index }}</td>
                                        <td>{{ $tip->title }}</td>
                                        <td>{{ $tip->video_url ? 'Ada' : 'Tidak ada' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($tip->description, 80) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.diet-tips.edit', $tip) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.diet-tips.destroy', $tip) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tips diet ini?')">
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
                                        <td colspan="5" class="text-center">Belum ada tips diet yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $dietTips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
