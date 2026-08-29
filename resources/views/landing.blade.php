<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>EduSkill - Platform Belajar Pemrograman Interaktif SMP & SMA</title>
    
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
            background-image: 
                radial-gradient(circle at 50% 20%, rgba(37, 99, 235, 0.05) 0%, transparent 60%),
                linear-gradient(to right, rgba(226, 232, 240, 0.5) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.5) 1px, transparent 1px);
            background-size: 100% 100%, 48px 48px, 48px 48px;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
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
            margin: 20px auto 60px auto;
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
            font-size: 44px;
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: -1.2px;
            margin-bottom: 18px;
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
            margin-bottom: 30px;
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* Clean Interactive Terminal Card */
        .code-terminal-card {
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 28px;
            box-shadow: 0 16px 32px -10px rgba(37, 99, 235, 0.1), 0 8px 0 #e2e8f0;
            overflow: hidden;
            width: 100%;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .code-terminal-card:hover {
            box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.15), 0 8px 0 #cbd5e1;
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

        /* Interactive Quiz Chip Choice Buttons */
        .quiz-chip {
            padding: 10px 16px;
            border-radius: 14px;
            background: #f1f5f9;
            border: 2px solid #cbd5e1;
            box-shadow: 0 3px 0 #cbd5e1;
            font-family: 'Fira Code', monospace;
            font-size: 13px;
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
            box-shadow: 0 3px 0 #059669 !important;
            color: #065f46 !important;
        }

        .quiz-chip.selected-wrong {
            background: #fef2f2 !important;
            border-color: #ef4444 !important;
            box-shadow: 0 3px 0 #b91c1c !important;
            color: #991b1b !important;
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
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
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

        /* Responsive Breakpoints */
        @media (max-width: 860px) {
            .navbar {
                padding: 14px 16px;
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
                gap: 28px;
                text-align: center;
                margin: 8px auto 44px auto;
                padding: 0 16px;
            }

            .hero-title {
                font-size: 28px;
                letter-spacing: -0.5px;
                line-height: 1.25;
                margin-bottom: 12px;
            }

            .hero-subtitle {
                font-size: 14px;
                line-height: 1.5;
                margin: 0 auto 20px auto;
            }

            .hero-actions {
                flex-direction: column;
                width: 100%;
                gap: 10px;
                margin-bottom: 8px;
            }

            .hero-actions .btn-3d {
                width: 100%;
                padding: 14px;
            }

            .terminal-body {
                padding: 16px;
            }

            .features-container {
                margin-bottom: 60px;
                padding: 0 16px;
            }

            .features-header h2 {
                font-size: 22px;
            }

            .feature-card {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Navigation Header -->
    <header class="navbar" id="navbar">
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #1d4ed8); display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <div>
                <span style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">EDUSKILL</span>
                <span class="logo-text" style="font-size: 9px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 8px;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue">
                    Roadmap Belajar
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue">
                    Daftar
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        
        <!-- Left: Catchy Headline & CTAs -->
        <div class="hero-content">
            <div class="badge-tag" style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary-blue-light); border: 1px solid #bfdbfe; color: var(--primary-blue); padding: 5px 12px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 14px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Platform Belajar Interaktif SMP &amp; SMA
            </div>

            <h1 class="hero-title" id="hero-heading">
                Belajar Coding Menyenangkan Seperti <span>Bermain Game</span>
            </h1>

            <p class="hero-subtitle" id="hero-subtext">
                Tantangan kuis interaktif algoritma, susun baris kode Parsons problem, pertahankan streak harian, dan raih sertifikat resmi dengan verifikasi QR Code publik.
            </p>

            <div class="hero-actions" id="hero-buttons">
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="font-size: 15px; padding: 15px 32px;">
                    Mulai Petualangan
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline">
                    Demo Akun
                </a>
            </div>
        </div>

        <!-- Right: Clean Interactive Playground Live Simulator Card -->
        <div class="interactive-stage" id="stage">
            <div class="code-terminal-card" id="terminal-card">
                <!-- Header -->
                <div class="terminal-header">
                    <div class="terminal-dots">
                        <div class="dot dot-red"></div>
                        <div class="dot dot-yellow"></div>
                        <div class="dot dot-green"></div>
                    </div>
                    <div class="code-font" style="font-size: 12px; font-weight: 700; color: #64748b;">
                        simulasi_tantangan.py
                    </div>
                    <div style="font-size: 11px; font-weight: 800; color: #10b981; background: #ecfdf5; padding: 2px 8px; border-radius: 6px;">
                        LIVE DEMO
                    </div>
                </div>

                <!-- Body Interactive Quiz & Code Runner -->
                <div class="terminal-body">
                    <!-- Instruction Prompt -->
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px; text-align: left;">
                        <span style="font-size: 12px; font-weight: 800; color: var(--primary-blue); background: var(--primary-blue-light); padding: 3px 8px; border-radius: 8px;">KUIS #1</span>
                        <span style="font-size: 13px; font-weight: 700; color: #1e293b;">Pilih fungsi untuk mencetak ke layar:</span>
                    </div>

                    <!-- Code Snippet with Slot Placeholder -->
                    <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 14px; text-align: left;">
                        <div class="code-font" style="font-size: 13px; line-height: 1.7; color: #1e293b;">
                            <span id="slot-placeholder" style="display: inline-block; min-width: 70px; padding: 2px 10px; background: #ffffff; border: 2px dashed #94a3b8; border-radius: 8px; color: var(--primary-blue); font-weight: 700; text-align: center;">...</span>(<span style="color: #d97706;">"Selamat Datang di EduSkill!"</span>)
                        </div>
                    </div>

                    <!-- Clickable Options -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; justify-content: center;">
                        <button type="button" class="quiz-chip" data-choice="input" onclick="chooseOption(this, false)">input</button>
                        <button type="button" class="quiz-chip" data-choice="print" onclick="chooseOption(this, true)">print</button>
                        <button type="button" class="quiz-chip" data-choice="echo" onclick="chooseOption(this, false)">echo</button>
                    </div>

                    <!-- Feedback Alert / Status Area -->
                    <div id="quiz-feedback-box" style="background: #0f172a; border-radius: 14px; padding: 12px 16px; color: #38bdf8; font-size: 12px; font-family: 'Fira Code', monospace; min-height: 44px; display: flex; align-items: center; justify-content: space-between; text-align: left;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #64748b;">&gt;</span>
                            <span id="quiz-feedback-text">Pilih salah satu jawaban di atas...</span>
                        </div>
                        <span id="quiz-xp-badge" style="display: none; background: #059669; color: #fff; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px;">+10 XP</span>
                    </div>

                    <!-- Integrated HUD Metrics Inside Card -->
                    <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid #f1f5f9; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                        <div style="text-align: center;">
                            <div style="font-size: 15px; font-weight: 900; color: var(--accent-orange);">7 Hari</div>
                            <div style="font-size: 9px; color: #64748b; font-weight: 800; text-transform: uppercase;">Streak Api</div>
                        </div>
                        <div style="text-align: center; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
                            <div style="font-size: 15px; font-weight: 900; color: var(--primary-blue);">250</div>
                            <div style="font-size: 9px; color: #64748b; font-weight: 800; text-transform: uppercase;">Gems</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 15px; font-weight: 900; color: var(--accent-green);">100%</div>
                            <div style="font-size: 9px; color: #64748b; font-weight: 800; text-transform: uppercase;">Valid QR</div>
                        </div>
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
                Mengapa Memilih EduSkill
            </div>
            <h2 style="font-size: 32px; font-weight: 900; color: #0f172a;">Dirancang Khusus untuk Siswa SMP &amp; SMA</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Parsons Code Ordering</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Susun balok baris kode algoritma layaknya puzzle balok untuk melatih logika berpikir tanpa takut frustrasi eror sintaks.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background: #fef2f2; color: #ef4444;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Gamifikasi Nyawa &amp; Streak</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Jaga nyawa belajar kamu, kumpulkan gems berharga, dan pertahankan streak api setiap hari agar kebiasaan coding terbentuk.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background: #fef3c7; color: #d97706;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Liga &amp; Papan Peringkat</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Raih posisi podium teratas di Liga Berlian mingguan dan pamerkan lencana pencapaian kepada teman sekolah.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                </div>
                <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Sertifikat Terverifikasi QR</h3>
                <p style="color: #64748b; font-size: 14px; line-height: 1.6;">Selesaikan seluruh unit untuk menerbitkan sertifikat digital resmi bertanda tangan kriptografis dengan QR publik.</p>
            </div>
        </div>
    </section>

    <!-- GSAP & Interactive Quiz Simulator Script Engine -->
    <script>
        // Interactive Mini-Quiz Handler
        function chooseOption(btn, isCorrect) {
            const placeholder = document.getElementById('slot-placeholder');
            const feedbackText = document.getElementById('quiz-feedback-text');
            const feedbackBox = document.getElementById('quiz-feedback-box');
            const xpBadge = document.getElementById('quiz-xp-badge');
            const choice = btn.getAttribute('data-choice');

            // Reset other buttons
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
                    particleCount: 60,
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

        // GSAP Entrance Animations
        document.addEventListener('DOMContentLoaded', () => {
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
    </script>
</body>
</html>
