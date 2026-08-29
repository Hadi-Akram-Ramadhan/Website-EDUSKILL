@php
    $title = 'Manajemen Kursus Saya - Mentor EduSkill';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 1060px; margin: 0 auto; width: 100%;">
        
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
            <div>
                <a href="{{ route('mentor.dashboard') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Dashboard Mentor
                </a>
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Daftar Kursus yang Saya Ampu</h1>
                <p style="color: #64748b; font-size: 14px;">Kelola silabus, tambah unit, modul pelajaran, dan soal latihan interaktif.</p>
            </div>

            <a href="{{ route('mentor.courses.create') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 12px 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Buat Kursus Baru
            </a>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse ($courses as $c)
                <div class="card-3d" style="padding: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 1; min-width: 280px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 3px 8px; border-radius: 6px;">
                                {{ $c->category }}
                            </span>
                            <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: {{ $c->is_published ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $c->is_published ? '#059669' : '#64748b' }};">
                                {{ $c->is_published ? 'PUBLISHED' : 'DRAFT' }}
                            </span>
                        </div>
                        <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">{{ $c->title }}</h2>
                        <div style="font-size: 13px; color: #64748b;">
                            {{ $c->units->count() }} Unit &bull; 
                            {{ $c->units->flatMap->lessons->count() }} Modul Pelajaran &bull;
                            {{ $c->units->flatMap->lessons->flatMap->exercises->count() }} Soal Interaktif
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ route('mentor.courses.manage', $c->id) }}" class="btn-3d btn-blue" style="padding: 10px 16px; font-size: 12px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            Kelola Unit &amp; Modul Soal
                        </a>

                        <a href="{{ route('mentor.courses.edit', $c->id) }}" class="btn-3d btn-outline" style="padding: 10px 14px; font-size: 12px;">
                            Edit Info
                        </a>

                        <form action="{{ route('mentor.courses.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kursus ini beserta seluruh materi di dalamnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-3d btn-red" style="padding: 10px 14px; font-size: 12px;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card-3d" style="padding: 40px; text-align: center; color: #64748b;">
                    <p style="margin-bottom: 16px;">Anda belum memiliki kursus yang diampu.</p>
                    <a href="{{ route('mentor.courses.create') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 12px 24px;">
                        Mulai Buat Kursus Pertama Anda
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
