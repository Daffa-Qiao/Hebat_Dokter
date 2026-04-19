@extends('layouts.app')
@section('title', 'Verifikasi Email')
@section('content')
@include('layouts.navbars.dashboardnav')
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-center">
                                <h4 class="font-weight-bolder text-success mb-2">Verifikasi Email</h4>
                                <p class="mb-0 text-sm">
                                    Kami telah mengirim kode verifikasi 6 digit ke<br>
                                    <strong>{{ $email }}</strong>
                                </p>
                            </div>
                            <div class="card-body p-4">

                                @if(session('success'))
                                <div class="alert alert-success text-white text-sm" role="alert">
                                    {{ session('success') }}
                                </div>
                                @endif

                                @if($errors->any())
                                <div class="alert alert-danger text-white text-sm" role="alert">
                                    {{ $errors->first() }}
                                </div>
                                @endif

                                <form method="POST" action="{{ route('verify.email.submit') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Kode Verifikasi</label>
                                        <input type="text"
                                            name="code"
                                            id="code"
                                            value="{{ old('code') }}"
                                            class="form-control form-control-lg text-center @error('code') is-invalid @enderror"
                                            placeholder="Masukkan 6 digit kode"
                                            maxlength="6"
                                            autocomplete="one-time-code"
                                            required
                                            autofocus
                                            style="letter-spacing: 10px; font-size: 1.6rem; font-weight: bold;">
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-lg btn-success w-100 mb-3">
                                        Verifikasi
                                    </button>
                                </form>

                                <div class="text-center">
                                    <p class="text-sm text-muted mb-2">Tidak menerima kode?</p>
                                    <form method="POST" action="{{ route('verify.email.resend') }}">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            Kirim Ulang Kode
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection