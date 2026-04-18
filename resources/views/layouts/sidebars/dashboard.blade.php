@php
$role = auth()->user()->role;
$roleColor = '';
$roleBtnText = '';

switch ($role) {
    case 'pasien':
        $roleColor = '#28a745'; // Green
        $roleBtnText = '#ffffff'; // White
        break;
    case 'dokter':
        $roleColor = '#ff0000'; // Red
        $roleBtnText = '#ffffff'; // White
        break;
    case 'admin':
        $roleColor = '#ffc107'; // Gray
        $roleBtnText = '#ffffff'; // White
        break;
}

@endphp
<div class="col-xl-3 mb-4">
    <button class="btn btn-outline-secondary d-xl-none w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardSidebar" aria-expanded="false" aria-controls="dashboardSidebar">
        <i class="fas fa-bars me-2"></i>Menu Dashboard
    </button>

    <div class="collapse d-xl-block" id="dashboardSidebar">
        <div class="card shadow-sm border-0">
            <div class="card-header" style="background:{{$roleColor}};">
                <h6 class="mb-0"style="color:{{$roleBtnText}};">Menu Dashboard</h6>
            </div>  
            <div class="list-group list-group-flush">
            <a href="{{ route('dashboard.' . $role) }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.' . $role) ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>

            @if($role === 'pasien')
                <a href="{{ route('pasien.reservations.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('pasien.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i>Reservasi Saya
                </a>
                <a href="{{ route('pasien.reservations.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('pasien.reservations.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i>Buat Reservasi
                </a>
            @elseif($role === 'dokter')
                <a href="{{ route('dokter.reservations.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dokter.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i>Reservasi Masuk
                </a>
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                </a>
                <a href="{{ route('dokter.healthy-menus.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dokter.healthy-menus.*') ? 'active' : '' }}">
                    <i class="fas fa-carrot me-2"></i>Menu Sehat Spesialis
                </a>
                <a href="{{ route('doctors.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-users me-2"></i>Daftar Dokter
                </a>
            @else
                <a href="{{ route('admin.reservations.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i>Reservasi
                </a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i>Pengguna
                </a>
                <a href="{{ route('admin.events.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt me-2"></i>Event
                </a>
                <a href="{{ route('admin.diet-tips.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.diet-tips.*') ? 'active' : '' }}">
                    <i class="fas fa-carrot me-2"></i>Tips Diet
                </a>
                <a href="{{ route('admin.healthy-menus.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.healthy-menus.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils me-2"></i>Menu Sehat
                </a>
            @endif
        </div>
    </div>
</div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar avatar-sm rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:42px; height:42px;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                    <span class="text-muted text-capitalize">{{ auth()->user()->role }}</span>
                </div>
            </div>
            @if($role === 'dokter')
                <hr>
                <p class="text-muted mb-1"><strong>Spesialisasi</strong></p>
                <p class="mb-0">{{ auth()->user()->specialization ?? 'Dokter Umum' }}</p>
            @endif
            <hr>
            <p class="text-muted small mb-0">Akses cepat dashboard dan manajemen fungsi sesuai peran Anda.</p>
        </div>
    </div>
</div>
