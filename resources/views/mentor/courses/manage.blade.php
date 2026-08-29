@php
    $title = 'Kelola Kurikulum: ' . $course->title . ' - Kodein';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 960px; margin: 0 auto; width: 100%;">
        
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 28px;">
            <div>
                <a href="{{ route('mentor.courses.index') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Daftar Kursus
                </a>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                    <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 3px 8px; border-radius: 6px;">
                        {{ $course->category }}
                    </span>
                    <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: {{ $course->is_published ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $course->is_published ? '#059669' : '#64748b' }};">
                        {{ $course->is_published ? 'PUBLISHED' : 'DRAFT' }}
                    </span>
                </div>
                <h1 style="font-size: 24px; font-weight: 900; color: #0f172a; margin-top: 4px;">{{ $course->title }}</h1>
            </div>

            <a href="{{ route('learn.index', ['course' => $course->id]) }}" class="btn-3d btn-outline" style="font-size: 13px; padding: 10px 18px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                Preview Roadmap Siswa
            </a>
        </div>

        @if (session('success'))
            <div style="background: #ecfdf5; border: 2px solid #a7f3d0; border-radius: 18px; padding: 14px 20px; margin-bottom: 24px; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 18px; padding: 16px 20px; margin-bottom: 24px; color: #991b1b; font-size: 13px; font-weight: 700;">
                <ul style="margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Unit Form Box -->
        <div class="card-3d" style="padding: 24px; margin-bottom: 32px; background: #eff6ff; border-color: #bfdbfe;">
            <h2 style="font-size: 16px; font-weight: 900; color: var(--primary-blue); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Unit / Bab Baru
            </h2>
            <form action="{{ route('mentor.units.store', $course->id) }}" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap;">
                @csrf
                <input type="text" name="title" required placeholder="Contoh: Unit 3: Struktur Perulangan (Looping)" style="flex: 2; min-width: 260px; padding: 10px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: #ffffff;">
                <input type="text" name="description" placeholder="Deskripsi singkat materi bab..." style="flex: 2; min-width: 240px; padding: 10px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: #ffffff;">
                <button type="submit" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 13px;">
                    + Tambah Unit
                </button>
            </form>
        </div>

        <!-- Units & Lessons Hierarchy List -->
        <div style="display: flex; flex-direction: column; gap: 28px;">
            @forelse ($course->units as $unit)
                <div class="card-3d" style="padding: 24px;">
                    <!-- Unit Header -->
                    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); text-transform: uppercase;">
                                Urutan #{{ $unit->order_index }}
                            </span>
                            <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin-top: 2px;">{{ $unit->title }}</h2>
                            <p style="font-size: 13px; color: #64748b; margin-top: 2px;">{{ $unit->description }}</p>
                        </div>

                        <form action="{{ route('mentor.units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Hapus Unit ini beserta seluruh modul pelajarannya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-3d btn-red" style="padding: 6px 12px; font-size: 11px; border-radius: 10px;">
                                Hapus Unit
                            </button>
                        </form>
                    </div>

                    <!-- Lessons in this Unit -->
                    <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px;">
                        @forelse ($unit->lessons as $lesson)
                            <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 18px;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--primary-blue-light); color: var(--primary-blue); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 900;">
                                            {{ $lesson->order_index }}
                                        </div>
                                        <div>
                                            <div style="font-size: 15px; font-weight: 900; color: #0f172a;">{{ $lesson->title }}</div>
                                            <div style="font-size: 12px; color: #64748b;">Reward: +{{ $lesson->xp_reward }} XP &bull; {{ $lesson->exercises->count() }} Soal Interaktif</div>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 8px;">
                                        <form action="{{ route('mentor.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Hapus modul pelajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-red" style="padding: 6px 10px; font-size: 11px; border-radius: 8px;">
                                                Hapus Modul
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Exercise List in Lesson -->
                                @if ($lesson->exercises->count() > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 14px; padding-left: 42px;">
                                        @foreach ($lesson->exercises as $exIdx => $ex)
                                            <div style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                                                <div style="font-size: 13px; color: #0f172a; font-weight: 600; flex: 1;">
                                                    <span style="font-size: 10px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 2px 6px; border-radius: 4px; margin-right: 6px;">
                                                        {{ strtoupper(str_replace('_', ' ', $ex->question_type)) }}
                                                    </span>
                                                    {{ Str::limit($ex->prompt, 70) }}
                                                </div>
                                                <form action="{{ route('mentor.exercises.destroy', $ex->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 12px; font-weight: 800; padding: 4px 8px;">
                                                        ✕ Hapus Soal
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Add Exercise Toggle & Form (Inline Accordion) -->
                                <details style="padding-left: 42px;">
                                    <summary style="font-size: 12px; font-weight: 800; color: var(--primary-blue); cursor: pointer; user-select: none;">
                                        + Tambah Soal Kuis ke Modul Ini
                                    </summary>
                                    <form action="{{ route('mentor.exercises.store', $lesson->id) }}" method="POST" style="margin-top: 12px; background: #ffffff; padding: 16px; border-radius: 12px; border: 1.5px solid #cbd5e1; display: flex; flex-direction: column; gap: 12px;">
                                        @csrf
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                            <div>
                                                <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">TIPE SOAL</label>
                                                <select name="question_type" required style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700;">
                                                    <option value="multiple_choice">Pilihan Ganda (Multiple Choice)</option>
                                                    <option value="fill_blank">Isian Kosong (Fill in the Blank)</option>
                                                    <option value="output_prediction">Tebak Output Kode (Output Prediction)</option>
                                                    <option value="code_ordering">Susun Potongan Kode (Parsons Problem)</option>
                                                    <option value="matching_pair">Cocokkan Pasangan (Matching Pair)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">KUNCI JAWABAN BENAR</label>
                                                <input type="text" name="answer_raw" required placeholder="Contoh: print / 17 / Option A" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600;">
                                            </div>
                                        </div>

                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">PERTANYAAN / INSTRUKSI</label>
                                            <textarea name="prompt" required rows="2" placeholder="Tulis instruksi atau pertanyaan untuk siswa..." style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600;"></textarea>
                                        </div>

                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">POTONGAN KODE (OPSIONAL)</label>
                                            <textarea name="code_snippet" rows="2" class="code-font" placeholder="Contoh: x = 10\nprint(x)" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px;"></textarea>
                                        </div>

                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">PILIHAN JAWABAN / BARIS SUSUN / PASANGAN (1 per baris)</label>
                                            <textarea name="options_raw" rows="3" placeholder="Pilihan ganda: Tulis 1 pilihan per baris.&#10;Pasangan: Tulis Kiri => Kanan (contoh: int => 17)" style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600;"></textarea>
                                        </div>

                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 4px;">PENJELASAN SAAT SISWA MENJAWAB (OPSIONAL)</label>
                                            <input type="text" name="explanation" placeholder="Penjelasan konsep yang benar..." style="width: 100%; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px;">
                                        </div>

                                        <button type="submit" class="btn-3d btn-blue" style="padding: 10px 16px; font-size: 12px; align-self: flex-start;">
                                            Simpan Soal Latihan
                                        </button>
                                    </form>
                                </details>

                            </div>
                        @empty
                            <div style="font-size: 13px; color: #64748b; font-style: italic; padding: 10px 0;">
                                Belum ada modul pelajaran di unit ini.
                            </div>
                        @endforelse
                    </div>

                    <!-- Add Lesson Form inside Unit -->
                    <div style="background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 14px; padding: 16px;">
                        <h3 style="font-size: 13px; font-weight: 900; color: #0f172a; margin-bottom: 10px;">+ Tambah Modul Pelajaran ke {{ $unit->title }}</h3>
                        <form action="{{ route('mentor.lessons.store', $unit->id) }}" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            @csrf
                            <input type="text" name="title" required placeholder="Judul Modul (Contoh: Pengenalan Loop For)" style="flex: 2; min-width: 220px; padding: 8px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none;">
                            <input type="number" name="xp_reward" value="20" min="5" max="100" placeholder="XP" style="width: 70px; padding: 8px 10px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 700; outline: none;">
                            <button type="submit" class="btn-3d btn-outline" style="padding: 8px 16px; font-size: 12px;">
                                Simpan Modul
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="card-3d" style="padding: 40px; text-align: center; color: #64748b;">
                    Belum ada unit pelajaran yang dibuat. Silakan tambahkan Unit 1 di atas!
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
