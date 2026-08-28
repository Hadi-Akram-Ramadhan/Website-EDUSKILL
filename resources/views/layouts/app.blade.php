<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kodein - Platform Belajar Coding untuk Siswa' }}</title>
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
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        /* 3D Button Utility in Blue/Light Theme */
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
            transition: transform 0.1s ease, filter 0.15s ease;
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
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 4px 0 #e2e8f0;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }

        /* Animations */
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.6); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 16px rgba(37, 99, 235, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }

        @keyframes float-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .animate-float {
            animation: float-soft 3s ease-in-out infinite;
        }

        .pulse-active-node {
            animation: pulse-ring 2s infinite cubic-bezier(0.45, 0, 0.55, 1);
        }

        /* Sidebar Styling */
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
            max-width: 1080px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 36px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .content-container {
                grid-template-columns: 1fr;
            }
            .sidebar {
                width: 80px;
                padding: 16px 8px;
            }
            .sidebar .nav-text, .sidebar .logo-text {
                display: none;
            }
            .sidebar .nav-item {
                justify-content: center;
                padding: 12px;
            }
        }

        @media (max-width: 640px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                height: 64px;
                position: fixed;
                bottom: 0;
                top: auto;
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                padding: 0 8px;
                border-right: none;
                border-top: 2px solid var(--border-color);
            }
            .sidebar .sidebar-top, .sidebar .sidebar-bottom {
                display: none;
            }
            .sidebar .nav-item {
                margin-bottom: 0;
            }
            .main-wrapper {
                padding: 16px 12px 84px 12px;
            }
        }
    </style>
</head>
<body>

    @auth
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-top" style="margin-bottom: 32px; padding: 0 8px;">
            <a href="{{ route('learn.index') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div style="width: 42px; height: 42px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; box-shadow: 0 4px 0 #1e40af;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div class="logo-text">
                    <span style="font-size: 22px; font-weight: 900; color: #2563eb; letter-spacing: -0.5px;">KODEIN</span>
                    <span style="font-size: 10px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">LEARNING PLATFORM</span>
                </div>
            </a>
        </div>

        <nav style="flex: 1;">
            @if (auth()->user()->role === 'super_admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard Admin</span>
                </a>
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Preview Siswa</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
                <a href="{{ route('certificates.web') }}" class="nav-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    <span class="nav-text">Sertifikat</span>
                </a>
            @elseif (auth()->user()->role === 'guru')
                <a href="{{ route('mentor.dashboard') }}" class="nav-item {{ request()->routeIs('mentor.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="nav-text">Dashboard Mentor</span>
                </a>
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Preview Roadmap</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
            @else
                <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    <span class="nav-text">Belajar</span>
                </a>
                <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    <span class="nav-text">Peringkat</span>
                </a>
                <a href="{{ route('profile.web') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span class="nav-text">Profil & Badge</span>
                </a>
                <a href="{{ route('certificates.web') }}" class="nav-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    <span class="nav-text">Sertifikat</span>
                </a>
            @endif

            <a href="{{ route('docs.api') }}" target="_blank" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                <span class="nav-text">OpenAPI Docs</span>
            </a>
        </nav>

        <div class="sidebar-bottom" style="border-top: 2px solid var(--border-color); padding-top: 16px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 0 8px;">
                <img src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . auth()->user()->id }}" style="width: 38px; height: 38px; border-radius: 50%; background: #f1f5f9; border: 2px solid #e2e8f0;" alt="Avatar">
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

    <!-- Web Audio Synthesizer Engine -->
    <script>
        window.SoundEngine = {
            ctx: null,
            init() {
                if (!this.ctx) {
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    if (AudioContext) this.ctx = new AudioContext();
                }
                if (this.ctx && this.ctx.state === 'suspended') {
                    this.ctx.resume();
                }
            },
            playCorrect() {
                this.init();
                if (!this.ctx) return;
                const now = this.ctx.currentTime;
                const notes = [523.25, 659.25, 783.99, 1046.50];
                notes.forEach((freq, i) => {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(freq, now + i * 0.08);
                    gain.gain.setValueAtTime(0.2, now + i * 0.08);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + i * 0.08 + 0.3);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start(now + i * 0.08);
                    osc.stop(now + i * 0.08 + 0.3);
                });
            },
            playWrong() {
                this.init();
                if (!this.ctx) return;
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(180, now);
                osc.frequency.exponentialRampToValueAtTime(110, now + 0.25);
                gain.gain.setValueAtTime(0.25, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.25);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.25);
            },
            playClick() {
                this.init();
                if (!this.ctx) return;
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(400, now);
                osc.frequency.exponentialRampToValueAtTime(800, now + 0.05);
                gain.gain.setValueAtTime(0.1, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.05);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.05);
            },
            playVictory() {
                this.init();
                if (!this.ctx) return;
                const now = this.ctx.currentTime;
                const fanfare = [
                    { f: 523.25, d: 0.15, t: 0 },
                    { f: 523.25, d: 0.15, t: 0.15 },
                    { f: 523.25, d: 0.15, t: 0.3 },
                    { f: 659.25, d: 0.4, t: 0.45 },
                    { f: 783.99, d: 0.2, t: 0.9 },
                    { f: 1046.50, d: 0.8, t: 1.1 }
                ];
                fanfare.forEach(n => {
                    const osc = this.ctx.createOscillator();
                    const gain = this.ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(n.f, now + n.t);
                    gain.gain.setValueAtTime(0.25, now + n.t);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + n.t + n.d);
                    osc.connect(gain);
                    gain.connect(this.ctx.destination);
                    osc.start(now + n.t);
                    osc.stop(now + n.t + n.d);
                });
            }
        };

        document.addEventListener('click', () => window.SoundEngine.init(), { once: true });
    </script>
</body>
</html>
