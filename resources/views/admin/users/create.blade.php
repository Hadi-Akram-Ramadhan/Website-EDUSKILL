@php
    $title = 'Tambah Pengguna Baru - Super Admin Kodein';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 640px; margin: 0 auto; width: 100%;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('admin.users.index') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Daftar Pengguna
            </a>
            <h1 style="font-size: 24px; font-weight: 900; color: #0f172a;">Tambah Pengguna Baru</h1>
            <p style="color: #64748b; font-size: 14px;">Daftarkan akun Siswa, Guru, atau Super Admin baru ke platform.</p>
        </div>

        @if ($errors->any())
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 18px; padding: 16px 20px; margin-bottom: 24px; color: #991b1b; font-size: 13px; font-weight: 700;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-3d" style="padding: 28px;">
            <form action="{{ route('admin.users.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
                @csrf

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="budi@sekolah.sch.id" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Role Akun</label>
                    <select name="role" required style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 700; color: #0f172a; outline: none; background: #ffffff;">
                        <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa (Pelajar)</option>
                        <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru / Mentor</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Gems Awal</label>
                        <input type="number" name="gems" value="{{ old('gems', 100) }}" min="0" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Nyawa (Maks 5)</label>
                        <input type="number" name="hearts" value="{{ old('hearts', 5) }}" min="1" max="5" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; gap: 12px;">
                    <button type="submit" class="btn-3d btn-blue" style="flex: 1; padding: 14px;">
                        Simpan Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-3d btn-outline" style="padding: 14px 20px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
