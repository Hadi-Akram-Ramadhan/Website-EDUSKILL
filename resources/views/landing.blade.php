<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kodein - Belajar Pemrograman Seru Ala Duolingo untuk SMP & SMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --duo-green: #58cc02;
            --duo-green-shadow: #46a302;
            --duo-blue: #1cb0f6;
            --duo-blue-shadow: #1899d6;
            --duo-orange: #ff9600;
            --duo-orange-shadow: #e58700;
            --duo-gold: #ffc800;
            --duo-gold-shadow: #e5b400;
            --duo-dark: #0e161a;
            --duo-card: #202f36;
            --duo-border: #37464f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--duo-dark);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            max-width: 1140px;
            margin: 0 auto;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 14px 28px;
            font-size: 15px;
            text-decoration: none;
            transition: transform 0.1s;
        }
        .btn-3d:active { transform: translateY(4px); }

        .btn-green {
            background: var(--duo-green);
            color: #fff;
            box-shadow: 0 4px 0 var(--duo-green-shadow);
        }
        .btn-green:active { box-shadow: 0 0 0 var(--duo-green-shadow); }

        .btn-blue {
            background: var(--duo-blue);
            color: #fff;
            box-shadow: 0 4px 0 var(--duo-blue-shadow);
        }
        .btn-blue:active { box-shadow: 0 0 0 var(--duo-blue-shadow); }

        .btn-outline {
            background: transparent;
            color: #38bdf8;
            border: 2px solid var(--duo-border);
            box-shadow: 0 4px 0 var(--duo-border);
        }
        .btn-outline:active { box-shadow: 0 0 0 var(--duo-border); }

        .hero {
            max-width: 1140px;
            margin: 40px auto 80px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
        }

        @media (max-width: 860px) {
            .hero {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .hero-actions {
                justify-content: center;
            }
        }

        .hero-title {
            font-size: 48px;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #58cc02, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 18px;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .mascot-card {
            background: var(--duo-card);
            border: 2px solid var(--duo-border);
            border-radius: 32px;
            padding: 40px 32px;
            box-shadow: 0 10px 0 var(--duo-border);
            text-align: center;
            position: relative;
        }

        @keyframes float-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .mascot-avatar {
            font-size: 88px;
            display: inline-block;
            animation: float-soft 3.5s ease-in-out infinite;
            filter: drop-shadow(0 12px 20px rgba(88, 204, 2, 0.3));
        }

        .features-grid {
            max-width: 1140px;
            margin: 0 auto 100px auto;
            padding: 0 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: var(--duo-card);
            border: 2px solid var(--duo-border);
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 6px 0 var(--duo-border);
            transition: transform 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
        }

        .feature-icon {
            font-size: 36px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header class="navbar">
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #58cc02, #46a302); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 0 #3a8a00;">
                ⚡
            </div>
            <div>
                <span style="font-size: 26px; font-weight: 900; color: #58cc02; letter-spacing: -0.5px;">KODEIN</span>
                <span style="font-size: 10px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">GAMIFIED LEARNING</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 12px;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-green" style="padding: 10px 20px; font-size: 13px;">
                    BUKA ROADMAP BELAJAR 🚀
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="padding: 10px 18px; font-size: 13px;">
                    MASUK
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-green" style="padding: 10px 20px; font-size: 13px;">
                    DAFTAR GRATIS
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(88, 204, 2, 0.15); border: 1px solid rgba(88, 204, 2, 0.3); color: #86efac; padding: 6px 14px; border-radius: 9999px; font-size: 13px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;">
                <span>🎮</span> Belajar Coding Ala Main Game
            </div>
            <h1 class="hero-title">
                Cara Paling Seru Belajar <span>Pemrograman</span> untuk Siswa!
            </h1>
            <p class="hero-subtitle">
                Tantangan kuis kilat, susun algoritma drag-and-drop, kumpulkan XP, jaga streak harian, dan raih sertifikat resmi bertanda tangan digital.
            </p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-3d btn-green" style="font-size: 17px; padding: 16px 36px;">
                    MULAI BELAJAR GRATIS 🚀
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline">
                    ⚡ 1-Click Demo Login
                </a>
            </div>
        </div>

        <div class="mascot-card">
            <div class="mascot-avatar">🤖</div>
            <div style="margin-top: 16px;">
                <div style="font-size: 20px; font-weight: 900; color: var(--duo-gold);">"Halo Calon Programmer!"</div>
                <div style="color: #94a3b8; font-size: 14px; margin-top: 6px;">Selesaikan modul Python pertama & raih badge pertamamu hari ini!</div>
            </div>
            <div style="margin-top: 24px; display: inline-flex; gap: 12px; background: #131f24; padding: 12px 20px; border-radius: 18px; border: 2px solid var(--duo-border);">
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: var(--duo-orange);">🔥 5+</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">STREAK</div>
                </div>
                <div style="width: 1px; background: var(--duo-border);"></div>
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: var(--duo-green);">⚡ 100%</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">INTERAKTIF</div>
                </div>
                <div style="width: 1px; background: var(--duo-border);"></div>
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: #38bdf8;">🎓 RESMI</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">SERTIFIKAT</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🧩</div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Parsons Code Ordering</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5;">Susun urutan baris kode dengan interaktif tanpa takut pusing sintaks di awal.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">❤️</div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Nyawa (Hearts) & Streak</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5;">Membangun konsistensi belajar harian. Salah menjawab mengurangi nyawa!</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Klasemen Liga</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5;">Bersaing dengan teman sekelas dan siswa lain untuk naik ke Liga Berlian.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📜</div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Sertifikat Kriptografis</h3>
            <p style="color: #94a3b8; font-size: 14px; line-height: 1.5;">Sertifikat kelulusan valid yang dapat diverifikasi publik via QR Code resmi.</p>
        </div>
    </section>
</body>
</html>
