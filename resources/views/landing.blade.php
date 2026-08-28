<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kodein - Platform Belajar Pemrograman untuk SMP & SMA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --primary-blue-light: #eff6ff;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --accent-orange: #f59e0b;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
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
            letter-spacing: 0.5px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            padding: 14px 28px;
            font-size: 14px;
            text-decoration: none;
            transition: transform 0.1s;
        }
        .btn-3d:active { transform: translateY(4px); }

        .btn-blue {
            background: var(--primary-blue);
            color: #fff;
            box-shadow: 0 4px 0 var(--primary-blue-shadow);
        }
        .btn-blue:active { box-shadow: 0 0 0 var(--primary-blue-shadow); }

        .btn-green {
            background: var(--accent-green);
            color: #fff;
            box-shadow: 0 4px 0 var(--accent-green-shadow);
        }
        .btn-green:active { box-shadow: 0 0 0 var(--accent-green-shadow); }

        .btn-outline {
            background: #ffffff;
            color: var(--primary-blue);
            border: 2px solid #cbd5e1;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-outline:active { box-shadow: 0 0 0 #cbd5e1; }

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
            font-size: 46px;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 20px;
            color: #0f172a;
        }

        .hero-title span {
            color: var(--primary-blue);
        }

        .hero-subtitle {
            font-size: 17px;
            color: var(--text-muted);
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
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 32px;
            padding: 40px 32px;
            box-shadow: 0 8px 0 #e2e8f0;
            text-align: center;
            position: relative;
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
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: transform 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
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
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header class="navbar">
        <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
            <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 0 #1e40af;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <div>
                <span style="font-size: 24px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">KODEIN</span>
                <span style="font-size: 10px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 12px;">
            @auth
                <a href="{{ route('learn.index') }}" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 13px;">
                    Roadmap Belajar
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="padding: 10px 18px; font-size: 13px;">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 13px;">
                    Daftar Gratis
                </a>
            @endauth
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: var(--primary-blue-light); border: 1px solid #bfdbfe; color: var(--primary-blue); padding: 6px 14px; border-radius: 9999px; font-size: 12px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                Platform Belajar Interaktif SMP & SMA
            </div>
            <h1 class="hero-title">
                Cara Menyenangkan Belajar <span>Pemrograman</span> Sejak Dini
            </h1>
            <p class="hero-subtitle">
                Tantangan kuis interaktif, susun urutan baris kode algoritma, raih poin pengalaman, pertahankan streak harian, dan dapatkan sertifikat resmi.
            </p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="font-size: 15px; padding: 16px 36px;">
                    Mulai Belajar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn-3d btn-outline">
                    Demo Login
                </a>
            </div>
        </div>

        <div class="mascot-card">
            <div style="width: 100px; height: 100px; margin: 0 auto; background: var(--primary-blue-light); border-radius: 28px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 20px;">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
            </div>
            <div>
                <div style="font-size: 20px; font-weight: 900; color: #0f172a;">Pemrograman Python & Web</div>
                <div style="color: #64748b; font-size: 14px; margin-top: 6px;">Selesaikan modul pertama dan kembangkan logika berpikir komputasional.</div>
            </div>
            <div style="margin-top: 24px; display: inline-flex; gap: 16px; background: #f8fafc; padding: 12px 24px; border-radius: 18px; border: 2px solid var(--border-color);">
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: var(--primary-blue);">7+ Hari</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">STREAK</div>
                </div>
                <div style="width: 1px; background: var(--border-color);"></div>
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: var(--accent-green);">100%</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">INTERAKTIF</div>
                </div>
                <div style="width: 1px; background: var(--border-color);"></div>
                <div style="text-align: center;">
                    <div style="font-size: 18px; font-weight: 900; color: var(--primary-blue);">VALID</div>
                    <div style="font-size: 10px; color: #64748b; font-weight: 800;">SERTIFIKAT</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-grid">
        <div class="feature-card">
            <div class="feature-icon-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Parsons Code Ordering</h3>
            <p style="color: #64748b; font-size: 14px; line-height: 1.5;">Menyusun potongan baris kode algoritma secara berurutan untuk melatih logika berpikir.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: #fef2f2; color: #ef4444;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Sistem Nyawa & Streak</h3>
            <p style="color: #64748b; font-size: 14px; line-height: 1.5;">Membangun konsistensi belajar harian secara teratur dengan evaluasi otomatis.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: #fef3c7; color: #d97706;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Papan Peringkat Liga</h3>
            <p style="color: #64748b; font-size: 14px; line-height: 1.5;">Bersaing secara sehat dengan teman sekelas untuk mengumpulkan XP mingguan.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
            </div>
            <h3 style="font-size: 18px; font-weight: 900; margin-bottom: 8px;">Sertifikat Terverifikasi</h3>
            <p style="color: #64748b; font-size: 14px; line-height: 1.5;">Menerbitkan sertifikat digital bertanda tangan kriptografis dengan QR Code verifikasi publik.</p>
        </div>
    </section>
</body>
</html>
