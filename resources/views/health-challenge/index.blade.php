@extends('layouts.app')
@section('title', 'Tantangan Hidup Sehat')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-success text-white py-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                        <div>
                            <h2 class="mb-1">Tantangan Hidup Sehat</h2>
                            <p class="mb-0 text-white-75">Ikuti kebiasaan sehat harian dan kumpulkan poin untuk hidup lebih bugar.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    @if(session('challengeSuccess'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-star me-2"></i>{{ session('challengeSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->role === 'pasien')
                        {{-- Authenticated pasien: DB-driven challenges --}}

                        <!-- Stats Row -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 text-center" style="background:#f0fdf4; border:2px solid #86efac;">
                                    <p class="text-muted small mb-1">Poin Hari Ini</p>
                                    <h3 class="fw-bold text-success mb-0">{{ $totalPoints ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 text-center" style="background:#f0f9ff; border:2px solid #93c5fd;">
                                    <p class="text-muted small mb-1">Tantangan Selesai</p>
                                    <h3 class="fw-bold text-primary mb-0">{{ isset($userChallenges) ? $userChallenges->where('completed', true)->count() : 0 }} / {{ isset($userChallenges) ? $userChallenges->count() : 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3 text-center" style="background:#fef9f0; border:2px solid #fcd34d;">
                                    <p class="text-muted small mb-1">Streak</p>
                                    <h3 class="fw-bold text-warning mb-0">🔥 {{ $streak ?? 0 }} hari</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Bell -->
                        @if(isset($notifications) && $notifications->count())
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-4" role="alert">
                            <div>
                                <i class="fas fa-bell me-2"></i>
                                <strong>{{ $notifications->count() }} notifikasi baru</strong> – tantangan hari ini sudah siap!
                            </div>
                            <form method="POST" action="{{ route('health-challenge.markRead') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning">Tandai Dibaca</button>
                            </form>
                        </div>
                        @endif

                        <!-- Today's Challenges -->
                        <h4 class="fw-bold mb-3">Tantangan Hari Ini</h4>
                        @if(isset($userChallenges) && $userChallenges->count())
                            <div class="list-group mb-4">
                                @foreach($userChallenges as $uc)
                                    <div class="list-group-item list-group-item-action d-flex align-items-start gap-3
                                                {{ $uc->completed ? 'list-group-item-success' : '' }}"
                                         data-uc-id="{{ $uc->id }}"
                                         data-title="{{ $uc->challenge->title }}">
                                        <div class="mt-1">
                                            @if($uc->completed)
                                                <i class="fas fa-check-circle text-success fs-5"></i>
                                            @else
                                                <i class="far fa-circle text-muted fs-5"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between flex-wrap gap-1">
                                                <strong class="{{ $uc->completed ? 'text-decoration-line-through text-muted' : '' }}">
                                                    {{ $uc->challenge->title }}
                                                </strong>
                                                <span class="badge bg-warning text-dark ms-2">+{{ $uc->challenge->points }} poin</span>
                                            </div>
                                            <p class="mb-1 text-muted small">{{ $uc->challenge->description }}</p>
                                            @if(!$uc->completed)
                                                <div id="timer-widget-{{ $uc->id }}"></div>
                                            @endif
                                        </div>
                                        @if(!$uc->completed)
                                            <form id="complete-form-{{ $uc->id }}" method="POST" action="{{ route('health-challenge.complete', $uc) }}" class="ms-auto flex-shrink-0">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Selesai</button>
                                            </form>
                                        @else
                                            <span class="badge bg-success align-self-center">✓</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">Tantangan hari ini sedang disiapkan. Cek kembali sebentar!</div>
                        @endif

                        @else
                        {{-- Other auth roles: static view --}}
                        @include('components.challenge-static', ['challenges' => $challenges ?? []])
                        @endif

                    @else
                    {{-- Guest: static view with CTA --}}
                    <div class="alert alert-success d-flex justify-content-between align-items-center mb-4">
                        <span><i class="fas fa-lock me-2"></i>Login untuk mendapatkan tantangan harian personal & kumpulkan poin!</span>
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm">Login Sekarang</a>
                    </div>
                    @include('components.challenge-static', ['challenges' => $challenges ?? []])
                    @endauth

                    <!-- Tips Tambahan -->
                    <div class="mt-4">
                        <h5 class="fw-bold">Tips Tambahan</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Sarapan Sehat</h6>
                                        <p class="text-muted mb-0">Mulai pagi Anda dengan protein dan serat untuk energi yang stabil.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Istirahat Aktif</h6>
                                        <p class="text-muted mb-0">Istirahat singkat setiap jam membantu fokus dan mencegah lelah.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Hormon dan Stres</h6>
                                        <p class="text-muted mb-0">Tarik napas dalam-dalam saat stres untuk menenangkan tubuh Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
<style>
    .alert-success i { color: #155724; }
    .list-group-item { border-radius: 1rem; margin-bottom: .5rem; }
    .timer-countdown { font-variant-numeric: tabular-nums; }
</style>
@endpush

@push('js')
<script>
(function () {

    /* ── Duration parser: returns minutes or null ── */
    function parseMinutes(title) {
        var m = title.match(/(\d+)\s*(?:[–\-]\d+)?\s*menit/i);
        var h = title.match(/(\d+)\s*(?:[–\-]\d+)?\s*jam/i);
        if (m) return parseInt(m[1], 10);
        if (h) return parseInt(h[1], 10) * 60;
        return null;
    }

    /* ── Format seconds → MM:SS or HH:MM:SS ── */
    function fmt(s) {
        var hh = Math.floor(s / 3600);
        var mm = Math.floor((s % 3600) / 60);
        var ss = s % 60;
        return hh > 0
            ? pad(hh) + ':' + pad(mm) + ':' + pad(ss)
            : pad(mm) + ':' + pad(ss);
    }
    function pad(n) { return String(n).padStart(2, '0'); }

    /* ── Browser Notification ── */
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
    function notify(title, body) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, { body: body });
        }
        showToast(title, body);
    }

    /* ── Bootstrap Toast ── */
    function showToast(title, body) {
        var wrap = document.getElementById('hc-toast-wrap');
        if (!wrap) {
            wrap = document.createElement('div');
            wrap.id = 'hc-toast-wrap';
            wrap.className = 'position-fixed bottom-0 end-0 p-3';
            wrap.style.zIndex = '9999';
            document.body.appendChild(wrap);
        }
        var id = 'ht-' + Date.now();
        wrap.insertAdjacentHTML('beforeend',
            '<div id="' + id + '" class="toast align-items-center text-bg-success border-0 mb-2" role="alert">' +
            '<div class="d-flex"><div class="toast-body">' +
            '<strong><i class="fas fa-bell me-1"></i>' + title + '</strong><br><small>' + body + '</small>' +
            '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div></div>');
        var el = document.getElementById(id);
        if (el && typeof bootstrap !== 'undefined') {
            new bootstrap.Toast(el, { delay: 7000 }).show();
        }
    }

    var timers = {};

    /* ── Entry point ── */
    function buildWidget(ucId, title, el) {
        var key  = 'hc_timer_' + ucId;
        var mins = parseMinutes(title);
        var saved = null;
        try { saved = JSON.parse(localStorage.getItem(key)); } catch (e) {}

        if (mins !== null) {
            /* Hide the "Selesai" button — challenge completes via countdown */
            var form = document.getElementById('complete-form-' + ucId);
            if (form) form.style.display = 'none';
            renderFixed(ucId, title, el, key, mins * 60, saved);
        } else {
            renderCustom(ucId, title, el, key, saved);
        }
    }

    /* ── Timer for challenges with detected duration ── */
    function renderFixed(ucId, title, el, key, totalSecs, saved) {
        el.innerHTML =
            '<div id="tb-' + ucId + '" class="d-flex align-items-center gap-2 flex-wrap mt-1">' +
            '<span class="badge bg-secondary timer-countdown" style="font-size:.8rem;min-width:64px;">' +
            '<i class="fas fa-clock me-1"></i>' + fmt(totalSecs) + '</span>' +
            '<button id="start-' + ucId + '" class="btn btn-success btn-sm py-0 px-2" style="font-size:.8rem;">' +
            '<i class="fas fa-play me-1"></i>Mulai Timer</button></div>';

        document.getElementById('start-' + ucId).addEventListener('click', function () {
            localStorage.setItem(key, JSON.stringify({ startedAt: Date.now(), totalSecs: totalSecs }));
            runCountdown(ucId, title, el, key, totalSecs, true);
        });

        if (saved && saved.startedAt) {
            runCountdown(ucId, title, el, key, saved.totalSecs || totalSecs, true);
        }
    }

    /* ── Optional reminder for non-timed challenges ── */
    function renderCustom(ucId, title, el, key, saved) {
        el.innerHTML =
            '<div id="tb-' + ucId + '" class="d-flex align-items-center gap-2 flex-wrap mt-1">' +
            '<input type="number" min="1" max="480" placeholder="menit" id="cm-' + ucId + '"' +
            ' class="form-control form-control-sm py-0" style="width:76px;font-size:.8rem;">' +
            '<button id="cstart-' + ucId + '" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size:.8rem;">' +
            '<i class="fas fa-bell me-1"></i>Set Pengingat</button></div>';

        document.getElementById('cstart-' + ucId).addEventListener('click', function () {
            var v = parseInt(document.getElementById('cm-' + ucId).value, 10);
            if (!v || v < 1) return;
            var totalSecs = v * 60;
            localStorage.setItem(key, JSON.stringify({ startedAt: Date.now(), totalSecs: totalSecs }));
            runCountdown(ucId, title, el, key, totalSecs, false);
        });

        if (saved && saved.startedAt) {
            runCountdown(ucId, title, el, key, saved.totalSecs, false);
        }
    }

    /* ── Live countdown
         autoComplete=true  → submit the "Selesai" form when done
         autoComplete=false → only notify, no auto-submit          ── */
    function runCountdown(ucId, title, el, key, fallbackTotal, autoComplete) {
        if (timers[ucId]) clearInterval(timers[ucId]);

        function tick() {
            var saved;
            try { saved = JSON.parse(localStorage.getItem(key)); } catch (e) { return; }
            if (!saved || !saved.startedAt) return;

            var totalSecs = saved.totalSecs || fallbackTotal;
            var elapsed   = Math.floor((Date.now() - saved.startedAt) / 1000);
            var remaining = totalSecs - elapsed;
            var bar       = document.getElementById('tb-' + ucId);
            if (!bar) { clearInterval(timers[ucId]); return; }

            /* ── Countdown finished ── */
            if (remaining <= 0) {
                clearInterval(timers[ucId]);
                localStorage.removeItem(key);

                if (autoComplete) {
                    /* Mark challenge as complete automatically */
                    bar.innerHTML =
                        '<span class="badge bg-success">' +
                        '<i class="fas fa-check me-1"></i>Tantangan selesai! Menyimpan...</span>';
                    notify('Tantangan Selesai!', '"' + title + '" berhasil diselesaikan.');
                    var form = document.getElementById('complete-form-' + ucId);
                    if (form) {
                        setTimeout(function () { form.submit(); }, 1200);
                    }
                } else {
                    bar.innerHTML =
                        '<span class="badge bg-success me-2">' +
                        '<i class="fas fa-check me-1"></i>Waktu habis! Tandai selesai.</span>' +
                        '<button id="restart-' + ucId + '" class="btn btn-outline-secondary btn-sm py-0 px-2" style="font-size:.8rem;">' +
                        '<i class="fas fa-redo me-1"></i>Ulangi</button>';
                    notify('Waktu Habis!', 'Tantangan "' + title + '" sudah selesai waktunya.');
                    document.getElementById('restart-' + ucId).addEventListener('click', function () {
                        localStorage.setItem(key, JSON.stringify({ startedAt: Date.now(), totalSecs: totalSecs }));
                        runCountdown(ucId, title, el, key, totalSecs, false);
                    });
                }
                return;
            }

            /* ── Still running ── */
            var pct      = Math.round(((totalSecs - remaining) / totalSecs) * 100);
            var urgent   = remaining <= 60;
            var badgeCls = urgent ? 'bg-danger' : 'bg-primary';
            var barCls   = urgent ? 'bg-danger progress-bar-striped progress-bar-animated' : 'bg-success';

            bar.innerHTML =
                '<div class="w-100">' +
                '<div class="d-flex align-items-center justify-content-between mb-1">' +
                '<span class="badge ' + badgeCls + ' timer-countdown" style="font-size:.8rem;min-width:68px;">' +
                '<i class="fas fa-hourglass-half me-1"></i>' + fmt(remaining) + '</span>' +
                (autoComplete ? '' :
                    '<button id="stop-' + ucId + '" class="btn btn-outline-danger btn-sm py-0 px-2" style="font-size:.78rem;">' +
                    '<i class="fas fa-stop me-1"></i>Stop</button>') +
                '</div>' +
                '<div class="progress" style="height:5px;border-radius:4px;">' +
                '<div class="progress-bar ' + barCls + '" style="width:' + pct + '%;transition:width .9s linear;"></div>' +
                '</div></div>';

            if (!autoComplete) {
                var stopBtn = document.getElementById('stop-' + ucId);
                if (stopBtn) {
                    stopBtn.addEventListener('click', function () {
                        clearInterval(timers[ucId]);
                        localStorage.removeItem(key);
                        var item = document.querySelector('[data-uc-id="' + ucId + '"]');
                        buildWidget(ucId, (item && item.dataset.title) || title, el);
                    });
                }
            }
        }

        tick();
        timers[ucId] = setInterval(tick, 1000);
    }

    /* ── Init on page load ── */
    document.querySelectorAll('[data-uc-id]').forEach(function (item) {
        var ucId = item.dataset.ucId;
        var w    = document.getElementById('timer-widget-' + ucId);
        if (w) buildWidget(ucId, item.dataset.title, w);
    });

})();
</script>
@endpush
@endsection