<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        $data = $request->validated();
        
        if (!empty($data['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        unset($data['current_password']);
        unset($data['password_confirmation']);

        $user->fill($data);

        // Handle foto_profil upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('avatars', $filename, 'public');
            
            $user->foto_profil = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


public function updateDataDiri(Request $request)
{
    $user = $request->user();
    $user->update($request->all());

    // Gunakan nama unik yang HANYA digunakan untuk edit profil
    return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
}
}