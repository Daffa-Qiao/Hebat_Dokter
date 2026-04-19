<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HealthChallengeController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DietTipController;
use App\Http\Controllers\Admin\HealthyMenuController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Dokter\HealthyMenuController as DokterHealthyMenuController;
use App\Http\Controllers\Dokter\ArticleController as DokterArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Models\HealthyMenu;
use App\Models\Event;
use App\Models\DietTip;
use App\Models\Reservation;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $events   = Event::latest()->take(3)->get();
    $dietTips = DietTip::latest()->take(3)->get();
    $doctors  = User::where('role', 'dokter')->take(4)->get();
    $articles = \App\Models\Article::with('author')->where('published', true)->latest()->take(3)->get();

    // For authenticated pasien: fetch last reservation disease
    $lastReservationDisease = null;
    if (Auth::check() && Auth::user()->role === 'pasien') {
        $lastReservation = Reservation::where('pasien_id', Auth::id())
            ->whereNotNull('disease')
            ->latest()
            ->first();
        $lastReservationDisease = $lastReservation?->disease;
    }

    return view('index', compact('events', 'dietTips', 'doctors', 'lastReservationDisease', 'articles'));
})->name('home');

// Auth routes
Route::get('captcha', [CaptchaController::class, 'generate'])->name('captcha');
Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('register', [UserController::class, 'showRegister'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::get('verify-email', [UserController::class, 'showVerifyEmail'])->name('verify.email.show');
Route::post('verify-email', [UserController::class, 'submitVerifyEmail'])->name('verify.email.submit');
Route::post('verify-email/resend', [UserController::class, 'resendVerificationCode'])->name('verify.email.resend');
Route::post('logout', [UserController::class, 'logout'])->name('logout');

// Dashboard untuk masing-masing role
Route::get('dashboard/pasien', [UserController::class, 'dashboard_pasien'])->middleware(['auth', 'role:pasien'])->name('dashboard.pasien');
Route::get('dashboard/dokter', [UserController::class, 'dashboard_dokter'])->middleware(['auth', 'role:dokter'])->name('dashboard.dokter');
Route::get('dashboard/admin', [UserController::class, 'dashboard_admin'])->middleware(['auth', 'role:admin'])->name('dashboard.admin');

// Hitung Kalori (auth only)
Route::middleware(['auth'])->get('hitung-kalori', function () {
    return view('kalori');
})->name('calories.index');

// Kalkulator BMI (public)
Route::get('bmi', function () {
    return view('bmi');
})->name('bmi.index');

// Artikel Kesehatan (public)
Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Makanan Sehat (auth only – filtered by last reservation disease)
Route::middleware(['auth'])->get('menu-sehat', function (Request $request) {
    $specialization = $request->get('specialization');

    // If no filter provided and user is pasien, auto-filter by last reservation
    if (!$specialization && Auth::check() && Auth::user()->role === 'pasien') {
        $lastReservation = \App\Models\Reservation::where('pasien_id', Auth::id())
            ->whereNotNull('disease')->latest()->first();
        $specialization = $lastReservation?->disease;
    }

    $menus = \App\Models\HealthyMenu::when($specialization, function ($query, $specialization) {
        return $query->where('specialization', 'like', "%{$specialization}%")
                     ->orWhere('specialization', 'like', '%Umum%');
    })->orderBy('created_at', 'desc')->get();

    return view('menu-sehat', compact('menus', 'specialization'));
})->name('healthy-menus.index');

// Route::get('menu-sehat', function () {
//     return view('menu-sehat');
// })->name('healthy-menus.index');    
Route::get('menu-sehat/{menu}', [HealthyMenuController::class, 'show'])->name('healthy-menus.show');

// Halaman Event Publik
Route::get('events', function () {
    $events = Event::latest()->get();
    return view('events', compact('events'));
})->name('events.index');

// Halaman Tips Diet Publik
Route::get('diet-tips', function () {
    $dietTips = DietTip::latest()->get();
    return view('diet-tips', compact('dietTips'));
})->name('diet-tips.index');

Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('health-challenge', [HealthChallengeController::class, 'index'])->name('health-challenge.index');
    Route::post('health-challenge/{userChallenge}/complete', [HealthChallengeController::class, 'complete'])->name('health-challenge.complete');
    Route::post('health-challenge/mark-read', [HealthChallengeController::class, 'markRead'])->name('health-challenge.markRead');
});

// Dokter
Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

// Group route reservasi
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('reservations/doctors-by-disease', [ReservationController::class, 'getDoctorsByDisease'])->name('reservations.doctorsByDisease');
    Route::resource('reservations', ReservationController::class)->only(['index', 'create', 'store', 'show']);
});

// Chat message route (auth — pasien, dokter, admin)
Route::middleware(['auth'])->post('reservations/{reservation}/message', [ReservationController::class, 'sendMessage'])->name('reservations.message');

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('reservations/{reservation}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');
    Route::post('reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    Route::resource('healthy-menus', DokterHealthyMenuController::class)->except(['show']);
    Route::resource('articles', DokterArticleController::class)->except(['show']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('reservations', ReservationController::class)->except(['create']);
    Route::resource('users', UserManagementController::class)->except(['create']);
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('diet-tips', DietTipController::class)->except(['show']);
    Route::resource('healthy-menus', HealthyMenuController::class)->except(['show']);
    Route::resource('articles', AdminArticleController::class)->except(['show']);
});

// Ubah Profil
Route::middleware(['auth'])->group(function () {
    Route::get('profile/edit', [UserController::class, 'showEditProfile'])->name('profile.edit');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});