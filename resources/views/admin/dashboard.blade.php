@php
    $title = 'Dashboard Super Admin - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        .admin-two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }
        @media (max-width: 768px) {
            .admin-two-cols {
                grid-template-columns: 1fr;
                gap: 18px;
            }
        }
    </style>

    <div style="max-width: 1040px; margin: 0 auto; width: 100%;">
        
        <!-- Header Banner -->
        <div style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: #eff6ff; border: 1px solid #bfdbfe; color: var(--primary-blue); padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    Panel Kontrol Utama
                </div>
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Dashboard Super Admin</h1>
                <p style="color: #64748b; font-size: 14px; margin-top: 2px;">Ringkasan metrik pengguna, kurikulum aktif, dan sertifikat yang diterbitkan di platform EduSkill.</p>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.users.index') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 10px 18px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Kelola Pengguna
                </a>
                <a href="{{ route('admin.courses.index') }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 18px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    Master Kursus
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 18px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    Rekap Sertifikat
                </a>
                <a href="{{ route('learn.index') }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 18px;">
                    Preview Siswa
                </a>
            </div>
        </div>

        <!-- 4 Key Stat Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px;">
            
            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Total Pengguna</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
                <div style="font-size: 26px; font-weight: 900; color: #0f172a;">{{ $stats['total_users'] }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ $stats['total_students'] }} Siswa &bull; {{ $stats['total_mentors'] }} Mentor</div>
            </div>

            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Kursus &amp; Modul</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    </div>
                </div>
                <div style="font-size: 26px; font-weight: 900; color: #0f172a;">{{ $stats['total_courses'] }} Kursus</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">{{ $stats['total_units'] }} Unit &bull; {{ $stats['total_lessons'] }} Modul</div>
            </div>

            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Sertifikat Terbit</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    </div>
                </div>
                <div style="font-size: 26px; font-weight: 900; color: #0f172a;">{{ $stats['total_certificates'] }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Tanda Tangan SHA-256 Valid</div>
            </div>

            <div class="card-3d" style="padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">Akumulasi XP</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                    </div>
                </div>
                <div style="font-size: 26px; font-weight: 900; color: var(--primary-blue);">{{ number_format($stats['total_xp']) }}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Poin Belajar Seluruh Siswa</div>
            </div>

        </div>

        <!-- 2 Column Section: Users & Courses -->
        <div class="admin-two-cols">
            
            <!-- Users Table Card -->
            <div class="card-3d" style="padding: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                    <h2 style="font-size: 16px; font-weight: 900; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        Daftar Pengguna
                    </h2>
                    <span style="font-size: 11px; font-weight: 800; color: #64748b;">{{ $recentUsers->count() }} PENGGUNA TERAKHIR</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($recentUsers as $u)
                        <div style="display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0;">
                            <img src="{{ $u->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $u->id }}" style="width: 34px; height: 34px; min-width: 34px; min-height: 34px; flex-shrink: 0; border-radius: 50%; object-fit: cover; background: #e2e8f0;" alt="">
                            <div style="flex: 1; overflow: hidden;">
                                <div style="font-size: 13px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->name }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $u->email }}</div>
                            </div>
                            <span style="font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 8px; border-radius: 6px; background: {{ $u->role === 'guru' ? '#dbeafe' : ($u->role === 'super_admin' ? '#f3e8ff' : '#ecfdf5') }}; color: {{ $u->role === 'guru' ? '#1d4ed8' : ($u->role === 'super_admin' ? '#7e22ce' : '#047857') }};">
                                {{ $u->role }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Courses Management Card -->
            <div class="card-3d" style="padding: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                    <h2 style="font-size: 16px; font-weight: 900; display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path></svg>
                        Kurikulum Kursus
                    </h2>
                    <span style="font-size: 11px; font-weight: 800; color: #059669; background: #ecfdf5; padding: 3px 8px; border-radius: 6px;">STATUS PUBLISHED</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach ($courses as $c)
                        <div style="padding: 14px; border-radius: 14px; border: 1.5px solid #e2e8f0; background: #ffffff;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                                <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 2px 6px; border-radius: 4px;">
                                    {{ $c->category }}
                                </span>
                                <span style="font-size: 11px; color: #64748b; font-weight: 700;">
                                    {{ $c->units->count() }} Unit &bull; {{ $c->units->flatMap->lessons->count() }} Modul
                                </span>
                            </div>
                            <div style="font-size: 14px; font-weight: 900; color: #0f172a; margin-top: 4px;">{{ $c->title }}</div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Mentor: {{ $c->mentor->name ?? 'Tim Pengajar' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Recent Issued Certificates Card -->
        <div class="card-3d" style="padding: 24px; margin-bottom: 40px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                <h2 style="font-size: 16px; font-weight: 900; display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                    Sertifikat Resmi yang Baru Diterbitkan
                </h2>
                <span style="font-size: 11px; font-weight: 800; color: #64748b;">VERIFIKASI REAL-TIME</span>
            </div>

            @if ($recentCertificates->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($recentCertificates as $cert)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $cert->recipient_name }}</div>
                                <div style="font-size: 12px; color: #64748b;">{{ $cert->course_title }} &bull; Nilai: {{ $cert->score_average }}/100</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span class="code-font" style="font-size: 12px; font-weight: 700; color: var(--primary-blue);">{{ $cert->cert_code }}</span>
                                <a href="{{ route('certificate.verify', $cert->cert_code) }}" target="_blank" class="btn-3d btn-outline" style="padding: 6px 12px; font-size: 11px;">
                                    Buka QR Verifikasi
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 24px; color: #64748b; font-size: 14px;">
                    Belum ada sertifikat yang diterbitkan.
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
