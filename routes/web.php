<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengadu.landingpage');
});
Route::get('/beranda', function () {
    return view('pengadu.landingpage');
})->name('beranda');
Route::get('/pengaduan', function () {
    return view('pengadu.formpengaduan');
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

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
