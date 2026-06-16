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
    $user = auth()->user();
    
    // Jika admin, tampilkan semua kuesioner. Jika bukan, filter berdasarkan tipe_pegawai atau 'semua'
    if ($user->role === 'admin') {
        $listCategories = \App\Models\Category::with('subCategories.questions')->get(); 
    } else {
        $userType = strtolower($user->tipe_pegawai ?? '');
        $listCategories = \App\Models\Category::with('subCategories.questions')
            ->where('target_role', 'semua')
            ->orWhere('target_role', $userType)
            ->get();
    }
    
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
        Route::get('/export-hasil/{category}', [App\Http\Controllers\Admin\ExportKuisionerController::class, 'export'])->name('export.hasil');
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
