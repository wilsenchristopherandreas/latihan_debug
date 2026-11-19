@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <h1 class="auth-title">Buat akun baru</h1>
    <p class="auth-sub">Isi data di bawah untuk mulai mengelola absensi mahasiswa.</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="field">
            <label for="name">Nama lengkap</label>
            <div class="input-wrap">
                <i class="bi bi-person lead-icon"></i>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control auth-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    autocomplete="name"
                    required
                    autofocus
                >
            </div>
            @error('name')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i><span>{{ $message }}</span></div>
            @enderror
        </div>

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
                    placeholder="Minimal 8 karakter"
                    autocomplete="new-password"
                    minlength="8"
                    required
                >
                <button type="button" class="toggle-pass" data-toggle-password="password" aria-label="Tampilkan password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="field-error"><i class="bi bi-exclamation-circle"></i><span>{{ $message }}</span></div>
            @else
                <div class="field-hint">Pakai minimal 8 karakter.</div>
            @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi password</label>
            <div class="input-wrap">
                <i class="bi bi-shield-lock lead-icon"></i>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control auth-input"
                    placeholder="Ketik ulang passwordmu"
                    autocomplete="new-password"
                    required
                >
                <button type="button" class="toggle-pass" data-toggle-password="password_confirmation" aria-label="Tampilkan password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn-auth flex-grow-1">
                <i class="bi bi-person-check"></i> Daftar
            </button>
            <a href="{{ route('login') }}" class="btn-ghost-auth">Batal</a>
        </div>
    </form>

    <p class="switch-link">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </p>
@endsection
