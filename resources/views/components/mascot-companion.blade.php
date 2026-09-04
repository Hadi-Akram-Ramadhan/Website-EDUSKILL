@props([
    'mode' => 'standard', // 'standard' | 'lesson' | 'landing'
])

<div id="eduskill-mascot-widget" class="mascot-root {{ $mode === 'lesson' ? 'mode-lesson' : '' }}">
    <style>
        .mascot-root {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            pointer-events: none;
            user-select: none;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Offset for mobile navigation bar */
        @media (max-width: 768px) {
            .mascot-root {
                bottom: 80px;
                right: 14px;
            }
            .mascot-root.mode-lesson {
                bottom: 90px;
            }
        }

        /* Mascot Speech Bubble */
        .mascot-bubble {
            pointer-events: auto;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 2px solid #bfdbfe;
            border-radius: 20px;
            padding: 12px 16px;
            box-shadow: 0 10px 30px -5px rgba(37, 99, 235, 0.15), 0 4px 0 #bfdbfe;
            margin-bottom: 12px;
            max-width: 260px;
            position: relative;
            transform-origin: bottom right;
            animation: bubblePop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .mascot-bubble::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 32px;
            width: 14px;
            height: 14px;
            background: #ffffff;
            border-right: 2px solid #bfdbfe;
            border-bottom: 2px solid #bfdbfe;
            transform: rotate(45deg);
        }

        .mascot-bubble-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            gap: 8px;
        }

        .mascot-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 800;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mascot-status-dot {
            width: 7px;
            height: 7px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25);
            animation: statusPulse 1.8s infinite;
        }

        .mascot-bubble-text {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.45;
        }

        .mascot-bubble-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px dashed #e2e8f0;
        }

        .mascot-btn-mini {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .mascot-btn-mini:hover {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        /* Mascot Character Avatar Container */
        .mascot-avatar-btn {
            pointer-events: auto;
            position: relative;
            cursor: pointer;
            width: 76px;
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.15s ease;
            filter: drop-shadow(0 8px 18px rgba(37, 99, 235, 0.22));
        }

        .mascot-avatar-btn:hover {
            transform: scale(1.08);
        }

        .mascot-avatar-btn:active {
            transform: scale(0.94) translateY(2px);
        }

        /* Mascot Floating Keyframes */
        .mascot-float-anim {
            animation: mascotFloating 3.2s ease-in-out infinite;
        }

        @keyframes mascotFloating {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-8px) rotate(2deg);
            }
        }

        @keyframes statusPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.6; }
        }

        @keyframes bubblePop {
            0% { transform: scale(0.6) translateY(12px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        @keyframes mascotBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            30% { transform: translateY(-16px) scale(1.1) rotate(-4deg); }
            60% { transform: translateY(-6px) scale(1.05) rotate(3deg); }
        }

        @keyframes mascotCheer {
            0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
            25% { transform: translateY(-18px) scale(1.15) rotate(-6deg); }
            50% { transform: translateY(-10px) scale(1.1) rotate(6deg); }
            75% { transform: translateY(-16px) scale(1.15) rotate(-4deg); }
        }

        @keyframes mascotShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px) rotate(-4deg); }
            40%, 80% { transform: translateX(6px) rotate(4deg); }
        }

        .anim-bounce {
            animation: mascotBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .anim-cheer {
            animation: mascotCheer 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        .anim-shake {
            animation: mascotShake 0.45s ease-in-out !important;
        }

        /* SVG Inner Animations */
        .visor-blink {
            animation: visorBlinking 4.5s infinite;
            transform-origin: center;
        }

        @keyframes visorBlinking {
            0%, 94%, 98%, 100% { transform: scaleY(1); }
            96% { transform: scaleY(0.1); }
        }

        .thruster-glow {
            animation: thrusterPulsing 1.4s ease-in-out infinite alternate;
        }

        @keyframes thrusterPulsing {
            0% { opacity: 0.65; transform: scaleY(0.85); }
            100% { opacity: 1; transform: scaleY(1.2); }
        }

        /* Minimized State */
        .mascot-root.is-minimized .mascot-bubble {
            display: none !important;
        }

        .mascot-root.is-minimized .mascot-avatar-btn {
            width: 48px;
            height: 48px;
        }

        .mascot-root.is-minimized svg {
            width: 48px;
            height: 48px;
        }

        .mascot-unread-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 14px;
            height: 14px;
            background: #ef4444;
            border: 2px solid #ffffff;
            border-radius: 50%;
            display: none;
        }

        .mascot-root.is-minimized .mascot-unread-badge {
            display: block;
        }
    </style>

    <!-- Interactive Dialogue Speech Bubble -->
    <div id="mascot-bubble" class="mascot-bubble">
        <div class="mascot-bubble-header">
            <div class="mascot-badge">
                <span class="mascot-status-dot"></span>
                <span>Byte • AI Companion</span>
            </div>
            <button type="button" class="mascot-btn-mini" onclick="window.EduMascot.minimize(event)" title="Sembunyikan">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <div id="mascot-bubble-text" class="mascot-bubble-text">
            @auth
                Halo {{ explode(' ', auth()->user()->name)[0] }}! Siap coding dan kumpulin XP hari ini?
            @else
                Halo calon developer hebat! Mau belajar coding seru bareng Byte?
            @endauth
        </div>

        <div class="mascot-bubble-actions">
            <button type="button" class="mascot-btn-mini" onclick="window.EduMascot.nextQuote(event)">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                <span>Tips Lain</span>
            </button>
        </div>
    </div>

    <!-- 100% Vector Crisp Cute Robot Mascot SVG -->
    <div id="mascot-avatar" class="mascot-avatar-btn mascot-float-anim" onclick="window.EduMascot.interact(event)" title="Klik Byte untuk tips & motivasi!">
        <div class="mascot-unread-badge"></div>
        <svg id="mascot-svg" width="76" height="76" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Body Linear Gradient -->
                <linearGradient id="byteBodyGrad" x1="20" y1="10" x2="80" y2="90" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#ffffff"/>
                    <stop offset="45%" stop-color="#eff6ff"/>
                    <stop offset="100%" stop-color="#dbeafe"/>
                </linearGradient>

                <!-- Primary Blue Accent -->
                <linearGradient id="byteBlueGrad" x1="10" y1="0" x2="90" y2="100" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#3b82f6"/>
                    <stop offset="100%" stop-color="#1d4ed8"/>
                </linearGradient>

                <!-- Visor Screen Dark Metallic Gradient -->
                <linearGradient id="byteVisorGrad" x1="0" y1="0" x2="0" y2="100%">
                    <stop offset="0%" stop-color="#0f172a"/>
                    <stop offset="100%" stop-color="#1e293b"/>
                </linearGradient>

                <!-- Cyan Eye Glow -->
                <linearGradient id="byteCyanEye" x1="0" y1="0" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#38bdf8"/>
                    <stop offset="100%" stop-color="#06b6d4"/>
                </linearGradient>

                <!-- Thruster Flame Gradient -->
                <linearGradient id="byteThrusterGrad" x1="0" y1="0" x2="0" y2="100%">
                    <stop offset="0%" stop-color="#60a5fa"/>
                    <stop offset="60%" stop-color="#3b82f6"/>
                    <stop offset="100%" stop-color="rgba(37, 99, 235, 0)"/>
                </linearGradient>

                <!-- Soft Drop Shadow Filter -->
                <filter id="byteGlow" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="3" result="blur"/>
                    <feComposite in="SourceGraphic" in2="blur" operator="over"/>
                </filter>
            </defs>

            <!-- Bottom Thruster Propulsion Energy Flame -->
            <g class="thruster-glow" transform-origin="50 82">
                <path d="M42 80 C44 94, 56 94, 58 80 Z" fill="url(#byteThrusterGrad)" opacity="0.9"/>
                <ellipse cx="50" cy="81" rx="7" ry="2.5" fill="#93c5fd"/>
            </g>

            <!-- Floating Robotic Side Wings/Ears -->
            <!-- Left Wing -->
            <path d="M18 42 C12 36, 12 56, 18 50 Z" fill="url(#byteBlueGrad)" stroke="#1e40af" stroke-width="1.5"/>
            <circle cx="16" cy="46" r="2" fill="#60a5fa"/>

            <!-- Right Wing -->
            <path d="M82 42 C88 36, 88 56, 82 50 Z" fill="url(#byteBlueGrad)" stroke="#1e40af" stroke-width="1.5"/>
            <circle cx="84" cy="46" r="2" fill="#60a5fa"/>

            <!-- Top Smart Antenna -->
            <rect x="48.5" y="10" width="3" height="12" rx="1.5" fill="#94a3b8"/>
            <circle cx="50" cy="9" r="4.5" fill="#3b82f6" filter="url(#byteGlow)"/>
            <circle cx="50" cy="9" r="2" fill="#93c5fd"/>

            <!-- Main Rounded Body / Head -->
            <rect x="20" y="20" width="60" height="58" rx="26" fill="url(#byteBodyGrad)" stroke="#cbd5e1" stroke-width="2.5"/>

            <!-- Head Glossy Reflection Light Curve -->
            <path d="M30 24 C40 22, 60 22, 70 24" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" opacity="0.8"/>

            <!-- Dark Futuristic Visor Screen -->
            <rect x="26" y="32" width="48" height="30" rx="14" fill="url(#byteVisorGrad)" stroke="#334155" stroke-width="1.5"/>

            <!-- Visor Edge Soft Blue Rim -->
            <rect x="27.5" y="33.5" width="45" height="27" rx="12.5" fill="none" stroke="#1e3a8a" stroke-width="1" opacity="0.4"/>

            <!-- Expressive Visor Eyes -->
            <g id="mascot-eyes" class="visor-blink">
                <!-- Normal Friendly Visor Eyes -->
                <g id="eyes-normal">
                    <!-- Left Eye -->
                    <rect x="36" y="41" width="8" height="12" rx="4" fill="url(#byteCyanEye)" filter="url(#byteGlow)"/>
                    <circle cx="38" cy="43" r="1.5" fill="#ffffff"/>
                    
                    <!-- Right Eye -->
                    <rect x="56" y="41" width="8" height="12" rx="4" fill="url(#byteCyanEye)" filter="url(#byteGlow)"/>
                    <circle cx="58" cy="43" r="1.5" fill="#ffffff"/>
                </g>

                <!-- Happy Arched Eyes (Hidden by default, triggered on correct/combo) -->
                <g id="eyes-happy" style="display: none;">
                    <path d="M35 47 Q40 40 45 47" stroke="#38bdf8" stroke-width="3" stroke-linecap="round" fill="none" filter="url(#byteGlow)"/>
                    <path d="M55 47 Q60 40 65 47" stroke="#38bdf8" stroke-width="3" stroke-linecap="round" fill="none" filter="url(#byteGlow)"/>
                </g>

                <!-- Concerned/Focused Eyes (Triggered on wrong answer) -->
                <g id="eyes-wrong" style="display: none;">
                    <line x1="36" y1="43" x2="44" y2="47" stroke="#f87171" stroke-width="3" stroke-linecap="round"/>
                    <line x1="64" y1="43" x2="56" y2="47" stroke="#f87171" stroke-width="3" stroke-linecap="round"/>
                </g>

                <!-- Star Fire Eyes (Triggered on 3+ Combo) -->
                <g id="eyes-fire" style="display: none;">
                    <polygon points="40,39 42,44 47,44 43,47 45,52 40,49 35,52 37,47 33,44 38,44" fill="#fbbf24" filter="url(#byteGlow)"/>
                    <polygon points="60,39 62,44 67,44 63,47 65,52 60,49 55,52 57,47 53,44 58,44" fill="#fbbf24" filter="url(#byteGlow)"/>
                </g>
            </g>

            <!-- Cute Blushing Cheeks -->
            <ellipse cx="32" cy="56" rx="3.5" ry="1.8" fill="#f43f5e" opacity="0.35"/>
            <ellipse cx="68" cy="56" rx="3.5" ry="1.8" fill="#f43f5e" opacity="0.35"/>

            <!-- Chest EduSkill Emblem (Glowing Center Core) -->
            <circle cx="50" cy="68" r="4.5" fill="#2563eb" stroke="#bfdbfe" stroke-width="1.5"/>
            <polygon points="50,65.5 52,68 50,70.5 48,68" fill="#60a5fa"/>
        </svg>
    </div>
</div>

<script>
    (function() {
        const quotes = [
            "Streak coding lo bakal bikin lo selangkah di depan yang lain!",
            "Tahu gak? Error itu temen terbaik programmer buat belajar sintaks!",
            "Tips: Pahami logikanya dulu, baru susun kodenya sat set!",
            "Konsisten 15 menit tiap hari jauh lebih sakti daripada begadang semalam.",
            "Semangat terus! Coding itu ibarat main puzzle, makin lama makin asik.",
            "Kombinasikan pemahaman algoritma dan logika buat raih ranking teratas!",
            "Jangan lupa minum air putih biar otak lo tetep encer pas ngoding!"
        ];

        let quoteIndex = 0;
        let isMinimized = localStorage.getItem('eduskill_mascot_minimized') === 'true';
        let bubbleTimeout = null;

        const widget = document.getElementById('eduskill-mascot-widget');
        const bubble = document.getElementById('mascot-bubble');
        const bubbleText = document.getElementById('mascot-bubble-text');
        const avatar = document.getElementById('mascot-avatar');

        // Apply saved minimized state
        if (isMinimized && widget) {
            widget.classList.add('is-minimized');
        }

        // Global EduMascot Controller Object
        window.EduMascot = {
            /**
             * Trigger interactive reaction
             * @param {'correct'|'wrong'|'combo'|'victory'|'click'} state
             * @param {string} customMsg
             */
            react: function(state, customMsg) {
                if (!avatar || !bubbleText) return;

                // Reset animation classes
                avatar.classList.remove('anim-bounce', 'anim-cheer', 'anim-shake');
                void avatar.offsetWidth; // Trigger reflow

                this.setEyeMood(state);

                if (state === 'correct') {
                    avatar.classList.add('anim-bounce');
                    this.showBubble(customMsg || "Mantap jiwa! Jawaban lo bener banget!", 3500);
                } else if (state === 'wrong') {
                    avatar.classList.add('anim-shake');
                    this.showBubble(customMsg || "Santai, coba periksa instruksi atau nilainya lagi ya!", 4000);
                } else if (state === 'combo') {
                    avatar.classList.add('anim-cheer');
                    this.showBubble(customMsg || "GOKIL! Combo streak lo lagi membara nih! Pertahankan!", 3500);
                } else if (state === 'victory') {
                    avatar.classList.add('anim-cheer');
                    this.showBubble(customMsg || "SELESAI! Selamat atas pencapaian luar biasa lo hari ini!", 5000);
                } else {
                    avatar.classList.add('anim-bounce');
                    if (customMsg) this.showBubble(customMsg, 4000);
                }
            },

            /**
             * Switch eye vector shapes
             */
            setEyeMood: function(mood) {
                const eyesNormal = document.getElementById('eyes-normal');
                const eyesHappy = document.getElementById('eyes-happy');
                const eyesWrong = document.getElementById('eyes-wrong');
                const eyesFire = document.getElementById('eyes-fire');

                if (!eyesNormal) return;

                eyesNormal.style.display = 'none';
                if (eyesHappy) eyesHappy.style.display = 'none';
                if (eyesWrong) eyesWrong.style.display = 'none';
                if (eyesFire) eyesFire.style.display = 'none';

                if (mood === 'correct' || mood === 'victory') {
                    if (eyesHappy) eyesHappy.style.display = 'block';
                } else if (mood === 'wrong') {
                    if (eyesWrong) eyesWrong.style.display = 'block';
                } else if (mood === 'combo') {
                    if (eyesFire) eyesFire.style.display = 'block';
                } else {
                    eyesNormal.style.display = 'block';
                }

                // Auto reset eyes to normal after 3 seconds
                setTimeout(() => {
                    if (eyesNormal) eyesNormal.style.display = 'block';
                    if (eyesHappy) eyesHappy.style.display = 'none';
                    if (eyesWrong) eyesWrong.style.display = 'none';
                    if (eyesFire) eyesFire.style.display = 'none';
                }, 3000);
            },

            /**
             * Show speech bubble with timeout
             */
            showBubble: function(text, duration = 4000) {
                if (!bubble || !bubbleText) return;
                
                // If minimized, restore temporarily
                if (widget && widget.classList.contains('is-minimized')) {
                    widget.classList.remove('is-minimized');
                }

                bubbleText.innerHTML = text;
                bubble.style.display = 'block';

                if (bubbleTimeout) clearTimeout(bubbleTimeout);
                if (duration > 0) {
                    bubbleTimeout = setTimeout(() => {
                        // Keep bubble visible in regular state, only auto-cycle if needed
                    }, duration);
                }
            },

            /**
             * Click mascot avatar event
             */
            interact: function(e) {
                if (e) e.stopPropagation();

                // If currently minimized, maximize
                if (widget && widget.classList.contains('is-minimized')) {
                    widget.classList.remove('is-minimized');
                    localStorage.setItem('eduskill_mascot_minimized', 'false');
                }

                if (window.EduAudio) {
                    window.EduAudio.playMascotChirp();
                }

                this.nextQuote();
                avatar.classList.remove('anim-bounce');
                void avatar.offsetWidth;
                avatar.classList.add('anim-bounce');
                this.setEyeMood('correct');
            },

            /**
             * Cycle to next tip quote
             */
            nextQuote: function(e) {
                if (e) e.stopPropagation();
                if (window.EduAudio) window.EduAudio.playTap();

                quoteIndex = (quoteIndex + 1) % quotes.length;
                this.showBubble(quotes[quoteIndex]);
            },

            /**
             * Minimize mascot bubble to small floating badge
             */
            minimize: function(e) {
                if (e) e.stopPropagation();
                if (window.EduAudio) window.EduAudio.playTap();

                if (widget) {
                    widget.classList.add('is-minimized');
                    localStorage.setItem('eduskill_mascot_minimized', 'true');
                }
            }
        };
    })();
</script>
