<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>EduSkill - Platform Belajar Pemrograman Interaktif SMP &amp; SMA</title>
    
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
            --accent-purple: #8b5cf6;
            --bg-page: #ffffff;
            --bg-dark-section: #1e40af;
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
            background-color: var(--bg-page);
            color: var(--text-main);
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* 3D Chunky Playful Buttons */
        .btn-3d {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 18px;
            border: none;
            cursor: pointer;
            padding: 16px 32px;
            font-size: 15px;
            text-decoration: none;
            user-select: none;
            transition: transform 0.1s ease, filter 0.15s ease, box-shadow 0.1s ease;
        }

        .btn-3d:active {
            transform: translateY(4px) !important;
        }

        .btn-blue {
            background: var(--primary-blue);
            color: #ffffff;
            box-shadow: 0 5px 0 var(--primary-blue-shadow);
        }
        .btn-blue:hover {
            background: var(--primary-blue-hover);
        }
        .btn-blue:active {
            box-shadow: 0 0 0 var(--primary-blue-shadow);
        }

        .btn-green {
            background: var(--accent-green);
            color: #ffffff;
            box-shadow: 0 5px 0 var(--accent-green-shadow);
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

        .btn-white {
            background: #ffffff;
            color: var(--primary-blue);
            box-shadow: 0 5px 0 #93c5fd;
        }
        .btn-white:active {
            box-shadow: 0 0 0 #93c5fd;
        }

        /* Top Sticky Navbar */
        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            z-index: 50;
            width: 100%;
            border-bottom: 1px solid rgba(226, 232, 240, 0.7);
        }

        /* Hero Wrapper */
        .hero-wrapper {
            position: relative;
            padding-top: 40px;
            padding-bottom: 0;
            background: radial-gradient(circle at 50% 10%, rgba(37, 99, 235, 0.08) 0%, #ffffff 70%);
            overflow: visible;
        }

        .hero-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 24px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            border: 2px solid #bfdbfe;
            color: var(--primary-blue);
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 900;
            line-height: 1.14;
            letter-spacing: -1.5px;
            color: #0f172a;
            max-width: 820px;
            margin: 0 auto 20px auto;
        }

        .hero-title span {
            color: var(--primary-blue);
            position: relative;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: 18px;
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 640px;
            margin: 0 auto 36px auto;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        /* Interactive Gamified Playground Stage (Overlapping Centerpiece) */
        .stage-wrapper {
            position: relative;
            max-width: 860px;
            margin: 0 auto;
            z-index: 20;
            padding-bottom: 30px;
        }

        /* Floating Gamification Vector Badges */
        .floating-badge {
            position: absolute;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 10px 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 4px 0 #e2e8f0;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
            z-index: 25;
        }

        .floating-badge:hover {
            transform: scale(1.12) rotate(2deg) !important;
            box-shadow: 0 16px 30px -5px rgba(37, 99, 235, 0.25), 0 4px 0 #bfdbfe;
            border-color: #bfdbfe;
        }

        .floating-badge:active {
            transform: scale(0.95) !important;
        }

        /* Keyframe Floating Micro-Animations */
        @keyframes floatGentle1 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-14px) rotate(3deg); }
        }

        @keyframes floatGentle2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(-4deg); }
        }

        @keyframes floatGentle3 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { filter: drop-shadow(0 0 4px rgba(37, 99, 235, 0.2)); }
            50% { filter: drop-shadow(0 0 12px rgba(37, 99, 235, 0.5)); }
        }

        .badge-heart {
            top: 20px;
            left: -40px;
            animation: floatGentle1 4s ease-in-out infinite;
        }

        .badge-gems {
            top: 10px;
            right: -40px;
            animation: floatGentle2 3.6s ease-in-out infinite 0.5s;
        }

        .badge-streak {
            bottom: 80px;
            left: -60px;
            animation: floatGentle3 4.2s ease-in-out infinite 1s;
        }

        .badge-xp {
            bottom: 70px;
            right: -50px;
            animation: floatGentle1 3.8s ease-in-out infinite 1.5s;
        }

        /* Center Phone / Terminal Container */
        .main-stage-card {
            background: #ffffff;
            border: 3px solid #cbd5e1;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.2), 0 8px 0 #94a3b8;
            overflow: hidden;
            width: 100%;
            margin: 0 auto;
            position: relative;
        }

        .terminal-header {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 22px;
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
            padding: 28px;
            background: #ffffff;
        }

        /* Interactive Quiz Chip Choice Buttons */
        .quiz-chip {
            padding: 12px 20px;
            border-radius: 16px;
            background: #f8fafc;
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
            font-family: 'Fira Code', monospace;
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
        }

        .quiz-chip:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .quiz-chip:active {
            transform: translateY(2px);
            box-shadow: 0 0 0 #cbd5e1;
        }

        .quiz-chip.selected-correct {
            background: #ecfdf5 !important;
            border-color: #10b981 !important;
            box-shadow: 0 4px 0 #059669 !important;
            color: #065f46 !important;
        }

        .quiz-chip.selected-wrong {
            background: #fef2f2 !important;
            border-color: #ef4444 !important;
            box-shadow: 0 4px 0 #b91c1c !important;
            color: #991b1b !important;
        }

        /* Organic Wave Curve Divider (Seamless Hill Connection) */
        .wave-curve-divider {
            position: relative;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            margin-top: -120px;
            z-index: 5;
        }

        .wave-curve-divider svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 180px;
        }

        /* Connected Gamified Section (Royal Blue Wonderland) */
        .connected-section {
            background: linear-gradient(180deg, #1d4ed8 0%, #1e3a8a 100%);
            color: #ffffff;
            padding: 40px 24px 100px 24px;
            position: relative;
            z-index: 10;
        }

        .section-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 50px auto;
        }

        .section-header .tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-size: 38px;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1.2;
            color: #ffffff;
            margin-bottom: 14px;
        }

        .section-header p {
            font-size: 16px;
            color: #bfdbfe;
            line-height: 1.6;
        }

        /* Feature Cards Grid */
        .features-grid {
            max-width: 1140px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .feature-box {
            background: #ffffff;
            border-radius: 28px;
            padding: 32px 24px;
            color: var(--text-main);
            box-shadow: 0 10px 0 rgba(0, 0, 0, 0.15), 0 20px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 0 rgba(0, 0, 0, 0.2), 0 25px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon-bubble {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Bottom Final CTA Card */
        .final-cta-container {
            max-width: 960px;
            margin: 60px auto 0 auto;
            background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.2) 0%, transparent 60%), #2563eb;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 32px;
            padding: 44px 32px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2), 0 6px 0 #1e40af;
        }

        /* Responsive Adjustments */
        @media (max-width: 900px) {
            .hero-title {
                font-size: 34px;
                letter-spacing: -0.8px;
            }
            .hero-subtitle {
                font-size: 15px;
            }
            .stage-wrapper {
                padding: 0 12px;
            }
            .floating-badge {
                position: static !important;
                display: inline-flex;
                margin: 4px;
                animation: none !important;
            }
            .floating-badges-mobile-row {
                display: flex;
                justify-content: center;
                gap: 8px;
                flex-wrap: wrap;
                margin-bottom: 16px;
            }
            .wave-curve-divider {
                margin-top: -60px;
            }
            .section-header h2 {
                font-size: 28px;
            }
            .mobile-bottom-cta {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                padding: 12px 16px;
                border-top: 2px solid var(--border-color);
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
                z-index: 50;
                gap: 10px;
            }
            .mobile-bottom-cta .btn-3d {
                flex: 1;
                padding: 14px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Sticky Header Navigation -->
    <header class="navbar" id="navbar">
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #1d4ed8); display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 0 #1e40af;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <div>
                <span style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">EDUSKILL</span>
                <span style="font-size: 9px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 8px;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 13px;">
                    Roadmap Belajar
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="padding: 10px 18px; font-size: 13px;">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 13px;">
                    Daftar
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-wrapper" id="hero">
        <div class="hero-container">
            
            <div class="hero-tag" id="hero-tag">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Platform Belajar Interaktif SMP &amp; SMA
            </div>

            <h1 class="hero-title" id="hero-title">
                Belajar Coding Menyenangkan Seperti <span>Bermain Game</span>
            </h1>

            <p class="hero-subtitle" id="hero-subtext">
                Kuasai logika algoritma, susun baris kode dengan interaktif, pertahankan streak harian, dan raih sertifikat resmi dengan verifikasi QR Code publik.
            </p>

            <div class="hero-cta-group" id="hero-ctas">
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="font-size: 16px; padding: 18px 36px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    Mulai Petualangan
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="font-size: 16px; padding: 18px 28px;">
                    Demo Akun Uji Coba
                </a>
            </div>

            <!-- Overlapping Gamification Stage -->
            <div class="stage-wrapper" id="stage-wrapper">
                
                <!-- Floating Gamified Badge 1: Heart (Nyawa) -->
                <div class="floating-badge badge-heart" id="badge-heart" onclick="triggerBadgePop('heart')">
                    <div style="width: 36px; height: 36px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ef4444;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 14px; font-weight: 900; color: #dc2626;">5 / 5 Nyawa</div>
                        <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Siap Tantangan</div>
                    </div>
                </div>

                <!-- Floating Gamified Badge 2: Gems (Berlian) -->
                <div class="floating-badge badge-gems" id="badge-gems" onclick="triggerBadgePop('gems')">
                    <div style="width: 36px; height: 36px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue);">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 14px; font-weight: 900; color: var(--primary-blue);">250 Gems</div>
                        <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Bonus Refill</div>
                    </div>
                </div>

                <!-- Floating Gamified Badge 3: Streak Api -->
                <div class="floating-badge badge-streak" id="badge-streak" onclick="triggerBadgePop('streak')">
                    <div style="width: 36px; height: 36px; background: #fffbeb; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #d97706;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 14px; font-weight: 900; color: #d97706;">7 Hari Streak</div>
                        <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Makin Konsisten</div>
                    </div>
                </div>

                <!-- Floating Gamified Badge 4: XP Coin -->
                <div class="floating-badge badge-xp" id="badge-xp" onclick="triggerBadgePop('xp')">
                    <div style="width: 36px; height: 36px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #059669;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-size: 14px; font-weight: 900; color: #059669;">+50 XP Bonus</div>
                        <div style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Naik Liga</div>
                    </div>
                </div>

                <!-- Center Interactive Simulator Terminal -->
                <div class="main-stage-card" id="terminal-card">
                    <!-- Header -->
                    <div class="terminal-header">
                        <div class="terminal-dots">
                            <div class="dot dot-red"></div>
                            <div class="dot dot-yellow"></div>
                            <div class="dot dot-green"></div>
                        </div>
                        <div class="code-font" style="font-size: 13px; font-weight: 700; color: #64748b; display: flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                            tantangan_pertama.py
                        </div>
                        <div style="font-size: 11px; font-weight: 800; color: #10b981; background: #ecfdf5; padding: 4px 10px; border-radius: 8px;">
                            LIVE SIMULATOR
                        </div>
                    </div>

                    <!-- Body Interactive Quiz & Code Runner -->
                    <div class="terminal-body">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 12px; font-weight: 800; color: var(--primary-blue); background: var(--primary-blue-light); padding: 4px 10px; border-radius: 8px;">KUIS #1</span>
                                <span style="font-size: 14px; font-weight: 700; color: #1e293b;">Pilih fungsi untuk mencetak teks ke layar:</span>
                            </div>
                        </div>

                        <!-- Code Snippet with Slot Placeholder -->
                        <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 18px; padding: 18px; margin-bottom: 16px; text-align: left;">
                            <div class="code-font" style="font-size: 14px; line-height: 1.7; color: #1e293b;">
                                <span id="slot-placeholder" style="display: inline-block; min-width: 80px; padding: 4px 12px; background: #ffffff; border: 2px dashed #94a3b8; border-radius: 10px; color: var(--primary-blue); font-weight: 700; text-align: center;">...</span>(<span style="color: #d97706;">"Selamat Datang di EduSkill!"</span>)
                            </div>
                        </div>

                        <!-- Clickable Options -->
                        <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; justify-content: center;">
                            <button type="button" class="quiz-chip" data-choice="input" onclick="chooseOption(this, false)">input</button>
                            <button type="button" class="quiz-chip" data-choice="print" onclick="chooseOption(this, true)">print</button>
                            <button type="button" class="quiz-chip" data-choice="echo" onclick="chooseOption(this, false)">echo</button>
                        </div>

                        <!-- Feedback Alert / Status Area -->
                        <div id="quiz-feedback-box" style="background: #0f172a; border-radius: 16px; padding: 14px 18px; color: #38bdf8; font-size: 13px; font-family: 'Fira Code', monospace; min-height: 50px; display: flex; align-items: center; justify-content: space-between; text-align: left;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="color: #64748b;">&gt;</span>
                                <span id="quiz-feedback-text">Klik salah satu opsi jawaban di atas untuk menguji kode...</span>
                            </div>
                            <span id="quiz-xp-badge" style="display: none; background: #059669; color: #fff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 8px;">+10 XP</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Organic Wave Curve Divider (Seamless Hill Bridge) -->
    <div class="wave-curve-divider">
        <svg viewBox="0 0 1440 180" fill="none" preserveAspectRatio="none">
            <path d="M0,60 C360,160 720,20 1080,100 C1260,140 1380,80 1440,60 L1440,180 L0,180 Z" fill="#1d4ed8"></path>
        </svg>
    </div>

    <!-- Connected Gamified Section (Royal Blue Wonderland) -->
    <section class="connected-section" id="features">
        <div class="section-header">
            <div class="tag-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                Metode Belajar Gamifikasi
            </div>
            <h2>Kenapa Belajar di EduSkill Terasa Beda?</h2>
            <p>Dirancang khusus untuk membuang rasa bosan dan ketakutan saat mulai belajar pemrograman dasar.</p>
        </div>

        <!-- 4 Bubbly Feature Boxes -->
        <div class="features-grid">
            
            <!-- Box 1: Parsons Problem -->
            <div class="feature-box">
                <div>
                    <div class="feature-icon-bubble" style="background: #eff6ff; color: var(--primary-blue);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 10px; color: #0f172a;">Parsons Code Puzzle</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                        Susun baris kode acak layaknya puzzle untuk melatih alur logika tanpa frustrasi eror tanda kurung atau titik koma.
                    </p>
                </div>
                <div style="background: #f8fafc; border-radius: 14px; padding: 12px; border: 1.5px dashed #cbd5e1; font-family: 'Fira Code', monospace; font-size: 12px; color: var(--primary-blue); font-weight: 700;">
                    1. for i in range(5):<br>
                    2. &nbsp;&nbsp;print("Belajar Asik")
                </div>
            </div>

            <!-- Box 2: Gamifikasi Nyawa & Streak -->
            <div class="feature-box">
                <div>
                    <div class="feature-icon-bubble" style="background: #fef2f2; color: #ef4444;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 10px; color: #0f172a;">Nyawa &amp; Api Streak</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                        Jaga 5 nyawa belajar setiap modul, kumpulkan gems berharga, dan pertahankan streak harian agar tidak terputus.
                    </p>
                </div>
                <div style="display: flex; gap: 8px; align-items: center; background: #fff1f2; border-radius: 14px; padding: 10px 14px; color: #e11d48; font-weight: 800; font-size: 12px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    Refill nyawa otomatis dengan Gems
                </div>
            </div>

            <!-- Box 3: Liga Berlian & Podium -->
            <div class="feature-box">
                <div>
                    <div class="feature-icon-bubble" style="background: #fffbeb; color: #d97706;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 10px; color: #0f172a;">Liga &amp; Papan Skor</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                        Raih poin XP tertinggi setiap minggu, naik dari Liga Perunggu hingga Liga Berlian, dan pamerkan lencana profil.
                    </p>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; background: #fef3c7; border-radius: 14px; padding: 10px 14px; color: #b45309; font-weight: 800; font-size: 12px;">
                    <span>Top #1 Liga Berlian</span>
                    <span>+100 XP</span>
                </div>
            </div>

            <!-- Box 4: QR Certified -->
            <div class="feature-box">
                <div>
                    <div class="feature-icon-bubble" style="background: #ecfdf5; color: #059669;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    </div>
                    <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 10px; color: #0f172a;">Sertifikat Valid QR</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                        Tuntaskan seluruh unit kursus untuk klaim sertifikat resmi bertanda tangan digital dengan kode verifikasi publik.
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; background: #ecfdf5; border-radius: 14px; padding: 10px 14px; color: #047857; font-weight: 800; font-size: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Verifikasi Instan via QR Publik
                </div>
            </div>

        </div>

        <!-- Final Conversion CTA Block -->
        <div class="final-cta-container">
            <h3 style="font-size: 32px; font-weight: 900; color: #ffffff; margin-bottom: 12px; letter-spacing: -0.5px;">
                Siap Mulai Petualangan Kodingmu?
            </h3>
            <p style="color: #bfdbfe; font-size: 16px; max-width: 580px; margin: 0 auto 28px auto;">
                Daftar gratis sekarang dan bergabung bersama ratusan siswa SMP &amp; SMA lainnya di EduSkill!
            </p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('register') }}" class="btn-3d btn-white" style="font-size: 15px; padding: 16px 36px;">
                    Daftar Akun Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="font-size: 15px; padding: 16px 28px; background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.4); box-shadow: 0 4px 0 rgba(0,0,0,0.2);">
                    Masuk ke Akun
                </a>
            </div>
        </div>

        <!-- Mobile Floating Bottom CTA Bar (Visible only on mobile) -->
        <div class="mobile-bottom-cta" style="display: none;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue">
                    Buka Roadmap Belajar
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue">
                    Daftar Akun
                </a>
            @endauth
        </div>
    </section>

    <!-- Interactive Scripts & Micro-Interactions -->
    <script>
        // Sound & Confetti triggers for floating badges
        function triggerBadgePop(type) {
            confetti({
                particleCount: 40,
                spread: 50,
                origin: { y: 0.6 }
            });
            
            const badge = document.getElementById('badge-' + type);
            if (badge) {
                gsap.fromTo(badge, { scale: 0.9 }, { scale: 1.15, yoyo: true, repeat: 1, duration: 0.2 });
            }
        }

        // Interactive Mini-Quiz Handler
        function chooseOption(btn, isCorrect) {
            const placeholder = document.getElementById('slot-placeholder');
            const feedbackText = document.getElementById('quiz-feedback-text');
            const xpBadge = document.getElementById('quiz-xp-badge');
            const choice = btn.getAttribute('data-choice');

            document.querySelectorAll('.quiz-chip').forEach(chip => {
                chip.classList.remove('selected-correct', 'selected-wrong');
            });

            placeholder.innerText = choice;

            if (isCorrect) {
                btn.classList.add('selected-correct');
                placeholder.style.borderColor = '#10b981';
                placeholder.style.color = '#059669';
                placeholder.style.background = '#ecfdf5';

                feedbackText.style.color = '#4ade80';
                feedbackText.innerText = 'Benar! Output: "Selamat Datang di EduSkill!"';
                xpBadge.style.display = 'inline-block';

                confetti({
                    particleCount: 70,
                    spread: 60,
                    origin: { y: 0.65 }
                });
            } else {
                btn.classList.add('selected-wrong');
                placeholder.style.borderColor = '#ef4444';
                placeholder.style.color = '#dc2626';
                placeholder.style.background = '#fef2f2';

                feedbackText.style.color = '#f87171';
                feedbackText.innerText = 'Kurang tepat. Coba pilih fungsi "print" ya!';
                xpBadge.style.display = 'none';
            }
        }

        // GSAP Animations on Entrance
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof gsap !== 'undefined') {
                const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

                tl.from("#navbar", { y: -30, opacity: 0, duration: 0.7 })
                  .from("#hero-tag", { scale: 0.8, opacity: 0, duration: 0.5, ease: "back.out(1.7)" }, "-=0.3")
                  .from("#hero-title", { y: 25, opacity: 0, duration: 0.6 }, "-=0.3")
                  .from("#hero-subtext", { y: 20, opacity: 0, duration: 0.5 }, "-=0.3")
                  .from("#hero-ctas .btn-3d", { y: 15, opacity: 0, stagger: 0.1, duration: 0.5 }, "-=0.2")
                  .from("#terminal-card", { scale: 0.95, opacity: 0, duration: 0.7, ease: "back.out(1.2)" }, "-=0.4")
                  .from(".floating-badge", { scale: 0.5, opacity: 0, stagger: 0.1, duration: 0.6, ease: "back.out(1.8)" }, "-=0.3");

                // Mouse Parallax Effect on Hero Stage
                const stage = document.getElementById('stage-wrapper');
                if (stage && window.innerWidth > 900) {
                    window.addEventListener('mousemove', (e) => {
                        const x = (e.clientX / window.innerWidth - 0.5) * 20;
                        const y = (e.clientY / window.innerHeight - 0.5) * 20;
                        
                        gsap.to("#badge-heart", { x: x * 1.2, y: y * 1.2, duration: 0.5 });
                        gsap.to("#badge-gems", { x: -x * 1.5, y: -y * 1.2, duration: 0.5 });
                        gsap.to("#badge-streak", { x: x * 0.8, y: -y * 0.9, duration: 0.5 });
                        gsap.to("#badge-xp", { x: -x * 1.1, y: y * 1.4, duration: 0.5 });
                    });
                }
            }
        });
    </script>
</body>
</html>
