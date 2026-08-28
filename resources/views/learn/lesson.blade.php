@php
    $title = $lesson->title . ' - Kodein';
@endphp

<x-lesson-layout :title="$title">
    <!-- Top Header -->
    <header class="lesson-header">
        <a href="{{ route('learn.index') }}" class="btn-close" title="Keluar">✕</a>
        
        <div class="progress-track">
            <div id="progressBar" class="progress-fill"></div>
        </div>

        <div class="heart-badge">
            <span>❤️</span>
            <span id="heartsCount">{{ $user->hearts }}</span>
        </div>
    </header>

    <!-- Main Quiz Arena -->
    <main class="quiz-arena" id="quizArena">
        <!-- Question Container rendered by JS -->
        <div id="questionCard"></div>
    </main>

    <!-- Bottom Action Drawer -->
    <footer id="actionDrawer" class="action-drawer">
        <div class="drawer-content">
            <div id="feedbackText" style="display: flex; align-items: center; gap: 16px;">
                <!-- Filled dynamically by JS -->
            </div>
            <button id="mainBtn" class="btn-3d btn-disabled" onclick="handleMainButtonClick()">
                PERIKSA
            </button>
        </div>
    </footer>

    <!-- Lesson Engine JavaScript -->
    <script>
        const lessonData = {
            id: {{ $lesson->id }},
            title: @json($lesson->title),
            xpReward: {{ $lesson->xp_reward }},
            exercises: @json($exercises),
            userHearts: {{ $user->hearts }},
            csrfToken: '{{ csrf_token() }}',
            submitUrl: '{{ route("learn.submit", $lesson->id) }}',
            roadmapUrl: '{{ route("learn.index") }}'
        };

        let currentIndex = 0;
        let userAnswers = []; // [{ exercise_id, answer }]
        let currentSelection = null;
        let isAnswerChecked = false;
        let isDrawerOpen = false;

        // Initialize first exercise
        document.addEventListener('DOMContentLoaded', () => {
            renderExercise();
        });

        function updateProgress() {
            const pct = (currentIndex / lessonData.exercises.length) * 100;
            document.getElementById('progressBar').style.width = pct + '%';
        }

        function renderExercise() {
            updateProgress();
            isAnswerChecked = false;
            currentSelection = null;
            resetDrawer();

            const container = document.getElementById('questionCard');
            const ex = lessonData.exercises[currentIndex];

            if (!ex) {
                submitAndCelebrate();
                return;
            }

            let html = `
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--duo-blue); letter-spacing: 1px; margin-bottom: 8px;">
                        TANTANGAN ${currentIndex + 1} DARI ${lessonData.exercises.length}
                    </div>
                    <h2 style="font-size: 24px; font-weight: 900; line-height: 1.3;">
                        ${ex.prompt}
                    </h2>
                </div>
            `;

            // Render depending on question type
            if (ex.question_type === 'fill_blank') {
                html += renderFillBlank(ex);
            } else if (ex.question_type === 'code_ordering') {
                html += renderCodeOrdering(ex);
            } else if (ex.question_type === 'output_prediction') {
                html += renderOutputPrediction(ex);
            } else if (ex.question_type === 'matching_pair') {
                html += renderMatchingPair(ex);
            } else {
                html += renderMultipleChoice(ex);
            }

            container.innerHTML = html;
        }

        /* 1. Fill In The Blank Question */
        function renderFillBlank(ex) {
            const options = Array.isArray(ex.options) ? ex.options : ['print', 'echo', 'input', 'write'];
            return `
                <div style="background: #131f24; border: 2px solid var(--duo-border); border-radius: 20px; padding: 24px; margin-bottom: 24px;">
                    <div class="code-font" style="font-size: 20px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span id="blankTarget" style="display: inline-block; min-width: 90px; height: 42px; border-bottom: 3px solid var(--duo-blue); background: #202f36; border-radius: 8px; padding: 6px 14px; text-align: center; color: #38bdf8; font-weight: 700;">____</span>
                        <span>("Halo Dunia")</span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    ${options.map(opt => `
                        <button type="button" class="btn-3d btn-blue option-chip" onclick="selectFillBlankChip(this, '${opt}')">
                            <span class="code-font">${opt}</span>
                        </button>
                    `).join('')}
                </div>
            `;
        }

        function selectFillBlankChip(btn, text) {
            window.SoundEngine.playTap();
            document.querySelectorAll('.option-chip').forEach(b => b.classList.remove('btn-green'));
            btn.classList.add('btn-green');
            document.getElementById('blankTarget').textContent = text;
            currentSelection = text;
            enableCheckButton();
        }

        /* 2. Parsons Problem (Code Ordering) */
        let orderedLines = [];
        function renderCodeOrdering(ex) {
            orderedLines = [];
            const rawOptions = Array.isArray(ex.options) ? ex.options : [];
            return `
                <div style="margin-bottom: 12px; font-size: 13px; color: #94a3b8; font-weight: 700;">
                    👇 Klik potongan kode di bawah untuk menyusunnya ke kotak atas:
                </div>

                <!-- Drop / Ordered Container -->
                <div id="orderedBox" style="min-height: 140px; background: #131f24; border: 2px dashed var(--duo-blue); border-radius: 20px; padding: 16px; margin-bottom: 20px; display: flex; flex-direction: column; gap: 10px;">
                    <div id="orderPlaceholder" style="color: #64748b; font-size: 14px; margin: auto; font-style: italic;">
                        Susunan kode akan muncul di sini...
                    </div>
                </div>

                <!-- Available Source Code Chips -->
                <div id="sourceBox" style="display: flex; flex-direction: column; gap: 10px;">
                    ${rawOptions.map(opt => `
                        <button type="button" id="opt-${opt.id}" class="btn-3d btn-blue code-font" style="justify-content: flex-start; padding: 12px 18px; font-size: 15px;" onclick="moveCodeBlock('${opt.id}', '${opt.text}')">
                            ${opt.text}
                        </button>
                    `).join('')}
                </div>
            `;
        }

        function moveCodeBlock(id, text) {
            window.SoundEngine.playTap();
            const sourceBtn = document.getElementById(`opt-${id}`);
            const placeholder = document.getElementById('orderPlaceholder');
            if (placeholder) placeholder.style.display = 'none';

            if (orderedLines.includes(id)) {
                // Remove from ordered
                orderedLines = orderedLines.filter(x => x !== id);
                document.getElementById(`ordered-${id}`)?.remove();
                sourceBtn.style.opacity = '1';
                sourceBtn.style.pointerEvents = 'auto';
            } else {
                // Add to ordered
                orderedLines.push(id);
                sourceBtn.style.opacity = '0.3';
                sourceBtn.style.pointerEvents = 'none';

                const chip = document.createElement('button');
                chip.type = 'button';
                chip.id = `ordered-${id}`;
                chip.className = 'btn-3d btn-green code-font';
                chip.style.cssText = 'justify-content: flex-start; padding: 12px 18px; font-size: 15px; width: 100%;';
                chip.innerHTML = `${text} <span style="margin-left: auto; font-size: 12px;">✕</span>`;
                chip.onclick = () => moveCodeBlock(id, text);
                document.getElementById('orderedBox').appendChild(chip);
            }

            if (orderedLines.length === lessonData.exercises[currentIndex].options.length) {
                currentSelection = orderedLines;
                enableCheckButton();
            } else {
                currentSelection = null;
                disableCheckButton();
            }
        }

        /* 3. Output Prediction */
        function renderOutputPrediction(ex) {
            const options = Array.isArray(ex.options) ? ex.options : ['Output 1', 'Output 2', 'Output 3', 'Output 4'];
            return `
                ${ex.code_snippet ? `
                    <div style="background: #131f24; border: 2px solid var(--duo-border); border-radius: 20px; padding: 20px; margin-bottom: 24px;">
                        <pre class="code-font" style="color: #38bdf8; font-size: 16px; margin: 0; line-height: 1.6;">${ex.code_snippet}</pre>
                    </div>
                ` : ''}

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    ${options.map((opt, i) => `
                        <button type="button" class="btn-3d btn-outline option-choice" onclick="selectChoice(this, '${opt}')">
                            <span style="font-size: 16px; font-weight: 800;">${opt}</span>
                        </button>
                    `).join('')}
                </div>
            `;
        }

        /* 4. Multiple Choice */
        function renderMultipleChoice(ex) {
            const options = Array.isArray(ex.options) ? ex.options : ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D'];
            return `
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    ${options.map((opt, i) => `
                        <button type="button" class="btn-3d btn-outline option-choice" style="justify-content: flex-start; padding: 16px 20px;" onclick="selectChoice(this, '${opt}')">
                            <span style="width: 32px; height: 32px; border-radius: 10px; background: #202f36; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 900; margin-right: 12px;">${i + 1}</span>
                            <span style="font-size: 16px; font-weight: 800;">${opt}</span>
                        </button>
                    `).join('')}
                </div>
            `;
        }

        function selectChoice(btn, val) {
            window.SoundEngine.playTap();
            document.querySelectorAll('.option-choice').forEach(b => {
                b.className = 'btn-3d btn-outline option-choice';
            });
            btn.className = 'btn-3d btn-blue option-choice';
            currentSelection = val;
            enableCheckButton();
        }

        /* 5. Matching Pair */
        let matchSelectedLeft = null;
        let matchedPairs = {};
        function renderMatchingPair(ex) {
            matchedPairs = {};
            matchSelectedLeft = null;
            const pairs = ex.options?.pairs || { 'int': '17', 'str': '"Belajar"', 'bool': 'True', 'float': '3.14' };
            const leftKeys = Object.keys(pairs);
            const rightVals = Object.values(pairs).sort(() => Math.random() - 0.5);

            return `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        ${leftKeys.map(k => `
                            <button type="button" id="match-left-${k}" class="btn-3d btn-outline match-left-btn code-font" onclick="selectMatchLeft('${k}')">
                                ${k}
                            </button>
                        `).join('')}
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        ${rightVals.map(v => `
                            <button type="button" id="match-right-${btoa(v)}" class="btn-3d btn-outline match-right-btn code-font" onclick="selectMatchRight('${v}')">
                                ${v}
                            </button>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        function selectMatchLeft(k) {
            window.SoundEngine.playTap();
            document.querySelectorAll('.match-left-btn').forEach(b => {
                if (!b.classList.contains('btn-green')) b.className = 'btn-3d btn-outline match-left-btn code-font';
            });
            const btn = document.getElementById(`match-left-${k}`);
            if (!btn.classList.contains('btn-green')) {
                btn.className = 'btn-3d btn-blue match-left-btn code-font';
                matchSelectedLeft = k;
            }
        }

        function selectMatchRight(v) {
            if (!matchSelectedLeft) return;
            window.SoundEngine.playTap();

            matchedPairs[matchSelectedLeft] = v;
            
            const leftBtn = document.getElementById(`match-left-${matchSelectedLeft}`);
            const rightBtn = document.getElementById(`match-right-${btoa(v)}`);

            leftBtn.className = 'btn-3d btn-green match-left-btn code-font';
            rightBtn.className = 'btn-3d btn-green match-right-btn code-font';
            leftBtn.disabled = true;
            rightBtn.disabled = true;

            matchSelectedLeft = null;

            const totalKeys = Object.keys(lessonData.exercises[currentIndex].options?.pairs || {}).length;
            if (Object.keys(matchedPairs).length >= totalKeys) {
                currentSelection = matchedPairs;
                enableCheckButton();
            }
        }

        /* Drawer & Evaluation Logic */
        function enableCheckButton() {
            const btn = document.getElementById('mainBtn');
            btn.className = 'btn-3d btn-green';
        }

        function disableCheckButton() {
            const btn = document.getElementById('mainBtn');
            btn.className = 'btn-3d btn-disabled';
        }

        function resetDrawer() {
            const drawer = document.getElementById('actionDrawer');
            drawer.className = 'action-drawer';
            document.getElementById('feedbackText').innerHTML = '';
            const btn = document.getElementById('mainBtn');
            btn.className = 'btn-3d btn-disabled';
            btn.textContent = 'PERIKSA';
        }

        function handleMainButtonClick() {
            if (!isAnswerChecked) {
                // Check answer
                checkCurrentAnswer();
            } else {
                // Move to next
                currentIndex++;
                renderExercise();
            }
        }

        function checkCurrentAnswer() {
            if (!currentSelection) return;

            const currentEx = lessonData.exercises[currentIndex];
            userAnswers.push({
                exercise_id: currentEx.id,
                answer: currentSelection
            });

            isAnswerChecked = true;
            const drawer = document.getElementById('actionDrawer');
            const feedback = document.getElementById('feedbackText');
            const mainBtn = document.getElementById('mainBtn');

            // Play correct sound
            window.SoundEngine.playCorrect();
            drawer.className = 'action-drawer correct-state';
            feedback.innerHTML = `
                <div style="font-size: 36px;">🎉</div>
                <div>
                    <div style="font-size: 20px; font-weight: 900; color: #86efac;">Luar Biasa!</div>
                    <div style="font-size: 13px; color: #d7ffb8;">Jawabanmu tepat sekali! +${lessonData.xpReward} XP</div>
                </div>
            `;
            mainBtn.className = 'btn-3d btn-green';
            mainBtn.textContent = 'LANJUTKAN';
        }

        /* Final Submit & Victory Fanfare */
        async function submitAndCelebrate() {
            document.getElementById('progressBar').style.width = '100%';
            window.SoundEngine.playVictory();

            // Fire confetti burst!
            if (window.confetti) {
                confetti({ particleCount: 120, spread: 80, origin: { y: 0.6 } });
            }

            const arena = document.getElementById('quizArena');
            arena.innerHTML = `
                <div style="text-align: center; padding: 40px 20px;">
                    <div style="font-size: 84px; margin-bottom: 16px;" class="animate-float">🏆</div>
                    <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 8px;">Pelajaran Selesai!</h1>
                    <p style="color: #94a3b8; font-size: 16px; margin-bottom: 32px;">Kamu menyelesaikan tantangan pemrograman dengan luar biasa!</p>

                    <div style="display: inline-flex; gap: 20px; background: #131f24; border: 2px solid var(--duo-border); border-radius: 24px; padding: 20px 32px; margin-bottom: 36px;">
                        <div>
                            <div style="font-size: 12px; font-weight: 800; color: var(--duo-gold); text-transform: uppercase;">Total XP</div>
                            <div style="font-size: 28px; font-weight: 900; color: var(--duo-gold);">+${lessonData.xpReward} XP</div>
                        </div>
                        <div style="width: 1px; background: var(--duo-border);"></div>
                        <div>
                            <div style="font-size: 12px; font-weight: 800; color: var(--duo-green); text-transform: uppercase;">Akurasi</div>
                            <div style="font-size: 28px; font-weight: 900; color: var(--duo-green);">100%</div>
                        </div>
                    </div>

                    <div>
                        <a href="${lessonData.roadmapUrl}" class="btn-3d btn-green" style="padding: 16px 40px; font-size: 17px;">
                            KEMBALI KE ROADMAP 🚀
                        </a>
                    </div>
                </div>
            `;

            document.getElementById('actionDrawer').style.display = 'none';

            // Send async result to backend
            try {
                await fetch(lessonData.submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': lessonData.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ answers: userAnswers })
                });
            } catch (err) {
                console.error('Submit error', err);
            }
        }
    </script>
</x-lesson-layout>
