<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function generateCaptcha(Request $request): array
    {
        $num1   = random_int(1, 9);
        $num2   = random_int(1, 9);
        $request->session()->put('captcha_answer', $num1 + $num2);
        return ['num1' => $num1, 'num2' => $num2];
    }

    public function showLogin(Request $request)
    {
        $rememberedEmail = Cookie::get('remembered_email');
        $captcha = $this->generateCaptcha($request);
        return view('auth.login', compact('rememberedEmail', 'captcha'));
    }

    public function login(Request $request)
    {
        // Validate captcha
        if ((string) $request->input('captcha') !== (string) $request->session()->get('captcha_answer')) {
            $this->generateCaptcha($request);
            return back()->withErrors(['captcha' => 'Jawaban captcha salah.'])->withInput();
        }
        $request->session()->forget('captcha_answer');

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($remember) {
                Cookie::queue('remembered_email', $request->email, 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('remembered_email'));
            }

            return $this->redirectToDashboard();
        }

        $this->generateCaptcha($request);
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function showRegister(Request $request)
    {
        $captcha = $this->generateCaptcha($request);
        return view('auth.register', compact('captcha'));
    }

    public function register(Request $request)
    {
        // Validate captcha
        if ((string) $request->input('captcha') !== (string) $request->session()->get('captcha_answer')) {
            $this->generateCaptcha($request);
            return back()->withErrors(['captcha' => 'Jawaban captcha salah.'])->withInput();
        }
        $request->session()->forget('captcha_answer');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|confirmed|min:8',
            'terms' => 'accepted',
            'role' => 'pasien',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'pasien',
            'phone' => $validated['phone'],
            'photo' => $photoPath,
        ]);
        Auth::login($user);
        return $this->redirectToDashboard();
    }

    private function redirectToDashboard()
    {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($role === 'dokter') {
            return redirect()->route('dashboard.dokter');
        } else {
            return redirect()->route('dashboard.pasien');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function dashboard_pasien()
    {
        $jumlahReservasi = \App\Models\Reservation::where('pasien_id', auth()->id())->count();
        $upcomingReservation = \App\Models\Reservation::with('dokter')
            ->where('pasien_id', auth()->id())
            ->where('jadwal', '>=', now())
            ->orderBy('jadwal')
            ->first();
        $latestDoctors = \App\Models\User::where('role', 'dokter')->latest()->take(3)->get();
        $latestEvents = \App\Models\Event::latest()->take(3)->get();
        $latestDietTips = \App\Models\DietTip::latest()->take(3)->get();
        // Statistik reservasi per bulan untuk pasien
        $reservasiPerBulan = \App\Models\Reservation::selectRaw('EXTRACT(MONTH FROM jadwal) as bulan, COUNT(*) as total')
            ->where('pasien_id', auth()->id())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')->toArray();
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $reservasiPerBulan[$i] ?? 0;
        }
        return view('dashboard-pasien', compact('jumlahReservasi', 'upcomingReservation', 'latestDoctors', 'latestEvents', 'latestDietTips', 'chartData'));
    }

    public function dashboard_dokter()
    {
        $menunggu = \App\Models\Reservation::where('dokter_id', auth()->id())->where('status', 'pending')->count();
        $diterima = \App\Models\Reservation::where('dokter_id', auth()->id())->where('status', 'accepted')->count();
        $ditolak = \App\Models\Reservation::where('dokter_id', auth()->id())->where('status', 'rejected')->count();
        $upcomingAppointments = \App\Models\Reservation::with('pasien')
            ->where('dokter_id', auth()->id())
            ->where('jadwal', '>=', now())
            ->orderBy('jadwal')
            ->take(5)
            ->get();
        // Statistik reservasi per bulan untuk dokter
        $reservasiPerBulan = \App\Models\Reservation::selectRaw('EXTRACT(MONTH FROM jadwal) as bulan, COUNT(*) as total')
            ->where('dokter_id', auth()->id())
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')->toArray();
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $reservasiPerBulan[$i] ?? 0;
        }
        return view('dashboard-dokter', compact('menunggu', 'diterima', 'ditolak', 'upcomingAppointments', 'chartData'));
    }

    public function dashboard_admin()
    {
        $totalUser = \App\Models\User::count();
        $totalReservasi = \App\Models\Reservation::count();
        $totalDoctors = \App\Models\User::where('role', 'dokter')->count();
        $totalEvents = \App\Models\Event::count();
        $totalDietTips = \App\Models\DietTip::count();
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $recentReservations = \App\Models\Reservation::with(['pasien', 'dokter'])->latest()->take(5)->get();
        // Data reservasi per bulan (12 bulan)
        $reservasiPerBulan = \App\Models\Reservation::selectRaw('EXTRACT(MONTH FROM jadwal) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')->toArray();
        // Normalisasi agar 12 bulan selalu ada
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $reservasiPerBulan[$i] ?? 0;
        }
        return view('dashboard-admin', compact('totalUser', 'totalReservasi', 'totalEvents', 'totalDoctors', 'totalDietTips', 'recentUsers', 'recentReservations', 'chartData'));
    }

    public function showEditProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|confirmed|min:8',
        ]);
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->photo = $photoPath;
        }
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
} 