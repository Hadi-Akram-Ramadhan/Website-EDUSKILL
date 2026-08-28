<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Kuis Pemrograman - Kodein' }}</title>
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
            --accent-green-bg: #ecfdf5;
            --accent-red: #ef4444;
            --accent-red-shadow: #dc2626;
            --accent-red-bg: #fef2f2;
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
            flex-direction: column;
            overflow-x: hidden;
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
            transition: transform 0.1s ease, filter 0.15s ease;
            user-select: none;
            text-decoration: none;
            padding: 14px 28px;
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

        .btn-red {
            background: var(--accent-red);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--accent-red-shadow);
        }
        .btn-red:active {
            box-shadow: 0 0 0 var(--accent-red-shadow);
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

        /* Card Utility */
        .card-3d {
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 4px 0 #e2e8f0;
        }

        /* Header Navigation in Lesson */
        .lesson-header {
            max-width: 860px;
            margin: 0 auto;
            width: 100%;
            height: 72px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .progress-track {
            flex: 1;
            height: 14px;
            background: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border-radius: 9999px;
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .heart-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--accent-red);
            font-weight: 900;
            font-size: 16px;
        }

        .btn-close {
            background: transparent;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.15s;
        }
        .btn-close:hover {
            color: #0f172a;
            background: #e2e8f0;
        }

        /* Main Quiz Arena */
        .quiz-arena {
            flex: 1;
            max-width: 720px;
            width: 100%;
            margin: 0 auto;
            padding: 20px 20px 140px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Bottom Action Drawer */
        .action-drawer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 2px solid var(--border-color);
            background: #ffffff;
            padding: 20px 24px;
            z-index: 50;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06);
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .action-drawer.correct-state {
            background: var(--accent-green-bg);
            border-color: #6ee7b7;
        }

        .action-drawer.wrong-state {
            background: var(--accent-red-bg);
            border-color: #fca5a5;
        }

        .drawer-content {
            max-width: 860px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        @media (max-width: 640px) {
            .lesson-header {
                padding: 12px 16px;
                height: 60px;
                gap: 12px;
            }

            .quiz-arena {
                padding: 12px 16px 150px 16px;
                justify-content: flex-start;
            }

            .drawer-content {
                flex-direction: column;
                align-items: stretch;
                gap: 14px;
            }

            .action-drawer {
                padding: 16px 16px calc(16px + env(safe-area-inset-bottom, 0px)) 16px;
            }

            .action-drawer .btn-3d {
                width: 100%;
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

    {{ $slot }}

    <!-- Sound Synthesizer Engine -->
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
                osc.frequency.setValueAtTime(160, now);
                osc.frequency.exponentialRampToValueAtTime(90, now + 0.3);
                gain.gain.setValueAtTime(0.25, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.3);
            },
            playTap() {
                this.init();
                if (!this.ctx) return;
                const now = this.ctx.currentTime;
                const osc = this.ctx.createOscillator();
                const gain = this.ctx.createGain();
                osc.type = 'sine';
                osc.frequency.setValueAtTime(500, now);
                osc.frequency.exponentialRampToValueAtTime(900, now + 0.04);
                gain.gain.setValueAtTime(0.1, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.04);
                osc.connect(gain);
                gain.connect(this.ctx.destination);
                osc.start(now);
                osc.stop(now + 0.04);
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
