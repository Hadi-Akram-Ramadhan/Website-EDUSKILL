<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kodein - Belajar Coding Seru Ala Duolingo' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --duo-green: #58cc02;
            --duo-green-shadow: #46a302;
            --duo-green-light: #d7ffb8;
            --duo-blue: #1cb0f6;
            --duo-blue-shadow: #1899d6;
            --duo-blue-light: #ddf4ff;
            --duo-purple: #ce82ff;
            --duo-purple-shadow: #a556d8;
            --duo-orange: #ff9600;
            --duo-orange-shadow: #e58700;
            --duo-red: #ff4b4b;
            --duo-red-shadow: #ea2b2b;
            --duo-gold: #ffc800;
            --duo-gold-shadow: #e5b400;
            --duo-gray: #e5e5e5;
            --duo-gray-shadow: #afafaf;
            --duo-dark: #131f24;
            --duo-dark-card: #202f36;
            --duo-dark-border: #37464f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: #0e161a;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
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
            letter-spacing: 0.8px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            transition: transform 0.1s ease, filter 0.15s ease;
            user-select: none;
            text-decoration: none;
            padding: 14px 24px;
            font-size: 15px;
        }

        .btn-3d:active {
            transform: translateY(4px);
        }

        .btn-green {
            background: var(--duo-green);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-green-shadow);
        }
        .btn-green:active {
            box-shadow: 0 0 0 var(--duo-green-shadow);
        }

        .btn-blue {
            background: var(--duo-blue);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-blue-shadow);
        }
        .btn-blue:active {
            box-shadow: 0 0 0 var(--duo-blue-shadow);
        }

        .btn-purple {
            background: var(--duo-purple);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-purple-shadow);
        }
        .btn-purple:active {
            box-shadow: 0 0 0 var(--duo-purple-shadow);
        }

        .btn-orange {
            background: var(--duo-orange);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-orange-shadow);
        }
        .btn-orange:active {
            box-shadow: 0 0 0 var(--duo-orange-shadow);
        }

        .btn-red {
            background: var(--duo-red);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-red-shadow);
        }
        .btn-red:active {
            box-shadow: 0 0 0 var(--duo-red-shadow);
        }

        .btn-gray {
            background: #2b3940;
            color: #94a3b8;
            box-shadow: 0 4px 0 #1b262c;
        }
        .btn-gray:active {
            box-shadow: 0 0 0 #1b262c;
        }

        .btn-outline {
            background: transparent;
            color: #38bdf8;
            border: 2px solid var(--duo-dark-border);
            box-shadow: 0 4px 0 var(--duo-dark-border);
        }
        .btn-outline:active {
            box-shadow: 0 0 0 var(--duo-dark-border);
        }

        /* 3D Card Utility */
        .card-3d {
            background: var(--duo-dark-card);
            border: 2px solid var(--duo-dark-border);
            border-radius: 20px;
            box-shadow: 0 6px 0 var(--duo-dark-border);
            transition: transform 0.15s ease, border-color 0.15s ease;
        }

        /* Animations */
        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(88, 204, 2, 0.7); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 16px rgba(88, 204, 2, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(88, 204, 2, 0); }
        }

        @keyframes float-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes flame-flicker {
            0%, 100% { transform: scale(1) rotate(-1deg); }
            50% { transform: scale(1.1) rotate(2deg); filter: drop-shadow(0 0 10px rgba(255, 150, 0, 0.8)); }
        }

        @keyframes shake-wrong {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }

        .animate-float {
            animation: float-soft 3s ease-in-out infinite;
        }

        .animate-flame {
            animation: flame-flicker 1.8s ease-in-out infinite;
            display: inline-block;
        }

        .pulse-active-node {
            animation: pulse-ring 2s infinite cubic-bezier(0.45, 0, 0.55, 1);
        }

        .shake-animation {
            animation: shake-wrong 0.4s ease-in-out;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0e161a;
        }
        ::-webkit-scrollbar-thumb {
            background: #2b3940;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #3c4f59;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: #131f24;
            border-right: 2px solid var(--duo-dark-border);
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
            gap: 16px;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 8px;
            border: 2px solid transparent;
        }

        .nav-item:hover {
            background: #202f36;
            color: #ffffff;
        }

        .nav-item.active {
            background: rgba(28, 176, 246, 0.15);
            color: var(--duo-blue);
            border-color: var(--duo-blue);
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
                border-top: 2px solid var(--duo-dark-border);
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
                <div style="width: 42px; height: 42px; background: linear-gradient(135deg, #58cc02, #46a302); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 4px 0 #3a8a00;">
                    ⚡
                </div>
                <div class="logo-text">
                    <span style="font-size: 24px; font-weight: 900; color: #58cc02; letter-spacing: -0.5px;">KODEIN</span>
                    <span style="font-size: 10px; font-weight: 800; display: block; color: #64748b; letter-spacing: 1px;">SMP / SMA</span>
                </div>
            </a>
        </div>

        <nav style="flex: 1;">
            <a href="{{ route('learn.index') }}" class="nav-item {{ request()->routeIs('learn.*') ? 'active' : '' }}">
                <span style="font-size: 20px;">📖</span>
                <span class="nav-text">Belajar</span>
            </a>
            <a href="{{ route('leaderboard.web') }}" class="nav-item {{ request()->routeIs('leaderboard.*') ? 'active' : '' }}">
                <span style="font-size: 20px;">🏆</span>
                <span class="nav-text">Peringkat</span>
            </a>
            <a href="{{ route('profile.web') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span style="font-size: 20px;">👤</span>
                <span class="nav-text">Profil & Badge</span>
            </a>
            <a href="{{ route('certificates.web') }}" class="nav-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                <span style="font-size: 20px;">🎓</span>
                <span class="nav-text">Sertifikat</span>
            </a>
            <a href="{{ route('docs.api') }}" target="_blank" class="nav-item">
                <span style="font-size: 20px;">⚡</span>
                <span class="nav-text">OpenAPI Docs</span>
            </a>
        </nav>

        <div class="sidebar-bottom" style="border-top: 2px solid var(--duo-dark-border); padding-top: 16px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 0 8px;">
                <img src="{{ auth()->user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . auth()->user()->id }}" style="width: 38px; height: 38px; border-radius: 50%; background: #202f36; border: 2px solid #37464f;" alt="Avatar">
                <div style="overflow: hidden;">
                    <div style="font-size: 13px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 11px; color: #38bdf8; font-weight: 700; text-transform: uppercase;">{{ auth()->user()->role }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-3d btn-gray" style="width: 100%; padding: 10px; font-size: 13px;">
                    Keluar 🚪
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- Main Content Area -->
    <main class="main-wrapper">
        {{ $slot }}
    </main>

    <!-- Web Audio Synthesizer Engine (Micro-Interactions) -->
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
                
                // Cheery arpeggio chime
                const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
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

        // Initialize sound context on first user click anywhere
        document.addEventListener('click', () => window.SoundEngine.init(), { once: true });
    </script>
</body>
</html>
