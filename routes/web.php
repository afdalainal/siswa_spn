<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;


Route::get('/', fn() => view('welcome'));

// Grup login
Route::middleware(['auth'])->group(function () {
    // Redirect otomatis berdasarkan role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'superadmin' => to_route('dashboard.superadmin'),
            'peleton' => to_route('dashboard.peleton'),
            default => abort(403),
        };
    })->name('dashboard');

    // Halaman superadmin
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/dashboard/superadmin', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard.superadmin');
        Route::resource('anggota', \App\Http\Controllers\Superadmin\AnggotaController::class);

    });

    // Halaman peleton
    Route::middleware(['role:peleton'])->group(function () {
        Route::get('/dashboard/peleton', [\App\Http\Controllers\Peleton\DashboardController::class, 'index'])->name('dashboard.peleton');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';