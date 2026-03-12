<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // 1. Validasi data sesuai dengan atribut 'name' di file register.blade.php Anda
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'gender' => ['required', 'string'],
        'status_responden' => ['required', 'string'],
        'program_studi' => ['required', 'string'],
        'angkatan' => ['required', 'string'],
    //     ], [
    // // Custom pesan error
    // 'name.required' => 'Wajib isi nama lengkap ya!',
    ]);

    // 2. Simpan data ke database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'gender' => $request->gender,
        'status_responden' => $request->status_responden,
        'program_studi' => $request->program_studi,
        'angkatan' => $request->angkatan,
        'role' => 'mahasiswa', // Memberikan akses otomatis sebagai mahasiswa
    ]);

    event(new Registered($user));

    Auth::login($user);

    // 3. Arahkan ke dashboard setelah berhasil
    return redirect(route('dashboard', absolute: false));
}
}
