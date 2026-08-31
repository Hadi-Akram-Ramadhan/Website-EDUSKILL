@php
    $title = 'Roadmap Belajar - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        .mobile-hud-bar {
            display: none;
        }

        .unit-section-container {
            margin-bottom: 48px;
        }

        .roadmap-path-wrapper {
            position: relative;
            padding: 32px 0;
        }

        .roadmap-svg-connector {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .roadmap-node-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s ease;
            z-index: 2;
        }

        .node-circle {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.15s ease, filter 0.15s ease;
        }

        .node-circle:hover {
            transform: scale(1.08);
        }

        .node-circle:active {
            transform: scale(0.96) translateY(4px);
        }

        @media (max-width: 768px) {
            .mobile-hud-bar {
                display: flex;
                align-items: center;
                justify-content: space-around;
                background: #ffffff;
                border: 2px solid var(--border-color);
                border-radius: 18px;
                padding: 12px 16px;
                margin-bottom: 20px;
                box-shadow: 0 4px 0 #e2e8f0;
            }

            .unit-banner {
                padding: 18px 16px !important;
                border-radius: 20px !important;
                margin-bottom: 24px !important;
            }

            .unit-title {
                font-size: 16px !important;
            }

            .roadmap-node-container {
                transform: translateX(calc(var(--offset) * 0.5)) !important;
            }
        }
    </style>

    <div class="content-container">
        
        <!-- Left Column: Snake / Zigzag Learning Roadmap -->
        <div style="width: 100%;">
            
            <!-- Mobile Sticky Top HUD Bar -->
            <div class="mobile-hud-bar">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <div style="color: var(--accent-orange);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    </div>
                    <span style="font-size: 15px; font-weight: 900; color: var(--accent-orange);">{{ $user->streak_count }}</span>
                </div>

                <div style="display: flex; align-items: center; gap: 6px;">
                    <div style="color: var(--primary-blue);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                    </div>
                    <span style="font-size: 15px; font-weight: 900; color: var(--primary-blue);">{{ $user->gems }}</span>
                </div>

                <div style="display: flex; align-items: center; gap: 6px;">
                    <div style="color: var(--accent-red);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    </div>
                    <span style="font-size: 15px; font-weight: 900; color: var(--accent-red);">{{ $user->hearts }}/5</span>
                </div>
            </div>

            <!-- Top Course Switcher Bar (Consistent Structured Layout) -->
            <div class="card-3d" style="padding: 16px 20px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px; min-width: 240px; flex: 1;">
                        <div style="width: 40px; height: 40px; min-width: 40px; min-height: 40px; border-radius: 12px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1.5px solid #bfdbfe;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Topik Kursus Aktif</div>
                            <div style="font-size: 16px; font-weight: 900; color: #0f172a; line-height: 1.2;">{{ $course->title ?? 'Pilih Kursus' }}</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        @foreach ($allCourses as $c)
                            <a href="{{ route('learn.index', ['course' => $c->id]) }}" 
                               class="btn-3d {{ ($course && $course->id === $c->id) ? 'btn-blue' : 'btn-outline' }}" 
                               style="padding: 8px 16px; font-size: 12px; border-radius: 12px; text-transform: none; display: inline-flex; align-items: center; gap: 6px;">
                                @if ($course && $course->id === $c->id)
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                @endif
                                {{ $c->category }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 0 #a7f3d0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #991b1b; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 0 #fecaca;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @foreach ($units as $unitIndex => $unit)
                <div class="unit-section-container">
                    <!-- Clean Unified Royal Blue Unit Header Banner -->
                    <div class="unit-banner" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 24px; padding: 24px; margin-bottom: 28px; box-shadow: 0 6px 0 #1e40af, 0 10px 25px -5px rgba(37, 99, 235, 0.2); position: relative; overflow: hidden;">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; position: relative; z-index: 2;">
                            <div>
                                <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: #bfdbfe; letter-spacing: 0.8px;">
                                    {{ $unit['title'] }}
                                </div>
                                <h2 class="unit-title" style="font-size: 19px; font-weight: 900; color: #fff; margin-top: 4px; line-height: 1.3;">
                                    {{ $unit['description'] ?? 'Pelajari konsep dasar algoritma' }}
                                </h2>
                            </div>
                            <div style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; background: rgba(255, 255, 255, 0.18); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Clean Continuous Roadmap Nodes with Dynamic Connecting Line -->
                    <div class="roadmap-path-wrapper">
                        <svg class="roadmap-svg-connector" id="svg-unit-{{ $unitIndex }}"></svg>

                        <div style="display: flex; flex-direction: column; align-items: center; gap: 42px; position: relative; z-index: 2;">
                            @php
                                $offsets = [0, 52, 0, -52];
                            @endphp

                            @foreach ($unit['lessons'] as $lessonIndex => $lesson)
                                @php
                                    $offset = $offsets[$lessonIndex % count($offsets)];
                                @endphp

                                <div class="roadmap-node-container" style="--offset: {{ $offset }}px; transform: translateX({{ $offset }}px);">
                                    
                                    <div class="node-btn-wrapper" data-completed="{{ $lesson['is_completed'] ? 'true' : 'false' }}" data-unlocked="{{ $lesson['is_unlocked'] ? 'true' : 'false' }}">
                                        @if ($lesson['is_unlocked'])
                                            <a href="{{ route('learn.lesson', $lesson['id']) }}" 
                                               style="text-decoration: none; position: relative; display: inline-block;">
                                                
                                                @if ($lesson['is_current'])
                                                    <!-- Floating Start Tooltip -->
                                                    <div style="position: absolute; top: -38px; left: 50%; transform: translateX(-50%); background: #2563eb; color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; padding: 6px 14px; border-radius: 12px; box-shadow: 0 4px 0 #1e40af; white-space: nowrap; z-index: 10;" class="animate-float">
                                                        Mulai +{{ $lesson['xp_reward'] }} XP
                                                        <div style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid #2563eb;"></div>
                                                    </div>
                                                @endif

                                                <!-- Circular Node Button -->
                                                <div class="node-circle btn-3d {{ $lesson['is_completed'] ? 'btn-green' : ($lesson['is_current'] ? 'btn-blue pulse-active-node' : 'btn-blue') }}">
                                                    @if ($lesson['is_completed'])
                                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    @elseif ($lesson['is_current'])
                                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    @else
                                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            <!-- Locked Node Button -->
                                            <div class="node-circle btn-gray" style="cursor: not-allowed;">
                                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div style="font-size: 13px; font-weight: 800; color: {{ $lesson['is_unlocked'] ? '#0f172a' : '#94a3b8' }}; margin-top: 10px; text-align: center; max-width: 160px; line-height: 1.3;">
                                        {{ $lesson['title'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Right Column: Clean Gamification HUD Widgets -->
        <div style="display: flex; flex-direction: column; gap: 20px; width: 100%;">
            
            <!-- Top Stats Bar (Clean 3-Box Style) -->
            <div class="card-3d" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <!-- Streak -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="color: var(--accent-orange);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size: 17px; font-weight: 900; color: var(--accent-orange);">{{ $user->streak_count }}</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Streak</div>
                    </div>
                </div>

                <!-- Gems -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="color: var(--primary-blue);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                    </div>
                    <div>
                        <div style="font-size: 17px; font-weight: 900; color: var(--primary-blue);">{{ $user->gems }}</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Gems</div>
                    </div>
                </div>

                <!-- Hearts -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="color: var(--accent-red);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size: 17px; font-weight: 900; color: var(--accent-red);">{{ $user->hearts }}/5</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Nyawa</div>
                    </div>
                </div>
            </div>

            <!-- Hearts Refill Card (If not full) -->
            @if ($user->hearts < 5)
                <div class="card-3d" style="padding: 20px; border-color: #fca5a5; background: #fef2f2;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div style="color: var(--accent-red);">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                        </div>
                        <div>
                            <div style="font-size: 14px; font-weight: 900; color: #991b1b;">Nyawa Berkurang</div>
                            <div style="font-size: 12px; color: #7f1d1d;">Isi penuh sekarang dengan 20 gems agar bisa lanjut belajar.</div>
                        </div>
                    </div>
                    <form action="{{ route('learn.refill-hearts') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-3d btn-blue" style="width: 100%; padding: 10px; font-size: 13px;">
                            Isi Penuh (20 Gems)
                        </button>
                    </form>
                </div>
            @endif

            <!-- Daily Quests Widget -->
            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 900;">Misi Harian</h3>
                    </div>
                    <span style="font-size: 10px; font-weight: 800; color: var(--primary-blue); background: var(--primary-blue-light); padding: 3px 8px; border-radius: 6px;">RESET 24 JAM</span>
                </div>

                <!-- Quest 1 -->
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Dapatkan 30 XP</span>
                        <span style="color: var(--primary-blue);">{{ min(30, $user->xp) }}/30 XP</span>
                    </div>
                    <div style="height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: {{ min(100, ($user->xp / 30) * 100) }}%; background: var(--primary-blue); border-radius: 9999px;"></div>
                    </div>
                </div>

                <!-- Quest 2 -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Selesaikan 1 Modul</span>
                        <span style="color: var(--accent-green);">1/1</span>
                    </div>
                    <div style="height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: 100%; background: var(--accent-green); border-radius: 9999px;"></div>
                    </div>
                </div>
            </div>

            <!-- Top 3 Leaderboard Preview -->
            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 900;">Peringkat Teratas</h3>
                    </div>
                    <a href="{{ route('leaderboard.web') }}" style="font-size: 11px; font-weight: 800; color: var(--primary-blue); text-decoration: none;">LIHAT SEMUA</a>
                </div>

                @foreach ($topStudents as $rank => $student)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: {{ $loop->last ? 'none' : '1px solid #f1f5f9' }};">
                        <div style="font-size: 13px; font-weight: 900; width: 22px; height: 22px; border-radius: 6px; background: {{ $rank == 0 ? '#eff6ff' : '#f8fafc' }}; color: {{ $rank == 0 ? 'var(--primary-blue)' : '#64748b' }}; display: flex; align-items: center; justify-content: center;">
                            {{ $rank + 1 }}
                        </div>
                        <img src="{{ $student->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->id }}" style="width: 34px; height: 34px; border-radius: 50%; background: #f1f5f9; border: 1.5px solid #e2e8f0;" alt="">
                        <div style="flex: 1; overflow: hidden;">
                            <div style="font-size: 13px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $student->name }}</div>
                            <div style="font-size: 11px; color: #64748b; font-weight: 700;">{{ $student->xp }} XP</div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

    <!-- Script to render smooth SVG connecting paths between consecutive roadmap nodes -->
    <script>
        function drawRoadmapConnectors() {
            document.querySelectorAll('.roadmap-path-wrapper').forEach(unit => {
                const svg = unit.querySelector('.roadmap-svg-connector');
                const nodeContainers = unit.querySelectorAll('.node-btn-wrapper');
                if (!svg || nodeContainers.length < 2) return;

                const unitRect = unit.getBoundingClientRect();
                svg.setAttribute('viewBox', `0 0 ${unitRect.width} ${unitRect.height}`);

                let svgContent = '';

                for (let i = 0; i < nodeContainers.length - 1; i++) {
                    const nodeA = nodeContainers[i];
                    const nodeB = nodeContainers[i + 1];

                    const rectA = nodeA.getBoundingClientRect();
                    const rectB = nodeB.getBoundingClientRect();

                    const x1 = (rectA.left + rectA.right) / 2 - unitRect.left;
                    const y1 = (rectA.top + rectA.bottom) / 2 - unitRect.top;
                    const x2 = (rectB.left + rectB.right) / 2 - unitRect.left;
                    const y2 = (rectB.top + rectB.bottom) / 2 - unitRect.top;

                    const isCompleted = nodeA.getAttribute('data-completed') === 'true' && nodeB.getAttribute('data-unlocked') === 'true';
                    const strokeColor = isCompleted ? '#10b981' : '#cbd5e1';

                    // Smooth Bezier Curve connecting Node A to Node B
                    const cy1 = y1 + (y2 - y1) * 0.5;
                    const cy2 = y1 + (y2 - y1) * 0.5;

                    svgContent += `
                        <path d="M ${x1} ${y1} C ${x1} ${cy1}, ${x2} ${cy2}, ${x2} ${y2}" 
                              stroke="${strokeColor}" 
                              stroke-width="10" 
                              stroke-linecap="round" 
                              stroke-dasharray="${isCompleted ? 'none' : '10 10'}" 
                              fill="none" 
                              opacity="0.9" />
                    `;
                }

                svg.innerHTML = svgContent;
            });
        }

        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(drawRoadmapConnectors, 100);
        });
        window.addEventListener('resize', drawRoadmapConnectors);
    </script>
</x-app-layout>
