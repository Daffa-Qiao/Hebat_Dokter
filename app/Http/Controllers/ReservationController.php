<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // List reservasi sesuai role
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $reservations = Reservation::with(['pasien', 'dokter'])->latest()->get();
        } elseif ($user->role === 'dokter') {
            $reservations = Reservation::with(['pasien', 'dokter'])->where('dokter_id', $user->id)->latest()->get();
        } else {
            $reservations = Reservation::with(['pasien', 'dokter'])->where('pasien_id', $user->id)->latest()->get();
        }

        $dokters = $user->role === 'admin' ? User::where('role', 'dokter')->get() : collect();

        $diseases = [
            'Jantung'    => 'Kardiologi',
            'Pencernaan' => 'Gastroenterologi',
            'Ginjal'     => 'Nefrologi',
            'Paru-paru'  => 'Pulmonologi',
            'Saraf'      => 'Neurologi',
            'Kulit'      => 'Dermatologi',
            'Anak'       => 'Pediatri',
            'Gigi'       => 'Gigi',
            'Mata'       => 'Mata',
            'Ortopedi'   => 'Ortopedi',
            'Umum'       => 'Umum',
        ];

        return view('pasien.reservations.index', compact('reservations', 'dokters', 'diseases'));
    }

    // Form buat reservasi (pasien)
    public function create()
    {
        $diseases = [
            'Jantung'      => 'Kardiologi',
            'Pencernaan'   => 'Gastroenterologi',
            'Ginjal'       => 'Nefrologi',
            'Paru-paru'    => 'Pulmonologi',
            'Saraf'        => 'Neurologi',
            'Kulit'        => 'Dermatologi',
            'Anak'         => 'Pediatri',
            'Gigi'         => 'Gigi',
            'Mata'         => 'Mata',
            'Ortopedi'     => 'Ortopedi',
            'Umum'         => 'Umum',
        ];
        return view('pasien.reservations.create', compact('diseases'));
    }

    // Simpan reservasi (pasien)
    public function store(Request $request)
    {
        $request->validate([
            'disease'    => 'required|string|max:100',
            'jadwal'     => 'required|date|after:today',
            'keterangan' => 'nullable|string',
        ]);

        $diseaseToSpec = [
            'Pencernaan'=> 'Gastroenterologi',
            'Ginjal'    => 'Nefrologi',
            'Paru-paru' => 'Pulmonologi',
            'Saraf'     => 'Neurologi',
            'Kulit'     => 'Dermatologi',
            'Anak'      => 'Pediatri',
            'Gigi'      => 'Gigi',
            'Mata'      => 'Mata',
            'Ortopedi'  => 'Ortopedi',
            'Umum'      => 'Umum',
        ];

        $specialization = $diseaseToSpec[$request->disease] ?? null;

        // Auto-assign doctor by specialization (least busy first)
        $dokter = null;
        if ($specialization) {
            $dokter = User::where('role', 'dokter')
                ->where(function ($q) use ($specialization) {
                    $q->where('specialization', 'like', "%{$specialization}%")
                      ->orWhere('specialization', 'like', "%{$specialization[0]}%");
                })
                ->withCount(['reservations as active_count' => fn($q) => $q->where('status', 'pending')])
                ->orderBy('active_count')
                ->first();
        }
        if (!$dokter) {
            $dokter = User::where('role', 'dokter')
                ->where(function ($q) { $q->whereNull('specialization')->orWhere('specialization', 'Umum'); })
                ->withCount(['reservations as active_count' => fn($q) => $q->where('status', 'pending')])
                ->orderBy('active_count')
                ->first();
        }

        // Cek konflik jadwal: dokter yang sama, jam yang sama
        if ($dokter) {
            $jadwalCarbon = \Carbon\Carbon::parse($request->jadwal);
            $conflict = Reservation::where('dokter_id', $dokter->id)
                ->whereYear('jadwal', $jadwalCarbon->year)
                ->whereMonth('jadwal', $jadwalCarbon->month)
                ->whereDay('jadwal', $jadwalCarbon->day)
                ->whereRaw('EXTRACT(HOUR FROM jadwal) = ?', [$jadwalCarbon->hour])
                ->whereIn('status', ['pending', 'accepted'])
                ->exists();

            if ($conflict) {
                return back()->withInput()->withErrors([
                    'jadwal' => 'Dokter sudah memiliki jadwal pada jam tersebut. Silakan pilih jam lain.',
                ]);
            }
        }

        Reservation::create([
            'pasien_id'  => Auth::id(),
            'dokter_id'  => $dokter?->id,
            'disease'    => $request->disease,
            'jadwal'     => $request->jadwal,
            'keterangan' => $request->keterangan,
            'status'     => 'pending',
        ]);

        return redirect()->route('pasien.reservations.index')->with('success', 'Reservasi berhasil dibuat! Dokter akan segera menghubungi Anda.');
    }

    // Tampilkan detail reservasi + chat
    public function show(Reservation $reservation)
    {
        $reservation->load(['pasien', 'dokter', 'messages.sender']);
        return view('pasien.reservations.show', compact('reservation'));
    }

    // Kirim pesan chat di reservasi
    public function sendMessage(Request $request, Reservation $reservation)
    {
        $request->validate(['body' => 'required|string|max:2000']);
        $user = Auth::user();

        $canChat = $user->id === $reservation->pasien_id
            || $user->id === $reservation->dokter_id
            || $user->role === 'admin';
        abort_unless($canChat, 403);

        $message = Message::create([
            'reservation_id' => $reservation->id,
            'sender_id'      => $user->id,
            'body'           => $request->body,
        ]);

        $message->load('sender');

        if ($request->expectsJson()) {
            return response()->json([
                'id'         => $message->id,
                'body'       => $message->body,
                'sender_id'  => $message->sender_id,
                'sender'     => $message->sender->name,
                'role'       => $message->sender->role,
                'created_at' => $message->created_at->format('H:i'),
            ]);
        }

        return back()->with('chatSuccess', 'Pesan terkirim!');
    }

    // Ambil pesan baru sejak ID tertentu (polling)
    public function getMessages(Request $request, Reservation $reservation)
    {
        $user = Auth::user();
        $canChat = $user->id === $reservation->pasien_id
            || $user->id === $reservation->dokter_id
            || $user->role === 'admin';
        abort_unless($canChat, 403);

        $since = $request->integer('since', 0);

        $messages = Message::with('sender')
            ->where('reservation_id', $reservation->id)
            ->where('id', '>', $since)
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'body'       => $m->body,
                'sender_id'  => $m->sender_id,
                'sender'     => $m->sender->name,
                'role'       => $m->sender->role,
                'created_at' => $m->created_at->format('H:i'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    // Cari dokter berdasarkan penyakit (AJAX untuk form reservasi)
    public function getDoctorsByDisease(Request $request)
    {
        $diseaseToSpec = [
            'Jantung'    => 'Kardiologi',
            'Pencernaan' => 'Gastroenterologi',
            'Ginjal'     => 'Nefrologi',
            'Paru-paru'  => 'Pulmonologi',
            'Saraf'      => 'Neurologi',
            'Kulit'      => 'Dermatologi',
            'Anak'       => 'Pediatri',
            'Gigi'       => 'Gigi',
            'Mata'       => 'Mata',
            'Ortopedi'   => 'Ortopedi',
            'Umum'       => 'Umum',
        ];

        $disease        = $request->get('disease');
        $specialization = $diseaseToSpec[$disease] ?? null;

        if (!$specialization) {
            return response()->json(['doctors' => [], 'specialization' => null]);
        }

        $doctors = User::where('role', 'dokter')
            ->where('specialization', 'like', "%{$specialization}%")
            ->withCount(['reservations as pending_count' => fn($q) => $q->where('status', 'pending')])
            ->orderBy('pending_count')
            ->get()
            ->map(fn($d) => [
                'id'             => $d->id,
                'name'           => $d->name,
                'specialization' => $d->specialization,
                'experience'     => $d->experience,
                'pending_count'  => $d->pending_count,
                'photo'          => $d->photo ? asset('storage/' . $d->photo) : null,
            ]);

        return response()->json([
            'doctors'        => $doctors,
            'specialization' => $specialization,
        ]);
    }

    // Cek jadwal yang sudah terisi untuk dokter tertentu pada tanggal tertentu
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer|exists:users,id',
            'date'      => 'required|date_format:Y-m-d',
        ]);

        $bookedHours = Reservation::where('dokter_id', $request->doctor_id)
            ->whereDate('jadwal', $request->date)
            ->whereIn('status', ['pending', 'accepted'])
            ->selectRaw('EXTRACT(HOUR FROM jadwal)::int AS hour')
            ->pluck('hour')
            ->map(fn($h) => str_pad((string)$h, 2, '0', STR_PAD_LEFT))
            ->values();

        return response()->json(['booked_hours' => $bookedHours]);
    }

    // Edit reservasi (admin)
    public function edit(Reservation $reservation)
    {
        $dokters = User::where('role', 'dokter')->get();
        return view('pasien.reservations.edit', compact('reservation', 'dokters'));
    }

    // Update reservasi (admin)
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'jadwal' => 'required|date|after:now',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected',
        ]);
        $reservation->update($request->only(['dokter_id', 'jadwal', 'keterangan', 'status']));
        return redirect()->route(auth()->user()->role . '.reservations.index')->with('success', 'Reservasi berhasil diupdate!');
    }

    // Hapus reservasi (admin)
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route(auth()->user()->role . '.reservations.index')->with('success', 'Reservasi berhasil dihapus!');
    }

    // Dokter menerima reservasi
    public function accept(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $reservation->update(['status' => 'accepted']);
        return redirect()->route(auth()->user()->role . '.reservations.index')->with('success', 'Reservasi diterima.');
    }

    // Dokter menolak reservasi
    public function reject(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $reservation->update(['status' => 'rejected']);
        return redirect()->route(auth()->user()->role . '.reservations.index')->with('success', 'Reservasi ditolak.');
    }
} 