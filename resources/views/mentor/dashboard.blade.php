@php
    $title = 'Dashboard Mentor - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        @media (max-width: 640px) {
            .mentor-card-pad {
                padding: 18px 16px !important;
            }
        }
    </style>

    <div style="max-width: 1040px; margin: 0 auto; width: 100%;">
        
        <!-- Header Banner -->
        <div style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: #eff6ff; border: 1px solid #bfdbfe; color: var(--primary-blue); padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path><path d="M6 6h10"></path><path d="M6 10h10"></path></svg>
                    Panel Guru &amp; Mentor
                </div>
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Dashboard Mentor: {{ $user->name }}</h1>
                <p style="color: #64748b; font-size: 14px; margin-top: 2px;">Kelola materi pelajaran, bank soal interaktif, dan pantau kemajuan belajar murid kamu.</p>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('mentor.courses.index') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 10px 18px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Kelola Kursus &amp; Materi
                </a>
                <a href="{{ route('learn.index') }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 18px;">
                    Preview Roadmap Siswa
                </a>
            </div>
        </div>

        <!-- 4 Mentor Key Metrics -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 32px;">
            
            <div class="card-3d" style="padding: 22px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Kursus Binaan</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path></svg>
                    </div>
                </div>
                <div style="font-size: 28px; font-weight: 900; color: #0f172a;">{{ $stats['total_courses'] }} Kursus</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Kurikulum Aktif di Sistem</div>
            </div>

            <div class="card-3d" style="padding: 22px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Modul &amp; Pelajaran</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                </div>
                <div style="font-size: 28px; font-weight: 900; color: #0f172a;">{{ $stats['total_lessons'] }} Modul</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Total Latihan Kuis Siap Dikerjakan</div>
            </div>

            <div class="card-3d" style="padding: 22px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Bank Soal Kuis</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    </div>
                </div>
                <div style="font-size: 28px; font-weight: 900; color: #0f172a;">{{ $stats['total_exercises'] }} Butir</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Parsons, Fill-in, Pair &amp; Output</div>
            </div>

            <div class="card-3d" style="padding: 22px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                    <span style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase;">Siswa Belajar</span>
                    <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; flex-shrink: 0; border-radius: 10px; background: #eff6ff; color: var(--primary-blue); display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                </div>
                <div style="font-size: 28px; font-weight: 900; color: var(--primary-blue);">{{ $stats['active_students'] }} Murid</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Aktif Menyelesaikan Modul Kamu</div>
            </div>

        </div>

        <!-- Courses Breakdown -->
        <div class="card-3d" style="padding: 28px; margin-bottom: 32px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h2 style="font-size: 18px; font-weight: 900; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"></path></svg>
                    Daftar Kursus yang Dikelola
                </h2>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                @forelse ($courses as $course)
                    <div style="padding: 20px; border: 1.5px solid #e2e8f0; border-radius: 18px; background: #f8fafc;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; flex-wrap: wrap; gap: 8px;">
                            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--primary-blue); background: #eff6ff; padding: 4px 10px; border-radius: 8px; border: 1px solid #bfdbfe;">
                                {{ $course->category }}
                            </span>
                            <span style="font-size: 12px; font-weight: 800; color: #059669; background: #ecfdf5; padding: 4px 10px; border-radius: 8px;">
                                Target: {{ $course->target_audience }}
                            </span>
                        </div>

                        <h3 style="font-size: 17px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">{{ $course->title }}</h3>
                        <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">{{ $course->description }}</p>

                        <!-- Units & Lessons Breakdown List -->
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach ($course->units as $unit)
                                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: 800; color: #0f172a;">{{ $unit->title }}</div>
                                        <div style="font-size: 11px; color: #64748b;">{{ $unit->lessons->count() }} Modul Pembelajaran</div>
                                    </div>
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                        @foreach ($unit->lessons as $l)
                                            <span style="font-size: 11px; font-weight: 700; color: #334155; background: #f1f5f9; padding: 4px 8px; border-radius: 6px;">
                                                {{ $l->title }} ({{ $l->exercises->count() }} Soal)
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 32px; color: #64748b;">
                        Belum ada kursus yang ditugaskan ke mentor ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Student Progress Monitoring Activity -->
        <div class="card-3d" style="padding: 28px; margin-bottom: 40px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h2 style="font-size: 18px; font-weight: 900; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                    Aktivitas Pengerjaan Siswa Terbaru
                </h2>
                <span style="font-size: 11px; font-weight: 800; color: #64748b;">LOG PENGERJAAN</span>
            </div>

            @if ($recentProgress->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($recentProgress as $prog)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0; flex-wrap: wrap; gap: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="{{ $prog->user->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $prog->user->id }}" style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0;" alt="">
                                <div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $prog->user->name }}</div>
                                    <div style="font-size: 12px; color: #64748b;">
                                        Modul: {{ $prog->lesson->title ?? '-' }} ({{ $prog->lesson->unit->course->title ?? '-' }})
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span style="font-size: 12px; font-weight: 800; color: {{ $prog->score >= 80 ? '#059669' : 'var(--primary-blue)' }}; background: {{ $prog->score >= 80 ? '#ecfdf5' : '#eff6ff' }}; padding: 4px 10px; border-radius: 8px;">
                                    Skor: {{ $prog->score }}/100
                                </span>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">{{ $prog->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 24px; color: #64748b; font-size: 14px;">
                    Belum ada riwayat pengerjaan modul dari siswa.
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
