@php
    $title = 'Papan Peringkat Liga - Kodein';
@endphp

<x-app-layout>
    <div style="width: 100%; max-width: 760px; margin: 0 auto;">
        
        <!-- Header Banner -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 48px; margin-bottom: 8px;" class="animate-float">🏆</div>
            <h1 style="font-size: 28px; font-weight: 900; letter-spacing: -0.5px;">Liga Berlian</h1>
            <p style="color: #94a3b8; font-size: 14px; margin-top: 4px;">10 besar teratas akan dipromosikan ke liga berikutnya tiap minggu!</p>
        </div>

        <!-- Filter Tabs -->
        <div style="display: flex; gap: 12px; margin-bottom: 32px; justify-content: center;">
            <a href="{{ route('leaderboard.web', ['type' => 'global']) }}" class="btn-3d {{ $type === 'global' ? 'btn-blue' : 'btn-outline' }}" style="padding: 10px 24px; font-size: 14px;">
                ⚡ Total XP
            </a>
            <a href="{{ route('leaderboard.web', ['type' => 'streak']) }}" class="btn-3d {{ $type === 'streak' ? 'btn-orange' : 'btn-outline' }}" style="padding: 10px 24px; font-size: 14px;">
                🔥 Hari Streak
            </a>
        </div>

        <!-- Top 3 Podium -->
        @if ($podium->count() >= 3)
            <div style="display: flex; align-items: flex-end; justify-content: center; gap: 16px; margin-bottom: 40px; padding: 0 10px;">
                
                <!-- Rank 2: Silver -->
                <div style="flex: 1; max-width: 160px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 4px;">🥈</div>
                    <img src="{{ $podium[1]->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $podium[1]->id }}" style="width: 54px; height: 54px; border-radius: 50%; border: 3px solid #94a3b8; background: #131f24; margin-bottom: 8px;" alt="">
                    <div style="font-size: 14px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $podium[1]->name }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: #38bdf8;">{{ $type === 'streak' ? $podium[1]->streak_count . ' Hari' : $podium[1]->xp . ' XP' }}</div>
                    <div style="height: 90px; background: linear-gradient(180deg, #334155, #1e293b); border: 2px solid #64748b; border-radius: 16px 16px 0 0; margin-top: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 900; color: #cbd5e1;">2</div>
                </div>

                <!-- Rank 1: Gold (Center & Taller) -->
                <div style="flex: 1; max-width: 180px; text-align: center;">
                    <div style="font-size: 32px; margin-bottom: 4px;" class="animate-float">👑</div>
                    <img src="{{ $podium[0]->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $podium[0]->id }}" style="width: 68px; height: 68px; border-radius: 50%; border: 4px solid var(--duo-gold); background: #131f24; margin-bottom: 8px; box-shadow: 0 0 20px rgba(255, 200, 0, 0.4);" alt="">
                    <div style="font-size: 15px; font-weight: 900; color: var(--duo-gold); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $podium[0]->name }}</div>
                    <div style="font-size: 13px; font-weight: 800; color: #fff;">{{ $type === 'streak' ? $podium[0]->streak_count . ' Hari' : $podium[0]->xp . ' XP' }}</div>
                    <div style="height: 130px; background: linear-gradient(180deg, #d97706, #78350f); border: 2px solid var(--duo-gold); border-radius: 20px 20px 0 0; margin-top: 12px; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 900; color: var(--duo-gold);">1</div>
                </div>

                <!-- Rank 3: Bronze -->
                <div style="flex: 1; max-width: 160px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 4px;">🥉</div>
                    <img src="{{ $podium[2]->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $podium[2]->id }}" style="width: 54px; height: 54px; border-radius: 50%; border: 3px solid #b45309; background: #131f24; margin-bottom: 8px;" alt="">
                    <div style="font-size: 14px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $podium[2]->name }}</div>
                    <div style="font-size: 12px; font-weight: 700; color: #38bdf8;">{{ $type === 'streak' ? $podium[2]->streak_count . ' Hari' : $podium[2]->xp . ' XP' }}</div>
                    <div style="height: 70px; background: linear-gradient(180deg, #451a03, #1e293b); border: 2px solid #b45309; border-radius: 16px 16px 0 0; margin-top: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 900; color: #f59e0b;">3</div>
                </div>

            </div>
        @endif

        <!-- Rest of Leaderboard List -->
        <div class="card-3d" style="padding: 12px 16px;">
            @foreach ($rankings as $idx => $student)
                @php $rank = $idx + 4; @endphp
                <div style="display: flex; align-items: center; gap: 16px; padding: 14px 12px; border-radius: 16px; margin-bottom: 4px; background: {{ $student->id === $currentUser->id ? 'rgba(28, 176, 246, 0.15)' : 'transparent' }}; border: 1px solid {{ $student->id === $currentUser->id ? 'var(--duo-blue)' : 'transparent' }};">
                    <div style="font-size: 16px; font-weight: 900; width: 28px; color: #64748b;">
                        {{ $rank }}
                    </div>
                    <img src="{{ $student->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->id }}" style="width: 40px; height: 40px; border-radius: 50%; background: #131f24;" alt="">
                    <div style="flex: 1;">
                        <div style="font-size: 15px; font-weight: 800; color: {{ $student->id === $currentUser->id ? 'var(--duo-blue)' : '#fff' }};">
                            {{ $student->name }} {{ $student->id === $currentUser->id ? '(Kamu)' : '' }}
                        </div>
                        <div style="font-size: 12px; color: #64748b;">Level {{ $student->level }}</div>
                    </div>
                    <div style="font-size: 15px; font-weight: 900; color: {{ $type === 'streak' ? 'var(--duo-orange)' : 'var(--duo-gold)' }};">
                        {{ $type === 'streak' ? $student->streak_count . ' Hari 🔥' : $student->xp . ' XP ⚡' }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
