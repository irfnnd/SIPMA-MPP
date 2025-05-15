<?php

use App\Http\Controllers\KategoriPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\UnitLayananController;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengadu.landingpage');
});

Route::get('/beranda', function () {
    return view('pengadu.landingpage');
})->name('beranda');

Route::middleware(['auth'])->group(function () {
    Route::resource('pengaduan', PengaduanController::class);
    Route::get('/lihat-pengaduan',[PengaduanController::class, 'index2'])->name('lihat-pengaduan');
});

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('auth.login-admin');
    });
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('login.admin');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');
    Route::get('logout', function () {
        Auth::logout();
        return redirect('/admin/login');
    })->name('admin.logout');
});



Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('kategori', KategoriPengaduanController::class);
    Route::resource('unit', UnitLayananController::class);
    Route::resource('data-pengaduan', PengaduanController::class);
    Route::resource('data-masyarakat', App\Http\Controllers\MasyarakatController::class);
    Route::resource('data-petugas', App\Http\Controllers\PetugasController::class);
    Route::resource('data-pengguna', App\Http\Controllers\UsersController::class);
    Route::post('/tanggapan/store', [TanggapanController::class, 'store'])->name('tanggapan.store');
    Route::put('/tanggapan/{id}', [TanggapanController::class, 'update'])->name('tanggapan.update');
});
