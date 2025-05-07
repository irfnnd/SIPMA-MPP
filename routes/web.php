<?php

use App\Http\Controllers\KategoriPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UnitLayananController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengadu.landingpage');
});
Route::get('/beranda', function () {
    return view('pengadu.landingpage');
})->name('beranda');

Route::middleware(['auth'])->group(function () {
    Route::get('/pengaduan', function () {
        return view('pengadu.formpengaduan');
    })->name('pengaduan');
    Route::get('/lihat-pengaduan',[PengaduanController::class, 'index2'])->name('lihat-pengaduan');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('auth.login-admin');
    });
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('login.admin');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('logout', function () {
        Auth::logout();
        return redirect('/admin/login');
    })->name('logout');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::middleware(['auth', 'role:masyarakat'])->group(function () {
//     Route::get('/', function () {
//         return view('pengadu.landingpage');
//     });
// });

Route::prefix('admin')->middleware(['admin', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('kategori', KategoriPengaduanController::class);
    Route::resource('unit', UnitLayananController::class);
    Route::resource('pengaduan', PengaduanController::class);
    Route::resource('data-masyarakat', App\Http\Controllers\MasyarakatController::class);
    Route::resource('data-petugas', App\Http\Controllers\PetugasController::class);
    Route::resource('data-pengguna', App\Http\Controllers\UsersController::class);

});
