<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\TabunganController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

app('router')->aliasMiddleware('role', RoleMiddleware::class);

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('penabung', UnitController::class);
        Route::resource('setoran', SetoranController::class);
        Route::resource('tabungan', TabunganController::class);
        Route::resource('donasi', DonasiController::class);
    });
});



require __DIR__.'/auth.php';
