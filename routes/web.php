<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Tambahkan import ini

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

// Tambahan: Rute Logout GET untuk mengatasi error Method Not Allowed
// Ini memungkinkan logout tetap berjalan meskipun JavaScript/Vite belum termuat sempurna
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// 2. RUTE DASHBOARD UMUM
Route::get('/dashboard', function () {
    // Perbaikan: Ambil data dari model Category, bukan Kuisioner
    // Kita gunakan Eager Loading (with) agar data sub-kategori dan pertanyaan ikut terbawa
    $listCategories = \App\Models\Category::with('subCategories.questions')->get(); 
    
    // Perbaikan: Kirim variabel $listCategories sesuai yang diminta Blade
    return view('dashboard', compact('listCategories'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. RUTE MAHASISWA (Kuisioner)
Route::middleware(['auth', 'verified'])->group(function () {
    // Tambahkan parameter {kategori} di sini
    Route::get('/kuisioner/{kategori}', KuisionerForm::class)->name('kuisioner.index');
    Route::view('/thank-you', 'thank-you')->name('thank-you');
});

// 4. RUTE PROFILE
Route::middleware('auth')->group(function () {
    Route::patch('/data-diri/update', [App\Http\Controllers\ProfileController::class, 'updateDataDiri'])->name('user.data-diri.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. RUTE KHUSUS ADMIN 
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth']) 
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
});

//6. RUTE THANK YOU
Route::get('/thank-you', function () {
    return view('thank-you');
})->name('thank-you');

Route::middleware('auth')->group(function () {
    Route::patch('/profile/data-diri/update', [ProfileController::class, 'updateDataDiri'])->name('user.data-diri.update');
});

Route::patch('/user/data-diri', [ProfileController::class, 'updateDataDiri'])->name('user.data-diri.update');

require __DIR__.'/auth.php';
