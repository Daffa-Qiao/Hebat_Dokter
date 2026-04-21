@extends('layouts.app')
@section('title', 'Detail Reservasi')
@section('content')
@include('layouts.navbars.dashboardnav')
<div class="container py-4">
    <div class="row justify-content-center g-4">
        <!-- Detail Reservasi -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-calendar-check me-2"></i>Detail Reservasi
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Pasien</dt>
                        <dd class="col-sm-8">{{ $reservation->pasien->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Penyakit</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-warning text-dark">{{ $reservation->disease ?? '-' }}</span>
                        </dd>

                        <dt class="col-sm-4">Dokter</dt>
                        <dd class="col-sm-8">
                            @if($reservation->dokter)
                                Dr. {{ $reservation->dokter->name }}
                                <small class="text-muted">({{ $reservation->dokter->specialization ?? 'Umum' }})</small>
                            @else
                                <span class="text-muted">Menunggu penugasan</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Jadwal</dt>
                        <dd class="col-sm-8">{{ $reservation->jadwal->locale('id')->translatedFormat('l, d F Y – H:i') }} WIB</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if($reservation->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($reservation->status === 'accepted')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </dd>

                        @if($reservation->keterangan)
                        <dt class="col-sm-4">Keterangan</dt>
                        <dd class="col-sm-8">{{ $reservation->keterangan }}</dd>
                        @endif
                    </dl>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">← Kembali</a>
                </div>
            </div>
        </div>

        <!-- Chat Section -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 d-flex flex-column" style="min-height:420px;">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-comments me-2"></i>Diskusi Reservasi</span>
                    <span class="badge bg-white text-success" id="msg-count">{{ $reservation->messages->count() }} pesan</span>
                </div>

                <!-- Messages -->
                <div id="chat-box" class="card-body overflow-auto flex-grow-1 d-flex flex-column gap-2 p-3"
                     style="max-height:340px; min-height:200px; background:#f8fdf8;">
                    @forelse($reservation->messages as $msg)
                        @php $isMe = $msg->sender_id === auth()->id(); @endphp
                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}" data-msg-id="{{ $msg->id }}">
                            <div class="p-2 rounded-3 shadow-sm"
                                 style="max-width:75%; background:{{ $isMe ? '#d1fae5' : '#ffffff' }}; border:1px solid {{ $isMe ? '#86efac' : '#e5e7eb' }}">
                                <div class="fw-semibold small mb-1 {{ $isMe ? 'text-success' : 'text-secondary' }}">
                                    {{ $isMe ? 'Anda' : $msg->sender->name }}
                                    @if($msg->sender->role === 'dokter') <span class="badge bg-success ms-1">Dokter</span> @endif
                                </div>
                                <p class="mb-0" style="font-size:0.95rem;">{{ $msg->body }}</p>
                                <div class="text-muted text-end" style="font-size:0.75rem;">{{ $msg->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div id="empty-chat" class="text-center text-muted my-auto py-4">
                            <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                            Belum ada pesan. Mulai diskusi dengan dokter Anda!
                        </div>
                    @endforelse
                </div>

                <!-- Typing indicator -->
                <div id="typing-indicator" class="px-3 pb-1" style="display:none; min-height:20px;">
                    <small class="text-muted fst-italic"><i class="fas fa-circle-notch fa-spin me-1"></i>Mengirim...</small>
                </div>

                <!-- Send Message Form -->
                <div class="card-footer bg-white border-top p-3">
                    <form id="chat-form" class="d-flex gap-2">
                        @csrf
                        <input type="text" id="chat-input" name="body" class="form-control"
                               placeholder="Tulis pesan..." autocomplete="off" required>
                        <button type="submit" class="btn btn-success px-3" id="chat-send-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
(function () {
    const chatBox     = document.getElementById('chat-box');
    const chatForm    = document.getElementById('chat-form');
    const chatInput   = document.getElementById('chat-input');
    const sendBtn     = document.getElementById('chat-send-btn');
    const typingEl    = document.getElementById('typing-indicator');
    const msgCount    = document.getElementById('msg-count');
    const emptyChat   = document.getElementById('empty-chat');

    const SEND_URL    = "{{ route('reservations.message', $reservation) }}";
    const FETCH_URL   = "{{ route('reservations.messages', $reservation) }}";
    const MY_ID       = {{ auth()->id() }};
    const CSRF        = document.querySelector('#chat-form input[name="_token"]').value;

    // Track last known message id from rendered messages
    let lastId = 0;
    document.querySelectorAll('[data-msg-id]').forEach(el => {
        const id = parseInt(el.dataset.msgId, 10);
        if (id > lastId) lastId = id;
    });

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function makeMessageEl(msg) {
        const isMe = msg.sender_id === MY_ID;
        const wrapper = document.createElement('div');
        wrapper.className = 'd-flex ' + (isMe ? 'justify-content-end' : 'justify-content-start');
        wrapper.dataset.msgId = msg.id;

        const bubble = document.createElement('div');
        bubble.className = 'p-2 rounded-3 shadow-sm';
        bubble.style.cssText = `max-width:75%; background:${isMe ? '#d1fae5' : '#ffffff'}; border:1px solid ${isMe ? '#86efac' : '#e5e7eb'}`;

        const doctorBadge = msg.role === 'dokter'
            ? ' <span class="badge bg-success ms-1">Dokter</span>'
            : '';

        bubble.innerHTML = `
            <div class="fw-semibold small mb-1 ${isMe ? 'text-success' : 'text-secondary'}">
                ${isMe ? 'Anda' : msg.sender}${doctorBadge}
            </div>
            <p class="mb-0" style="font-size:0.95rem;">${escapeHtml(msg.body)}</p>
            <div class="text-muted text-end" style="font-size:0.75rem;">${msg.created_at}</div>`;

        wrapper.appendChild(bubble);
        return wrapper;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    function appendMessages(messages) {
        if (!messages.length) return;

        if (emptyChat) emptyChat.remove();

        messages.forEach(msg => {
            if (msg.id <= lastId) return;
            chatBox.appendChild(makeMessageEl(msg));
            lastId = msg.id;
        });

        // Update count badge
        const total = document.querySelectorAll('[data-msg-id]').length;
        if (msgCount) msgCount.textContent = total + ' pesan';

        scrollToBottom();
    }

    // Poll every 2.5 seconds
    function poll() {
        fetch(`${FETCH_URL}?since=${lastId}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => appendMessages(data.messages || []))
        .catch(() => {}); // silent fail, will retry
    }

    const pollInterval = setInterval(poll, 2500);

    // AJAX send
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const body = chatInput.value.trim();
        if (!body) return;

        sendBtn.disabled = true;
        if (typingEl) typingEl.style.display = 'block';

        fetch(SEND_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ body })
        })
        .then(r => r.json())
        .then(msg => {
            if (msg.id) {
                chatInput.value = '';
                appendMessages([msg]);
            }
        })
        .catch(() => alert('Gagal mengirim pesan. Coba lagi.'))
        .finally(() => {
            sendBtn.disabled = false;
            if (typingEl) typingEl.style.display = 'none';
        });
    });

    // Stop polling when page is hidden to save bandwidth
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) clearInterval(pollInterval);
    });

    scrollToBottom();
})();
</script>
@endpush
@endsection