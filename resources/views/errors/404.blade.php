<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 Halaman Tidak Ditemukan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --accent: #CEF17B;
            --accent-dark: #b0d65a;
            --text-primary: #1a1a1a;
            --text-muted: #8a8a8a;
            --bg: #f9f9f9;
            --card-bg: #ffffff;
            --border: #e8e8e8;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-primary);
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            gap: 0;
        }

        /* ── Top decoration dots ── */
        .deco-dots {
            position: fixed;
            top: 24px;
            right: 32px;
            display: flex;
            gap: 7px;
            opacity: 0.35;
        }
        .deco-dots span {
            width: 9px; height: 9px;
            border-radius: 50%;
            background: var(--text-muted);
        }

        /* ── SVG illustration ── */
        .illustration {
            width: 220px;
            height: auto;
            margin-bottom: 2.5rem;
            animation: float 3.5s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }

        /* ── 404 number ── */
        .error-code {
            font-size: clamp(6rem, 18vw, 10rem);
            font-weight: 900;
            letter-spacing: -4px;
            line-height: 1;
            color: var(--text-primary);
            position: relative;
            margin-bottom: 0.35rem;
        }
        .error-code::after {
            content: '404';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--accent) 20%, transparent 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0.18;
            font-weight: 900;
            z-index: -1;
            transform: translate(4px, 5px);
            letter-spacing: -4px;
        }

        /* ── Divider line ── */
        .divider {
            width: 52px;
            height: 3px;
            background: var(--accent);
            border-radius: 99px;
            margin: 0.85rem auto 1.1rem;
        }

        /* ── Sub text ── */
        .error-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.4px;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .error-sub {
            font-size: 0.92rem;
            color: var(--text-muted);
            text-align: center;
            max-width: 340px;
            line-height: 1.65;
            margin-bottom: 2.4rem;
        }

        /* ── Button ── */
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            background: var(--accent);
            color: #1a1a1a;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.8rem 2.2rem;
            border-radius: 50px;
            border: 2px solid transparent;
            transition: background 0.22s, transform 0.18s, box-shadow 0.22s;
            box-shadow: 0 4px 18px rgba(206, 241, 123, 0.35);
        }
        .btn-home:hover {
            background: var(--accent-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 26px rgba(206, 241, 123, 0.5);
        }
        .btn-home svg {
            width: 16px; height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── Bottom watermark ── */
        .watermark {
            position: fixed;
            bottom: 22px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.76rem;
            color: var(--border);
            letter-spacing: 0.06em;
            user-select: none;
            white-space: nowrap;
        }

        /* ── Subtle grid bg ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(to right, #e8e8e8 1px, transparent 1px),
                linear-gradient(to bottom, #e8e8e8 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.45;
            pointer-events: none;
            z-index: 0;
        }

        .page-wrapper { position: relative; z-index: 1; }
    </style>
</head>
<body>

    <!-- Decoration dots top-right -->
    <div class="deco-dots">
        <span></span><span></span><span></span>
    </div>

    <div class="page-wrapper">

        <!-- SVG Illustration -->
        <img
            src="{{ asset('img/not-found.svg') }}"
            alt="Halaman tidak ditemukan"
            class="illustration"
        />

        <!-- 404 Big Number -->
        <div class="error-code">404</div>

        <!-- Accent divider -->
        <div class="divider"></div>

        <!-- Text -->
        <p class="error-title">Oops!, Page not Found</p>
        <p class="error-sub">
            Halaman yang kamu cari tidak ada atau telah dipindahkan.
            Coba kembali ke halaman utama.
        </p>

        <!-- CTA Button -->
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}" class="btn-home">
            <svg viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Go Back Home
        </a>

    </div>

    <!-- Watermark -->
    <div class="watermark">Sistem Perpustakaan Digital &mdash; Error 404</div>

</body>
</html>
