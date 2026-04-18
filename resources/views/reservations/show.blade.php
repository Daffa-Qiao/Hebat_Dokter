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
                    <small>{{ $reservation->messages->count() }} pesan</small>
                </div>

                <!-- Messages -->
                <div id="chat-box" class="card-body overflow-auto flex-grow-1 d-flex flex-column gap-2 p-3"
                     style="max-height:340px; min-height:200px; background:#f8fdf8;">
                    @forelse($reservation->messages as $msg)
                        @php $isMe = $msg->sender_id === auth()->id(); @endphp
                        <div class="d-flex {{ $isMe ? 'justify-content-end' : 'justify-content-start' }}">
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
                        <div class="text-center text-muted my-auto py-4">
                            <i class="fas fa-comments fa-2x mb-2 d-block"></i>
                            Belum ada pesan. Mulai diskusi dengan dokter Anda!
                        </div>
                    @endforelse
                </div>

                <!-- Send Message Form -->
                <div class="card-footer bg-white border-top p-3">
                    @if(session('chatSuccess'))
                        <div class="alert alert-success py-1 px-2 small mb-2">{{ session('chatSuccess') }}</div>
                    @endif
                    <form method="POST" action="{{ route('reservations.message', $reservation) }}" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="body" class="form-control @error('body') is-invalid @enderror"
                               placeholder="Tulis pesan..." value="{{ old('body') }}" required autocomplete="off">
                        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <button type="submit" class="btn btn-success px-3">
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
// Auto-scroll chat to bottom
const chatBox = document.getElementById('chat-box');
if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush
@endsection
 