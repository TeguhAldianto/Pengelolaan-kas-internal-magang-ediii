<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // --- Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Dashboard Utama ---
    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');

    // --- Fitur Khusus Manager (Laporan) ---
    Route::middleware('role:manager')->group(function () {
        Route::get('/report/print', [TransactionController::class, 'printReport'])->name('report.print');
    });

    // --- Fitur Khusus Admin (Full Akses) ---
    Route::middleware('role:admin')->group(function () {
        // Transaksi: Input & Transfer
        Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
        Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transaction.transfer');

        // Transaksi: Edit & Hapus (BARU)
        Route::put('/transaction/{id}', [TransactionController::class, 'update'])->name('transaction.update');
        Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__ . '/auth.php';
