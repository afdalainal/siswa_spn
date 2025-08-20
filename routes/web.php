<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Route::get('/', fn() => view('welcome'));

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

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

    // superadmin
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/dashboard/superadmin', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard.superadmin');
        Route::get('laporan', [\App\Http\Controllers\Superadmin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/laporan', [\App\Http\Controllers\Superadmin\LaporanController::class, 'laporan'])->name('laporan.laporan');
        Route::resource('siswa', \App\Http\Controllers\Superadmin\SiswaController::class);
        Route::resource('pengasuh', \App\Http\Controllers\Superadmin\PengasuhController::class);
        Route::resource('akunpeleton', \App\Http\Controllers\Superadmin\AkunPeletonController::class);
        Route::resource('tugaspeleton', \App\Http\Controllers\Superadmin\TugasPeletonController::class);
        Route::delete('/tugaspeleton/{id}/softdelete', [\App\Http\Controllers\Superadmin\TugasPeletonController::class, 'softdelete'])->name('tugaspeleton.softdelete');
        Route::patch('tugaspeleton/restore/{id}', [\App\Http\Controllers\Superadmin\TugasPeletonController::class, 'restore'])->name('tugaspeleton.restore');
    });

    // peleton
    Route::middleware(['role:peleton'])->group(function () {
        Route::get('/dashboard/peleton', [\App\Http\Controllers\Peleton\DashboardController::class, 'index'])->name('dashboard.peleton');
        
        Route::resource('penilaianpengamatan', \App\Http\Controllers\Peleton\PenilaianPengamatanController::class);
        Route::get('/penilaianpengamatan/grafik/{id}', [\App\Http\Controllers\Peleton\PenilaianPengamatanController::class, 'grafik'])->name('penilaianpengamatan.grafik');
        Route::get('/penilaianpengamatan/laporan/{id}', [\App\Http\Controllers\Peleton\PenilaianPengamatanController::class, 'laporan'])->name('penilaianpengamatan.laporan');
        Route::get('penilaianpengamatan/{tugasPeletonId}/siswa/{tugasSiswaId}', [\App\Http\Controllers\Peleton\PenilaianPengamatanController::class, 'showHarian'])->name('penilaianpengamatan.harian');
        
        
        Route::resource('penilaianharian', \App\Http\Controllers\Peleton\PenilaianHarianController::class);
        Route::get('/penilaianharian/grafik/{id}', [\App\Http\Controllers\Peleton\PenilaianHarianController::class, 'grafik'])->name('penilaianharian.grafik');
        Route::get('/penilaianharian/laporan/{id}', [\App\Http\Controllers\Peleton\PenilaianHarianController::class, 'laporan'])->name('penilaianharian.laporan');
        
        
        Route::resource('penilaianmingguan', \App\Http\Controllers\Peleton\PenilaianMingguanController::class);
        Route::get('/penilaianmingguan/grafik/{id}', [\App\Http\Controllers\Peleton\PenilaianMingguanController::class, 'grafik'])->name('penilaianmingguan.grafik');
        Route::get('/penilaianmingguan/laporan/{id}', [\App\Http\Controllers\Peleton\PenilaianMingguanController::class, 'laporan'])->name('penilaianmingguan.laporan');
        
        
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';