@php
    $role           = auth()->check() ? auth()->user()->role : null;
    // Primary brand color per role
    $roleColor      = match($role) { 'admin' => '#ffc107', 'dokter' => '#dc3545', 'pasien' => '#198754', default => '#6c757d' };
    // RGB version for box-shadow / rgba() in CSS
    $roleColorRgb   = match($role) { 'admin' => '255,193,7', 'dokter' => '220,53,69', default => '25,135,84' };
    // Text on role-colored backgrounds (yellow needs dark text)
    $roleBtnText    = match($role) { 'admin' => '#000', default => '#fff' };
    // Hover / darker shade
    $roleHover      = match($role) { 'admin' => '#e0a800', 'dokter' => '#bb2d3b', default => '#157347' };
    $roleActive     = match($role) { 'admin' => '#d39e00', 'dokter' => '#b02a37', default => '#146c43' };
    // Light variant (for alerts, subtle backgrounds)
    $roleLightBg    = match($role) { 'admin' => '#fff3cd', 'dokter' => '#f8d7da', default => '#d1e7dd' };
    $roleLightText  = match($role) { 'admin' => '#664d03', 'dokter' => '#842029', default => '#0f5132' };
    $roleLightBorder= match($role) { 'admin' => '#ffecb5', 'dokter' => '#f5c2c7', default => '#badbcc' };
    // Badge class for inline use
    $roleBadge      = match($role) { 'admin' => 'bg-warning text-dark', 'dokter' => 'bg-danger', 'pasien' => 'bg-success', default => 'bg-secondary' };
    $roleLabel      = match($role) { 'admin' => 'Admin', 'dokter' => 'Dokter', 'pasien' => 'Pasien', default => '' };
    $currentUrl     = request()->url();
@endphp

{{-- Role-coloured accent strip --}}
<div style="height:3px;background:{{ $roleColor }};width:100%;"></div>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="Hebat Dokter" height="36" class="rounded-1">
            <span class="fw-bold" style="color:green">Hebat Dokter</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarDashboard" aria-controls="navbarDashboard"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDashboard">
            {{-- Main links --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"
                           href="{{ route('dashboard.' . $role) }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>

                    @if($role === 'pasien')
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('pasien.reservations.*') ? 'active' : '' }}"
                               href="{{ route('pasien.reservations.index') }}">
                                <i class="fas fa-calendar-check me-1"></i>Reservasi Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('doctors.*') ? 'active' : '' }}"
                               href="{{ route('doctors.index') }}">
                                <i class="fas fa-stethoscope me-1"></i>Cari Dokter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('articles.*') ? 'active' : '' }}"
                               href="{{ route('articles.index') }}">
                                <i class="fas fa-newspaper me-1"></i>Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('health-challenge.*') ? 'active' : '' }}"
                               href="{{ route('health-challenge.index') }}">
                                <i class="fas fa-bolt me-1"></i>Tantangan
                            </a>
                        </li>

                    @elseif($role === 'dokter')
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('dokter.reservations.*') ? 'active' : '' }}"
                               href="{{ route('dokter.reservations.index') }}">
                                <i class="fas fa-calendar-alt me-1"></i>Reservasi Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('dokter.articles.*') ? 'active' : '' }}"
                               href="{{ route('dokter.articles.index') }}">
                                <i class="fas fa-newspaper me-1"></i>Artikel Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('dokter.healthy-menus.*') ? 'active' : '' }}"
                               href="{{ route('dokter.healthy-menus.index') }}">
                                <i class="fas fa-carrot me-1"></i>Menu Sehat
                            </a>
                        </li>

                    @elseif($role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}"
                               href="{{ route('admin.reservations.index') }}">
                                <i class="fas fa-calendar-check me-1"></i>Reservasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                               href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-1"></i>Pengguna
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link fw-medium dropdown-toggle
                               {{ request()->routeIs('admin.articles.*','admin.events.*','admin.diet-tips.*','admin.healthy-menus.*') ? 'active' : '' }}"
                               href="#" id="adminContentDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-layer-group me-1"></i>Konten
                            </a>
                            <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="adminContentDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                                       href="{{ route('admin.articles.index') }}">
                                        <i class="fas fa-newspaper me-2 text-primary"></i>Artikel Kesehatan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                                       href="{{ route('admin.events.index') }}">
                                        <i class="fas fa-calendar-alt me-2 text-warning"></i>Event
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.diet-tips.*') ? 'active' : '' }}"
                                       href="{{ route('admin.diet-tips.index') }}">
                                        <i class="fas fa-video me-2 text-danger"></i>Tips Diet
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('admin.healthy-menus.*') ? 'active' : '' }}"
                                       href="{{ route('admin.healthy-menus.index') }}">
                                        <i class="fas fa-carrot me-2 text-success"></i>Menu Sehat
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('doctors.index') }}">
                            <i class="fas fa-stethoscope me-1"></i>Cari Dokter
                        </a>
                    </li>
                @endauth
            </ul>

            {{-- Right: user dropdown --}}
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 fw-medium"
                           href="#" id="navbarUserDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:32px;height:32px;font-size:.85rem;font-weight:700;background:{{ $roleColor }};color:{{ $roleBtnText }};">
                                {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            @if($roleLabel)
                                <span class="badge d-none d-md-inline" style="font-size:.7rem;background:{{ $roleColor }};color:{{ $roleBtnText }};">{{ $roleLabel }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarUserDropdown">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ auth()->user()->email }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('dashboard.' . $role) }}">
                                    <i class="fas fa-tachometer-alt me-2 text-muted"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2 text-muted"></i>Ubah Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item py-2 text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@once
@push('css')
<style>
/* ============================================================
   Role-based color theme — injected by dashboardnav.blade.php
   Pasien = green #198754 | Dokter = red #dc3545 | Admin = yellow #ffc107
   ============================================================ */

/* ------ Navbar active / hover links ------ */
nav.navbar .nav-link            { color: #333 !important; transition: color .2s; }
nav.navbar .nav-link:hover      { color: {{ $roleColor }} !important; }
nav.navbar .nav-link.active     { color: {{ $roleColor }} !important; font-weight: 600 !important; }
nav.navbar .dropdown-item.active,
nav.navbar .dropdown-item:active{ background-color: {{ $roleColor }}22; color: {{ $roleColor }} !important; }

/* ------ Bootstrap root success → role color ------ */
:root {
    --bs-success:            {{ $roleColor }};
    --bs-success-rgb:        {{ $roleColorRgb }};
    --bs-success-text:       {{ $roleLightText }};
    --bs-success-bg-subtle:  {{ $roleLightBg }};
    --bs-success-border-subtle: {{ $roleLightBorder }};
}

/* ------ btn-success ------ */
.btn-success {
    --bs-btn-color:              {{ $roleBtnText }};
    --bs-btn-bg:                 {{ $roleColor }};
    --bs-btn-border-color:       {{ $roleColor }};
    --bs-btn-hover-color:        {{ $roleBtnText }};
    --bs-btn-hover-bg:           {{ $roleHover }};
    --bs-btn-hover-border-color: {{ $roleActive }};
    --bs-btn-active-color:       {{ $roleBtnText }};
    --bs-btn-active-bg:          {{ $roleActive }};
    --bs-btn-active-border-color:{{ $roleActive }};
    --bs-btn-disabled-color:     {{ $roleBtnText }};
    --bs-btn-disabled-bg:        {{ $roleColor }};
    --bs-btn-disabled-border-color: {{ $roleColor }};
    --bs-btn-focus-shadow-rgb:   {{ $roleColorRgb }};
}
.btn-outline-success {
    --bs-btn-color:              {{ $roleColor }};
    --bs-btn-border-color:       {{ $roleColor }};
    --bs-btn-hover-color:        {{ $roleBtnText }};
    --bs-btn-hover-bg:           {{ $roleColor }};
    --bs-btn-hover-border-color: {{ $roleColor }};
    --bs-btn-active-color:       {{ $roleBtnText }};
    --bs-btn-active-bg:          {{ $roleColor }};
    --bs-btn-focus-shadow-rgb:   {{ $roleColorRgb }};
}

/* ------ Backgrounds ------ */
.bg-success                   { background-color: {{ $roleColor }} !important; }
.bg-success *                 { color: {{ $roleBtnText }}; }
.bg-gradient-success          { background: linear-gradient(195deg, {{ $roleHover }}, {{ $roleColor }}) !important; }
.bg-gradient-success *        { color: {{ $roleBtnText }}; }
.bg-success-subtle            { background-color: {{ $roleLightBg }} !important; }

/* ------ Text / border ------ */
.text-success, a.text-success, a.text-success:hover { color: {{ $roleColor }} !important; }
.text-success-emphasis         { color: {{ $roleLightText }} !important; }
.border-success                { border-color: {{ $roleColor }} !important; }

/* ------ Badges ------ */
.badge.bg-success,
span.badge.bg-success,
.text-bg-success               { background-color: {{ $roleColor }} !important; color: {{ $roleBtnText }} !important; }

/* ------ Card headers ------ */
.card-header.bg-success        { background-color: {{ $roleColor }} !important; color: {{ $roleBtnText }} !important; }
.card-header.bg-gradient-success { background: linear-gradient(195deg, {{ $roleHover }}, {{ $roleColor }}) !important; color: {{ $roleBtnText }} !important; }

/* ------ Alerts ------ */
.alert-success {
    --bs-alert-color:         {{ $roleLightText }};
    --bs-alert-bg:            {{ $roleLightBg }};
    --bs-alert-border-color:  {{ $roleLightBorder }};
    color:            {{ $roleLightText }};
    background-color: {{ $roleLightBg }};
    border-color:     {{ $roleLightBorder }};
}

/* ------ Misc ------ */
.progress-bar.bg-success       { background-color: {{ $roleColor }} !important; }
.form-check-input:checked       { background-color: {{ $roleColor }} !important; border-color: {{ $roleColor }} !important; }
.nav-pills .nav-link.active     { background-color: {{ $roleColor }} !important; color: {{ $roleBtnText }} !important; }
.list-group-item.active         { background-color: {{ $roleColor }} !important; border-color: {{ $roleColor }} !important; color: {{ $roleBtnText }} !important; }

@if($role === 'admin')
/* ------ Admin: also remap "primary" → yellow (admin dashboard uses bg-gradient-primary) ------ */
:root {
    --bs-primary:            #ffc107;
    --bs-primary-rgb:        255,193,7;
}
.btn-primary {
    --bs-btn-color:              #000;
    --bs-btn-bg:                 #ffc107;
    --bs-btn-border-color:       #ffc107;
    --bs-btn-hover-color:        #000;
    --bs-btn-hover-bg:           #e0a800;
    --bs-btn-hover-border-color: #d39e00;
    --bs-btn-active-color:       #000;
    --bs-btn-active-bg:          #d39e00;
    --bs-btn-focus-shadow-rgb:   255,193,7;
}
.btn-outline-primary {
    --bs-btn-color:              #ca8a04;
    --bs-btn-border-color:       #ca8a04;
    --bs-btn-hover-color:        #000;
    --bs-btn-hover-bg:           #ffc107;
    --bs-btn-hover-border-color: #ffc107;
    --bs-btn-active-color:       #000;
    --bs-btn-active-bg:          #ffc107;
}
.bg-primary                   { background-color: #ffc107 !important; }
.bg-gradient-primary          { background: linear-gradient(195deg, #e0a800, #ffc107) !important; }
.text-primary                 { color: #ca8a04 !important; }
.border-primary               { border-color: #ffc107 !important; }
.badge.bg-primary,
.text-bg-primary              { background-color: #ffc107 !important; color: #000 !important; }
.card-header.bg-primary,
.card-header.bg-gradient-primary { background: linear-gradient(195deg, #e0a800, #ffc107) !important; color: #000 !important; }
@endif
</style>
@endpush
@endonce 