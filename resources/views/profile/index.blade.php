@php
    $title = 'Profil & Lencana - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        @media (max-width: 640px) {
            .profile-header-card {
                padding: 20px 16px !important;
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .profile-stats-row {
                width: 100% !important;
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 10px !important;
            }
        }
    </style>

    <div style="max-width: 860px; margin: 0 auto; width: 100%;">
        
        <!-- Profile Header Card (Light Blue Theme) -->
        <div class="card-3d profile-header-card" style="padding: 32px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $user->id }}" style="width: 76px; height: 76px; min-width: 76px; min-height: 76px; flex-shrink: 0; border-radius: 50%; object-fit: cover; background: var(--primary-blue-light); border: 4px solid #bfdbfe;" alt="">
                <div>
                    <h1 style="font-size: 22px; font-weight: 900; color: #0f172a;">{{ $user->name }}</h1>
                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px; flex-wrap: wrap;">
                        <span style="background: var(--primary-blue-light); color: var(--primary-blue); font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 8px; border: 1px solid #bfdbfe;">
                            {{ $user->role }}
                        </span>
                        <span style="color: #64748b; font-size: 12px; font-weight: 600;">
                            Bergabung {{ $user->created_at->translatedFormat('F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="profile-stats-row" style="display: flex; gap: 14px;">
                <div style="text-align: center; background: #f8fafc; border: 2px solid var(--border-color); border-radius: 18px; padding: 12px 18px;">
                    <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Level</div>
                    <div style="font-size: 20px; font-weight: 900; color: var(--primary-blue);">{{ $user->level }}</div>
                </div>
                <div style="text-align: center; background: #f8fafc; border: 2px solid var(--border-color); border-radius: 18px; padding: 12px 18px;">
                    <div style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Total XP</div>
                    <div style="font-size: 20px; font-weight: 900; color: var(--primary-blue);">{{ $user->xp }}</div>
                </div>
            </div>
        </div>

        <!-- 4 Key Statistics Cards -->
        <h2 style="font-size: 18px; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v-6M6 20V10M18 20V4"></path></svg>
            Statistik Belajar
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; margin-bottom: 36px;">
            <!-- Stat 1 -->
            <div class="card-3d" style="padding: 18px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Streak</span>
                    <div style="color: var(--accent-orange);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    </div>
                </div>
                <div style="font-size: 22px; font-weight: 900; color: var(--accent-orange);">{{ $user->streak_count }} Hari</div>
            </div>

            <!-- Stat 2 -->
            <div class="card-3d" style="padding: 18px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Gems</span>
                    <div style="color: var(--primary-blue);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                    </div>
                </div>
                <div style="font-size: 22px; font-weight: 900; color: var(--primary-blue);">{{ $user->gems }}</div>
            </div>

            <!-- Stat 3 -->
            <div class="card-3d" style="padding: 18px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Selesai</span>
                    <div style="color: var(--accent-green);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                </div>
                <div style="font-size: 22px; font-weight: 900; color: var(--accent-green);">{{ $completedLessonsCount }} Modul</div>
            </div>

            <!-- Stat 4 -->
            <div class="card-3d" style="padding: 18px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Lencana</span>
                    <div style="color: var(--primary-blue);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    </div>
                </div>
                <div style="font-size: 22px; font-weight: 900; color: var(--primary-blue);">{{ $unlockedBadges->count() }}/{{ count($allBadges) }}</div>
            </div>
        </div>

        <!-- Badges Gallery Grid -->
        <h2 style="font-size: 18px; font-weight: 900; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
            Koleksi Lencana &amp; Pencapaian
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
            @foreach ($allBadges as $badgeItem)
                @php
                    $isUnlocked = $unlockedBadges->has($badgeItem['code']);
                @endphp

                <div class="card-3d" style="padding: 22px 18px; text-align: center; border-color: {{ $isUnlocked ? '#bfdbfe' : 'var(--border-color)' }}; opacity: {{ $isUnlocked ? '1' : '0.55' }}; background: {{ $isUnlocked ? '#ffffff' : '#f8fafc' }};">
                    <div style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; flex-shrink: 0; margin: 0 auto 12px auto; background: {{ $isUnlocked ? 'var(--primary-blue-light)' : '#e2e8f0' }}; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: {{ $isUnlocked ? 'var(--primary-blue)' : '#94a3b8' }};">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                    </div>
                    <div style="font-size: 15px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                        {{ $badgeItem['name'] }}
                    </div>
                    <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                        {{ $badgeItem['description'] }}
                    </div>

                    @if ($isUnlocked)
                        <div style="margin-top: 12px; font-size: 11px; font-weight: 800; color: #059669; text-transform: uppercase; background: #ecfdf5; padding: 4px 10px; border-radius: 8px; display: inline-block;">
                            Terbuka
                        </div>
                    @else
                        <div style="margin-top: 12px; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; background: #e2e8f0; padding: 4px 10px; border-radius: 8px; display: inline-block;">
                            Terkunci
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Account Session / Logout Section (Especially convenient on mobile) -->
        <div class="card-3d" style="padding: 24px; margin-top: 36px; margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; border-color: #fca5a5; background: #fffdfd;">
            <div>
                <h3 style="font-size: 16px; font-weight: 900; color: #991b1b; display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Sesi Akun &amp; Ganti Pengguna
                </h3>
                <p style="font-size: 13px; color: #64748b; margin-top: 2px;">Sedang masuk sebagai <strong>{{ $user->email }}</strong> ({{ strtoupper($user->role) }}).</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-3d btn-red" style="padding: 10px 20px; font-size: 13px;">
                    Keluar / Ganti Akun
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
