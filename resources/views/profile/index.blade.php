@php
    $title = 'Profil & Lencana - Kodein';
@endphp

<x-app-layout>
    <div style="width: 100%; max-width: 780px; margin: 0 auto;">
        
        <!-- Profile Header Card -->
        <div class="card-3d" style="padding: 32px 28px; margin-bottom: 28px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
            <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $user->id }}" style="width: 88px; height: 88px; border-radius: 50%; background: #131f24; border: 4px solid var(--duo-blue); box-shadow: 0 0 20px rgba(28, 176, 246, 0.3);" alt="Avatar">
            
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <h1 style="font-size: 24px; font-weight: 900;">{{ $user->name }}</h1>
                    <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; background: var(--duo-blue); color: #fff; padding: 4px 10px; border-radius: 8px;">
                        Level {{ $user->level }}
                    </span>
                </div>
                <div style="font-size: 14px; color: #94a3b8; margin-top: 4px;">{{ $user->email }} • Bergabung sejak {{ $user->created_at->translatedFormat('F Y') }}</div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <h2 style="font-size: 18px; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <span>📊</span> Statistik Belajar
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 36px;">
            
            <!-- Streak -->
            <div class="card-3d" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span class="animate-flame" style="font-size: 24px;">🔥</span>
                    <span style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Streak</span>
                </div>
                <div style="font-size: 24px; font-weight: 900; color: var(--duo-orange);">{{ $user->streak_count }} Hari</div>
            </div>

            <!-- Total XP -->
            <div class="card-3d" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span style="font-size: 24px;">⚡</span>
                    <span style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Total XP</span>
                </div>
                <div style="font-size: 24px; font-weight: 900; color: var(--duo-gold);">{{ $user->xp }} XP</div>
            </div>

            <!-- Modul Selesai -->
            <div class="card-3d" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span style="font-size: 24px;">📚</span>
                    <span style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Modul Selesai</span>
                </div>
                <div style="font-size: 24px; font-weight: 900; color: var(--duo-green);">{{ $completedLessonsCount }} Modul</div>
            </div>

            <!-- Sertifikat -->
            <div class="card-3d" style="padding: 16px 20px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span style="font-size: 24px;">🎓</span>
                    <span style="font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Sertifikat</span>
                </div>
                <div style="font-size: 24px; font-weight: 900; color: #38bdf8;">{{ $certificatesCount }} Diraih</div>
            </div>

        </div>

        <!-- Achievements / Badges Showcase -->
        <h2 style="font-size: 18px; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <span>🏅</span> Koleksi Lencana & Pencapaian
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
            @foreach ($allBadges as $badge)
                @php
                    $isUnlocked = $unlockedBadges->has($badge['code']);
                @endphp

                <div class="card-3d" style="padding: 20px; text-align: center; border-color: {{ $isUnlocked ? 'var(--duo-gold)' : 'var(--duo-dark-border)' }}; opacity: {{ $isUnlocked ? '1' : '0.45' }};">
                    <div style="font-size: 48px; margin-bottom: 12px; filter: {{ $isUnlocked ? 'none' : 'grayscale(100%)' }};">
                        {{ $badge['icon'] }}
                    </div>
                    <div style="font-size: 16px; font-weight: 900; color: {{ $isUnlocked ? '#fff' : '#64748b' }}; margin-bottom: 6px;">
                        {{ $badge['name'] }}
                    </div>
                    <div style="font-size: 12px; color: #94a3b8; line-height: 1.5;">
                        {{ $badge['description'] }}
                    </div>

                    @if ($isUnlocked)
                        <div style="margin-top: 12px; font-size: 11px; font-weight: 800; color: var(--duo-gold); text-transform: uppercase;">
                            ✨ TERBUKA
                        </div>
                    @else
                        <div style="margin-top: 12px; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">
                            🔒 TERKUNCI
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
