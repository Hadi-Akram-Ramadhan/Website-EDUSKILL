<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kodein - Platform Belajar Pemrograman Interaktif SMP & SMA</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- GSAP & Canvas Confetti Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --primary-blue-light: #eff6ff;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --accent-green-bg: #ecfdf5;
            --accent-orange: #f59e0b;
            --accent-orange-shadow: #d97706;
            --accent-red: #ef4444;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            position: relative;
            background-image: 
                radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 30%), rgba(37, 99, 235, 0.07) 0%, transparent 60%),
                linear-gradient(to right, rgba(226, 232, 240, 0.4) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.4) 1px, transparent 1px);
            background-size: 100% 100%, 48px 48px, 48px 48px;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* Custom Interactive Glowing Cursor (Desktop Only) */
        .cursor-dot, .cursor-follower {
            position: fixed;
            top: 0;
            left: 0;
            pointer-events: none;
            border-radius: 50%;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
        }

        .cursor-dot {
            width: 8px;
            height: 8px;
            background: var(--primary-blue);
            box-shadow: 0 0 12px var(--primary-blue);
        }

        .cursor-follower {
            width: 38px;
            height: 38px;
            border: 2px solid rgba(37, 99, 235, 0.4);
            background: rgba(37, 99, 235, 0.04);
            backdrop-filter: blur(2px);
            transition: width 0.25s ease, height 0.25s ease, background-color 0.25s ease, border-color 0.25s ease;
        }

        .cursor-follower.hover-active {
            width: 64px;
            height: 64px;
            background: rgba(37, 99, 235, 0.12);
            border-color: var(--primary-blue);
        }

        @media (hover: none) or (max-width: 768px) {
            .cursor-dot, .cursor-follower {
                display: none !important;
            }
        }

        /* 3D Button Utility */
        .btn-3d {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 14px 28px;
            font-size: 14px;
            text-decoration: none;
            user-select: none;
            transition: transform 0.1s ease, filter 0.15s ease, box-shadow 0.1s ease;
        }

        .btn-3d:active {
            transform: translateY(4px);
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }
        .btn-blue:active {
            box-shadow: 0 0 0 var(--primary-blue-shadow);
        }

        .btn-green {
            background: var(--accent-green);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--accent-green-shadow);
        }
        .btn-green:active {
            box-shadow: 0 0 0 var(--accent-green-shadow);
        }

        .btn-outline {
            background: #ffffff;
            color: var(--primary-blue);
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-outline:active {
            box-shadow: 0 0 0 #cbd5e1;
        }

        /* Navbar */
        .navbar {
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 20;
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            max-width: 1140px;
            margin: 20px auto 70px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
            position: relative;
            z-index: 10;
            width: 100%;
        }

        .hero-title {
            font-size: 46px;
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: -1.2px;
            margin-bottom: 20px;
            color: #0f172a;
        }

        .hero-title span {
            color: var(--primary-blue);
            position: relative;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 32px;
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* Interactive Antigravity Terminal Preview Card */
        .interactive-stage {
            position: relative;
            perspective: 1200px;
            width: 100%;
        }

        .code-terminal-card {
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 28px;
            box-shadow: 0 20px 40px -15px rgba(37, 99, 235, 0.12), 0 8px 0 #e2e8f0;
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 0.2s cubic-bezier(0.2, 0, 0.2, 1);
            width: 100%;
        }

        .terminal-header {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .terminal-dots {
            display: flex;
            gap: 8px;
        }
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        .terminal-body {
            padding: 24px;
            background: #ffffff;
        }

        /* Floating Antigravity Badges (Desktop) */
        .antigravity-badge {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 2px solid #bfdbfe;
            border-radius: 20px;
            padding: 12px 18px;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.15), 0 4px 0 #bfdbfe;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 15;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .antigravity-badge:hover {
            transform: scale(1.06) translateY(-4px);
            border-color: var(--primary-blue);
        }

        .badge-1 {
            top: -24px;
            left: -20px;
        }

        .badge-2 {
            bottom: -20px;
            right: -15px;
        }

        .badge-3 {
            bottom: 40px;
            left: -35px;
        }

        .badges-wrapper {
            position: relative;
            width: 100%;
        }

        /* Features Section */
        .features-container {
            max-width: 1140px;
            margin: 0 auto 100px auto;
            padding: 0 24px;
            width: 100%;
        }

        .features-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 24px;
            padding: 30px 24px;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: transform 0.2s ease, border-color 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: #bfdbfe;
            box-shadow: 0 12px 24px -6px rgba(37, 99, 235, 0.12), 0 4px 0 #bfdbfe;
        }

        .feature-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: var(--primary-blue-light);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Responsive Breakpoints for Mobile */
        @media (max-width: 860px) {
            .navbar {
                padding: 16px 16px;
            }
            .navbar .logo-text {
                display: none;
            }
            .navbar .btn-3d {
                padding: 8px 14px;
                font-size: 12px;
                border-radius: 12px;
            }

            .hero-section {
                grid-template-columns: 1fr;
                gap: 36px;
                text-align: center;
                margin: 10px auto 50px auto;
                padding: 0 16px;
            }

            .hero-title {
                font-size: 30px;
                letter-spacing: -0.5px;
                margin-bottom: 14px;
            }

            .hero-subtitle {
                font-size: 14px;
                line-height: 1.55;
                margin: 0 auto 24px auto;
            }

            .hero-actions {
                flex-direction: column;
                width: 100%;
                gap: 12px;
            }

            .hero-actions .btn-3d {
                width: 100%;
                padding: 14px;
            }

            .terminal-body {
                padding: 16px;
            }

            .terminal-body pre {
                font-size: 12px;
                line-height: 1.5;
            }

            /* Responsive Floating Badges on Mobile */
            .antigravity-badge {
                position: static !important;
                transform: none !important;
                width: 100% !important;
                box-shadow: 0 4px 0 #bfdbfe !important;
                justify-content: flex-start;
                padding: 10px 14px;
                border-radius: 14px;
            }

            .mobile-badges-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-top: 16px;
                width: 100%;
            }

            .features-container {
                margin-bottom: 60px;
                padding: 0 16px;
            }

            .features-header h2 {
                font-size: 24px;
            }

            .feature-card {
                padding: 22px 18px;
            }
        }
    </style>
</head>
<body>

    <!-- Custom Glowing Mouse Follower Elements -->
    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-follower" id="cursor-follower"></div>

    <!-- Top Navigation Header -->
    <header class="navbar" id="navbar">
        <a href="/" style="display: flex; align-items: center; gap: 10px; text-decoration: none;" class="hover-target">
            <div style="width: 42px; height: 42px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 0 #1e40af; flex-shrink: 0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <div>
                <span style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">KODEIN</span>
                <span class="logo-text" style="font-size: 9px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 8px;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue hover-target">
                    Roadmap Belajar
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline hover-target">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue hover-target">
                    Daftar
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section with Antigravity Interactive Playground -->
    <section class="hero-section" id="hero">
        
        <!-- Left: Catchy Headline & CTAs -->
        <div class="hero-content">
            <div class="badge-tag" style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary-blue-light); border: 1px solid #bfdbfe; color: var(--primary-blue); padding: 6px 14px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 16px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Platform Belajar Interaktif SMP &amp; SMA
            </div>

            <h1 class="hero-title" id="hero-heading">
                Belajar Coding Menyenangkan Seperti <span>Bermain Game</span>
            </h1>

            <p class="hero-subtitle" id="hero-subtext">
                Tantangan kuis interaktif algoritma, susun baris kode *Parsons problem*, pertahankan *streak* harian, dan raih sertifikat resmi dengan verifikasi QR Code publik.
            </p>

            <div class="hero-actions" id="hero-buttons">
                <a href="{{ route('register') }}" class="btn-3d btn-blue hover-target" style="font-size: 15px; padding: 16px 36px;">
                    Mulai Petualangan
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline hover-target">
                    Demo Akun
                </a>
            </div>
        </div>

        <!-- Right: Interactive Antigravity 3D Code Terminal Preview -->
        <div class="interactive-stage" id="stage">
            
            <div class="badges-wrapper">
                <!-- Antigravity Floating Badge 1 (Top Left on Desktop) -->
                <div class="antigravity-badge badge-1 hover-target float-anim-1" data-parallax="0.3">
                    <div style="width: 32px; height: 32px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Tantangan 1</div>
                        <div class="code-font" style="font-size: 13px; font-weight: 700; color: #0f172a;">print("Halo Dunia")</div>
                    </div>
                </div>

                <!-- Interactive Terminal Card -->
                <div class="code-terminal-card hover-target" id="terminal-card">
                    <div class="terminal-header">
                        <div class="terminal-dots">
                            <div class="dot dot-red"></div>
                            <div class="dot dot-yellow"></div>
                            <div class="dot dot-green"></div>
                        </div>
                        <div class="code-font" style="font-size: 12px; font-weight: 700; color: #64748b;">
                            belajar_python.py
                        </div>
                        <div style="font-size: 11px; font-weight: 800; color: #10b981; background: #ecfdf5; padding: 2px 8px; border-radius: 6px;">
                            PYTHON 3
                        </div>
                    </div>

                    <div class="terminal-body">
                        <!-- Code Snippet Area -->
                        <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 14px; text-align: left; overflow-x: auto;">
                            <pre class="code-font" style="font-size: 13px; line-height: 1.6; color: #1e293b; margin: 0;"><span style="color: #2563eb; font-weight: 700;">def</span> <span style="color: #059669; font-weight: 700;">sambutan_siswa</span>(nama):
    pesan = <span style="color: #d97706;">f"Selamat datang {nama} di Kodein!"</span>
    <span style="color: #2563eb; font-weight: 700;">return</span> pesan

print(sambutan_siswa(<span style="color: #d97706;">"Budi"</span>))</pre>
                        </div>

                        <!-- Interactive Simulation Button -->
                        <button type="button" id="btn-run-demo" class="btn-3d btn-green hover-target" style="width: 100%; padding: 12px; font-size: 13px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Jalankan Kode Program
                        </button>

                        <!-- Terminal Output Box -->
                        <div id="demo-output-box" style="margin-top: 12px; background: #0f172a; border-radius: 14px; padding: 12px 16px; color: #38bdf8; font-size: 12px; font-family: 'Fira Code', monospace; min-height: 44px; display: flex; align-items: center; text-align: left;">
                            <span style="color: #64748b; margin-right: 8px;">&gt;</span>
                            <span id="demo-output-text">Klik tombol di atas untuk menjalankan simulasi...</span>
                        </div>
                    </div>
                </div>

                <!-- Antigravity Floating Badge 2 (Bottom Right on Desktop) -->
                <div class="antigravity-badge badge-2 hover-target float-anim-2" data-parallax="0.45">
                    <div style="width: 32px; height: 32px; border-radius: 10px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary-blue); text-transform: uppercase;">Sertifikat Sah</div>
                        <div style="font-size: 13px; font-weight: 800; color: #0f172a;">QR SHA-256 Valid</div>
                    </div>
                </div>

                <!-- Antigravity Floating Badge 3 (Bottom Left on Desktop) -->
                <div class="antigravity-badge badge-3 hover-target float-anim-3" data-parallax="0.2">
                    <div style="color: var(--accent-orange); flex-shrink: 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 900; color: var(--accent-orange);">
                        7 Hari Streak Belajar
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Features Showcase Grid -->
    <section class="features-container" id="features">
        <div class="features-header">
            <div style="display: inline-flex; align-items: center; gap: 6px; color: var(--primary-blue); font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Mengapa Memilih Kodein
            </div>
            <h2 style="font-size: 32px; font-weight: 900; color: #0f172a;">Dirancang Khusus untuk Siswa SMP &amp; SMA</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card hover-target">
                <div class="feature-icon-wrapper">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Parsons Code Ordering</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Susun balok baris kode algoritma layaknya puzzle balok untuk melatih logika berpikir tanpa takut frustrasi eror sintaks.</p>
            </div>

            <div class="feature-card hover-target">
                <div class="feature-icon-wrapper" style="background: #fef2f2; color: #ef4444;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Gamifikasi Nyawa &amp; Streak</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Jaga nyawa belajar kamu, kumpulkan gems berharga, dan pertahankan streak api setiap hari agar kebiasaan coding terbentuk.</p>
            </div>

            <div class="feature-card hover-target">
                <div class="feature-icon-wrapper" style="background: #fef3c7; color: #d97706;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Liga &amp; Papan Peringkat</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Raih posisi podium teratas di Liga Berlian mingguan dan pamerkan lencana pencapaian kepada teman sekolah.</p>
            </div>

            <div class="feature-card hover-target">
                <div class="feature-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Sertifikat Terverifikasi QR</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Selesaikan seluruh unit untuk menerbitkan sertifikat digital resmi bertanda tangan kriptografis dengan QR publik.</p>
            </div>
        </div>
    </section>

    <!-- GSAP & Interactive Cursor Script Engine -->
    <script>
        // Interactive Mouse Movement & Custom Cursor
        const cursorDot = document.getElementById('cursor-dot');
        const cursorFollower = document.getElementById('cursor-follower');
        const terminalCard = document.getElementById('terminal-card');
        const stage = document.getElementById('stage');
        const parallaxBadges = document.querySelectorAll('[data-parallax]');

        let mouseX = window.innerWidth / 2;
        let mouseY = window.innerHeight / 2;
        let followerX = mouseX;
        let followerY = mouseY;

        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;

            // Set CSS custom variables for reactive gradient spotlight
            document.body.style.setProperty('--mouse-x', `${mouseX}px`);
            document.body.style.setProperty('--mouse-y', `${mouseY}px`);

            // 3D Card Perspective Tilt (Desktop Only)
            if (stage && terminalCard && window.innerWidth > 860) {
                const rect = stage.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const deltaX = (e.clientX - centerX) / (rect.width / 2);
                const deltaY = (e.clientY - centerY) / (rect.height / 2);

                gsap.to(terminalCard, {
                    rotationY: deltaX * 8,
                    rotationX: -deltaY * 8,
                    ease: "power1.out",
                    duration: 0.5
                });

                // Parallax on Floating Badges
                parallaxBadges.forEach(badge => {
                    const depth = parseFloat(badge.getAttribute('data-parallax')) || 0.2;
                    gsap.to(badge, {
                        x: deltaX * depth * 30,
                        y: deltaY * depth * 30,
                        ease: "power1.out",
                        duration: 0.6
                    });
                });
            }
        });

        // Smooth GSAP Cursor Follower Loop
        gsap.ticker.add(() => {
            followerX += (mouseX - followerX) * 0.18;
            followerY += (mouseY - followerY) * 0.18;

            if (cursorDot && cursorFollower) {
                cursorDot.style.left = `${mouseX}px`;
                cursorDot.style.top = `${mouseY}px`;
                cursorFollower.style.left = `${followerX}px`;
                cursorFollower.style.top = `${followerY}px`;
            }
        });

        // Cursor hover expansions
        document.querySelectorAll('.hover-target, button, a').forEach(el => {
            el.addEventListener('mouseenter', () => {
                if (cursorFollower) cursorFollower.classList.add('hover-active');
            });
            el.addEventListener('mouseleave', () => {
                if (cursorFollower) cursorFollower.classList.remove('hover-active');
            });
        });

        // GSAP Entrance Animations
        document.addEventListener('DOMContentLoaded', () => {
            // Register ScrollTrigger
            if (typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
            }

            const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

            tl.from("#navbar", { y: -30, opacity: 0, duration: 0.7 })
              .from(".badge-tag", { scale: 0.8, opacity: 0, duration: 0.5, ease: "back.out(1.7)" }, "-=0.3")
              .from("#hero-heading", { y: 25, opacity: 0, duration: 0.6 }, "-=0.3")
              .from("#hero-subtext", { y: 20, opacity: 0, duration: 0.5 }, "-=0.3")
              .from("#hero-buttons .btn-3d", { y: 15, opacity: 0, stagger: 0.1, duration: 0.5 }, "-=0.2")
              .from("#terminal-card", { scale: 0.95, opacity: 0, duration: 0.7, ease: "back.out(1.2)" }, "-=0.4");

            // Floating animation only on desktop
            if (window.innerWidth > 860) {
                tl.from(".antigravity-badge", { scale: 0, opacity: 0, stagger: 0.15, duration: 0.6, ease: "back.out(1.8)" }, "-=0.3");
                gsap.to(".badge-1", { y: "-=10", duration: 2.4, repeat: -1, yoyo: true, ease: "sine.inOut" });
                gsap.to(".badge-2", { y: "+=8", duration: 2.8, repeat: -1, yoyo: true, ease: "sine.inOut", delay: 0.4 });
                gsap.to(".badge-3", { y: "-=12", duration: 3.2, repeat: -1, yoyo: true, ease: "sine.inOut", delay: 0.8 });
            }

            // ScrollTrigger for Feature Cards
            if (typeof ScrollTrigger !== 'undefined') {
                gsap.from(".feature-card", {
                    scrollTrigger: {
                        trigger: "#features",
                        start: "top 85%"
                    },
                    y: 30,
                    opacity: 0,
                    stagger: 0.12,
                    duration: 0.6,
                    ease: "power2.out"
                });
            }
        });

        // Interactive Code Runner Demo Click
        const btnRun = document.getElementById('btn-run-demo');
        const outputText = document.getElementById('demo-output-text');

        btnRun.addEventListener('click', () => {
            btnRun.innerText = "Mengeksekusi...";
            btnRun.disabled = true;

            outputText.style.color = '#38bdf8';
            outputText.innerText = "Memproses kode Python...";

            setTimeout(() => {
                confetti({
                    particleCount: 70,
                    spread: 60,
                    origin: { y: 0.7 }
                });

                outputText.style.color = '#4ade80';
                outputText.innerText = 'Output: "Selamat datang Budi di Kodein!"';
                btnRun.innerText = "Jalankan Kode Program";
                btnRun.disabled = false;
            }, 500);
        });
    </script>
</body>
</html>
