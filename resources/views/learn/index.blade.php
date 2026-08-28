@php
    $title = 'Roadmap Belajar - Kodein';
@endphp

<x-app-layout>
    <div class="content-container">
        
        <!-- Left Column: Snake / Zigzag Learning Roadmap -->
        <div>
            @if (session('success'))
                <div style="background: rgba(88, 204, 2, 0.15); border: 2px solid var(--duo-green); border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #86efac; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">🎉</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div style="background: rgba(239, 68, 68, 0.15); border: 2px solid var(--duo-red); border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #fca5a5; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @foreach ($units as $unitIndex => $unit)
                <!-- Unit Header Banner -->
                <div style="background: linear-gradient(135deg, #58cc02, #46a302); border-radius: 24px; padding: 24px; margin-bottom: 36px; box-shadow: 0 6px 0 #3a8a00; position: relative;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <div style="font-size: 13px; font-weight: 900; text-transform: uppercase; color: #d7ffb8; letter-spacing: 0.8px;">
                                {{ $unit['title'] }}
                            </div>
                            <h2 style="font-size: 22px; font-weight: 900; color: #fff; margin-top: 4px;">
                                {{ $unit['description'] ?? 'Pelajari konsep dasar algoritma' }}
                            </h2>
                        </div>
                        <div style="width: 48px; height: 48px; background: rgba(0, 0, 0, 0.15); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            📚
                        </div>
                    </div>
                </div>

                <!-- Zigzag Nodes Path -->
                <div style="display: flex; flex-direction: column; align-items: center; gap: 28px; margin-bottom: 50px;">
                    @php
                        // Zigzag offsets in pixels: 0, 45, 0, -45
                        $offsets = [0, 45, 0, -45];
                    @endphp

                    @foreach ($unit['lessons'] as $lessonIndex => $lesson)
                        @php
                            $offset = $offsets[$lessonIndex % count($offsets)];
                        @endphp

                        <div style="transform: translateX({{ $offset }}px); position: relative; display: flex; flex-direction: column; align-items: center;">
                            
                            @if ($lesson['is_unlocked'])
                                <a href="{{ route('learn.lesson', $lesson['id']) }}" 
                                   style="text-decoration: none; position: relative; display: inline-block;">
                                    
                                    @if ($lesson['is_current'])
                                        <!-- Floating Start Tooltip -->
                                        <div style="position: absolute; top: -38px; left: 50%; transform: translateX(-50%); background: #1cb0f6; color: #fff; font-size: 11px; font-weight: 900; text-transform: uppercase; padding: 6px 12px; border-radius: 12px; box-shadow: 0 4px 0 #1899d6; white-space: nowrap; z-index: 10;" class="animate-float">
                                            MULAI +{{ $lesson['xp_reward'] }} XP
                                            <div style="position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid #1cb0f6;"></div>
                                        </div>
                                    @endif

                                    <!-- Circular Node Button -->
                                    <div class="btn-3d {{ $lesson['is_completed'] ? 'btn-green' : ($lesson['is_current'] ? 'btn-blue pulse-active-node' : 'btn-blue') }}"
                                         style="width: 76px; height: 76px; border-radius: 50%; padding: 0; font-size: 32px; display: flex; align-items: center; justify-content: center;">
                                        @if ($lesson['is_completed'])
                                            👑
                                        @elseif ($lesson['is_current'])
                                            ⭐
                                        @else
                                            ▶
                                        @endif
                                    </div>
                                </a>
                            @else
                                <!-- Locked Node Button -->
                                <div class="btn-3d btn-gray"
                                     style="width: 76px; height: 76px; border-radius: 50%; padding: 0; font-size: 28px; display: flex; align-items: center; justify-content: center; cursor: not-allowed;">
                                    🔒
                                </div>
                            @endif

                            <div style="font-size: 13px; font-weight: 800; color: {{ $lesson['is_unlocked'] ? '#ffffff' : '#64748b' }}; margin-top: 8px; text-align: center; max-width: 140px;">
                                {{ $lesson['title'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Right Column: Gamification HUD Widgets -->
        <div style="display: flex; flex-direction: column; gap: 20px; position: sticky; top: 24px;">
            
            <!-- Top Stats Bar -->
            <div class="card-3d" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <!-- Streak -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="animate-flame" style="font-size: 24px;">🔥</span>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: var(--duo-orange);">{{ $user->streak_count }}</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Streak</div>
                    </div>
                </div>

                <!-- Gems -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 24px;">💎</span>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: #38bdf8;">{{ $user->gems }}</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Gems</div>
                    </div>
                </div>

                <!-- Hearts -->
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 24px;">❤️</span>
                    <div>
                        <div style="font-size: 18px; font-weight: 900; color: var(--duo-red);">{{ $user->hearts }}/5</div>
                        <div style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase;">Nyawa</div>
                    </div>
                </div>
            </div>

            <!-- Hearts Refill Card (If not full) -->
            @if ($user->hearts < 5)
                <div class="card-3d" style="padding: 20px; border-color: rgba(239, 68, 68, 0.4); background: rgba(60, 20, 24, 0.6);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <span style="font-size: 28px;">💔</span>
                        <div>
                            <div style="font-size: 15px; font-weight: 900;">Nyawa Berkurang!</div>
                            <div style="font-size: 12px; color: #94a3b8;">Isi penuh sekarang agar bisa terus belajar.</div>
                        </div>
                    </div>
                    <form action="{{ route('learn.refill-hearts') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-3d btn-green" style="width: 100%; padding: 10px; font-size: 13px;">
                            ISI PENUH (20 💎)
                        </button>
                    </form>
                </div>
            @endif

            <!-- Daily Quests Widget -->
            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 900;">🎯 Misi Harian</h3>
                    <span style="font-size: 12px; font-weight: 800; color: var(--duo-gold);">RESET 24 JAM</span>
                </div>

                <!-- Quest 1 -->
                <div style="margin-bottom: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Dapatkan 30 XP</span>
                        <span style="color: var(--duo-gold);">{{ min(30, $user->xp) }}/30 XP</span>
                    </div>
                    <div style="height: 10px; background: #131f24; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: {{ min(100, ($user->xp / 30) * 100) }}%; background: var(--duo-gold); border-radius: 9999px;"></div>
                    </div>
                </div>

                <!-- Quest 2 -->
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 6px;">
                        <span>Selesaikan 1 Modul</span>
                        <span style="color: var(--duo-green);">1/1</span>
                    </div>
                    <div style="height: 10px; background: #131f24; border-radius: 9999px; overflow: hidden;">
                        <div style="height: 100%; width: 100%; background: var(--duo-green); border-radius: 9999px;"></div>
                    </div>
                </div>
            </div>

            <!-- Top 3 Leaderboard Preview -->
            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <h3 style="font-size: 16px; font-weight: 900;">🏆 Peringkat Teratas</h3>
                    <a href="{{ route('leaderboard.web') }}" style="font-size: 12px; font-weight: 800; color: #38bdf8; text-decoration: none;">LIHAT SEMUA</a>
                </div>

                @foreach ($topStudents as $rank => $student)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 8px 0; border-bottom: 1px solid var(--duo-dark-border);">
                        <div style="font-size: 16px; font-weight: 900; width: 24px; color: {{ $rank == 0 ? 'var(--duo-gold)' : ($rank == 1 ? '#cbd5e1' : '#d97706') }};">
                            #{{ $rank + 1 }}
                        </div>
                        <img src="{{ $student->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->id }}" style="width: 32px; height: 32px; border-radius: 50%; background: #131f24;" alt="">
                        <div style="flex: 1; overflow: hidden;">
                            <div style="font-size: 13px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $student->name }}</div>
                            <div style="font-size: 11px; color: #64748b;">{{ $student->xp }} XP</div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </div>
</x-app-layout>
