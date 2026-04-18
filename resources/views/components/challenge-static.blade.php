<div class="row gy-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Cara Pakai</h5>
                <p class="card-text text-muted">Centang setiap kebiasaan yang sudah Anda lakukan. Login untuk menyimpan progress dan mendapatkan poin.</p>
                <div class="alert alert-success mt-3" role="alert">
                    <strong>Tip:</strong> lakukan setidaknya 3 tantangan setiap hari untuk rutinitas sehat yang berkelanjutan.
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title">Manfaat</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Meningkatkan energi dan fokus.</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Memperbaiki kualitas tidur.</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Memperkuat kebiasaan makan sehat.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<h4 class="fw-bold">Checklist Tantangan</h4>
<p class="text-muted">Centang tantangan yang sudah Anda lakukan hari ini.</p>
<div class="list-group mb-4" id="challengeList">
    @foreach($challenges as $key => $challenge)
        <label class="list-group-item list-group-item-action d-flex align-items-start gap-3">
            <input class="form-check-input mt-1" type="checkbox" data-challenge="challenge-{{ is_object($challenge) ? $challenge->id ?? $key : $key }}">
            <div class="flex-grow-1">
                <strong>{{ is_object($challenge) ? $challenge->title : $challenge['title'] }}</strong>
                <p class="mb-0 text-muted">{{ is_object($challenge) ? $challenge->description : $challenge['description'] }}</p>
            </div>
            @if(is_object($challenge) && isset($challenge->points))
                <span class="badge bg-warning text-dark align-self-center">+{{ $challenge->points }} poin</span>
            @endif
        </label>
    @endforeach
</div>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3">
    <button id="clearChallenge" class="btn btn-outline-success w-100 w-sm-auto">Reset Progress</button>
    <div class="text-muted text-center text-sm-start">Progress tersimpan di browser Anda.</div>
</div>

@push('js')
<script>
const challengeKey = 'healthChallengeProgress';
const checkboxes = document.querySelectorAll('#challengeList input[type=checkbox]');

function loadChallengeProgress() {
    const saved = localStorage.getItem(challengeKey);
    if (!saved) return;
    try {
        const progress = JSON.parse(saved);
        checkboxes.forEach(cb => { cb.checked = progress[cb.dataset.challenge] === true; });
    } catch(e) {}
}

function saveChallengeProgress() {
    const progress = {};
    checkboxes.forEach(cb => { progress[cb.dataset.challenge] = cb.checked; });
    localStorage.setItem(challengeKey, JSON.stringify(progress));
}

checkboxes.forEach(cb => cb.addEventListener('change', saveChallengeProgress));

document.getElementById('clearChallenge')?.addEventListener('click', () => {
    checkboxes.forEach(cb => cb.checked = false);
    localStorage.removeItem(challengeKey);
});

loadChallengeProgress();
</script>
@endpush
