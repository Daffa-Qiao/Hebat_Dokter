@extends('layouts.app')
@section('title', 'Kalkulator Kalori')
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
                <div class="card-header bg-gradient" style="background-color: #2E7D32;">
                    <h3 class="mb-0 text-white text-center">Pengukur Kalori Aktivitas Fisik</h3>
                </div>
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label for="activity" class="form-label fw-bold">Pilih Aktivitas:</label>
                        <select id="activity" class="form-select form-select-lg">
                            <option value="running">Lari</option>
                            <option value="cycling">Bersepeda</option>
                            <option value="walking">Berjalan</option>
                            <option value="swimming">Berenang</option>
                            <option value="yoga">Yoga</option>
                        </select>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration" class="form-label fw-bold">Durasi (menit):</label>
                                <div class="input-group">
                                    <input type="number" id="duration" class="form-control form-control-lg" min="1" value="30" required>
                                    <span class="input-group-text">menit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight" class="form-label fw-bold">Berat Badan:</label>
                                <div class="input-group">
                                    <input type="number" id="weight" class="form-control form-control-lg" min="1" value="70" required>
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button onclick="calculateCalories()" class="btn btn-success btn-lg w-100 mb-4">
                        <i class="fas fa-calculator me-2"></i>Hitung Kalori
                    </button>

                    <div id="result" class="result-box p-4 rounded-3 text-center" style="display: none;">
                        <h4 class="text-success mb-3">Hasil Perhitungan</h4>
                        <div class="calories-result">
                            <span class="display-4 fw-bold text-success calories-number">0</span>
                            <p class="text-muted mb-0">kalori terbakar</p>
                        </div>
                        <div class="activity-details mt-3 text-muted">
                            <span class="activity-type"></span> • 
                            <span class="activity-duration"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-heartbeat text-success mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">Kesehatan</h5>
                            <p class="card-text text-muted">Aktivitas fisik rutin meningkatkan kesehatan jantung</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-dumbbell text-success mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">Kebugaran</h5>
                            <p class="card-text text-muted">Tingkatkan stamina dan kekuatan otot</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-brain text-success mb-3" style="font-size: 2rem;"></i>
                            <h5 class="card-title">Mental</h5>
                            <p class="card-text text-muted">Kurangi stres dan tingkatkan mood</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// MET (Metabolic Equivalent of Task) untuk masing-masing aktivitas
const METs = {
    running: 9.8,
    cycling: 7.5,
    walking: 3.5,
    swimming: 8.0,
    yoga: 2.5
};

const activityNames = {
    running: 'Lari',
    cycling: 'Bersepeda',
    walking: 'Berjalan',
    swimming: 'Berenang',
    yoga: 'Yoga'
};

function calculateCalories() {
    const activity = document.getElementById("activity").value;
    const duration = parseFloat(document.getElementById("duration").value);
    const weight = parseFloat(document.getElementById("weight").value);

    if (!activity || isNaN(duration) || isNaN(weight)) {
        showError("Mohon isi semua data dengan benar.");
        return;
    }

    if (duration < 1) {
        showError("Durasi minimal 1 menit.");
        return;
    }

    if (weight < 1) {
        showError("Berat badan tidak valid.");
        return;
    }

    const met = METs[activity];
    const caloriesBurned = (met * 3.5 * weight / 200) * duration;

    // Tampilkan hasil
    const resultBox = document.getElementById("result");
    resultBox.style.display = "block";
    
    // Animasi angka kalori
    const caloriesNumber = resultBox.querySelector('.calories-number');
    animateNumber(0, Math.round(caloriesBurned), 1000, caloriesNumber);

    // Update detail aktivitas
    resultBox.querySelector('.activity-type').textContent = activityNames[activity];
    resultBox.querySelector('.activity-duration').textContent = `${duration} menit`;

    // Scroll ke hasil
    resultBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: message,
        confirmButtonColor: '#2E7D32'
    });
}

function animateNumber(start, end, duration, element) {
    let current = start;
    const range = end - start;
    const increment = end > start ? 1 : -1;
    const stepTime = Math.abs(Math.floor(duration / range));
    
    const timer = setInterval(() => {
        current += increment;
        element.textContent = current;
        if (current == end) {
            clearInterval(timer);
        }
    }, stepTime);
}
</script>

@push('css')
<style>
.bg-gradient {
    background: linear-gradient(45deg, #2E7D32, #4CAF50);
}

.card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.card:hover {
    transform: translateY(-5px);
}

.form-control,
.form-select,
.input-group-text {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 12px;
}

.form-control:focus,
.form-select:focus {
    border-color: #2E7D32;
    box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
}

.btn-success {
    background-color: #2E7D32;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background-color: #1B5E20;
    transform: translateY(-2px);
}

.result-box {
    background-color: #F5F5F5;
    border: 2px solid #E8F5E9;
    transition: all 0.3s ease;
}

.result-box:hover {
    border-color: #2E7D32;
}

.calories-number {
    color: #2E7D32;
    font-size: 3.5rem;
}

.form-label {
    color: #333;
    margin-bottom: 8px;
}

.input-group-text {
    background-color: #F5F5F5;
    color: #666;
    font-weight: 500;
}

/* Animasi untuk cards */
.card {
    animation: fadeIn 0.5s ease-out;
}

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

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .calories-number {
        font-size: 2.5rem;
    }
}
</style>
@endpush
@endsection