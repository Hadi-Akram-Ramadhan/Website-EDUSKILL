<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sesi Belajar Kuis - Kodein' }}</title>
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
            --duo-orange: #ff9600;
            --duo-orange-shadow: #e58700;
            --duo-red: #ff4b4b;
            --duo-red-shadow: #ea2b2b;
            --duo-red-bg: #3c1418;
            --duo-green-bg: #14351a;
            --duo-gold: #ffc800;
            --duo-dark: #0e161a;
            --duo-card: #202f36;
            --duo-border: #37464f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--duo-dark);
            color: #ffffff;
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
            letter-spacing: 0.8px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            transition: transform 0.1s ease, filter 0.15s ease;
            user-select: none;
            text-decoration: none;
            padding: 14px 28px;
            font-size: 16px;
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

        .btn-red {
            background: var(--duo-red);
            color: #ffffff;
            box-shadow: 0 4px 0 var(--duo-red-shadow);
        }
        .btn-red:active {
            box-shadow: 0 0 0 var(--duo-red-shadow);
        }

        .btn-disabled {
            background: #2b3940 !important;
            color: #64748b !important;
            box-shadow: 0 4px 0 #1b262c !important;
            cursor: not-allowed !important;
            transform: none !important;
        }

        /* Top Progress Bar */
        .lesson-header {
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
            padding: 24px 20px 12px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .progress-track {
            flex: 1;
            height: 16px;
            background: #2b3940;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #58cc02, #68e805);
            border-radius: 9999px;
            transition: width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 8px;
            right: 8px;
            height: 4px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 9999px;
        }

        .heart-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--duo-red);
            font-weight: 800;
            font-size: 18px;
        }

        .btn-close {
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 22px;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.15s;
        }
        .btn-close:hover {
            color: #ffffff;
            background: #202f36;
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
            border-top: 2px solid var(--duo-border);
            background: #131f24;
            padding: 24px 20px;
            z-index: 50;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .action-drawer.correct-state {
            background: var(--duo-green-bg);
            border-color: var(--duo-green);
        }

        .action-drawer.wrong-state {
            background: var(--duo-red-bg);
            border-color: var(--duo-red);
        }

        .drawer-content {
            max-width: 860px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .drawer-content {
                flex-direction: column;
                align-items: stretch;
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
                    gain.gain.setValueAtTime(0.25, now + i * 0.08);
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
                gain.gain.setValueAtTime(0.3, now);
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
                gain.gain.setValueAtTime(0.12, now);
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
