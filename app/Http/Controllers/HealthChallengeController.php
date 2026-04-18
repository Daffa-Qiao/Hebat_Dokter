<?php

namespace App\Http\Controllers;

use App\Jobs\DistributeDailyChallenges;
use App\Models\HealthChallenge;
use App\Models\UserChallenge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthChallengeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        if (Auth::check() && Auth::user()->role === 'pasien') {
            // Ensure today's challenges are distributed on-demand
            $existing = UserChallenge::where('user_id', Auth::id())
                ->where('challenge_date', $today)->count();
            if ($existing === 0) {
                DistributeDailyChallenges::dispatchSync();
            }

            $userChallenges = UserChallenge::with('challenge')
                ->where('user_id', Auth::id())
                ->where('challenge_date', $today)
                ->get();

            $totalPoints = $userChallenges->where('completed', true)->sum(fn($uc) => $uc->challenge->points ?? 10);
            $streak      = UserChallenge::where('user_id', Auth::id())->max('streak') ?? 0;
            $notifications = Auth::user()->unreadNotifications()->take(5)->get();

            return view('health-challenge', compact('userChallenges', 'totalPoints', 'streak', 'notifications'));
        }

        // Guests: show static list
        $challenges = HealthChallenge::where('active', true)->get();
        if ($challenges->isEmpty()) {
            $challenges = collect([
                (object)['title' => 'Minum 8 Gelas Air', 'description' => 'Mulailah hari dengan hidrasi yang baik.', 'points' => 10],
                (object)['title' => 'Tambah Sayuran di Makan Siang', 'description' => 'Tambahkan sayuran hijau atau salad.', 'points' => 10],
                (object)['title' => 'Berjalan 20 Menit', 'description' => 'Aktivitas sederhana untuk sirkulasi dan bakar kalori.', 'points' => 15],
                (object)['title' => 'Istirahat Tanpa Gadget', 'description' => 'Jeda dari layar setiap 2 jam.', 'points' => 10],
                (object)['title' => 'Pilih Camilan Sehat', 'description' => 'Buah atau kacang sebagai camilan.', 'points' => 10],
                (object)['title' => 'Tarik Napas Dalam', 'description' => 'Latihan pernapasan redakan stres.', 'points' => 5],
                (object)['title' => 'Tidur Teratur', 'description' => 'Jaga waktu tidur cukup dan teratur.', 'points' => 15],
            ]);
        }
        return view('health-challenge', compact('challenges'));
    }

    public function complete(Request $request, UserChallenge $userChallenge)
    {
        abort_unless($userChallenge->user_id === Auth::id(), 403);
        $userChallenge->update([
            'completed'    => true,
            'completed_at' => now(),
        ]);
        return back()->with('challengeSuccess', 'Tantangan selesai! +' . ($userChallenge->challenge->points ?? 10) . ' poin');
    }

    public function markRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }

    public function create() { }
    public function store(Request $request) { }
    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}

