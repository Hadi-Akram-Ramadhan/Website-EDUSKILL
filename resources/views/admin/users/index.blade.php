@php
    $title = 'Manajemen Pengguna - Super Admin EduSkill';
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
                <h1 style="font-size: 26px; font-weight: 900; color: #0f172a;">Manajemen Pengguna</h1>
                <p style="color: #64748b; font-size: 14px;">Kelola akun Siswa, Guru/Mentor, dan Super Admin di platform EduSkill.</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn-3d btn-blue" style="font-size: 13px; padding: 12px 20px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Pengguna Baru
            </a>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #991b1b; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="card-3d" style="padding: 18px 20px; margin-bottom: 24px;">
            <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 14px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap; flex: 1;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." style="padding: 10px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; min-width: 240px; outline: none; flex: 1;">
                    
                    <select name="role" style="padding: 10px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 700; color: #0f172a; outline: none; background: #ffffff;">
                        <option value="">Semua Role</option>
                        <option value="siswa" {{ request('role') === 'siswa' ? 'selected' : '' }}>Siswa ({{ $stats['students'] }})</option>
                        <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru / Mentor ({{ $stats['mentors'] }})</option>
                        <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin ({{ $stats['admins'] }})</option>
                    </select>

                    <button type="submit" class="btn-3d btn-blue" style="padding: 10px 18px; font-size: 13px;">
                        Filter
                    </button>
                    @if (request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="btn-3d btn-outline" style="padding: 10px 14px; font-size: 13px;">
                            Reset
                        </a>
                    @endif
                </div>

                <div style="font-size: 12px; font-weight: 800; color: #64748b;">
                    TOTAL: {{ $users->total() }} PENGGUNA
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="card-3d" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th style="padding: 16px 20px;">Pengguna</th>
                            <th style="padding: 16px 20px;">Role</th>
                            <th style="padding: 16px 20px;">Statistik Belajar</th>
                            <th style="padding: 16px 20px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;">
                                <td style="padding: 16px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <img src="{{ $u->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . $u->id }}" style="width: 40px; height: 40px; min-width: 40px; min-height: 40px; flex-shrink: 0; border-radius: 50%; object-fit: cover; background: #f1f5f9; border: 1.5px solid #e2e8f0;" alt="">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 800; color: #0f172a;">{{ $u->name }}</div>
                                            <div style="font-size: 12px; color: #64748b;">{{ $u->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 8px; background: {{ $u->role === 'guru' ? '#dbeafe' : ($u->role === 'super_admin' ? '#f3e8ff' : '#ecfdf5') }}; color: {{ $u->role === 'guru' ? '#1d4ed8' : ($u->role === 'super_admin' ? '#7e22ce' : '#047857') }};">
                                        {{ $u->role === 'super_admin' ? 'Super Admin' : ($u->role === 'guru' ? 'Guru/Mentor' : 'Siswa') }}
                                    </span>
                                </td>
                                <td style="padding: 16px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; font-weight: 700;">
                                        <span style="color: var(--primary-blue); display: inline-flex; align-items: center; gap: 4px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            {{ number_format($u->xp) }} XP
                                        </span>
                                        <span style="color: var(--accent-orange); display: inline-flex; align-items: center; gap: 4px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                                            {{ $u->streak_count }}d
                                        </span>
                                        <span style="color: var(--accent-red); display: inline-flex; align-items: center; gap: 4px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path></svg>
                                            {{ $u->hearts }}/5
                                        </span>
                                        <span style="color: #0284c7; display: inline-flex; align-items: center; gap: 4px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"></path><path d="M11 3 8 9l4 13 4-13-3-6"></path><path d="M2 9h20"></path></svg>
                                            {{ $u->gems }}
                                        </span>
                                    </div>
                                </td>
                                <td style="padding: 16px 20px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn-3d btn-outline" style="padding: 8px 12px; font-size: 11px; border-radius: 10px;">
                                            Edit
                                        </a>
                                        @if ($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-3d btn-red" style="padding: 8px 12px; font-size: 11px; border-radius: 10px;">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 36px; color: #64748b; font-size: 14px;">
                                    Tidak ada pengguna yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div style="padding: 16px 20px; border-top: 2px solid #e2e8f0; background: #f8fafc;">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
