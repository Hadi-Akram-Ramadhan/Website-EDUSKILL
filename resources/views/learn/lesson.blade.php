@php
    $title = 'Kuis: ' . $lesson->title . ' - EduSkill';
@endphp

<x-lesson-layout :title="$title">
    <div id="quiz-container" style="display: flex; flex-direction: column; min-height: 100vh;">
        
        <!-- Header Progress & Lives Bar -->
        <header class="lesson-header">
            <a href="{{ route('learn.index', ['course' => $lesson->unit->course_id]) }}" class="btn-close" title="Keluar" onclick="if(window.EduAudio) window.EduAudio.stopBgm();">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </a>

            <div class="progress-track">
                <div id="progress-bar" class="progress-fill"></div>
            </div>

            <!-- Dynamic Quiz Combo Streak Indicator -->
            <div id="combo-streak-pill" style="display: none; align-items: center; gap: 6px; background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid #f59e0b; padding: 4px 12px; border-radius: 9999px; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25); animation: pulse-project 1.5s infinite;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="#d97706" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                <span id="combo-streak-text" style="font-size: 12px; font-weight: 900; color: #b45309; letter-spacing: 0.5px;">COMBO x2</span>
            </div>

            <!-- Sound & Dynamic Music Toggle -->
            <button type="button" id="btn-sound-toggle" onclick="toggleAudio()" class="btn-close" title="Toggle Musik & Suara" style="color: #2563eb; background: #eff6ff; border: 1.5px solid #bfdbfe; width: 38px; height: 38px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <svg id="icon-sound-on" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                <svg id="icon-sound-off" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
            </button>

            <div class="heart-badge">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                <span id="hearts-counter">{{ $user->hearts }}</span>
            </div>
        </header>

        <!-- Main Question Slide Arena -->
        <main class="quiz-arena">
            @if ($lesson->is_project || $lesson->type === 'project')
                <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); border: 2px solid #d8b4fe; border-radius: 18px; padding: 14px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 0 #d8b4fe; width: 100%;">
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; border-radius: 10px; background: #7e22ce; color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size: 11px; font-weight: 900; color: #7e22ce; text-transform: uppercase;">TANTANGAN PROYEK AKHIR MODUL</div>
                        <div style="font-size: 14px; font-weight: 900; color: #0f172a;">{{ $lesson->title }}</div>
                        @if ($lesson->project_brief)
                            <div style="font-size: 12px; color: #475569; margin-top: 2px;">{{ $lesson->project_brief }}</div>
                        @endif
                    </div>
                </div>
            @endif

            <div id="question-card" style="width: 100%;">
                <!-- Dynamic Question Content Injected via JS -->
            </div>
        </main>

        <!-- Bottom Action Feedback Drawer -->
        <footer id="action-drawer" class="action-drawer">
            <div class="drawer-content">
                <div id="feedback-message" style="display: flex; align-items: center; gap: 16px;">
                    <!-- Message dynamically updated (icon + heading + explanation) -->
                </div>
                <div>
                    <button id="btn-action" class="btn-3d btn-blue" onclick="handleActionClick()">
                        Periksa Jawaban
                    </button>
                </div>
            </div>
        </footer>
    </div>

    <!-- Victory Screen Modal (Hidden by Default) -->
    <div id="victory-modal" style="display: none; position: fixed; inset: 0; background: #ffffff; z-index: 100; flex-direction: column; align-items: center; justify-content: center; padding: 24px; text-align: center;">
        <div style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; flex-shrink: 0; background: #eff6ff; border-radius: 28px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 24px; box-shadow: 0 4px 0 #bfdbfe;" class="animate-float">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
        <h1 style="font-size: 32px; font-weight: 900; color: #0f172a; margin-bottom: 8px;">Pelajaran Selesai!</h1>
        <p style="color: #64748b; font-size: 16px; max-width: 440px; margin-bottom: 32px;">Kamu berhasil menyelesaikan semua latihan kode dengan pemahaman yang baik.</p>

        <div style="display: flex; gap: 16px; margin-bottom: 36px; flex-wrap: wrap; justify-content: center;">
            <div class="card-3d" style="padding: 18px 24px; text-align: center; border-color: #bfdbfe; min-width: 120px;">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary-blue); text-transform: uppercase;">Total XP</div>
                <div id="victory-xp" style="font-size: 26px; font-weight: 900; color: var(--primary-blue);">+{{ $lesson->xp_reward }}</div>
            </div>
            <div class="card-3d" style="padding: 18px 24px; text-align: center; border-color: #a7f3d0; min-width: 120px;">
                <div style="font-size: 11px; font-weight: 800; color: #059669; text-transform: uppercase;">Akurasi</div>
                <div id="victory-accuracy" style="font-size: 26px; font-weight: 900; color: #059669;">100%</div>
            </div>
            <div class="card-3d" style="padding: 18px 24px; text-align: center; border-color: #fed7aa; min-width: 120px;">
                <div style="font-size: 11px; font-weight: 800; color: #d97706; text-transform: uppercase;">Max Combo</div>
                <div id="victory-combo" style="font-size: 26px; font-weight: 900; color: #d97706;">0x</div>
            </div>
        </div>

        <a href="{{ route('learn.index', ['course' => $lesson->unit->course_id]) }}" class="btn-3d btn-blue" style="font-size: 16px; padding: 16px 48px;">
            Lanjutkan ke Roadmap
        </a>
    </div>

    <!-- Quiz Engine Script -->
    <script>
        const exercises = @json($exercises);
        const lessonId = {{ $lesson->id }};
        const submitUrl = "{{ route('learn.submit', $lesson->id) }}";
        const csrfToken = "{{ csrf_token() }}";
        const isMiniProject = {{ ($lesson->is_project || $lesson->type === 'project') ? 'true' : 'false' }};

        let currentIndex = 0;
        let currentAnswers = []; // Store {exercise_id, answer}
        let selectedAnswer = null;
        let currentHearts = {{ $user->hearts }};
        let isDrawerAnswerChecked = false;
        let currentCombo = 0;
        let maxCombo = 0;

        function updateAudioToggleUI() {
            if (!window.EduAudio) return;
            const isMuted = window.EduAudio.isSfxMuted && window.EduAudio.isBgmMuted;
            const iconOn = document.getElementById('icon-sound-on');
            const iconOff = document.getElementById('icon-sound-off');
            const btn = document.getElementById('btn-sound-toggle');
            if (iconOn && iconOff && btn) {
                if (isMuted) {
                    iconOn.style.display = 'none';
                    iconOff.style.display = 'block';
                    btn.style.color = '#94a3b8';
                    btn.style.background = '#f1f5f9';
                    btn.style.borderColor = '#cbd5e1';
                } else {
                    iconOn.style.display = 'block';
                    iconOff.style.display = 'none';
                    btn.style.color = '#2563eb';
                    btn.style.background = '#eff6ff';
                    btn.style.borderColor = '#bfdbfe';
                }
            }
        }

        function toggleAudio() {
            if (window.EduAudio) {
                window.EduAudio.init();
                const unmuted = window.EduAudio.toggleAllSound();
                if (unmuted) {
                    window.EduAudio.startBgm(isMiniProject ? 'project' : 'quiz');
                    window.EduAudio.playSelect();
                }
                updateAudioToggleUI();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCurrentQuestion();
            updateAudioToggleUI();

            // Auto-start dynamic BGM on first interaction
            const startQuizAudio = () => {
                if (window.EduAudio) {
                    window.EduAudio.init();
                    window.EduAudio.startBgm(isMiniProject ? 'project' : 'quiz');
                    updateAudioToggleUI();
                }
                window.removeEventListener('click', startQuizAudio);
                window.removeEventListener('touchstart', startQuizAudio);
            };
            window.addEventListener('click', startQuizAudio, { once: true });
            window.addEventListener('touchstart', startQuizAudio, { once: true });
        });

        function parseOptions(raw) {
            if (!raw) return [];
            if (Array.isArray(raw)) return raw;
            if (typeof raw === 'object') return raw;
            try {
                return JSON.parse(raw);
            } catch (e) {
                return [];
            }
        }

        function renderCurrentQuestion() {
            isDrawerAnswerChecked = false;
            selectedAnswer = null;

            const drawer = document.getElementById('action-drawer');
            drawer.className = 'action-drawer';
            document.getElementById('feedback-message').innerHTML = '';
            
            const btnAction = document.getElementById('btn-action');
            btnAction.innerText = 'Periksa Jawaban';
            btnAction.className = 'btn-3d btn-blue';

            if (currentIndex >= exercises.length) {
                submitCompletedLesson();
                return;
            }

            // Update Progress Bar
            const progress = (currentIndex / exercises.length) * 100;
            document.getElementById('progress-bar').style.width = `${progress}%`;

            // Dynamically adapt BGM intensity
            if (window.EduAudio && window.EduAudio.setIntensity) {
                window.EduAudio.setIntensity(currentIndex / Math.max(1, exercises.length));
            }

            const ex = exercises[currentIndex];
            const card = document.getElementById('question-card');

            let html = `
                <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--primary-blue); margin-bottom: 8px; letter-spacing: 0.8px;">
                    Latihan ${currentIndex + 1} dari ${exercises.length}
                </div>
                <h2 style="font-size: 22px; font-weight: 900; color: #0f172a; line-height: 1.4; margin-bottom: 24px;">
                    ${ex.prompt}
                </h2>
            `;

            if (ex.code_snippet) {
                html += `
                    <div style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 18px; padding: 20px; margin-bottom: 24px; box-shadow: 0 4px 0 #e2e8f0;">
                        <pre class="code-font" style="font-size: 16px; font-weight: 600; color: #0f172a; line-height: 1.6; overflow-x: auto; margin: 0;"><code>${escapeHtml(ex.code_snippet)}</code></pre>
                    </div>
                `;
            }

            const rawOpts = ex.options_json || ex.options;
            const parsedOpts = parseOptions(rawOpts);

            // Question Type: Fill Blank / Multiple Choice / Output Prediction
            if (ex.question_type === 'fill_blank' || ex.question_type === 'multiple_choice' || ex.question_type === 'output_prediction') {
                html += `<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 8px;">`;
                
                const optList = Array.isArray(parsedOpts) ? parsedOpts : [];
                optList.forEach((opt, idx) => {
                    const optText = typeof opt === 'object' ? (opt.text || JSON.stringify(opt)) : opt;
                    html += `
                        <button type="button" class="btn-3d btn-outline opt-chip" 
                                data-option="${escapeHtml(optText)}"
                                onclick="selectSingleOption(this)" 
                                style="justify-content: flex-start; text-align: left; text-transform: none; font-size: 15px; font-weight: 700; padding: 18px 20px; width: 100%; border-radius: 18px;">
                            <span style="width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #64748b; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                ${String.fromCharCode(65 + idx)}
                            </span>
                            <span class="code-font" style="flex: 1;">${escapeHtml(optText)}</span>
                        </button>
                    `;
                });
                html += `</div>`;
            } 
            // Question Type: Code Ordering (Parsons Problem)
            else if (ex.question_type === 'code_ordering') {
                html += `
                    <div style="margin-bottom: 12px; font-size: 13px; font-weight: 800; color: #64748b;">
                        Susun urutan baris kode di kotak atas dengan mengetuk potongan kode di bawah:
                    </div>
                    <div id="ordering-bucket" style="min-height: 84px; background: #ffffff; border: 2px dashed var(--primary-blue); border-radius: 18px; padding: 14px; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                    </div>
                    <div id="ordering-pool" style="display: flex; flex-direction: column; gap: 10px;">
                `;
                const poolList = Array.isArray(parsedOpts) ? parsedOpts : [];
                poolList.forEach(item => {
                    html += `
                        <button type="button" class="btn-3d btn-outline ordering-chip code-font" 
                                data-id="${escapeHtml(item.id)}"
                                onclick="moveOrderingChip(this)" 
                                style="justify-content: flex-start; text-align: left; text-transform: none; font-size: 15px; font-weight: 600; padding: 14px 18px; border-radius: 14px;">
                            ${escapeHtml(item.text)}
                        </button>
                    `;
                });
                html += `</div>`;
            }
            // Question Type: Matching Pair
            else if (ex.question_type === 'matching_pair') {
                const pairs = (parsedOpts && parsedOpts.pairs) ? parsedOpts.pairs : parsedOpts;
                const leftKeys = typeof pairs === 'object' && !Array.isArray(pairs) ? Object.keys(pairs) : [];
                const rightVals = typeof pairs === 'object' && !Array.isArray(pairs) ? Object.values(pairs).sort(() => Math.random() - 0.5) : [];

                html += `
                    <div style="margin-bottom: 14px; font-size: 13px; font-weight: 800; color: #64748b;">
                        Pilih satu item di kiri, lalu pilih pasangannya di kanan:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            ${leftKeys.map(k => `
                                <button type="button" class="btn-3d btn-outline match-left code-font" 
                                        data-key="${escapeHtml(k)}" 
                                        onclick="selectMatchPair('left', this)" 
                                        style="text-transform: none; font-size: 14px; padding: 14px 16px; border-radius: 14px; width: 100%; text-align: center;">
                                    ${escapeHtml(k)}
                                </button>
                            `).join('')}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            ${rightVals.map(v => `
                                <button type="button" class="btn-3d btn-outline match-right code-font" 
                                        data-val="${escapeHtml(v)}" 
                                        onclick="selectMatchPair('right', this)" 
                                        style="text-transform: none; font-size: 14px; padding: 14px 16px; border-radius: 14px; width: 100%; text-align: center;">
                                    ${escapeHtml(v)}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                `;
                window._matchedPairs = {};
                window._currentMatchLeft = null;
                window._currentMatchRight = null;
            }
            // Question Type: Interactive 3D Question (Spatial & Computational 3D Models)
            else if (ex.question_type === 'interactive_3d') {
                const modelConfig = ex.model_3d_json || ex.model_3d || { preset: 'matrix_grid' };
                html += `
                    <div style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 24px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 6px 0 #e2e8f0;">
                        <div style="background: #0f172a; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; color: #fff; flex-wrap: wrap; gap: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="background: #2563eb; color: #fff; font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                    3D VIEWPORT
                                </span>
                                <span style="font-size: 13px; font-weight: 700; color: #e2e8f0;">${escapeHtml(modelConfig.label || 'Visualisasi Objek 3D')}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <button type="button" onclick="toggle3DWireframe()" class="btn-3d" style="background: #1e293b; border: 1px solid #334155; color: #94a3b8; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: none;">
                                    📐 Wireframe
                                </button>
                                <button type="button" onclick="toggle3DAnimation()" class="btn-3d" style="background: #1e293b; border: 1px solid #334155; color: #94a3b8; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: none;">
                                    ⏸️ Putar
                                </button>
                                <button type="button" onclick="reset3DCamera()" class="btn-3d" style="background: #1e293b; border: 1px solid #334155; color: #94a3b8; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: none;">
                                    🔄 Reset
                                </button>
                            </div>
                        </div>
                        <div id="three-viewport-container" style="width: 100%; height: 320px; background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%); position: relative; cursor: grab;">
                            <div style="position: absolute; bottom: 10px; left: 12px; background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(6px); padding: 5px 10px; border-radius: 8px; color: #94a3b8; font-size: 11px; pointer-events: none; z-index: 5; font-weight: 600;">
                                🖱️ Putar 360° &bull; 🔍 Scroll Zoom &bull; 👆 Geser
                            </div>
                        </div>
                    </div>
                `;

                html += `<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 8px;">`;
                const optList = Array.isArray(parsedOpts) ? parsedOpts : [];
                optList.forEach((opt, idx) => {
                    const optText = typeof opt === 'object' ? (opt.text || JSON.stringify(opt)) : opt;
                    html += `
                        <button type="button" class="btn-3d btn-outline opt-chip" 
                                data-option="${escapeHtml(optText)}"
                                onclick="selectSingleOption(this)" 
                                style="justify-content: flex-start; text-align: left; text-transform: none; font-size: 15px; font-weight: 700; padding: 18px 20px; width: 100%; border-radius: 18px;">
                            <span style="width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #64748b; font-weight: 800; font-size: 12px; display: inline-flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                ${String.fromCharCode(65 + idx)}
                            </span>
                            <span class="code-font" style="flex: 1;">${escapeHtml(optText)}</span>
                        </button>
                    `;
                });
                html += `</div>`;
            }

            card.innerHTML = html;

            // Initialize Three.js scene if this question is 3D
            if (ex.question_type === 'interactive_3d') {
                const modelConfig = ex.model_3d_json || ex.model_3d || { preset: 'matrix_grid' };
                setTimeout(() => {
                    init3DScene('three-viewport-container', modelConfig);
                }, 50);
            } else {
                dispose3DScene();
            }
        }

        // Single Choice / Fill Blank Selection
        function selectSingleOption(btn) {
            if (window.EduAudio) window.EduAudio.playSelect();
            const val = btn.getAttribute('data-option');
            document.querySelectorAll('.opt-chip').forEach(c => {
                c.style.borderColor = '#cbd5e1';
                c.style.background = '#ffffff';
                c.style.color = 'var(--primary-blue)';
            });
            btn.style.borderColor = 'var(--primary-blue)';
            btn.style.background = '#eff6ff';
            selectedAnswer = val;
        }

        // Parsons Code Ordering Move
        function moveOrderingChip(btn) {
            if (window.EduAudio) window.EduAudio.playTap();
            const bucket = document.getElementById('ordering-bucket');
            const pool = document.getElementById('ordering-pool');

            if (btn.parentElement === pool) {
                bucket.appendChild(btn);
                btn.style.background = '#eff6ff';
                btn.style.borderColor = 'var(--primary-blue)';
            } else {
                pool.appendChild(btn);
                btn.style.background = '#ffffff';
                btn.style.borderColor = '#cbd5e1';
            }

            // Extract IDs in bucket
            const bucketChips = bucket.querySelectorAll('.ordering-chip');
            selectedAnswer = Array.from(bucketChips).map(c => c.getAttribute('data-id'));
        }

        // Matching Pairs Logic (Zero Quoting Bug & Re-pairable)
        function selectMatchPair(side, btn) {
            if (window.EduAudio) window.EduAudio.playTap();

            if (side === 'left') {
                const key = btn.getAttribute('data-key');
                
                // If button is already paired, un-pair it first
                if (btn.getAttribute('data-paired') === 'true') {
                    const pairedVal = window._matchedPairs[key];
                    delete window._matchedPairs[key];
                    btn.removeAttribute('data-paired');
                    btn.style.background = '#ffffff';
                    btn.style.borderColor = '#cbd5e1';
                    btn.style.color = 'var(--primary-blue)';

                    // Find and un-pair the right button
                    document.querySelectorAll('.match-right').forEach(rBtn => {
                        if (rBtn.getAttribute('data-val') === pairedVal) {
                            rBtn.removeAttribute('data-paired');
                            rBtn.style.background = '#ffffff';
                            rBtn.style.borderColor = '#cbd5e1';
                            rBtn.style.color = 'var(--primary-blue)';
                        }
                    });
                }

                // Highlight selected left button
                document.querySelectorAll('.match-left').forEach(b => {
                    if (b.getAttribute('data-paired') !== 'true') {
                        b.style.background = '#ffffff';
                        b.style.borderColor = '#cbd5e1';
                    }
                });

                btn.style.background = '#eff6ff';
                btn.style.borderColor = 'var(--primary-blue)';
                window._currentMatchLeft = { val: key, btn: btn };

            } else {
                const val = btn.getAttribute('data-val');

                // If right button is already paired, un-pair it first
                if (btn.getAttribute('data-paired') === 'true') {
                    for (let k in window._matchedPairs) {
                        if (window._matchedPairs[k] === val) {
                            delete window._matchedPairs[k];
                            // Un-pair the left button
                            document.querySelectorAll('.match-left').forEach(lBtn => {
                                if (lBtn.getAttribute('data-key') === k) {
                                    lBtn.removeAttribute('data-paired');
                                    lBtn.style.background = '#ffffff';
                                    lBtn.style.borderColor = '#cbd5e1';
                                }
                            });
                            break;
                        }
                    }
                    btn.removeAttribute('data-paired');
                    btn.style.background = '#ffffff';
                    btn.style.borderColor = '#cbd5e1';
                    btn.style.color = 'var(--primary-blue)';
                }

                // Highlight selected right button
                document.querySelectorAll('.match-right').forEach(b => {
                    if (b.getAttribute('data-paired') !== 'true') {
                        b.style.background = '#ffffff';
                        b.style.borderColor = '#cbd5e1';
                    }
                });

                btn.style.background = '#eff6ff';
                btn.style.borderColor = 'var(--primary-blue)';
                window._currentMatchRight = { val: val, btn: btn };
            }

            // If both a left and right item are actively selected, pair them!
            if (window._currentMatchLeft && window._currentMatchRight) {
                const leftKey = window._currentMatchLeft.val;
                const rightVal = window._currentMatchRight.val;

                window._matchedPairs[leftKey] = rightVal;

                window._currentMatchLeft.btn.style.background = '#ecfdf5';
                window._currentMatchLeft.btn.style.borderColor = '#10b981';
                window._currentMatchLeft.btn.style.color = '#065f46';
                window._currentMatchLeft.btn.setAttribute('data-paired', 'true');
                
                window._currentMatchRight.btn.style.background = '#ecfdf5';
                window._currentMatchRight.btn.style.borderColor = '#10b981';
                window._currentMatchRight.btn.style.color = '#065f46';
                window._currentMatchRight.btn.setAttribute('data-paired', 'true');

                if (window.EduAudio) window.EduAudio.playSelect();

                window._currentMatchLeft = null;
                window._currentMatchRight = null;
                selectedAnswer = Object.assign({}, window._matchedPairs);
            }
        }

        // Handle Check / Continue button in bottom drawer
        function handleActionClick() {
            if (!isDrawerAnswerChecked) {
                checkAnswer();
            } else {
                nextQuestion();
            }
        }

        function checkAnswer() {
            if (!selectedAnswer && selectedAnswer !== 0) {
                alert('Silakan pilih atau susun jawaban kamu terlebih dahulu!');
                return;
            }

            const ex = exercises[currentIndex];
            let isCorrect = false;

            const rawAnswer = ex.answer_json || ex.answer;

            // Client-side quick validation for sound & feedback
            if (ex.question_type === 'code_ordering') {
                const target = Array.isArray(rawAnswer) ? rawAnswer : parseOptions(rawAnswer);
                isCorrect = JSON.stringify(selectedAnswer) === JSON.stringify(target);
            } else if (ex.question_type === 'matching_pair') {
                const target = typeof rawAnswer === 'object' ? rawAnswer : parseOptions(rawAnswer);
                isCorrect = JSON.stringify(selectedAnswer) === JSON.stringify(target);
            } else {
                isCorrect = String(selectedAnswer).trim().toLowerCase() === String(rawAnswer).trim().toLowerCase();
            }

            currentAnswers.push({
                exercise_id: ex.id,
                answer: selectedAnswer
            });

            const drawer = document.getElementById('action-drawer');
            const feedback = document.getElementById('feedback-message');
            const btnAction = document.getElementById('btn-action');
            const comboPill = document.getElementById('combo-streak-pill');
            const comboText = document.getElementById('combo-streak-text');

            if (isCorrect) {
                currentCombo++;
                if (currentCombo > maxCombo) maxCombo = currentCombo;

                if (currentCombo >= 2) {
                    if (comboPill && comboText) {
                        comboPill.style.display = 'inline-flex';
                        comboText.innerText = `COMBO x${currentCombo}!`;
                    }
                    if (window.EduAudio) window.EduAudio.playCombo(currentCombo);
                    if (window.EduMascot) window.EduMascot.react('combo', `Gokil! Combo x${currentCombo} berturut-turut! Pertahankan!`);
                } else {
                    if (comboPill) comboPill.style.display = 'none';
                    if (window.EduAudio) window.EduAudio.playCorrect();
                    if (window.EduMascot) window.EduMascot.react('correct', 'Luar biasa, jawaban kamu tepat sekali!');
                }

                drawer.className = 'action-drawer correct-state';
                feedback.innerHTML = `
                    <div style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; flex-shrink: 0; border-radius: 14px; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: #065f46;">${currentCombo >= 2 ? `Luar Biasa! Combo x${currentCombo} 🔥` : 'Luar Biasa, Tepat Sekali!'}</div>
                        <div style="font-size: 13px; color: #047857;">${escapeHtml(ex.explanation || 'Jawaban kamu sesuai dengan sintaks yang benar.')}</div>
                    </div>
                `;
                btnAction.className = 'btn-3d btn-green';
                btnAction.innerText = 'Lanjutkan';
            } else {
                currentCombo = 0;
                if (comboPill) comboPill.style.display = 'none';

                if (window.EduAudio) {
                    window.EduAudio.playWrong();
                    window.EduAudio.playHeartLoss();
                }
                if (window.EduMascot) {
                    window.EduMascot.react('wrong', 'Santai bro, pelajari penjelasannya dan coba lagi di soal berikutnya!');
                }

                currentHearts = Math.max(0, currentHearts - 1);
                document.getElementById('hearts-counter').innerText = currentHearts;

                drawer.className = 'action-drawer wrong-state';
                feedback.innerHTML = `
                    <div style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; flex-shrink: 0; border-radius: 14px; background: #ef4444; color: #fff; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: #991b1b;">Belum Tepat</div>
                        <div style="font-size: 13px; color: #b91c1c;">${escapeHtml(ex.explanation || 'Periksa kembali struktur instruksi dan nilai yang diharapkan.')}</div>
                    </div>
                `;
                btnAction.className = 'btn-3d btn-red';
                btnAction.innerText = 'Mengerti & Lanjut';
            }

            isDrawerAnswerChecked = true;
        }

        function nextQuestion() {
            if (window.EduAudio) window.EduAudio.playTap();
            currentIndex++;
            renderCurrentQuestion();
        }

        async function submitCompletedLesson() {
            document.getElementById('progress-bar').style.width = '100%';

            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ answers: currentAnswers })
                });

                const result = await response.json();

                if (result.success) {
                    if (window.EduAudio) {
                        window.EduAudio.stopBgm();
                        window.EduAudio.playVictory();
                    }
                    if (window.EduMascot) {
                        window.EduMascot.react('victory', `GOKIL! Modul tuntas dengan Max Combo ${maxCombo}x!`);
                    }
                    confetti({
                        particleCount: 120,
                        spread: 80,
                        origin: { y: 0.6 }
                    });

                    document.getElementById('victory-xp').innerText = `+${result.data.xp_earned} XP`;
                    document.getElementById('victory-accuracy').innerText = `${result.data.score}%`;
                    const comboEl = document.getElementById('victory-combo');
                    if (comboEl) comboEl.innerText = `${maxCombo}x`;
                    document.getElementById('victory-modal').style.display = 'flex';
                } else {
                    alert(result.message || 'Gagal menyimpan kemajuan belajar.');
                    window.location.href = "{{ route('learn.index') }}";
                }
            } catch (err) {
                console.error(err);
                window.location.href = "{{ route('learn.index') }}";
            }
        }

        function escapeHtml(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        // ==========================================
        // 3D INTERACTIVE ENGINE (THREE.JS RUNTIME)
        // ==========================================
        let _threeState = {
            scene: null,
            camera: null,
            renderer: null,
            controls: null,
            animId: null,
            rootGroup: null,
            isAnimRunning: true,
            wireframe: false,
            materials: [],
            initialCamPos: { x: 5, y: 5, z: 7 }
        };

        function dispose3DScene() {
            if (_threeState.animId) {
                cancelAnimationFrame(_threeState.animId);
                _threeState.animId = null;
            }
            if (_threeState.controls) {
                _threeState.controls.dispose();
                _threeState.controls = null;
            }
            if (_threeState.renderer) {
                try {
                    _threeState.renderer.forceContextLoss();
                } catch (e) {}
                _threeState.renderer.dispose();
                if (_threeState.renderer.domElement && _threeState.renderer.domElement.parentElement) {
                    _threeState.renderer.domElement.parentElement.removeChild(_threeState.renderer.domElement);
                }
                _threeState.renderer = null;
            }
            _threeState.scene = null;
            _threeState.camera = null;
            _threeState.rootGroup = null;
            _threeState.materials = [];
        }

        function init3DScene(containerId, config) {
            dispose3DScene();

            const container = document.getElementById(containerId);
            if (!container || typeof THREE === 'undefined') return;

            const width = container.clientWidth || 600;
            const height = container.clientHeight || 320;

            // 1. Scene setup
            const scene = new THREE.Scene();
            scene.background = new THREE.Color(0x0f172a);
            scene.fog = new THREE.FogExp2(0x0f172a, 0.035);

            // 2. Camera setup
            const camX = (config.camera && config.camera.x) || 6;
            const camY = (config.camera && config.camera.y) || 5;
            const camZ = (config.camera && config.camera.z) || 7;
            _threeState.initialCamPos = { x: camX, y: camY, z: camZ };

            const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
            camera.position.set(camX, camY, camZ);

            // 3. Renderer setup
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.shadowMap.enabled = true;
            container.appendChild(renderer.domElement);

            // 4. Controls setup
            let controls = null;
            if (typeof THREE.OrbitControls !== 'undefined') {
                controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.06;
                controls.maxDistance = 25;
                controls.minDistance = 2.5;
            }

            // 5. Lights
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
            scene.add(ambientLight);

            const dirLight = new THREE.DirectionalLight(0xffffff, 0.9);
            dirLight.position.set(8, 12, 8);
            dirLight.castShadow = true;
            scene.add(dirLight);

            const pointLight = new THREE.PointLight(config.accent_color || 0x10b981, 1.2, 15);
            pointLight.position.set(-4, 4, -2);
            scene.add(pointLight);

            // 6. Helpers (Grid & Axis)
            if (config.show_grid !== false) {
                const grid = new THREE.GridHelper(10, 10, 0x3b82f6, 0x334155);
                grid.position.y = -1.5;
                scene.add(grid);

                const axes = new THREE.AxesHelper(3.5);
                axes.position.y = -1.49;
                scene.add(axes);
            }

            // 7. Object Generator based on Presets
            const rootGroup = new THREE.Group();
            scene.add(rootGroup);

            const preset = config.preset || 'matrix_grid';
            const baseColor = new THREE.Color(config.color || '#2563eb');
            const accentColor = new THREE.Color(config.accent_color || '#10b981');
            const wireframe = !!config.wireframe;
            _threeState.wireframe = wireframe;

            _build3DPreset(rootGroup, preset, baseColor, accentColor, wireframe, config);

            _threeState.scene = scene;
            _threeState.camera = camera;
            _threeState.renderer = renderer;
            _threeState.controls = controls;
            _threeState.rootGroup = rootGroup;
            _threeState.isAnimRunning = true;

            // 8. Animation Render Loop
            let clock = new THREE.Clock();

            function animate() {
                _threeState.animId = requestAnimationFrame(animate);

                const elapsedTime = clock.getElapsedTime();
                const speedMult = config.speed === 'slow' ? 0.5 : (config.speed === 'fast' ? 2.0 : 1.0);

                if (_threeState.controls) {
                    _threeState.controls.update();
                }

                if (_threeState.isAnimRunning && rootGroup) {
                    const animType = config.animation || 'rotate';
                    if (animType === 'rotate') {
                        rootGroup.rotation.y = elapsedTime * 0.35 * speedMult;
                    } else if (animType === 'pulse') {
                        const s = 1 + Math.sin(elapsedTime * 2.5 * speedMult) * 0.06;
                        const baseScale = config.scale || 1.0;
                        rootGroup.scale.set(s * baseScale, s * baseScale, s * baseScale);
                        rootGroup.rotation.y = elapsedTime * 0.2 * speedMult;
                    } else if (animType === 'hover') {
                        rootGroup.position.y = Math.sin(elapsedTime * 2 * speedMult) * 0.25;
                        rootGroup.rotation.y = elapsedTime * 0.25 * speedMult;
                    } else if (animType === 'orbit') {
                        rootGroup.rotation.y = elapsedTime * 0.5 * speedMult;
                        rootGroup.rotation.x = Math.sin(elapsedTime * 0.5 * speedMult) * 0.15;
                    }
                }

                renderer.render(scene, camera);
            }

            animate();

            // Apply custom scale if set
            if (config.scale && config.scale !== 1.0) {
                rootGroup.scale.set(config.scale, config.scale, config.scale);
            }

            // Resize listener
            const resizeHandler = () => {
                if (!container || !renderer || !camera) return;
                const newW = container.clientWidth;
                const newH = container.clientHeight;
                camera.aspect = newW / newH;
                camera.updateProjectionMatrix();
                renderer.setSize(newW, newH);
            };
            window.addEventListener('resize', resizeHandler);
        }

        function _build3DPreset(group, preset, baseColor, accentColor, wireframe, config = {}) {
            _threeState.materials = [];

            const isGlass = config.material === 'glass';
            const isGlow = config.material === 'glow';

            if (preset === 'matrix_grid') {
                // 3D Array Grid (Configurable N x N x N Matrix)
                const size = parseInt(config.matrix_size) || 3;
                const targetX = config.target_x !== undefined ? parseInt(config.target_x) : 1;
                const targetY = config.target_y !== undefined ? parseInt(config.target_y) : 0;
                const targetZ = config.target_z !== undefined ? parseInt(config.target_z) : 1;

                const cubeGeo = new THREE.BoxGeometry(0.7, 0.7, 0.7);
                const half = (size - 1) / 2;

                for (let x = 0; x < size; x++) {
                    for (let y = 0; y < size; y++) {
                        for (let z = 0; z < size; z++) {
                            const isTarget = (x === targetX && y === targetY && z === targetZ);
                            const mat = new THREE.MeshStandardMaterial({
                                color: isTarget ? accentColor : baseColor,
                                roughness: isGlass ? 0.1 : 0.2,
                                metalness: isGlass ? 0.1 : 0.5,
                                wireframe: wireframe,
                                transparent: true,
                                opacity: isTarget ? 1.0 : (isGlass ? 0.3 : 0.45),
                                emissive: isTarget ? accentColor : (isGlow ? baseColor : 0x000000),
                                emissiveIntensity: isTarget ? 0.5 : (isGlow ? 0.2 : 0.0)
                            });
                            _threeState.materials.push(mat);

                            const mesh = new THREE.Mesh(cubeGeo, mat);
                            mesh.position.set((x - half) * 1.0, (y - half) * 1.0, (z - half) * 1.0);
                            group.add(mesh);

                            const edgeGeo = new THREE.EdgesGeometry(cubeGeo);
                            const edgeMat = new THREE.LineBasicMaterial({ color: isTarget ? 0xffffff : 0x93c5fd });
                            const edgeLine = new THREE.LineSegments(edgeGeo, edgeMat);
                            mesh.add(edgeLine);
                        }
                    }
                }
            } else if (preset === 'robot_axis') {
                // Robotic Drone with XYZ Coordinate Vectors
                const bodyGeo = new THREE.CylinderGeometry(0.8, 1.0, 0.5, 8);
                const bodyMat = new THREE.MeshStandardMaterial({ color: baseColor, roughness: 0.3, metalness: 0.7, wireframe });
                _threeState.materials.push(bodyMat);
                const body = new THREE.Mesh(bodyGeo, bodyMat);
                group.add(body);

                // Arm pointing forward
                const armGeo = new THREE.BoxGeometry(0.2, 0.2, 1.6);
                const armMat = new THREE.MeshStandardMaterial({ color: 0x94a3b8, metalness: 0.8 });
                const arm = new THREE.Mesh(armGeo, armMat);
                arm.position.set(0, 0.2, 0.8);
                group.add(arm);

                // Target Waypoint Indicator
                const targetGeo = new THREE.SphereGeometry(0.35, 16, 16);
                const targetMat = new THREE.MeshStandardMaterial({ color: accentColor, emissive: accentColor, emissiveIntensity: 0.6, wireframe });
                _threeState.materials.push(targetMat);
                const target = new THREE.Mesh(targetGeo, targetMat);
                target.position.set(1.8, 1.2, 1.8);
                group.add(target);
            } else if (preset === 'binary_tree') {
                // 3D Hierarchical Tree Nodes
                const nodeGeo = new THREE.SphereGeometry(0.4, 20, 20);
                const positions = [
                    { pos: [0, 1.8, 0], isTarget: false },
                    { pos: [-1.4, 0.5, 0.5], isTarget: false },
                    { pos: [1.4, 0.5, -0.5], isTarget: true },
                    { pos: [-2.0, -0.8, 0.8], isTarget: false },
                    { pos: [-0.8, -0.8, 0.2], isTarget: false },
                    { pos: [0.8, -0.8, -0.2], isTarget: false },
                    { pos: [2.0, -0.8, -0.8], isTarget: false },
                ];

                positions.forEach(item => {
                    const mat = new THREE.MeshStandardMaterial({
                        color: item.isTarget ? accentColor : baseColor,
                        roughness: 0.2,
                        metalness: 0.4,
                        emissive: item.isTarget ? accentColor : 0x000000,
                        emissiveIntensity: item.isTarget ? 0.5 : 0.0,
                        wireframe
                    });
                    _threeState.materials.push(mat);

                    const mesh = new THREE.Mesh(nodeGeo, mat);
                    mesh.position.set(item.pos[0], item.pos[1], item.pos[2]);
                    group.add(mesh);
                });

                // Link Lines
                const linkPairs = [[0, 1], [0, 2], [1, 3], [1, 4], [2, 5], [2, 6]];
                linkPairs.forEach(([from, to]) => {
                    const p1 = new THREE.Vector3(...positions[from].pos);
                    const p2 = new THREE.Vector3(...positions[to].pos);
                    const lineGeo = new THREE.BufferGeometry().setFromPoints([p1, p2]);
                    const lineMat = new THREE.LineBasicMaterial({ color: 0x64748b, linewidth: 2 });
                    group.add(new THREE.Line(lineGeo, lineMat));
                });
            } else if (preset === 'memory_block') {
                // Vertical Stack of Memory Registers
                const slots = parseInt(config.memory_slots) || 4;
                const blockGeo = new THREE.BoxGeometry(2.4, 0.45, 1.4);
                const halfSlots = (slots - 1) / 2;

                for (let i = 0; i < slots; i++) {
                    const isTarget = (i === Math.floor(slots / 2));
                    const mat = new THREE.MeshStandardMaterial({
                        color: isTarget ? accentColor : baseColor,
                        roughness: 0.3,
                        metalness: 0.5,
                        emissive: isTarget ? accentColor : 0x000000,
                        emissiveIntensity: isTarget ? 0.4 : 0.0,
                        wireframe
                    });
                    _threeState.materials.push(mat);

                    const mesh = new THREE.Mesh(blockGeo, mat);
                    mesh.position.set(0, (i - halfSlots) * 0.65, 0);
                    group.add(mesh);

                    const edgeGeo = new THREE.EdgesGeometry(blockGeo);
                    const edgeLine = new THREE.LineSegments(edgeGeo, new THREE.LineBasicMaterial({ color: isTarget ? 0x10b981 : 0xffffff }));
                    mesh.add(edgeLine);
                }
            } else {
                // Rich Procedural Geometries (Cube, Sphere, Cylinder, Cone, Torus, Torus Knot, Pyramid, Capsule)
                let geo;
                if (preset === 'geometry_sphere') {
                    geo = new THREE.SphereGeometry(1.3, 32, 32);
                } else if (preset === 'geometry_cylinder') {
                    geo = new THREE.CylinderGeometry(1.0, 1.0, 2.0, 24);
                } else if (preset === 'geometry_cone') {
                    geo = new THREE.ConeGeometry(1.3, 2.4, 32);
                } else if (preset === 'geometry_torus') {
                    geo = new THREE.TorusGeometry(1.2, 0.4, 16, 40);
                } else if (preset === 'geometry_torus_knot') {
                    geo = new THREE.TorusKnotGeometry(0.9, 0.3, 80, 16);
                } else if (preset === 'geometry_pyramid') {
                    geo = new THREE.ConeGeometry(1.4, 2.2, 4);
                } else if (preset === 'geometry_capsule') {
                    geo = new THREE.CylinderGeometry(0.7, 0.7, 1.4, 20);
                } else {
                    geo = new THREE.BoxGeometry(1.8, 1.8, 1.8);
                }

                const mat = new THREE.MeshStandardMaterial({
                    color: baseColor,
                    roughness: isGlass ? 0.1 : 0.25,
                    metalness: isGlass ? 0.1 : 0.6,
                    wireframe,
                    transparent: isGlass,
                    opacity: isGlass ? 0.75 : 1.0,
                    emissive: isGlow ? baseColor : 0x000000,
                    emissiveIntensity: isGlow ? 0.3 : 0.0
                });
                _threeState.materials.push(mat);

                const mesh = new THREE.Mesh(geo, mat);
                group.add(mesh);

                if (preset === 'geometry_capsule') {
                    const sphereGeo = new THREE.SphereGeometry(0.7, 20, 20);
                    const topSphere = new THREE.Mesh(sphereGeo, mat);
                    topSphere.position.set(0, 0.7, 0);
                    const botSphere = new THREE.Mesh(sphereGeo, mat);
                    botSphere.position.set(0, -0.7, 0);
                    group.add(topSphere);
                    group.add(botSphere);
                }

                const edgeGeo = new THREE.EdgesGeometry(geo);
                const edgeLine = new THREE.LineSegments(edgeGeo, new THREE.LineBasicMaterial({ color: accentColor }));
                mesh.add(edgeLine);
            }
        }

        function toggle3DWireframe() {
            if (window.EduAudio) window.EduAudio.playTap();
            _threeState.wireframe = !_threeState.wireframe;
            _threeState.materials.forEach(m => {
                m.wireframe = _threeState.wireframe;
            });
        }

        function toggle3DAnimation() {
            if (window.EduAudio) window.EduAudio.playTap();
            _threeState.isAnimRunning = !_threeState.isAnimRunning;
        }

        function reset3DCamera() {
            if (window.EduAudio) window.EduAudio.playSelect();
            if (_threeState.camera && _threeState.controls) {
                _threeState.camera.position.set(_threeState.initialCamPos.x, _threeState.initialCamPos.y, _threeState.initialCamPos.z);
                _threeState.controls.target.set(0, 0, 0);
                _threeState.controls.update();
            }
        }
    </script>
</x-lesson-layout>
