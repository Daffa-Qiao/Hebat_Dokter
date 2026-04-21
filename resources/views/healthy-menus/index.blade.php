@extends('layouts.app')
@section('title', 'Menu Makanan Sehat')
@include('layouts.navbars.dashboardnav')
@section('content')

<div class="container py-5" style="background-color: white;">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="text-center" style="color: green;">Menu Makanan Sehat</h2>
            <p class="text-muted">Pilihan menu sehat yang dikelola oleh admin dan dokter sesuai spesialisasi.</p>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.healthy-menus.index') }}" class="btn btn-success btn-sm me-2">Kelola Menu Sehat</a>
                @elseif(auth()->user()->role === 'dokter')
                    <a href="{{ route('dokter.healthy-menus.index') }}" class="btn btn-success btn-sm me-2">Kelola Menu Spesialis Anda</a>
                @endif
                <a href="{{ route('calories.index') }}" class="btn btn-outline-success btn-sm">Hitung Kalori</a>
            @else
                <a href="{{ route('calories.index') }}" class="btn btn-success btn-sm me-2">Hitung Kalori</a>
            @endauth
        </div>
    </div>

    @if(isset($specialization) && $specialization)
        <div class="row mb-4">
            <div class="col-12 text-center">
                <span class="badge bg-info text-dark">Filter: {{ $specialization }}</span>
                <a href="{{ route('healthy-menus.index') }}" class="btn btn-sm btn-outline-secondary ms-2">Hapus Filter</a>
            </div>
        </div>
    @elseif(isset($disease) && $disease)
        <div class="row mb-3">
            <div class="col-12 text-center">
                <span class="badge bg-success">Menu diprioritaskan untuk: {{ $disease }}</span>
                <p class="text-muted small mt-1 mb-0">Menu dengan spesialisasi sesuai kondisi Anda ditampilkan lebih awal, diikuti menu umum dan lainnya.</p>
            </div>
        </div>
    @endif

    <div class="row g-4">
        @forelse($menus as $menu)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : asset('img/logo.png') }}"
                         class="card-img-top"
                         alt="{{ $menu->title }}"
                         style="height:200px;object-fit:cover;"
                         onerror="this.onerror=null;this.src='{{ asset('img/logo.png') }}' ">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $menu->title }}</h5>
                        <p class="text-muted mb-2">{{ $menu->category ?? 'Umum' }}</p>
                        <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($menu->description, 110, '...') }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-success">{{ $menu->calories ? $menu->calories . ' kkal' : 'Kalori belum diatur' }}</span>
                            <span class="badge bg-secondary">{{ $menu->specialization ?? 'Umum' }}</span>
                        </div>
                        @if($menu->doctor)
                            <p class="text-muted small mt-2 mb-0">Disiapkan oleh Dr. {{ $menu->doctor->name }}</p>
                        @endif
                        <a href="{{ route('healthy-menus.show', $menu->id) }}" class="btn btn-outline-success btn-sm mt-3">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm p-5 text-center">
                    <h5 class="mb-0">Belum ada menu sehat tersedia saat ini.</h5>
                    <p class="text-muted">Silakan kembali lagi nanti atau hubungi admin.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm" style="border-left: 5px solid green;">
                <div class="card-body">
                    <h4 style="color: green;">Tips Memilih Makanan Sehat:</h4>
                    <ul class="mb-0">
                        <li>Perhatikan kandungan nutrisi pada label makanan</li>
                        <li>Pilih makanan dengan bahan-bahan alami</li>
                        <li>Hindari makanan dengan pengawet berlebihan</li>
                        <li>Perhatikan tanggal kedaluwarsa</li>
                        <li>Pilih penjual dengan reputasi dan ulasan baik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn-success {
        background-color: green;
        border-color: green;
    }
    .btn-success:hover {
        background-color: darkgreen;
        border-color: darkgreen;
    }
</style>
@endpush
@endsection





