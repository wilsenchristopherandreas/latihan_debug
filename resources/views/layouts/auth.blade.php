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


        /* ---------- Popup notifikasi (toast) ---------- */
        .toast-region {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 1080;
            width: min(380px, calc(100vw - 2rem));
            pointer-events: none;
        }

        @media (max-width: 575.98px) {
            .toast-region { top: 1rem; left: 1rem; right: 1rem; width: auto; }
        }

        .toast-card {
            pointer-events: auto;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            gap: .85rem;
            padding: 1rem 1rem 1.2rem;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 1rem;
            box-shadow: 0 22px 40px -14px rgba(15, 27, 51, .3), 0 2px 6px rgba(15, 27, 51, .06);
            animation: toast-in .45s cubic-bezier(.2, .9, .25, 1.1) both;
        }

        .toast-card.is-leaving { animation: toast-out .25s ease-in both; }

        .toast-icon {
            flex: none;
            width: 2.5rem;
            height: 2.5rem;
            display: grid;
            place-items: center;
            border-radius: .85rem;
            font-size: 1.2rem;
        }

        .toast-error .toast-icon   { background: #fdecec; color: #d92d20; }
        .toast-success .toast-icon { background: #e6f6ec; color: #12803a; }

        .toast-body { flex: 1; min-width: 0; }
        .toast-title { margin: 0 0 .15rem; font-weight: 700; font-size: .95rem; letter-spacing: -.01em; }
        .toast-text { margin: 0; color: var(--muted); font-size: .88rem; line-height: 1.5; }

        .toast-close {
            flex: none;
            width: 1.9rem;
            height: 1.9rem;
            margin: -.2rem -.2rem 0 0;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: .5rem;
            background: transparent;
            color: #8b96ab;
            font-size: .8rem;
        }

        .toast-close:hover { background: #f1f4f9; color: var(--text); }
        .toast-close:focus-visible { outline: 3px solid rgba(36, 87, 245, .45); outline-offset: 1px; }

        /* garis waktu di bawah toast, berhenti kalau di-hover */
        .toast-bar {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 3px;
            transform-origin: left;
            animation: toast-timer 6s linear forwards;
        }

        .toast-error .toast-bar   { background: #e5484d; }
        .toast-success .toast-bar { background: #16a34a; }
        .toast-card:hover .toast-bar { animation-play-state: paused; }

        @keyframes toast-in {
            from { opacity: 0; transform: translateY(-14px) scale(.97); }
            to   { opacity: 1; transform: none; }
        }

        @keyframes toast-out {
            to { opacity: 0; transform: translateY(-10px) scale(.97); }
        }

        @keyframes toast-timer { to { transform: scaleX(0); } }

        /* form bergetar sekali waktu login gagal */
        .shake { animation: shake .5s cubic-bezier(.36, .07, .19, .97) both; }

        @keyframes shake {
            10%, 90% { transform: translateX(-2px); }
            20%, 80% { transform: translateX(4px); }
            30%, 50%, 70% { transform: translateX(-7px); }
            40%, 60% { transform: translateX(7px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .sheet-badge,
            .toast-card,
            .toast-bar,
            .shake { animation: none; }
            .toast-bar { display: none; }
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

    @php
        $toast = null;
        if (session('toast_error')) {
            $toast = [
                'type' => 'error',
                'icon' => 'bi-shield-exclamation',
                'title' => session('toast_title', 'Ada yang salah'),
                'text' => session('toast_error'),
            ];
        } elseif (session('success')) {
            $toast = [
                'type' => 'success',
                'icon' => 'bi-check-lg',
                'title' => 'Berhasil',
                'text' => session('success'),
            ];
        }
    @endphp

    @if ($toast)
        <div class="toast-region" aria-live="assertive">
            <div class="toast-card toast-{{ $toast['type'] }}" id="toast" role="alert">
                <span class="toast-icon"><i class="bi {{ $toast['icon'] }}"></i></span>
                <div class="toast-body">
                    <p class="toast-title">{{ $toast['title'] }}</p>
                    <p class="toast-text">{{ $toast['text'] }}</p>
                </div>
                <button type="button" class="toast-close" aria-label="Tutup notifikasi">
                    <i class="bi bi-x-lg"></i>
                </button>
                <span class="toast-bar"></span>
            </div>
        </div>
    @endif

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

        // Popup notifikasi: tutup otomatis, bisa ditutup manual atau dengan Esc
        (function () {
            var toast = document.getElementById('toast');
            if (!toast) return;

            var closed = false;
            function closeToast() {
                if (closed) return;
                closed = true;
                toast.classList.add('is-leaving');
                setTimeout(function () { toast.parentNode && toast.parentNode.remove(); }, 260);
            }

            toast.querySelector('.toast-close').addEventListener('click', closeToast);
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeToast(); });

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                setTimeout(closeToast, 6000);
            } else {
                toast.querySelector('.toast-bar').addEventListener('animationend', closeToast);
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
