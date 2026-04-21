<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

            // Cek apakah email sudah diverifikasi
            if (is_null(Auth::user()->email_verified_at)) {
                $email = Auth::user()->email;
                Auth::logout();
                $this->generateCaptcha($request);
                return redirect()->route('verify.email.show', ['email' => $email])
                    ->withErrors(['email' => 'Email Anda belum diverifikasi. Silakan cek email dan masukkan kode verifikasi.']);
            }

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
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role'     => 'pasien',
            'phone'    => $validated['phone'],
            'photo'    => $photoPath,
        ]);

        $code    = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(10);

        // Simpan langsung ke DB agar pasti tersimpan
        \DB::table('users')->where('id', $user->id)->update([
            'email_verification_code'       => $code,
            'email_verification_expires_at' => $expires,
        ]);

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        return redirect()->route('verify.email.show', ['email' => $user->email]);
    }

    public function showVerifyEmail(Request $request)
    {
        $email = $request->query('email');
        if (!$email) {
            return redirect()->route('register');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Akun dengan email tersebut tidak ditemukan.']);
        }

        if (!is_null($user->email_verified_at)) {
            return redirect()->route('login')
                ->with('success', 'Email Anda sudah terverifikasi. Silakan login.');
        }

        return view('auth.verify-email', compact('email'));
    }

    public function submitVerifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Akun tidak ditemukan atau sudah diverifikasi.']);
        }

        // Ambil nilai fresh langsung dari DB untuk menghindari isu cache/cast
        $dbUser = \DB::table('users')->where('id', $user->id)->first();

        if ((string) $dbUser->email_verification_code !== (string) $request->code) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.']);
        }

        if ($dbUser->email_verification_expires_at && now()->isAfter($dbUser->email_verification_expires_at)) {
            return back()->withErrors(['code' => 'Kode verifikasi sudah kadaluarsa. Silakan minta kode baru.']);
        }

        \DB::table('users')->where('id', $user->id)->update([
            'email_verified_at'             => now(),
            'email_verification_code'       => null,
            'email_verification_expires_at' => null,
        ]);

        Auth::login($user);
        return $this->redirectToDashboard();
    }

    public function resendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Akun tidak ditemukan atau sudah diverifikasi.']);
        }

        $code    = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(10);

        \DB::table('users')->where('id', $user->id)->update([
            'email_verification_code'       => $code,
            'email_verification_expires_at' => $expires,
        ]);

        Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name));

        return redirect()->route('verify.email.show', ['email' => $user->email])
            ->with('success', 'Kode verifikasi baru telah dikirim ke email Anda.');
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
        return view('pasien.dashboard', compact('jumlahReservasi', 'upcomingReservation', 'latestDoctors', 'latestEvents', 'latestDietTips', 'chartData'));
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
        return view('dokter.dashboard', compact('menunggu', 'diterima', 'ditolak', 'upcomingAppointments', 'chartData'));
    }

    public function dashboard_admin()
    {
        $totalUser = \App\Models\User::count();
        $totalReservasi = \App\Models\Reservation::count();
        $totalDoctors = \App\Models\User::where('role', 'dokter')->count();
        $totalEvents = \App\Models\Event::count();
        $totalDietTips = \App\Models\DietTip::count();
        $totalMenuSehat = \App\Models\HealthyMenu::count();
        $totalArtikel = \App\Models\Article::count();
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
        return view('admin.dashboard', compact('totalUser', 'totalReservasi', 'totalEvents', 'totalDoctors', 'totalDietTips', 'totalMenuSehat', 'totalArtikel', 'recentUsers', 'recentReservations', 'chartData'));
    }

    public function showEditProfile()
    {
        $user = auth()->user();
        return view('pasien.profile.edit', compact('user'));
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
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
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