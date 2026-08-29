@php
    $title = 'Edit Kursus: ' . $course->title . ' - Super Admin';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 680px; margin: 0 auto; width: 100%;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('admin.courses.index') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kembali ke Daftar Kursus
            </a>
            <h1 style="font-size: 24px; font-weight: 900; color: #0f172a;">Edit Kursus</h1>
            <p style="color: #64748b; font-size: 14px;">Ubah data kursus dan mentor pengampu.</p>
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
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 18px;">
                @csrf
                @method('PUT')

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Guru / Mentor Pengampu</label>
                    <select name="mentor_id" required style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 700; color: #0f172a; outline: none; background: #ffffff;">
                        @foreach ($mentors as $m)
                            <option value="{{ $m->id }}" {{ old('mentor_id', $course->mentor_id) == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->role }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Judul Kursus</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" required style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Kategori Singkat</label>
                        <input type="text" name="category" value="{{ old('category', $course->category) }}" required style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Tingkat Kesulitan</label>
                        <select name="level" required style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 700; color: #0f172a; outline: none; background: #ffffff;">
                            <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Pemula (Beginner)</option>
                            <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Menengah (Intermediate)</option>
                            <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Lanjutan (Advanced)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 12px 16px; border: 2px solid #cbd5e1; border-radius: 14px; font-size: 14px; font-weight: 600; outline: none;">{{ old('description', $course->description) }}</textarea>
                </div>

                <div style="display: flex; align-items: center; gap: 10px; padding: 10px 0;">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $course->is_published) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-blue);">
                    <label for="is_published" style="font-size: 14px; font-weight: 800; color: #0f172a; cursor: pointer;">Publikasikan kursus ini agar aktif</label>
                </div>

                <div style="margin-top: 10px; display: flex; gap: 12px;">
                    <button type="submit" class="btn-3d btn-blue" style="flex: 1; padding: 14px;">
                        Perbarui Kursus
                    </button>
                    <a href="{{ route('admin.courses.index') }}" class="btn-3d btn-outline" style="padding: 14px 20px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
