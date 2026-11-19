@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h1 class="auth-title">Masuk ke akunmu</h1>
    <p class="auth-sub">Masukkan email dan password untuk membuka data absensi.</p>

    @if (session('success'))
        <div class="notice" role="status">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <div class="input-wrap">
                <i class="bi bi-envelope lead-icon"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control auth-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>
            @error('email')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i><span>{{ $message }}</span></div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
                <i class="bi bi-lock lead-icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control auth-input @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pass" data-toggle-password="password" aria-label="Tampilkan password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i><span>{{ $message }}</span></div>
            @enderror
        </div>

        <div class="remember">
            <input type="checkbox" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Ingat saya di perangkat ini</label>
        </div>

        <button type="submit" class="btn-auth w-100">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
        </button>
    </form>

    <p class="switch-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </p>
@endsection
