@extends('layouts.app')
@section('title', 'Register User')
@section('content')
@include('layouts.navbars.dashboardnav')
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-10">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-center">
                                <h4 class="font-weight-bolder text-success mb-3">Daftar Akun Hebat Dokter</h4>
                                <p class="mb-0">Isi data diri Anda untuk membuat akun</p>
                            </div>
                            <div class="card-body p-4">
                                <form role="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="row">
                                        <!-- Nama Lengkap -->
                                        <div class="col-12 mb-3">
                                            <label for="name" class="form-label">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="nama@email.com">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- No. Telepon -->
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">No. Telepon</label>
                                            <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Foto Profil -->
                                        <div class="col-12 mb-3">
                                            <label for="photo" class="form-label">Foto Profil</label>
                                            <input type="file" name="photo" class="form-control form-control-lg @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                                            <div class="form-text">Upload foto profil Anda (JPG, JPEG, atau PNG)</div>
                                            @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                placeholder="Minimal 8 karakter" required>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Konfirmasi Password -->
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                                placeholder="Ulangi password" required>
                                        </div>

                                        <!-- Terms & Conditions -->
                                        <div class="col-12">
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

                                            <div class="form-check mb-3">
                                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                                                <label class="form-check-label" for="terms">
                                                    Saya setuju dengan <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#termsModal">Syarat & Ketentuan</a>
                                                </label>
                                                @error('terms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <p class="mb-4 text-sm mx-auto">
                                                Sudah punya akun?
                                                <a href="{{ route('login') }}" class="text-success" style="color:green;"><u>Masuk di sini</u></a>
                                            </p>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-lg btn-success w-100 mb-2">
                                                Daftar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="termsModalLabel">Syarat & Ketentuan Hebat Dokter</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Pendahuluan -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">1. Pendahuluan</h5>
                    <p>Selamat datang di Hebat Dokter. Dengan mendaftar atau menggunakan layanan kami, Anda menyetujui syarat dan ketentuan berikut:</p>
                </section>

                <!-- Pendaftaran dan Akun -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">2. Pendaftaran dan Akun</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Anda harus berusia minimal 15 tahun untuk mendaftar</li>
                        <li class="mb-2">✓ Informasi yang diberikan harus akurat dan lengkap</li>
                        <li class="mb-2">✓ Anda bertanggung jawab atas keamanan akun Anda</li>
                        <li class="mb-2">✓ Satu email hanya untuk satu akun</li>
                    </ul>
                </section>

                <!-- Layanan -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">3. Layanan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Konsultasi online dengan dokter terpercaya</li>
                        <li class="mb-2">✓ Kalkulator kalori dan BMI</li>
                        <li class="mb-2">✓ Informasi menu sehat</li>
                        <li class="mb-2">✓ Rekomendasi program kesehatan</li>
                    </ul>
                </section>

                <!-- Privasi dan Data -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">4. Privasi dan Data</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Data pribadi Anda akan dilindungi</li>
                        <li class="mb-2">✓ Informasi medis bersifat rahasia</li>
                        <li class="mb-2">✓ Data hanya digunakan untuk layanan Hebat Dokter</li>
                        <li class="mb-2">✓ Anda dapat meminta penghapusan data</li>
                    </ul>
                </section>

                <!-- Pembatasan -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">5. Pembatasan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Dilarang memberikan informasi palsu</li>
                        <li class="mb-2">✓ Dilarang menyalahgunakan layanan</li>
                        <li class="mb-2">✓ Dilarang melakukan tindakan ilegal</li>
                        <li class="mb-2">✓ Pelanggaran dapat berakibat penutupan akun</li>
                    </ul>
                </section>

                <!-- Perubahan Ketentuan -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">6. Perubahan Ketentuan</h5>
                    <p>Hebat Dokter berhak mengubah syarat dan ketentuan sewaktu-waktu. Perubahan akan diberitahukan melalui email atau notifikasi di aplikasi.</p>
                </section>

                <!-- Kontak -->
                <section class="mb-4">
                    <h5 class="text-success mb-3">7. Kontak</h5>
                    <p class="mb-2">Untuk pertanyaan tentang syarat dan ketentuan ini, silakan hubungi:</p>
                    <ul class="list-unstyled">
                        <li>Email: support@hebatdokter.com</li>
                        <li>Telepon: 082123432959</li>
                        <li>Alamat: Gedung Tedja Buana, Jl. Menteng Raya No. 29, Jakarta Pusat</li>
                    </ul>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="document.getElementById('terms').checked = true;">
                    Saya Setuju
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
<style>
    .logo-wrapper {
        transition: transform 0.3s ease;
        margin-bottom: 2rem;
    }

    .logo-wrapper:hover {
        transform: translateY(-5px);
    }

    .logo-image {
        max-width: 150px;
        height: auto;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .card {
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        background: #ffffff;
        margin-bottom: 3rem;
    }

    .card-header {
        background: transparent;
        border-bottom: none;
        padding: 2rem 2rem 0;
    }

    .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .form-select {
        background-color: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    /* File input styling */
    input[type="file"].form-control {
        padding: 8px 12px;
    }

    input[type="file"].form-control::file-selector-button {
        background-color: #28a745;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        margin-right: 12px;
        transition: all 0.3s ease;
    }

    input[type="file"].form-control::file-selector-button:hover {
        background-color: #218838;
    }

    .form-text {
        color: #6c757d;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #2d3748;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        border-radius: 10px;
        padding: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .text-success {
        color: #28a745 !important;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-plain {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .card {
            margin: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-success {
            padding: 12px;
        }

        .form-control {
            padding: 10px;
        }
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
        border: none;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-body section {
        position: relative;
        padding-left: 15px;
    }

    .modal-body section::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #2E7D32, transparent);
        border-radius: 3px;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .modal-dialog-scrollable .modal-content {
        max-height: 90vh;
    }

    .btn-close-white:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    }

    .list-unstyled li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Responsive Modal */
    @media (max-width: 768px) {
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-header {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('js')
<script>
// Auto-scroll to top when modal opens
document.getElementById('termsModal').addEventListener('show.bs.modal', function () {
    setTimeout(() => {
        this.querySelector('.modal-body').scrollTop = 0;
    }, 100);
});

// Preview uploaded image
document.querySelector('input[name="photo"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.style.maxWidth = '200px';
            preview.style.marginTop = '10px';
            preview.style.borderRadius = '10px';
            
            const previewContainer = document.querySelector('input[name="photo"]').parentElement;
            const existingPreview = previewContainer.querySelector('img');
            if (existingPreview) {
                existingPreview.remove();
            }
            previewContainer.appendChild(preview);
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection