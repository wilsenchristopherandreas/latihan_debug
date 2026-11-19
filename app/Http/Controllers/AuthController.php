<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Simpan user baru lalu langsung login.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email belum benar.',
            'email.unique' => 'Email ini sudah terdaftar. Coba masuk atau pakai email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan password.',
        ]);

        // Password otomatis di-hash lewat casts() di model User
        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email belum benar.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('absensi.index'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak cocok.'])
            ->onlyInput('email');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Kamu sudah keluar.');
    }
}
