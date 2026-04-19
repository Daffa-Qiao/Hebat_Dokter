@extends('layouts.app')
@section('title', 'Login User')
@section('content')
<div class="position-fixed" style="top: 20px; left: 20px; z-index: 1000;">
    <a href="{{ route('home') }}" class="btn btn-light rounded-circle shadow-sm" title="Home">
        <i class="fas fa-home"></i>
    </a>
</div>

<!-- Role Selection Dropdown -->
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="me-auto d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center rounded-circle shadow"
                                 style="width:80px;height:80px;background:linear-gradient(135deg,#157347,#28a745);flex-shrink:0;">
                                <i class="fas fa-user-md" style="font-size:2.2rem;color:#fff;"></i>
                            </div>
                            <div class="ms-3">
                                <h3 class="mb-0 fw-bold" style="color:#157347;">Hebat Dokter</h3>
                                <small class="text-muted">Masuk untuk melanjutkan ke dashboard Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="font-weight-bolder mb-0">Sign In</h4>
                                    <span class="badge ms-2 bg-success text-white">
                                        Akun
                                    </span>
                                </div>
                                <p class="mb-0">Masuk dengan email dan password Anda. Sistem akan mengarahkan sesuai peran yang terdaftar.</p>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="flex flex-col mb-3">
                                        <input type="email" name="email" class="form-control form-control-lg"
                                            value="{{ old('email', $rememberedEmail ?? '') }}" aria-label="Email" placeholder="Email">
                                        @error('email')
                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            aria-label="Password" placeholder="Password">
                                        @error('password')
                                            <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" name="remember" type="checkbox" id="rememberMe" {{ old('remember') || isset($rememberedEmail) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                    </div>

                                    {{-- CAPTCHA --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Verifikasi Keamanan</label>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <div class="px-4 py-2 rounded-3 fw-bold text-white text-center"
                                                 style="background:linear-gradient(135deg,#157347,#28a745);font-size:1.3rem;letter-spacing:2px;min-width:130px;user-select:none;">
                                                {{ $captcha['num1'] }} + {{ $captcha['num2'] }} = ?
                                            </div>
                                        </div>
                                        <input type="number" name="captcha" class="form-control form-control-lg @error('captcha') is-invalid @enderror"
                                               placeholder="Masukkan hasil penjumlahan" required autocomplete="off">
                                        @error('captcha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-success w-100 mt-4 mb-0">
                                            Sign in
                                        </button>
                                    </div>

                                    @if($errors->has('email'))
                                        <div class="alert alert-danger mt-3" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </form>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Belum punya akun? <a href="{{ route('register') }}" class="text-success">Daftar di sini</a>.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('{{ asset('img/logo.png') }}'); background-size: cover;">
                            <span class="mask opacity-6" style="background-color: rgba(21, 115, 71, 0.55);"></span>
                            <div class="position-relative text-center px-4">
                                <div class="mb-4">
                                    <i class="fas fa-user-md" style="font-size:4rem;color:#fff;filter:drop-shadow(0 4px 12px rgba(0,0,0,0.3));"></i>
                                </div>
                                <h2 class="fw-bold mb-3" style="color:#fff;text-shadow:0 2px 12px rgba(0,0,0,0.35);letter-spacing:.5px;">Hebat Dokter</h2>
                                <p class="mb-4" style="color:rgba(255,255,255,0.9);font-size:1.05rem;line-height:1.7;text-shadow:0 1px 6px rgba(0,0,0,0.25);">Kelola kesehatan Anda dalam satu platform yang mudah dan terpercaya.</p>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <div class="text-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);">
                                        <i class="fas fa-stethoscope mb-1" style="color:#fff;font-size:1.2rem;"></i>
                                        <p class="mb-0" style="color:#fff;font-size:.75rem;font-weight:600;">Konsultasi</p>
                                    </div>
                                    <div class="text-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);">
                                        <i class="fas fa-calendar-check mb-1" style="color:#fff;font-size:1.2rem;"></i>
                                        <p class="mb-0" style="color:#fff;font-size:.75rem;font-weight:600;">Reservasi</p>
                                    </div>
                                    <div class="text-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);">
                                        <i class="fas fa-heartbeat mb-1" style="color:#fff;font-size:1.2rem;"></i>
                                        <p class="mb-0" style="color:#fff;font-size:.75rem;font-weight:600;">Tantangan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@push('css')
<style>
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert-danger i {
        color: #721c24;
    }

    #rememberMe:checked {
        background-color: #198754;
        border-color: #198754;
    }
    #rememberMe:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }
</style>
@endpush
@endsection