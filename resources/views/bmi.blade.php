@extends('layouts.app')
@section('title', 'Kalkulator BMI')
@section('content')
<!-- Home Button -->
<div class="position-fixed" style="top: 20px; left: 20px; z-index: 1000;">
    <a href="{{ route('home') }}" class="btn btn-primary rounded-circle shadow-sm" style="background-color:green;" title="Kembali ke Beranda">
        <i class="fas fa-home"></i>
    </a>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header" style="background: linear-gradient(45deg, #2E7D32, #4CAF50);">
                    <h3 class="mb-0 text-white text-center"><i class="fas fa-weight me-2"></i>Kalkulator BMI</h3>
                    <p class="text-white text-center mb-0 mt-1" style="opacity:0.85;">Body Mass Index – Ukur berat badan ideal Anda</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label for="weight" class="form-label fw-bold">Berat Badan</label>
                            <div class="input-group">
                                <input type="number" id="weight" class="form-control form-control-lg" min="1" max="300" value="70" placeholder="kg">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="height" class="form-label fw-bold">Tinggi Badan</label>
                            <div class="input-group">
                                <input type="number" id="height" class="form-control form-control-lg" min="1" max="300" value="170" placeholder="cm">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="age" class="form-label fw-bold">Usia</label>
                            <div class="input-group">
                                <input type="number" id="age" class="form-control form-control-lg" min="1" max="120" value="25" placeholder="tahun">
                                <span class="input-group-text">thn</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                <label class="form-check-label fw-semibold" for="male"><i class="fas fa-mars me-1 text-primary"></i>Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                <label class="form-check-label fw-semibold" for="female"><i class="fas fa-venus me-1 text-danger"></i>Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <button onclick="calculateBMI()" class="btn btn-success btn-lg w-100 mb-4">
                        <i class="fas fa-calculator me-2"></i>Hitung BMI Saya
                    </button>

                    <div id="bmi-result" style="display:none;">
                        <hr>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4 text-center">
                                <div class="p-3 rounded-3" id="bmi-card" style="background:#f0fdf4; border:2px solid #22c55e;">
                                    <p class="text-muted mb-1 small">Nilai BMI</p>
                                    <h2 id="bmi-value" class="fw-bold mb-1" style="color:#2E7D32;">—</h2>
                                    <span id="bmi-category" class="badge fs-6">—</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 rounded-3" style="background:#f0f9ff; border:2px solid #3b82f6;">
                                    <p class="text-muted mb-1 small">Berat Ideal</p>
                                    <h2 id="ideal-weight" class="fw-bold mb-1" style="color:#2563eb;">—</h2>
                                    <p class="mb-0 small text-muted">kg</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3 rounded-3" style="background:#fef9f0; border:2px solid #f59e0b;">
                                    <p class="text-muted mb-1 small">Kebutuhan Kalori</p>
                                    <h2 id="daily-calories" class="fw-bold mb-1" style="color:#d97706;">—</h2>
                                    <p class="mb-0 small text-muted">kkal/hari</p>
                                </div>
                            </div>
                        </div>

                        <!-- BMI Gauge -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Kurus<br>&lt;18.5</span>
                                <span>Normal<br>18.5–24.9</span>
                                <span>Gemuk<br>25–29.9</span>
                                <span>Obesitas<br>&ge;30</span>
                            </div>
                            <div class="progress" style="height:20px; border-radius:10px;">
                                <div class="progress-bar bg-info" style="width:25%" title="Kurus"></div>
                                <div class="progress-bar bg-success" style="width:25%" title="Normal"></div>
                                <div class="progress-bar bg-warning" style="width:25%" title="Gemuk"></div>
                                <div class="progress-bar bg-danger" style="width:25%" title="Obesitas"></div>
                            </div>
                            <div class="position-relative mt-1">
                                <div id="bmi-pointer" class="text-center" style="position:absolute; transform:translateX(-50%); font-size:1.3rem;">▲</div>
                            </div>
                        </div>

                        <div id="bmi-advice" class="alert mt-4" role="alert"></div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-3">
                        <i class="fas fa-info-circle text-success mb-2" style="font-size:2rem;"></i>
                        <h6 class="fw-bold">Apa itu BMI?</h6>
                        <p class="text-muted small mb-0">BMI adalah rasio berat terhadap tinggi badan yang mengindikasikan kategori berat badan seseorang.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-3">
                        <i class="fas fa-exclamation-triangle text-warning mb-2" style="font-size:2rem;"></i>
                        <h6 class="fw-bold">Keterbatasan BMI</h6>
                        <p class="text-muted small mb-0">BMI tidak membedakan massa otot dan lemak. Konsultasikan dengan dokter untuk analisis lebih akurat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center p-3">
                        <i class="fas fa-user-md text-primary mb-2" style="font-size:2rem;"></i>
                        <h6 class="fw-bold">Konsultasi Dokter</h6>
                        <p class="text-muted small mb-0">Ingin saran lebih personal? Buat reservasi dengan dokter spesialis kami.</p>
                        <a href="{{ route('doctors.index') }}" class="btn btn-outline-success btn-sm mt-2">Cari Dokter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calculateBMI() {
    const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);
    const age    = parseInt(document.getElementById('age').value);
    const gender = document.querySelector('input[name="gender"]:checked').value;

    if (!weight || !height || !age || weight < 1 || height < 50 || age < 1) {
        alert('Mohon isi semua data dengan benar.');
        return;
    }

    const heightM = height / 100;
    const bmi = weight / (heightM * heightM);
    const bmiRounded = Math.round(bmi * 10) / 10;

    // Berat ideal (Devine formula)
    let idealWeight;
    if (gender === 'male') {
        idealWeight = 50 + 2.3 * ((height - 152.4) / 2.54);
    } else {
        idealWeight = 45.5 + 2.3 * ((height - 152.4) / 2.54);
    }
    idealWeight = Math.max(30, Math.round(idealWeight * 10) / 10);

    // Kebutuhan kalori (Mifflin-St Jeor)
    let bmr;
    if (gender === 'male') {
        bmr = 10 * weight + 6.25 * height - 5 * age + 5;
    } else {
        bmr = 10 * weight + 6.25 * height - 5 * age - 161;
    }
    const dailyCalories = Math.round(bmr * 1.55); // moderate activity

    // Category & styling
    let category, colorClass, bgColor, borderColor, advice;
    if (bmi < 18.5) {
        category = 'Berat Badan Kurang'; colorClass = 'bg-info text-white';
        bgColor = '#f0f9ff'; borderColor = '#3b82f6';
        advice = '<strong>Berat badan Anda kurang dari ideal.</strong> Tingkatkan asupan kalori dengan makanan bergizi, protein, dan lemak sehat. Pertimbangkan konsultasi dengan ahli gizi.';
    } else if (bmi < 25) {
        category = 'Berat Badan Normal'; colorClass = 'bg-success text-white';
        bgColor = '#f0fdf4'; borderColor = '#22c55e';
        advice = '<strong>Selamat! Berat badan Anda ideal.</strong> Pertahankan pola makan sehat dan rutinitas olahraga untuk menjaga kondisi tubuh yang optimal.';
    } else if (bmi < 30) {
        category = 'Berat Badan Lebih'; colorClass = 'bg-warning text-dark';
        bgColor = '#fef9f0'; borderColor = '#f59e0b';
        advice = '<strong>Berat badan Anda sedikit berlebih.</strong> Kurangi asupan kalori, perbanyak sayur dan buah, serta tingkatkan aktivitas fisik setidaknya 150 menit per minggu.';
    } else {
        category = 'Obesitas'; colorClass = 'bg-danger text-white';
        bgColor = '#fef2f2'; borderColor = '#ef4444';
        advice = '<strong>Berat badan Anda masuk kategori obesitas.</strong> Sangat disarankan berkonsultasi dengan dokter atau ahli gizi untuk program penurunan berat badan yang aman dan terstruktur.';
    }

    document.getElementById('bmi-value').textContent = bmiRounded;
    document.getElementById('bmi-category').textContent = category;
    document.getElementById('bmi-category').className = 'badge fs-6 ' + colorClass;
    document.getElementById('bmi-card').style.background = bgColor;
    document.getElementById('bmi-card').style.borderColor = borderColor;
    document.getElementById('ideal-weight').textContent = idealWeight;
    document.getElementById('daily-calories').textContent = dailyCalories.toLocaleString('id-ID');

    // Pointer position (BMI range roughly 15–40 mapped to 0–100%)
    const pct = Math.min(100, Math.max(0, ((bmi - 15) / 25) * 100));
    document.getElementById('bmi-pointer').style.left = pct + '%';

    const adviceEl = document.getElementById('bmi-advice');
    adviceEl.innerHTML = '<i class="fas fa-lightbulb me-2"></i>' + advice;
    adviceEl.className = 'alert mt-4 alert-' + (bmi < 18.5 ? 'info' : bmi < 25 ? 'success' : bmi < 30 ? 'warning' : 'danger');

    document.getElementById('bmi-result').style.display = 'block';
    document.getElementById('bmi-result').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

@push('css')
<style>
.card { border-radius: 15px; transition: all 0.3s ease; }
.card:hover { transform: translateY(-4px); }
.form-control, .form-select, .input-group-text {
    border-radius: 10px; border: 1px solid #ddd; padding: 12px;
}
.form-control:focus { border-color: #2E7D32; box-shadow: 0 0 0 0.25rem rgba(46,125,50,0.2); }
.btn-success { background-color: #2E7D32; border: none; border-radius: 10px; font-weight: 600; }
.btn-success:hover { background-color: #1B5E20; }
</style>
@endpush
@endsection
