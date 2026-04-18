<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['pasien', 'dokter']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pasien', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('dokter', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get data for modal
        $pasiens = User::where('role', 'pasien')->get();
        $dokters = User::where('role', 'dokter')->get();
        
        return view('admin.reservations.index', compact('reservations', 'pasiens', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'dokter_id' => 'required|exists:users,id',
            'jadwal' => 'required|date|after:now',
            'status' => 'required|in:pending,accepted,rejected',
            'keterangan' => 'nullable|string',
        ]);

        // Verify that selected users have correct roles
        $pasien = User::find($request->pasien_id);
        $dokter = User::find($request->dokter_id);
        
        if ($pasien->role !== 'pasien') {
            return back()->withErrors(['pasien_id' => 'User yang dipilih bukan pasien.']);
        }
        
        if ($dokter->role !== 'dokter') {
            return back()->withErrors(['dokter_id' => 'User yang dipilih bukan dokter.']);
        }

        Reservation::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'jadwal' => $request->jadwal,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['pasien', 'dokter']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $dokters = User::where('role', 'dokter')->get();
        return view('admin.reservations.edit', compact('reservation', 'dokters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'jadwal' => 'required|date',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        // Verify that selected doctor has correct role
        $dokter = User::find($request->dokter_id);
        if ($dokter->role !== 'dokter') {
            return back()->withErrors(['dokter_id' => 'User yang dipilih bukan dokter.']);
        }

        $reservation->update($request->only(['dokter_id', 'jadwal', 'keterangan', 'status']));

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }
} 