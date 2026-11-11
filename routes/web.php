<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MahasiswaController;

// 1. Halaman utama redirect ke tabel mahasiswa
Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});

// 2. Tampilkan Form Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 3. Proses Verifikasi Login (Bypass AuthController)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/mahasiswa');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

// 4. Proses Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// 5. Penanganan Link Register
Route::get('/register', function () {
    return redirect()->route('login');
})->name('register');

// 6. Proteksi Middleware Auth & Multi-Role
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    });
});