<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'EduSkill - Platform Belajar Coding untuk Siswa' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --primary-blue-shadow: #1e40af;
            --primary-blue-light: #eff6ff;
            --primary-blue-subtle: #dbeafe;
            --accent-green: #10b981;
            --accent-green-shadow: #059669;
            --accent-orange: #f59e0b;
            --accent-orange-shadow: #d97706;
            --accent-red: #ef4444;
            --accent-red-shadow: #dc2626;
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

        body {
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(37, 99, 235, 0.04) 0%, transparent 50%),
                linear-gradient(to right, rgba(226, 232, 240, 0.6) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.6) 1px, transparent 1px);
            background-size: 100% 100%, 40px 40px, 40px 40px;
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
            gap: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            transition: transform 0.1s ease, filter 0.15s ease, box-shadow 0.1s ease;
            user-select: none;
            text-decoration: none;
            padding: 14px 24px;
            font-size: 14px;
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

        .btn-orange {
            background: var(--accent-orange);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--accent-orange-shadow);
        }
        .btn-orange:active {
            box-shadow: 0 0 0 var(--accent-orange-shadow);
        }

        .btn-red {
            background: var(--accent-red);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--accent-red-shadow);
        }
        .btn-red:active {
            box-shadow: 0 0 0 var(--accent-red-shadow);
        }

        .btn-purple {
            background: #8b5cf6;
            color: #ffffff;
            box-shadow: 0 4px 0 #6d28d9;
        }
        .btn-purple:active {
            box-shadow: 0 0 0 #6d28d9;
        }

        .btn-gray {
            background: #e2e8f0;
            color: #64748b;
            box-shadow: 0 4px 0 #cbd5e1;
        }
        .btn-gray:active {
            box-shadow: 0 0 0 #cbd5e1;
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

        /* 3D Card Utility */
        .card-3d {
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }

        /* Animations */
        @keyframes pulse-ring {
            0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.5); }
            70% { transform: scale(1.04); box-shadow: 0 0 0 14px rgba(37, 99, 235, 0); }
            100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }

        @keyframes float-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .animate-float {
            animation: float-soft 3s ease-in-out infinite;
        }

        .pulse-active-node {
            animation: pulse-ring 2s infinite cubic-bezier(0.45, 0, 0.55, 1);
        }

        @keyframes pulse-project {
            0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.6); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 16px rgba(147, 51, 234, 0); }
            100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(147, 51, 234, 0); }
        }

        .pulse-active-project {
            animation: pulse-project 2s infinite cubic-bezier(0.45, 0, 0.55, 1);
        }

        /* Desktop & Tablet Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 2px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            flex-shrink: 0;
            z-index: 40;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 6px;
            border: 2px solid transparent;
        }

        .nav-item:hover {
            background: #f1f5f9;
            color: var(--primary-blue);
        }

        .nav-item.active {
            background: var(--primary-blue-light);
            color: var(--primary-blue);
            border-color: #bfdbfe;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 32px 24px;
            overflow-y: auto;
            max-width: 100%;
        }

        .content-container {
            width: 100%;
            max-width: 1060px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 36px;
            align-items: start;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .content-container {
                grid-template-columns: 1fr;
                gap: 28px;
            }
            .sidebar {
                width: 84px;
                padding: 16px 8px;
            }
            .sidebar .nav-text, .sidebar .logo-text {
                display: none;
            }
            .sidebar .nav-item {
                justify-content: center;
                padding: 14px 8px;
            }
        }

        /* Mobile Viewport */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .main-wrapper {
                padding: 16px 16px 100px 16px;
                width: 100%;
            }

            .content-container {
                display: flex;
                flex-direction: column;
                gap: 24px;
                width: 100%;
            }

            /* Mobile Bottom Navigation Bar */
            .sidebar {
                width: 100%;
                height: 68px;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                flex-direction: row;
                align-items: center;
                justify-content: space-around;
                padding: 6px 8px;
                background: rgba(255, 255, 255, 0.96);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-right: none;
                border-top: 2px solid var(--border-color);
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
                z-index: 50;
            }

            .sidebar .sidebar-top, 
            .sidebar .sidebar-bottom {
                display: none;
            }

            .sidebar nav {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-around;
                width: 100%;
                height: 100%;
                margin: 0;
                gap: 4px;
            }

            .sidebar .nav-item {
                flex: 1;
                max-width: 72px;
                height: 52px;
                padding: 6px 4px;
                margin-bottom: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
                border-radius: 12px;
                border: none;
            }

            .sidebar .nav-item svg {
                width: 22px;
                height: 22px;
            }

            /* Mobile Top Navigation Bar */
            .mobile-top-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                padding: 12px 16px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 2px solid var(--border-color);
                position: sticky;
                top: 0;
                left: 0;
                right: 0;
                z-index: 40;
                margin-bottom: 16px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            }

            .sidebar .nav-text {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Mobile Sticky Top Header (Visible only on mobile/tablet) -->
    <header class="mobile-top-header" style="display: none;">
        <a href="{{ route('learn.index') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
            <div style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; flex-shrink: 0; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <span style="font-size: 17px; font-weight: 900; color: var(--primary-blue); letter-spacing: -0.5px;">EDUSKILL</span>
        </a>

        @auth
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <img src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . auth()->user()->id }}" style="width: 28px; height: 28px; min-width: 28px; min-height: 28px; flex-shrink: 0; border-radius: 50%; object-fit: cover; background: #eff6ff; border: 1.5px solid #bfdbfe;" alt="">
                    <span style="font-size: 11px; font-weight: 800; color: #0f172a; max-width: 90px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-3d btn-outline" style="padding: 6px 10px; font-size: 11px; border-radius: 8px;" title="Keluar / Ganti Akun">
                        Keluar
                    </button>
                </form>
            </div>
        @else
            <div style="display: flex; align-items: center; gap: 6px;">
                <a href="{{ route('login') }}" class="btn-3d btn-outline" style="padding: 6px 12px; font-size: 11px; border-radius: 8px;">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="btn-3d btn-blue" style="padding: 6px 12px; font-size: 11px; border-radius: 8px;">
                    Daftar
                </a>
            </div>
        @endauth
    </header>

    @auth
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-top" style="margin-bottom: 32px; padding: 0 8px;">
            <a href="{{ route('learn.index') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div style="width: 42px; height: 42px; min-width: 42px; min-height: 42px; flex-shrink: 0; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 0 #1e40af;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div class="logo-text">
                    <span style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">EDUSKILL</span>
                    <span style="font-size: 10px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
                </div>
            </a>
        </div>

        <nav>
            @if (auth()->user()->role === 'super_admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard Admin">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard Admin</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Kelola Pengguna">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span class="nav-text">Kelola Pengguna</span>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" title="Master Kursus">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Master Kursus</span>
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}" title="Rekap Sertifikat">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    <span class="nav-text">Rekap Sertifikat</span>
                </a>
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}" title="Preview Siswa">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    <span class="nav-text">Preview Siswa</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}" title="Peringkat">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
                <a href="{{ route('docs.api') }}" target="_blank" class="nav-item" title="OpenAPI Docs">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    <span class="nav-text">OpenAPI Docs</span>
                </a>
            @elseif (auth()->user()->role === 'guru')
                <a href="{{ route('mentor.dashboard') }}" class="nav-item {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}" title="Dashboard Mentor">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard Mentor</span>
                </a>
                <a href="{{ route('mentor.courses.index') }}" class="nav-item {{ request()->routeIs('mentor.courses.*') ? 'active' : '' }}" title="Kursus Saya">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Kursus Saya</span>
                </a>
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}" title="Preview Roadmap">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    <span class="nav-text">Preview Roadmap</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}" title="Peringkat">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
            @else
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}" title="Belajar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Belajar</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}" title="Peringkat">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
                <a href="{{ route('profile.web') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" title="Profil & Badge">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span class="nav-text">Profil & Badge</span>
                </a>
                <a href="{{ route('certificates.web') }}" class="nav-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}" title="Sertifikat">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    <span class="nav-text">Sertifikat</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-bottom" style="border-top: 2px solid var(--border-color); padding-top: 16px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 0 8px;">
                <img src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . auth()->user()->id }}" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; flex-shrink: 0; border-radius: 50%; object-fit: cover; background: #eff6ff; border: 2px solid #bfdbfe;" alt="Avatar">
                <div style="overflow: hidden;">
                    <div style="font-size: 13px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-main);">{{ auth()->user()->name }}</div>
                    <div style="font-size: 11px; color: var(--primary-blue); font-weight: 700; text-transform: uppercase;">{{ auth()->user()->role }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-3d btn-gray" style="width: 100%; padding: 10px; font-size: 13px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Main Content Area -->
    <main class="main-wrapper">
        {{ $slot }}
    </main>

    <!-- Pure Web Audio API Synthesizer & Dynamic Audio Engine -->
    <script src="{{ asset('js/audio-engine.js') }}"></script>
    <script>
        // Global interactive feedback for 3D buttons, navigation, and pills
        document.addEventListener('click', (e) => {
            const target = e.target.closest('.btn-3d, .nav-item, .roadmap-node, .pill-tab, .opt-chip, .btn-action');
            if (target && window.EduAudio) {
                window.EduAudio.playTap();
            }
        }, { passive: true });
    </script>
</body>
</html>
