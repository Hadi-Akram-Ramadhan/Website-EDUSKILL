@php
    $title = 'Kuis: ' . $lesson->title . ' - Kodein';
@endphp

<x-lesson-layout :title="$title">
    <div id="quiz-container" style="display: flex; flex-direction: column; min-height: 100vh;">
        
        <!-- Header Progress & Lives Bar -->
        <header class="lesson-header">
            <a href="{{ route('learn.index') }}" class="btn-close" title="Keluar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </a>

            <div class="progress-track">
                <div id="progress-bar" class="progress-fill"></div>
            </div>

            <div class="heart-badge">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                <span id="hearts-counter">{{ $user->hearts }}</span>
            </div>
        </header>

        <!-- Main Question Slide Arena -->
        <main class="quiz-arena">
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
        <div style="width: 90px; height: 90px; background: #eff6ff; border-radius: 28px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); margin-bottom: 24px; box-shadow: 0 4px 0 #bfdbfe;" class="animate-float">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
        <h1 style="font-size: 32px; font-weight: 900; color: #0f172a; margin-bottom: 8px;">Pelajaran Selesai!</h1>
        <p style="color: #64748b; font-size: 16px; max-width: 440px; margin-bottom: 32px;">Kamu berhasil menyelesaikan semua latihan kode dengan pemahaman yang baik.</p>

        <div style="display: flex; gap: 20px; margin-bottom: 36px;">
            <div class="card-3d" style="padding: 20px 28px; text-align: center; border-color: #bfdbfe;">
                <div style="font-size: 11px; font-weight: 800; color: var(--primary-blue); text-transform: uppercase;">Total XP</div>
                <div id="victory-xp" style="font-size: 26px; font-weight: 900; color: var(--primary-blue);">+{{ $lesson->xp_reward }}</div>
            </div>
            <div class="card-3d" style="padding: 20px 28px; text-align: center; border-color: #a7f3d0;">
                <div style="font-size: 11px; font-weight: 800; color: #059669; text-transform: uppercase;">Akurasi</div>
                <div id="victory-accuracy" style="font-size: 26px; font-weight: 900; color: #059669;">100%</div>
            </div>
        </div>

        <a href="{{ route('learn.index') }}" class="btn-3d btn-blue" style="font-size: 16px; padding: 16px 48px;">
            Lanjutkan ke Roadmap
        </a>
    </div>

    <!-- Quiz Engine Script -->
    <script>
        const exercises = @json($exercises);
        const lessonId = {{ $lesson->id }};
        const submitUrl = "{{ route('learn.submit', $lesson->id) }}";
        const csrfToken = "{{ csrf_token() }}";

        let currentIndex = 0;
        let currentAnswers = []; // Store {exercise_id, answer}
        let selectedAnswer = null;
        let currentHearts = {{ $user->hearts }};
        let isDrawerAnswerChecked = false;

        document.addEventListener('DOMContentLoaded', () => {
            renderCurrentQuestion();
        });

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
                        <pre class="code-font" style="font-size: 15px; color: #1e293b; line-height: 1.6; overflow-x: auto;"><code>${escapeHtml(ex.code_snippet)}</code></pre>
                    </div>
                `;
            }

            // Question Type Rendering
            if (ex.question_type === 'fill_blank' || ex.question_type === 'multiple_choice' || ex.question_type === 'output_prediction') {
                html += `<div style="display: grid; grid-template-columns: 1fr; gap: 12px;">`;
                (ex.options_json || []).forEach(opt => {
                    const optText = typeof opt === 'object' ? (opt.text || JSON.stringify(opt)) : opt;
                    html += `
                        <button type="button" class="btn-3d btn-outline opt-chip" 
                                onclick="selectSingleOption('${escapeJs(optText)}', this)" 
                                style="justify-content: flex-start; text-align: left; text-transform: none; font-size: 15px; padding: 16px 20px;">
                            ${escapeHtml(optText)}
                        </button>
                    `;
                });
                html += `</div>`;
            } 
            else if (ex.question_type === 'code_ordering') {
                html += `
                    <div style="margin-bottom: 16px; font-size: 13px; font-weight: 700; color: #64748b;">
                        Ketuk baris kode di bawah untuk menyusun urutan yang benar:
                    </div>
                    <div id="ordering-bucket" style="min-height: 80px; background: #ffffff; border: 2px dashed #94a3b8; border-radius: 18px; padding: 14px; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                    </div>
                    <div id="ordering-pool" style="display: flex; flex-direction: column; gap: 10px;">
                `;
                (ex.options_json || []).forEach(item => {
                    html += `
                        <button type="button" class="btn-3d btn-outline ordering-chip code-font" 
                                data-id="${item.id}"
                                onclick="moveOrderingChip(this)" 
                                style="justify-content: flex-start; text-align: left; text-transform: none; font-size: 14px; padding: 14px 18px;">
                            ${escapeHtml(item.text)}
                        </button>
                    `;
                });
                html += `</div>`;
            }
            else if (ex.question_type === 'matching_pair') {
                const pairs = (ex.options_json && ex.options_json.pairs) ? ex.options_json.pairs : {};
                const leftKeys = Object.keys(pairs);
                const rightVals = Object.values(pairs).sort(() => Math.random() - 0.5);

                html += `
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            ${leftKeys.map(k => `
                                <button type="button" class="btn-3d btn-outline match-left code-font" data-key="${escapeJs(k)}" onclick="selectMatchPair('left', '${escapeJs(k)}', this)" style="text-transform: none;">
                                    ${escapeHtml(k)}
                                </button>
                            `).join('')}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            ${rightVals.map(v => `
                                <button type="button" class="btn-3d btn-outline match-right code-font" data-val="${escapeJs(v)}" onclick="selectMatchPair('right', '${escapeJs(v)}', this)" style="text-transform: none;">
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

            card.innerHTML = html;
        }

        // Single Choice / Fill Blank Selection
        function selectSingleOption(val, btn) {
            window.SoundEngine.playTap();
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
            window.SoundEngine.playTap();
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

        // Matching Pairs Logic
        function selectMatchPair(side, val, btn) {
            window.SoundEngine.playTap();
            if (side === 'left') {
                document.querySelectorAll('.match-left').forEach(b => b.style.background = '#ffffff');
                btn.style.background = '#eff6ff';
                window._currentMatchLeft = { val, btn };
            } else {
                document.querySelectorAll('.match-right').forEach(b => b.style.background = '#ffffff');
                btn.style.background = '#eff6ff';
                window._currentMatchRight = { val, btn };
            }

            if (window._currentMatchLeft && window._currentMatchRight) {
                window._matchedPairs[window._currentMatchLeft.val] = window._currentMatchRight.val;
                window._currentMatchLeft.btn.style.background = '#ecfdf5';
                window._currentMatchLeft.btn.style.borderColor = '#10b981';
                window._currentMatchRight.btn.style.background = '#ecfdf5';
                window._currentMatchRight.btn.style.borderColor = '#10b981';

                window._currentMatchLeft = null;
                window._currentMatchRight = null;
                selectedAnswer = window._matchedPairs;
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

            // Client-side quick validation for sound & feedback
            if (ex.question_type === 'code_ordering') {
                const target = Array.isArray(ex.answer_json) ? ex.answer_json : JSON.parse(ex.answer_json);
                isCorrect = JSON.stringify(selectedAnswer) === JSON.stringify(target);
            } else if (ex.question_type === 'matching_pair') {
                const target = typeof ex.answer_json === 'object' ? ex.answer_json : JSON.parse(ex.answer_json);
                isCorrect = JSON.stringify(selectedAnswer) === JSON.stringify(target);
            } else {
                isCorrect = String(selectedAnswer).trim().toLowerCase() === String(ex.answer_json).trim().toLowerCase();
            }

            currentAnswers.push({
                exercise_id: ex.id,
                answer: selectedAnswer
            });

            const drawer = document.getElementById('action-drawer');
            const feedback = document.getElementById('feedback-message');
            const btnAction = document.getElementById('btn-action');

            if (isCorrect) {
                window.SoundEngine.playCorrect();
                drawer.className = 'action-drawer correct-state';
                feedback.innerHTML = `
                    <div style="width: 44px; height: 44px; border-radius: 14px; background: #10b981; color: #fff; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: #065f46;">Luar Biasa, Tepat Sekali!</div>
                        <div style="font-size: 13px; color: #047857;">${escapeHtml(ex.explanation || 'Jawaban kamu sesuai dengan sintaks yang benar.')}</div>
                    </div>
                `;
                btnAction.className = 'btn-3d btn-green';
                btnAction.innerText = 'Lanjutkan';
            } else {
                window.SoundEngine.playWrong();
                currentHearts = Math.max(0, currentHearts - 1);
                document.getElementById('hearts-counter').innerText = currentHearts;

                drawer.className = 'action-drawer wrong-state';
                feedback.innerHTML = `
                    <div style="width: 44px; height: 44px; border-radius: 14px; background: #ef4444; color: #fff; display: flex; align-items: center; justify-content: center;">
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
                    window.SoundEngine.playVictory();
                    confetti({
                        particleCount: 100,
                        spread: 70,
                        origin: { y: 0.6 }
                    });

                    document.getElementById('victory-xp').innerText = `+${result.data.xp_earned} XP`;
                    document.getElementById('victory-accuracy').innerText = `${result.data.score}%`;
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
        function escapeJs(str) {
            return String(str).replace(/'/g, "\\'");
        }
    </script>
</x-lesson-layout>
