@php
    $title = 'Roadmap Belajar - EduSkill';
    $userXp = $user->xp ?? 0;

    if ($userXp >= 3000) {
        $tierName = 'Cyber Master';
        $tierColor = '#9333ea';
        $tierBg = '#faf5ff';
        $tierBorder = '#d8b4fe';
        $tierProgress = 100;
        $tierDesc = 'Puncak Tertinggi Developer';
    } elseif ($userXp >= 1500) {
        $tierName = 'Diamond Hacker';
        $tierColor = '#0284c7';
        $tierBg = '#f0f9ff';
        $tierBorder = '#7dd3fc';
        $tierProgress = min(100, (int) round((($userXp - 1500) / 1500) * 100));
        $tierDesc = (3000 - $userXp) . ' XP menuju Cyber Master';
    } elseif ($userXp >= 700) {
        $tierName = 'Platinum Architect';
        $tierColor = '#0d9488';
        $tierBg = '#f0fdfa';
        $tierBorder = '#5eead4';
        $tierProgress = min(100, (int) round((($userXp - 700) / 800) * 100));
        $tierDesc = (1500 - $userXp) . ' XP menuju Diamond Hacker';
    } elseif ($userXp >= 300) {
        $tierName = 'Gold Engineer';
        $tierColor = '#d97706';
        $tierBg = '#fffbeb';
        $tierBorder = '#fde68a';
        $tierProgress = min(100, (int) round((($userXp - 300) / 400) * 100));
        $tierDesc = (700 - $userXp) . ' XP menuju Platinum Architect';
    } elseif ($userXp >= 100) {
        $tierName = 'Silver Coder';
        $tierColor = '#475569';
        $tierBg = '#f8fafc';
        $tierBorder = '#cbd5e1';
        $tierProgress = min(100, (int) round((($userXp - 100) / 200) * 100));
        $tierDesc = (300 - $userXp) . ' XP menuju Gold Engineer';
    } else {
        $tierName = 'Bronze Explorer';
        $tierColor = '#b45309';
        $tierBg = '#fdf4ff';
        $tierBorder = '#fed7aa';
        $tierProgress = min(100, (int) round(($userXp / 100) * 100));
        $tierDesc = (100 - $userXp) . ' XP menuju Silver Coder';
    }
@endphp

<x-app-layout :title="$title">
    <style>
        .mobile-hud-bar {
            display: none;
        }

        .unit-section-container {
            margin-bottom: 64px;
        }

        .roadmap-path-wrapper {
            position: relative;
            padding: 36px 0;
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
            position: relative;
        }

        .node-circle:hover {
            transform: scale(1.08);
        }

        .node-circle:active {
            transform: scale(0.96) translateY(4px);
        }

        /* Distinct Mini Project Capstone Node Styling */
        .project-node {
            width: 84px !important;
            height: 84px !important;
            border-radius: 26px !important;
        }

        .project-node.btn-purple {
            background: linear-gradient(135deg, #9333ea, #7e22ce) !important;
            border: 3px solid #d8b4fe !important;
            box-shadow: 0 6px 0 #581c87 !important;
        }

        .project-node.btn-green {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            border: 3px solid #a7f3d0 !important;
            box-shadow: 0 6px 0 #047857 !important;
        }

        .project-node.btn-gray {
            border-radius: 26px !important;
            border: 2.5px dashed #94a3b8 !important;
            background: #e2e8f0 !important;
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
                    <div class="unit-banner" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 24px; padding: 24px; margin-bottom: 32px; box-shadow: 0 6px 0 #1e40af, 0 10px 25px -5px rgba(37, 99, 235, 0.2); position: relative; overflow: hidden;">
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

                        <div style="display: flex; flex-direction: column; align-items: center; gap: 68px; position: relative; z-index: 2;">
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
                                                    <div style="position: absolute; top: -42px; left: 50%; transform: translateX(-50%); background: {{ $lesson['is_project'] ? '#7e22ce' : '#2563eb' }}; color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; padding: 6px 14px; border-radius: 12px; box-shadow: 0 4px 0 {{ $lesson['is_project'] ? '#581c87' : '#1e40af' }}; white-space: nowrap; z-index: 10; display: inline-flex; align-items: center; gap: 6px;" class="animate-float">
                                                        @if ($lesson['is_project'])
                                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#facc15" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                            <span>PROYEK +{{ $lesson['xp_reward'] }} XP</span>
                                                        @else
                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                                            <span>Mulai +{{ $lesson['xp_reward'] }} XP</span>
                                                        @endif
                                                        <div style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid {{ $lesson['is_project'] ? '#7e22ce' : '#2563eb' }};"></div>
                                                    </div>
                                                @endif

                                                <!-- Circular or Squircle Node Button -->
                                                @php
                                                    $btnClass = 'btn-blue';
                                                    if ($lesson['is_completed']) {
                                                        $btnClass = 'btn-green';
                                                    } elseif ($lesson['is_project']) {
                                                        $btnClass = 'btn-purple' . ($lesson['is_current'] ? ' pulse-active-project' : '');
                                                    } elseif ($lesson['is_current']) {
                                                        $btnClass = 'btn-blue pulse-active-node';
                                                    }
                                                @endphp
                                                <div class="node-circle btn-3d {{ $lesson['is_project'] ? 'project-node' : '' }} {{ $btnClass }}">
                                                    @if ($lesson['is_completed'])
                                                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    @elseif ($lesson['is_project'])
                                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="#fde047" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    @elseif ($lesson['is_current'])
                                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    @else
                                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            <!-- Locked Node Button -->
                                            <div class="node-circle btn-gray {{ $lesson['is_project'] ? 'project-node' : '' }}" style="cursor: not-allowed;">
                                                @if ($lesson['is_project'])
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                @else
                                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Node Title and Badges -->
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; margin-top: 12px; max-width: 170px; text-align: center;">
                                        @if ($lesson['is_project'])
                                            <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 900; background: {{ $lesson['is_unlocked'] ? '#f3e8ff' : '#f1f5f9' }}; color: {{ $lesson['is_unlocked'] ? '#7e22ce' : '#64748b' }}; border: 1.5px solid {{ $lesson['is_unlocked'] ? '#d8b4fe' : '#cbd5e1' }}; padding: 3px 10px; border-radius: 9999px; letter-spacing: 0.5px; text-transform: uppercase;">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="{{ $lesson['is_unlocked'] ? '#9333ea' : '#64748b' }}" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                PROYEK AKHIR
                                            </span>
                                        @endif
                                        <span style="font-size: 13px; font-weight: 800; color: {{ $lesson['is_unlocked'] ? ($lesson['is_project'] ? '#6b21a8' : '#0f172a') : '#94a3b8' }}; line-height: 1.3;">
                                            {{ $lesson['title'] }}
                                        </span>
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

            <!-- Developer League & Rank Tier Card -->
            <div class="card-3d" style="padding: 20px; border-color: {{ $tierBorder }}; background: {{ $tierBg }};">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 28px; height: 28px; border-radius: 8px; background: #ffffff; color: {{ $tierColor }}; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 0 {{ $tierBorder }};">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                        <h3 style="font-size: 15px; font-weight: 900; color: #0f172a;">Liga Pengembang</h3>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <button type="button" onclick="openLeagueInfoModal()" style="width: 24px; height: 24px; border-radius: 50%; background: #ffffff; border: 1.5px solid {{ $tierBorder }}; color: {{ $tierColor }}; font-size: 12px; font-weight: 900; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s ease;" title="Panduan & Penjelasan Sistem Liga">
                            ?
                        </button>
                        <span style="font-size: 10px; font-weight: 800; color: {{ $tierColor }}; background: #ffffff; padding: 3px 8px; border-radius: 6px; border: 1px solid {{ $tierBorder }};">LIGA AKTIF</span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
                    <!-- Tier Emblem Badge -->
                    <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; border-radius: 14px; background: #ffffff; border: 2px solid {{ $tierBorder }}; display: flex; align-items: center; justify-content: center; color: {{ $tierColor }}; box-shadow: 0 4px 0 {{ $tierBorder }}; flex-shrink: 0;" class="animate-float">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div style="flex: 1; overflow: hidden;">
                        <div style="font-size: 15px; font-weight: 900; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $tierName }}</div>
                        <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-top: 1px;">{{ $tierDesc }}</div>
                    </div>
                </div>

                <!-- Progress to Next Tier -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 5px;">
                        <span>Progres Divisi</span>
                        <span style="color: {{ $tierColor }};">{{ $tierProgress }}%</span>
                    </div>
                    <div style="height: 10px; background: rgba(0, 0, 0, 0.06); border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $tierProgress }}%; background: {{ $tierColor }}; border-radius: 9999px; transition: width 0.4s ease;"></div>
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
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Raih Combo x3 di Kuis</span>
                        <span style="color: var(--accent-orange);">3/3 Selesai</span>
                    </div>
                    <div style="height: 10px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: 100%; background: var(--accent-orange); border-radius: 9999px;"></div>
                    </div>
                </div>

                <!-- Quest 3 -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Selesaikan 1 Modul</span>
                        <span style="color: var(--accent-green);">1/1 Selesai</span>
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

    <!-- Modal Panduan Sistem Liga & Gamifikasi -->
    <div id="league-info-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
        <div class="card-3d" style="background: #ffffff; max-width: 580px; width: 100%; border-radius: 28px; padding: 26px; max-height: 90vh; overflow-y: auto; border: 2px solid #bfdbfe; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 14px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; border: 2px solid #bfdbfe; box-shadow: 0 4px 0 #bfdbfe;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 19px; font-weight: 900; color: #0f172a;">Sistem Liga & Gamifikasi</h2>
                        <div style="font-size: 12px; font-weight: 700; color: #64748b;">Panduan Lengkap Tingkatan Divisi & Bonus XP</div>
                    </div>
                </div>
                <button type="button" onclick="closeLeagueInfoModal()" class="btn-close" style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <div style="font-size: 13px; color: #334155; line-height: 1.6; margin-bottom: 20px;">
                <p style="margin-bottom: 12px;"><strong>Cara Kerja Liga:</strong> Divisi liga lo ditentukan otomatis berdasarkan <strong>Total XP</strong> yang lo raih dari kuis, latihan kode, misi harian, dan proyek modul.</p>
                
                <h4 style="font-size: 13px; font-weight: 900; color: #0f172a; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;">6 Tingkatan Kasta Pengembang:</h4>
                
                <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px;">
                    <!-- Tier 1 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #fdf4ff; border: 1.5px solid #fed7aa; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #b45309; min-width: 125px;">1. Bronze Explorer</div>
                        <div style="font-size: 11px; font-weight: 800; color: #78350f; background: #ffffff; padding: 2px 7px; border-radius: 6px;">0 - 99 XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Eksplorasi awal logika & dasar coding.</div>
                    </div>
                    <!-- Tier 2 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #f8fafc; border: 1.5px solid #cbd5e1; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #475569; min-width: 125px;">2. Silver Coder</div>
                        <div style="font-size: 11px; font-weight: 800; color: #334155; background: #ffffff; padding: 2px 7px; border-radius: 6px;">100 - 299 XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Menguasai sintaks variabel, percabangan, & loop.</div>
                    </div>
                    <!-- Tier 3 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #fffbeb; border: 1.5px solid #fde68a; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #d97706; min-width: 125px;">3. Gold Engineer</div>
                        <div style="font-size: 11px; font-weight: 800; color: #b45309; background: #ffffff; padding: 2px 7px; border-radius: 6px;">300 - 699 XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Algoritma fungsi, array, dan logic lanjutan.</div>
                    </div>
                    <!-- Tier 4 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #f0fdfa; border: 1.5px solid #5eead4; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #0d9488; min-width: 125px;">4. Platinum Architect</div>
                        <div style="font-size: 11px; font-weight: 800; color: #115e59; background: #ffffff; padding: 2px 7px; border-radius: 6px;">700 - 1499 XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Arsitektur kode clean, terstruktur, & modular.</div>
                    </div>
                    <!-- Tier 5 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #f0f9ff; border: 1.5px solid #7dd3fc; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #0284c7; min-width: 125px;">5. Diamond Hacker</div>
                        <div style="font-size: 11px; font-weight: 800; color: #0369a1; background: #ffffff; padding: 2px 7px; border-radius: 6px;">1500 - 2999 XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Problem solving cepat dengan akurasi tinggi.</div>
                    </div>
                    <!-- Tier 6 -->
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 12px; background: #faf5ff; border: 1.5px solid #d8b4fe; flex-wrap: wrap;">
                        <div style="font-size: 12px; font-weight: 900; color: #9333ea; min-width: 125px;">6. Cyber Master</div>
                        <div style="font-size: 11px; font-weight: 800; color: #7e22ce; background: #ffffff; padding: 2px 7px; border-radius: 6px;">3000+ XP</div>
                        <div style="font-size: 11.5px; color: #475569; flex: 1;">Kasta tertinggi elit developer di EduSkill!</div>
                    </div>
                </div>

                <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 16px; padding: 12px 14px;">
                    <div style="font-size: 12px; font-weight: 800; color: var(--primary-blue); margin-bottom: 4px;">⚡ Fitur Gamifikasi Lainnya:</div>
                    <ul style="padding-left: 16px; font-size: 11.5px; color: #334155; line-height: 1.45;">
                        <li><strong>Quiz Combo Multiplier</strong>: Jawaban benar berturut-turut bakal melipatgandakan combo dan menaikkan nada synthesizer audio!</li>
                        <li><strong>Streak Belajar</strong>: Jaga streak tiap hari agar tidak putus dan raih badge eksklusif.</li>
                        <li><strong>Nyawa (Maks 5)</strong>: Regenerasi otomatis 1 nyawa per 30 menit atau isi instan pakai 20 Gems.</li>
                    </ul>
                </div>
            </div>

            <button type="button" onclick="closeLeagueInfoModal()" class="btn-3d btn-blue" style="width: 100%; padding: 12px; font-size: 13px;">
                Paham & Siap Push Rank!
            </button>
        </div>
    </div>

    <!-- Script to render smooth SVG connecting paths between consecutive roadmap nodes -->
    <script>
        function openLeagueInfoModal() {
            if (window.EduAudio) window.EduAudio.playPop();
            const modal = document.getElementById('league-info-modal');
            if (modal) modal.style.display = 'flex';
        }

        function closeLeagueInfoModal() {
            if (window.EduAudio) window.EduAudio.playTap();
            const modal = document.getElementById('league-info-modal');
            if (modal) modal.style.display = 'none';
        }

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
