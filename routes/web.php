<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Livewire Components
use App\Livewire\KuisionerForm;
use App\Livewire\AdminDashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. RUTE PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// 2. RUTE DASHBOARD UMUM
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. RUTE MAHASISWA (Kuisioner)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/kuisioner', KuisionerForm::class)->name('kuisioner.index');
    Route::view('/thank-you', 'thank-you')->name('thank-you');
});

// 4. RUTE PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. RUTE KHUSUS ADMIN (Sudah diperbaiki)
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth']) // Hapus function() yang bikin error tadi
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
});

require __DIR__.'/auth.php';