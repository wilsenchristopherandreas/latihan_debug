<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') - PWL UTS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --ink: #0f1b33;
            --ink-soft: #1a2a4d;
            --paper: #f4f6fb;
            --line: #dde3ee;
            --text: #1b2640;
            --muted: #66728a;
            --blue: #2457f5;
            --blue-dark: #1b44c8;
            --danger: #b42318;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--paper);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 992px) {
            .auth-shell { grid-template-columns: minmax(400px, 5fr) 6fr; }
        }

        /* ---------- Panel kiri: kertas absen ---------- */
        .auth-side {
            display: none;
            position: relative;
            overflow: hidden;
            padding: 3rem 3.5rem;
            color: #fff;
            background-color: var(--ink);
            /* garis seperti kertas daftar hadir */
            background-image:
                linear-gradient(to right, transparent 71px, rgba(255, 255, 255, .10) 71px, rgba(255, 255, 255, .10) 72px, transparent 72px),
                repeating-linear-gradient(to bottom, transparent 0, transparent 39px, rgba(255, 255, 255, .05) 39px, rgba(255, 255, 255, .05) 40px);
        }

        @media (min-width: 992px) {
            .auth-side {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 2.5rem;
            }
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .7rem;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: -.01em;
            text-decoration: none;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--blue);
            color: #fff;
            font-size: 1.15rem;
        }

        .auth-side .brand { color: #fff; }

        .side-title {
            font-size: clamp(2rem, 3.2vw, 2.9rem);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0 0 1rem;
            max-width: 15ch;
        }

        .side-text {
            color: rgba(255, 255, 255, .68);
            max-width: 38ch;
            line-height: 1.65;
            margin: 0;
        }

        /* kartu contoh rekap */
        .sheet {
            background: #fff;
            color: var(--text);
            border-radius: 16px;
            padding: .4rem 0;
            max-width: 400px;
            box-shadow: 0 28px 50px -18px rgba(0, 0, 0, .55);
        }

        .sheet-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 1rem;
            padding: .9rem 1.25rem;
            border-bottom: 1px solid #eef1f6;
            font-size: .82rem;
            color: var(--muted);
        }

        .sheet-head strong { color: var(--text); font-weight: 700; font-size: .9rem; }

        .sheet-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .8rem 1.25rem;
            border-bottom: 1px solid #f1f4f8;
        }

        .sheet-row:last-child { border-bottom: 0; }

        .sheet-name { font-weight: 700; font-size: .84rem; text-transform: uppercase; line-height: 1.25; }
        .sheet-nim { color: var(--muted); font-size: .76rem; }

        .sheet-badge {
            min-width: 58px;
            text-align: center;
            padding: .25rem .7rem;
            border-radius: 6px;
            font-size: .74rem;
            font-weight: 700;
            animation: pop .5s cubic-bezier(.2, .8, .2, 1) both;
            animation-delay: calc(var(--i) * .18s + .35s);
        }

        .b-hadir { background: #d1fae5; color: #047857; }
        .b-absen { background: #fee2e2; color: #b91c1c; }
        .b-izin  { background: #dbeafe; color: #1d4ed8; }
        .b-sakit { background: #fef3c7; color: #b45309; }

        @keyframes pop {
            from { opacity: 0; transform: scale(.6); }
            to   { opacity: 1; transform: scale(1); }
        }

        .side-foot { color: rgba(255, 255, 255, .45); font-size: .82rem; margin: 0; }

        /* ---------- Panel kanan: form ---------- */
        .auth-main {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
        }

        .auth-form-wrap { width: 100%; max-width: 420px; }

        .mobile-brand { display: flex; margin-bottom: 2rem; color: var(--ink); }
        @media (min-width: 992px) { .mobile-brand { display: none; } }

        .auth-title {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0 0 .4rem;
        }

        .auth-sub { color: var(--muted); margin: 0 0 2rem; line-height: 1.55; }

        .field { margin-bottom: 1.15rem; }

        .field label {
            display: block;
            font-size: .88rem;
            font-weight: 600;
            margin-bottom: .45rem;
        }

        .input-wrap { position: relative; }

        .input-wrap > .lead-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8b96ab;
            pointer-events: none;
            font-size: 1.05rem;
            transition: color .15s;
        }

        .input-wrap:focus-within > .lead-icon { color: var(--blue); }

        .auth-input {
            height: 3rem;
            padding: 0 2.9rem 0 2.8rem;
            border-radius: .8rem;
            border: 1px solid var(--line);
            background: #fff;
            font-size: .95rem;
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
        }

        .auth-input::placeholder { color: #a3adc0; }

        .auth-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 4px rgba(36, 87, 245, .14);
            background: #fff;
            color: var(--text);
        }

        .auth-input.is-invalid {
            border-color: #e5484d;
            background-image: none;
            padding-right: 2.9rem;
        }

        .auth-input.is-invalid:focus { box-shadow: 0 0 0 4px rgba(229, 72, 77, .15); }

        .toggle-pass {
            position: absolute;
            right: .35rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.4rem;
            height: 2.4rem;
            border: 0;
            border-radius: .6rem;
            background: transparent;
            color: #8b96ab;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-pass:hover { color: var(--text); background: #f1f4f9; }

        .field-error {
            display: flex;
            align-items: flex-start;
            gap: .4rem;
            margin-top: .4rem;
            color: var(--danger);
            font-size: .83rem;
            line-height: 1.4;
        }

        .field-hint { margin-top: .4rem; color: var(--muted); font-size: .8rem; }

        .notice {
            display: flex;
            gap: .6rem;
            align-items: center;
            padding: .8rem 1rem;
            border-radius: .8rem;
            background: #e8f6ee;
            color: #146c43;
            font-size: .9rem;
            margin-bottom: 1.5rem;
        }

        .btn-auth,
        .btn-ghost-auth {
            height: 3rem;
            border-radius: .8rem;
            font-weight: 600;
            font-size: .95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            text-decoration: none;
            transition: background .15s, border-color .15s, transform .1s;
        }

        .btn-auth {
            border: 0;
            background: var(--blue);
            color: #fff;
        }

        .btn-auth:hover { background: var(--blue-dark); color: #fff; }
        .btn-auth:active { transform: translateY(1px); }

        .btn-ghost-auth {
            padding: 0 1.4rem;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--muted);
        }

        .btn-ghost-auth:hover { border-color: #c4cddd; color: var(--text); }

        .btn-auth:focus-visible,
        .btn-ghost-auth:focus-visible,
        .toggle-pass:focus-visible,
        .switch-link a:focus-visible {
            outline: 3px solid rgba(36, 87, 245, .45);
            outline-offset: 2px;
        }

        .remember { display: flex; align-items: center; gap: .55rem; font-size: .88rem; color: var(--muted); margin: .25rem 0 1.5rem; }
        .remember input { width: 1.05rem; height: 1.05rem; accent-color: var(--blue); margin: 0; cursor: pointer; }
        .remember label { cursor: pointer; margin: 0; }

        .switch-link { text-align: center; color: var(--muted); font-size: .9rem; margin: 1.75rem 0 0; }
        .switch-link a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .switch-link a:hover { text-decoration: underline; }

        @media (prefers-reduced-motion: reduce) {
            .sheet-badge { animation: none; }
            * { transition: none !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-shell">
        {{-- Panel kiri (dekoratif, hanya tampil di layar lebar) --}}
        <aside class="auth-side" aria-hidden="true">
            <a class="brand" href="{{ route('login') }}" tabindex="-1">
                <span class="brand-icon"><i class="bi bi-calendar2-check"></i></span>
                PWL UTS
            </a>

            <div>
                <h2 class="side-title">Absensi kelas, tercatat rapi.</h2>
                <p class="side-text">
                    Pilih mata kuliah, tandai Hadir, Izin, Sakit, atau Absen, lalu rekapnya langsung tersimpan.
                </p>
            </div>

            <div class="sheet">
                <div class="sheet-head">
                    <strong>Pemograman Web Dasar</strong>
                    <span>ST0001</span>
                </div>
                <div class="sheet-row">
                    <div>
                        <div class="sheet-name">Saya</div>
                        <div class="sheet-nim">0001</div>
                    </div>
                    <span class="sheet-badge b-hadir" style="--i:0">Hadir</span>
                </div>
                <div class="sheet-row">
                    <div>
                        <div class="sheet-name">Kamu</div>
                        <div class="sheet-nim">0002</div>
                    </div>
                    <span class="sheet-badge b-izin" style="--i:1">Izin</span>
                </div>
                <div class="sheet-row">
                    <div>
                        <div class="sheet-name">Dia</div>
                        <div class="sheet-nim">0003</div>
                    </div>
                    <span class="sheet-badge b-sakit" style="--i:2">Sakit</span>
                </div>
            </div>

            <p class="side-foot">Sistem Absensi Mahasiswa</p>
        </aside>

        {{-- Panel kanan: form --}}
        <main class="auth-main">
            <div class="auth-form-wrap">
                <a class="brand mobile-brand" href="{{ route('login') }}">
                    <span class="brand-icon"><i class="bi bi-calendar2-check"></i></span>
                    PWL UTS
                </a>

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Tombol tampilkan / sembunyikan password
        document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById(btn.dataset.togglePassword);
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
                btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
