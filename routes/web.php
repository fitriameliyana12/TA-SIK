<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDokterController;
use App\Http\Controllers\Admin\AdminFisioterapisController;
use App\Http\Controllers\Admin\AdminPasienController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAntrianController;
use App\Http\Controllers\Admin\AdminRiwayatTerapiController;
use App\Http\Controllers\Admin\AdminRMController;
use App\Http\Controllers\Fisioterapis\FisioterapisController;
use App\Http\Controllers\Fisioterapis\FisioterapisProfileController;
use App\Http\Controllers\Fisioterapis\FisioterapisRMController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pasien\PasienController;
use App\Http\Controllers\Pasien\ProfileController;
use App\Http\Controllers\Pasien\RiwayatTerapiController;
use App\Http\Controllers\Pasien\AntrianController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth Routes
Auth::routes();

Route::get('/home', function () {
    return view('index'); // Ganti 'home' dengan view yang sesuai
})->name('home');

// Halaman utama: redirect ke dashboard jika login, atau ke login form
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('auth.login');
});

// Route Login dan Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman profil admin
    Route::get('/dashboard/profile/adm', [AdminController::class, 'show'])->name('profileadm.show');
    
    // Halaman profil pasien
    Route::get('/dashboard/profile', [PasienController::class, 'show'])->name('profile.show');
    
    // Halaman edit profil pasien
    Route::get('/dashboard/profile/edit', [PasienController::class, 'edit'])->name('profile.edit');
    
    // Update profil pasien
    Route::put('/dashboard/profile/update', [PasienController::class, 'update'])->name('profile.update');

    Route::get('/riwayat-terapi', [RiwayatTerapiController::class, 'index'])->name('riwayat-terapi.index');
    // Route::get('/riwayat-terapi', [RiwayatTerapiController::class, 'index'])->name('pasien.riwayat');

    Route::get('/unduh-tiket-antrian/{id}', [RiwayatTerapiController::class, 'unduhTiketAntrian'])->name('pasien.unduh-tiket');

    Route::get('/pasien/{id}', [AntrianController::class, 'detail'])->name('pasien.detail');

    // Halaman profil fisioterapis
    Route::get('/dashboard/fisioterapis/profile', [FisioterapisProfileController::class, 'show'])->name('fisioterapis.profile.show');

    // Halaman edit profil fisioterapis
    Route::get('/dashboard/fisioterapis/profile/edit', [FisioterapisProfileController::class, 'edit'])->name('fisioterapis.profile.edit');

    // Update profil fisioterapis
    Route::put('/dashboard/fisioterapis/profile/update', [FisioterapisProfileController::class, 'update'])->name('fisioterapis.profile.update');

   // Rute untuk menampilkan daftar rekam medis pasien
Route::get('/fisioterapis/rekam-medis', [FisioterapisRMController::class, 'index'])->name('fisioterapis.rekam_medis.index');
Route::get('/fisioterapis/rekam-medis/{id}', [FisioterapisRMController::class, 'show'])->name('fisioterapis.rekam_medis.show');
Route::get('/fisioterapis/rekam-medis/{id}/edit', [FisioterapisRMController::class, 'edit'])->name('fisioterapis.rekam_medis.edit');
Route::put('/fisioterapis/rekam-medis/{id}/update', [FisioterapisRMController::class, 'update'])->name('fisioterapis.rekam_medis.update');

// Rute untuk menampilkan detail rekam medis pasien berdasarkan id rekam medis
// Rute untuk menampilkan detail pasien berdasarkan ID antrian
Route::get('/fisioterapis/antrian/{id}', [FisioterapisRMController::class, 'showByAntrian'])->name('fisioterapis.antrian.show');

Route::post('/fisioterapis/rekam_medis/store', [FisioterapisRMController::class, 'store'])->name('fisioterapis.rekam_medis.store');

Route::prefix('admin')->group(function () {
    Route::get('/riwayat-terapi', [AdminRiwayatTerapiController::class, 'index'])->name('admin.riwayat.index');
    Route::get('admin/riwayat-terapi/{id_pasien}', [AdminRiwayatTerapiController::class, 'detail'])->name('admin.riwayat.detail');
});


    // Menampilkan form untuk mengambil antrian
    Route::get('/antrian/create', [AntrianController::class, 'create'])->name('antrian.create');

    // Menyimpan data antrian yang diambil pasien
    // Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');
    Route::post('/proses-terapi', [AntrianController::class, 'store'])->name('proses.terapi');

    Route::get('/admin/antrian/{id_antrian}/edit', [AntrianController::class, 'edit'])->name('admin-antrian.edit');
    Route::put('/admin/antrian/{id_antrian}', [AntrianController::class, 'update'])->name('admin-antrian.update');


    // Rute lainnya yang mungkin ada di dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
        Route::get('/fisioterapis', [DashboardController::class, 'fisioterapis'])->name('fisioterapis.dashboard');
        Route::get('/pasien', [DashboardController::class, 'pasien'])->name('pasien.dashboard');
    });
});

// Resource Routes dengan Middleware
Route::middleware(['auth'])->group(function () {
    Route::resource('pasien', PasienController::class)->middleware('checkRole:dokter,pasien,admin');
    Route::resource('admin', AdminController::class)->middleware('checkRole:admin');

    // Admin-Specific Resource Routes
    Route::resource('admin-fisioterapis', AdminFisioterapisController::class)->middleware('checkRole:admin');
    Route::resource('admin-pasien', AdminPasienController::class)->middleware('checkRole:admin');
    Route::resource('admin-user', AdminUserController::class)->middleware('checkRole:admin');
    Route::resource('admin-antrian', AdminAntrianController::class)->middleware('checkRole:admin');
    Route::resource('admin-rekam-medis', AdminRMController::class)->middleware('checkRole:admin');

});



