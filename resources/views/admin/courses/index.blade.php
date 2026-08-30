@php
    $title = 'Master Kontrol Kursus - Super Admin';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 1060px; margin: 0 auto; width: 100%;">
        
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
            <div>
                <a href="{{ route('admin.dashboard') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Dashboard
                </a>
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Master Kurikulum &amp; Kursus</h1>
                <p style="color: #64748b; font-size: 14px;">Kelola semua topik kursus yang tersedia di platform EduSkill.</p>
            </div>

            <a href="{{ route('admin.courses.create') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 12px 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Kursus Baru
            </a>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Courses Grid -->
        <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px;">
            @forelse ($courses as $c)
                <div class="card-3d" style="padding: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    <div style="flex: 1; min-width: 280px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 3px 8px; border-radius: 6px;">
                                {{ $c->category }}
                            </span>
                            @if (!$c->is_published)
                                <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #94a3b8;"></span>
                                    DRAFT (DIARSIPKAN)
                                </span>
                            @elseif ($c->is_upcoming)
                                <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b;"></span>
                                    ROADMAP MENDATANG
                                </span>
                            @else
                                <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                                    AKTIF (SIAP BELAJAR)
                                </span>
                            @endif
                        </div>
                        <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">{{ $c->title }}</h2>
                        <div style="font-size: 13px; color: #64748b;">
                            Mentor: <strong style="color: #0f172a;">{{ $c->mentor->name ?? 'Belum Ditugaskan' }}</strong> &bull; 
                            {{ $c->units->count() }} Unit &bull; 
                            {{ $c->units->flatMap->lessons->count() }} Modul Pelajaran
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <form action="{{ route('admin.courses.toggle-publish', $c->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-3d {{ $c->is_published ? 'btn-outline' : 'btn-green' }}" style="padding: 10px 14px; font-size: 12px;">
                                {{ $c->is_published ? 'Arsipkan (Draft)' : 'Publikasikan' }}
                            </button>
                        </form>

                        <a href="{{ route('mentor.courses.manage', $c->id) }}" class="btn-3d btn-blue" style="padding: 10px 14px; font-size: 12px;">
                            Kelola Kurikulum
                        </a>

                        <a href="{{ route('admin.courses.edit', $c->id) }}" class="btn-3d btn-outline" style="padding: 10px 14px; font-size: 12px;">
                            Edit
                        </a>

                        <form action="{{ route('admin.courses.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kursus ini beserta seluruh unit dan modulnya?')">
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
                    Belum ada kursus yang dibuat di platform.
                </div>
            @endforelse
        </div>

        @if ($courses->hasPages())
            <div style="padding: 16px 20px; border-top: 2px solid #e2e8f0; background: #ffffff; border-radius: 16px;">
                {{ $courses->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
