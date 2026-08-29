@php
    $title = 'Papan Peringkat - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        @media (max-width: 520px) {
            .podium-grid {
                gap: 8px !important;
            }
            .podium-card {
                padding: 14px 8px !important;
            }
            .podium-card img {
                width: 44px !important;
                height: 44px !important;
            }
            .podium-card-gold img {
                width: 56px !important;
                height: 56px !important;
            }
            .podium-name {
                font-size: 12px !important;
            }
            .podium-score {
                font-size: 11px !important;
            }
        }
    </style>

    <div style="max-width: 760px; margin: 0 auto; width: 100%;">
        
        <!-- Header Banner (Blue Theme) -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="width: 64px; height: 64px; margin: 0 auto 16px auto; background: var(--primary-blue-light); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); box-shadow: 0 4px 0 #bfdbfe;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1v-2.34"></path><path d="M18 14.66V17c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-2.34"></path><path d="M6 2h12v7a6 6 0 0 1-12 0V2Z"></path></svg>
            </div>
            <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Liga Berlian</h1>
            <p style="color: #64748b; font-size: 14px; margin-top: 4px;">Peringkat mingguan siswa berdasarkan perolehan XP dan keaktifan belajar.</p>

            <!-- Toggle Filter Tab -->
            <div style="display: inline-flex; background: #f1f5f9; padding: 4px; border-radius: 16px; margin-top: 20px; border: 2px solid #e2e8f0;">
                <a href="{{ route('leaderboard.web', ['type' => 'global']) }}" 
                   style="padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; text-transform: uppercase; text-decoration: none; transition: all 0.15s; background: {{ $type === 'global' ? 'var(--primary-blue)' : 'transparent' }}; color: {{ $type === 'global' ? '#ffffff' : '#64748b' }};">
                    Total XP
                </a>
                <a href="{{ route('leaderboard.web', ['type' => 'streak']) }}" 
                   style="padding: 10px 20px; border-radius: 12px; font-size: 13px; font-weight: 800; text-transform: uppercase; text-decoration: none; transition: all 0.15s; background: {{ $type === 'streak' ? 'var(--primary-blue)' : 'transparent' }}; color: {{ $type === 'streak' ? '#ffffff' : '#64748b' }};">
                    Hari Streak
                </a>
            </div>
        </div>

        <!-- Top 3 Podium Cards -->
        @if ($students->count() >= 3)
            <div class="podium-grid" style="display: grid; grid-template-columns: 1fr 1.15fr 1fr; gap: 16px; align-items: flex-end; margin-bottom: 40px;">
                
                <!-- Rank 2: Silver -->
                @php $s2 = $students[1]; @endphp
                <div class="card-3d podium-card" style="padding: 24px 16px; text-align: center; border-color: #cbd5e1; background: #ffffff;">
                    <div style="width: 30px; height: 30px; background: #94a3b8; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 13px;">2</div>
                    <img src="{{ $s2->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s2->id }}" style="width: 56px; height: 56px; border-radius: 50%; background: #f8fafc; border: 3px solid #cbd5e1; margin-bottom: 8px;" alt="">
                    <div class="podium-name" style="font-size: 14px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s2->name }}</div>
                    <div class="podium-score" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); margin-top: 4px;">{{ $type === 'streak' ? $s2->streak_count . ' Hari' : $s2->xp . ' XP' }}</div>
                </div>

                <!-- Rank 1: Gold (Center Elevated) -->
                @php $s1 = $students[0]; @endphp
                <div class="card-3d podium-card podium-card-gold" style="padding: 30px 16px; text-align: center; border-color: #f59e0b; background: #fffbeb; transform: translateY(-8px); box-shadow: 0 6px 0 #d97706;">
                    <div style="width: 34px; height: 34px; background: #f59e0b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 15px;">1</div>
                    <img src="{{ $s1->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s1->id }}" style="width: 72px; height: 72px; border-radius: 50%; background: #f8fafc; border: 4px solid #f59e0b; margin-bottom: 8px;" alt="">
                    <div class="podium-name" style="font-size: 15px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #78350f;">{{ $s1->name }}</div>
                    <div class="podium-score" style="font-size: 13px; font-weight: 900; color: #d97706; margin-top: 4px;">{{ $type === 'streak' ? $s1->streak_count . ' Hari' : $s1->xp . ' XP' }}</div>
                </div>

                <!-- Rank 3: Bronze -->
                @php $s3 = $students[2]; @endphp
                <div class="card-3d podium-card" style="padding: 20px 16px; text-align: center; border-color: #cbd5e1; background: #ffffff;">
                    <div style="width: 30px; height: 30px; background: #b45309; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 13px;">3</div>
                    <img src="{{ $s3->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s3->id }}" style="width: 52px; height: 52px; border-radius: 50%; background: #f8fafc; border: 3px solid #cbd5e1; margin-bottom: 8px;" alt="">
                    <div class="podium-name" style="font-size: 14px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s3->name }}</div>
                    <div class="podium-score" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); margin-top: 4px;">{{ $type === 'streak' ? $s3->streak_count . ' Hari' : $s3->xp . ' XP' }}</div>
                </div>

            </div>
        @endif

        <!-- Full Ranking List -->
        <div class="card-3d" style="padding: 8px 12px;">
            @foreach ($students as $index => $student)
                @php
                    $isCurrentUser = $student->id === $user->id;
                @endphp
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px 8px; border-radius: 16px; margin: 4px 0; background: {{ $isCurrentUser ? 'var(--primary-blue-light)' : 'transparent' }}; border: {{ $isCurrentUser ? '2px solid #bfdbfe' : 'none' }};">
                    <div style="font-size: 14px; font-weight: 900; width: 24px; text-align: center; color: {{ $index < 3 ? 'var(--primary-blue)' : '#94a3b8' }};">
                        {{ $index + 1 }}
                    </div>

                    <img src="{{ $student->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->id }}" style="width: 38px; height: 38px; border-radius: 50%; background: #f1f5f9; border: 2px solid #e2e8f0;" alt="">

                    <div style="flex: 1; overflow: hidden;">
                        <div style="font-size: 14px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $student->name }}</span>
                            @if ($isCurrentUser)
                                <span style="font-size: 9px; font-weight: 800; background: var(--primary-blue); color: #fff; padding: 2px 6px; border-radius: 6px; text-transform: uppercase;">Kamu</span>
                            @endif
                        </div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 2px;">Level {{ $student->level }}</div>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-size: 14px; font-weight: 900; color: var(--primary-blue);">
                            {{ $type === 'streak' ? $student->streak_count . ' Hari' : $student->xp . ' XP' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
