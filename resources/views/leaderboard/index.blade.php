@php
    $title = 'Papan Peringkat Liga Pengembang - EduSkill';
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
        
        <!-- Header Banner (Unified Developer League Theme) -->
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="width: 64px; height: 64px; min-width: 64px; min-height: 64px; flex-shrink: 0; margin: 0 auto 16px auto; background: {{ $userTier['bg'] }}; border: 2px solid {{ $userTier['border'] }}; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: {{ $userTier['color'] }}; box-shadow: 0 4px 0 {{ $userTier['border'] }};" class="animate-float">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </div>
            
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: wrap;">
                <h1 style="font-size: 28px; font-weight: 900; color: #0f172a; letter-spacing: -0.5px;">Liga Pengembang</h1>
                <button type="button" onclick="openLeagueInfoModal()" style="width: 26px; height: 26px; border-radius: 50%; background: #ffffff; border: 1.5px solid {{ $userTier['border'] }}; color: {{ $userTier['color'] }}; font-size: 13px; font-weight: 900; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.15s ease;" title="Panduan & Penjelasan Sistem Liga">
                    ?
                </button>
            </div>

            <!-- Current User Active Tier Pill -->
            <div style="margin-top: 8px;">
                <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 800; color: {{ $userTier['color'] }}; background: {{ $userTier['bg'] }}; border: 1.5px solid {{ $userTier['border'] }}; padding: 4px 14px; border-radius: 9999px;">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ $userTier['color'] }};"></span>
                    Divisi Anda: {{ $userTier['name'] }}
                </span>
            </div>

            <p style="color: #64748b; font-size: 14px; margin-top: 10px;">Peringkat siswa berdasarkan akumulasi XP dan konsistensi belajar pemrograman.</p>

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
                    <div style="width: 30px; height: 30px; min-width: 30px; min-height: 30px; flex-shrink: 0; background: #94a3b8; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 13px;">2</div>
                    <img src="{{ $s2->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s2->id }}" style="width: 56px; height: 56px; min-width: 56px; min-height: 56px; flex-shrink: 0; border-radius: 50%; background: #f8fafc; border: 3px solid #cbd5e1; margin: 0 auto 8px auto; object-fit: cover;" alt="">
                    <div class="podium-name" style="font-size: 14px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s2->name }}</div>
                    <div style="font-size: 10px; font-weight: 800; color: {{ $s2->tier['color'] ?? '#64748b' }}; margin-top: 2px;">{{ $s2->tier['name'] ?? 'Bronze Explorer' }}</div>
                    <div class="podium-score" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); margin-top: 4px;">{{ $type === 'streak' ? $s2->streak_count . ' Hari' : $s2->xp . ' XP' }}</div>
                </div>

                <!-- Rank 1: Gold (Center Elevated) -->
                @php $s1 = $students[0]; @endphp
                <div class="card-3d podium-card podium-card-gold" style="padding: 30px 16px; text-align: center; border-color: #f59e0b; background: #fffbeb; transform: translateY(-8px); box-shadow: 0 6px 0 #d97706;">
                    <div style="width: 34px; height: 34px; min-width: 34px; min-height: 34px; flex-shrink: 0; background: #f59e0b; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 15px;">1</div>
                    <img src="{{ $s1->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s1->id }}" style="width: 72px; height: 72px; min-width: 72px; min-height: 72px; flex-shrink: 0; border-radius: 50%; background: #f8fafc; border: 4px solid #f59e0b; margin: 0 auto 8px auto; object-fit: cover;" alt="">
                    <div class="podium-name" style="font-size: 15px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #78350f;">{{ $s1->name }}</div>
                    <div style="font-size: 11px; font-weight: 900; color: {{ $s1->tier['color'] ?? '#d97706' }}; margin-top: 2px;">{{ $s1->tier['name'] ?? 'Gold Engineer' }}</div>
                    <div class="podium-score" style="font-size: 13px; font-weight: 900; color: #d97706; margin-top: 4px;">{{ $type === 'streak' ? $s1->streak_count . ' Hari' : $s1->xp . ' XP' }}</div>
                </div>

                <!-- Rank 3: Bronze -->
                @php $s3 = $students[2]; @endphp
                <div class="card-3d podium-card" style="padding: 20px 16px; text-align: center; border-color: #cbd5e1; background: #ffffff;">
                    <div style="width: 30px; height: 30px; min-width: 30px; min-height: 30px; flex-shrink: 0; background: #b45309; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; margin: 0 auto 10px auto; font-size: 13px;">3</div>
                    <img src="{{ $s3->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $s3->id }}" style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; flex-shrink: 0; border-radius: 50%; background: #f8fafc; border: 3px solid #cbd5e1; margin: 0 auto 8px auto; object-fit: cover;" alt="">
                    <div class="podium-name" style="font-size: 14px; font-weight: 900; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $s3->name }}</div>
                    <div style="font-size: 10px; font-weight: 800; color: {{ $s3->tier['color'] ?? '#64748b' }}; margin-top: 2px;">{{ $s3->tier['name'] ?? 'Bronze Explorer' }}</div>
                    <div class="podium-score" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); margin-top: 4px;">{{ $type === 'streak' ? $s3->streak_count . ' Hari' : $s3->xp . ' XP' }}</div>
                </div>

            </div>
        @endif

        <!-- Full Ranking List -->
        <div class="card-3d" style="padding: 8px 12px;">
            @foreach ($students as $index => $student)
                @php
                    $isCurrentUser = $student->id === $user->id;
                    $stTier = $student->tier ?? \App\Services\GamificationService::getTierDetails($student->xp ?? 0);
                @endphp
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px 8px; border-radius: 16px; margin: 4px 0; background: {{ $isCurrentUser ? 'var(--primary-blue-light)' : 'transparent' }}; border: {{ $isCurrentUser ? '2px solid #bfdbfe' : 'none' }};">
                    <div style="font-size: 14px; font-weight: 900; width: 24px; text-align: center; color: {{ $index < 3 ? 'var(--primary-blue)' : '#94a3b8' }};">
                        {{ $index + 1 }}
                    </div>

                    <img src="{{ $student->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $student->id }}" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; flex-shrink: 0; border-radius: 50%; background: #f1f5f9; border: 2px solid #e2e8f0; object-fit: cover;" alt="">

                    <div style="flex: 1; overflow: hidden;">
                        <div style="font-size: 14px; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 6px;">
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $student->name }}</span>
                            @if ($isCurrentUser)
                                <span style="font-size: 9px; font-weight: 800; background: var(--primary-blue); color: #fff; padding: 2px 6px; border-radius: 6px; text-transform: uppercase;">Kamu</span>
                            @endif
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                            <span style="font-size: 11px; color: #64748b;">Level {{ $student->level }}</span>
                            <span style="font-size: 10px; font-weight: 800; color: {{ $stTier['color'] }}; background: {{ $stTier['bg'] }}; border: 1px solid {{ $stTier['border'] }}; padding: 1px 6px; border-radius: 6px;">{{ $stTier['name'] }}</span>
                        </div>
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

    <!-- Modal Panduan Sistem Liga & Gamifikasi -->
    <div id="league-info-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
        <div class="card-3d" style="background: #ffffff; max-width: 580px; width: 100%; border-radius: 28px; padding: 26px; max-height: 90vh; overflow-y: auto; border: 2px solid #bfdbfe; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 14px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; border: 2px solid #bfdbfe; box-shadow: 0 4px 0 #bfdbfe;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
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
    </script>
</x-app-layout>
