@extends('layouts.app')
@section('title', 'Daftar Dokter')
@section('content')
@include('layouts.navbars.dashboardnav')

{{-- Hero Section --}}
<div style="background: linear-gradient(135deg, #1a6b3c 0%, #28a745 100%);">
    <div class="container py-5 text-white">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="text-white-50 mb-1 text-uppercase " style="letter-spacing:.08em;font-size:.85rem;color:white;"><i class="fas fa-stethoscope me-2" style="color:white;"></i>Tim Medis Kami</p>
                <h1 class="display-5 fw-bold mb-2" style="color:white;">Temukan Dokter Terbaik</h1>
                <p class="mb-4" style="opacity:.85;">Pilih dokter umum atau spesialis — konsultasi kesehatan jadi lebih cepat dan aman.</p>
                <form method="GET" action="{{ route('doctors.index') }}">
                    <div class="input-group shadow">
                        <span class="input-group-text bg-white border-0 text-success">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="specialization" value="{{ $specialization }}"
                               class="form-control border-0 py-2"
                               placeholder="Cari spesialisasi: Kardiologi, Ginjal, Kulit…">
                        <button class="btn btn-warning fw-semibold px-4" style="background-color:white;color:#28a745;" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <i class="fas fa-user-md" style="font-size:8rem;color:white;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- Breadcrumb + count --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active">Dokter</li>
                </ol>
            </nav>
            @if($specialization)
                <span class="badge bg-success-subtle text-success border border-success mt-1">
                    <i class="fas fa-filter me-1"></i>Filter: {{ $specialization }}
                    <a href="{{ route('doctors.index') }}" class="text-success ms-1" title="Hapus filter"><i class="fas fa-times"></i></a>
                </span>
            @endif
        </div>
        <span class="text-muted small">{{ $doctors->count() }} dokter ditemukan</span>
    </div>

    @if($doctors->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada dokter yang sesuai</h5>
            <p class="text-muted small">Coba kata kunci lain atau
                <a href="{{ route('doctors.index') }}" class="text-success">lihat semua dokter</a>.
            </p>
        </div>
    @else
        <div class="row g-4">
            @foreach($doctors as $doctor)
                @php $initial = mb_strtoupper(mb_substr($doctor->name, 0, 1)); @endphp
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;">

                        {{-- Coloured top stripe --}}
                        <div style="height:6px;background:linear-gradient(90deg,#28a745,#20c997);"></div>

                        <div class="card-body d-flex flex-column p-4">
                            {{-- Avatar + name --}}
                            <div class="d-flex align-items-center gap-3 mb-3">
                                @if($doctor->photo)
                                    <img src="{{ asset('storage/'.$doctor->photo) }}"
                                         class="rounded-circle flex-shrink-0"
                                         style="width:56px;height:56px;object-fit:cover;"
                                         alt="{{ $doctor->name }}">
                                @else
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width:56px;height:56px;font-size:1.4rem;font-weight:700;">
                                        {{ $initial }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h6 class="fw-bold mb-0 text-truncate">{{ $doctor->name }}</h6>
                                    <span class="badge bg-success-subtle text-success border border-success" style="font-size:.75rem;">
                                        {{ $doctor->specialization ?? 'Dokter Umum' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Bio --}}
                            <p class="text-muted small flex-grow-1 mb-3" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $doctor->bio ?? 'Dokter profesional siap membantu kebutuhan kesehatan Anda dengan layanan konsultasi dan reservasi.' }}
                            </p>

                            {{-- Experience --}}
                            @if($doctor->experience)
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="fas fa-briefcase-medical text-success small"></i>
                                    <span class="small text-muted">{{ $doctor->experience }}</span>
                                </div>
                            @endif

                            {{-- CTA --}}
                            <a href="{{ route('doctors.show', $doctor) }}"
                               class="btn btn-success w-100 mt-auto">
                                <i class="fas fa-user-md me-2"></i>Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
