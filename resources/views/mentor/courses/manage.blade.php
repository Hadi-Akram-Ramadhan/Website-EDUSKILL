@php
    $title = 'Kelola Kurikulum: ' . $course->title . ' - EduSkill';
@endphp

<x-app-layout :title="$title">
    <div style="max-width: 960px; margin: 0 auto; width: 100%;">
        
        <!-- Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
            <div>
                <a href="{{ route('mentor.courses.index') }}" style="font-size: 12px; font-weight: 800; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Daftar Kursus
                </a>
                <div style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                    <span style="font-size: 11px; font-weight: 800; color: var(--primary-blue); background: #eff6ff; padding: 3px 8px; border-radius: 6px;">
                        {{ $course->category }}
                    </span>
                    @if (!$course->is_published)
                        <span style="font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #94a3b8;"></span>
                            DRAFT (DIARSIPKAN)
                        </span>
                    @elseif ($course->is_upcoming)
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
                <h1 style="font-size: 24px; font-weight: 900; color: #0f172a; margin-top: 4px;">{{ $course->title }}</h1>
            </div>

            <!-- Quick Action Hub -->
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="downloadXlsxTemplate(event)" class="btn-3d btn-green" style="font-size: 12px; padding: 10px 16px; cursor: pointer;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Download Template Excel (.xlsx)
                </button>

                <a href="{{ route('learn.index', ['course_id' => $course->id]) }}" class="btn-3d btn-outline" style="font-size: 12px; padding: 10px 16px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    Roadmap Siswa
                </a>
            </div>
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

        <!-- Quick Import Banner Card -->
        <div class="card-3d" style="padding: 20px 24px; margin-bottom: 28px; background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%); border-color: #bfdbfe; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; flex-shrink: 0; border-radius: 14px; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 0 #1e40af;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 900; color: #0f172a; margin-bottom: 2px;">Ingin Tambah Banyak Soal Sekaligus?</h2>
                    <p style="font-size: 13px; color: #64748b;">Gunakan fitur import Excel (.xlsx) / CSV untuk memasukkan puluhan soal interaktif dalam sekali klik.</p>
                </div>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="downloadXlsxTemplate(event)" class="btn-3d btn-green" style="font-size: 12px; padding: 10px 16px; cursor: pointer;">
                    1. Download Template Excel (.xlsx)
                </button>
                <button type="button" onclick="downloadCsvTemplate(event)" class="btn-3d btn-outline" style="font-size: 12px; padding: 10px 14px; background: #ffffff; cursor: pointer;">
                    Format CSV
                </button>
            </div>
        </div>

        <!-- Add Unit Form Box -->
        <div class="card-3d" style="padding: 24px; margin-bottom: 32px; background: #ffffff; border-color: #cbd5e1;">
            <h2 style="font-size: 16px; font-weight: 900; color: var(--primary-blue); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Unit / Bab Baru
            </h2>
            <form action="{{ route('mentor.units.store', $course->id) }}" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap;">
                @csrf
                <input type="text" name="title" required placeholder="Contoh: Unit 3: Struktur Perulangan (Looping)" style="flex: 2; min-width: 260px; padding: 11px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: #ffffff;">
                <input type="text" name="description" placeholder="Deskripsi singkat materi bab..." style="flex: 2; min-width: 240px; padding: 11px 16px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none; background: #ffffff;">
                <button type="submit" class="btn-3d btn-blue" style="padding: 11px 22px; font-size: 13px;">
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
                                Urutan Bab #{{ $unit->order_index }}
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
                    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">
                        @forelse ($unit->lessons as $lesson)
                            <div style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 18px; padding: 20px;">
                                
                                <!-- Lesson Header Bar -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; border-radius: 10px; background: {{ ($lesson->is_project || $lesson->type === 'project') ? '#fef3c7' : 'var(--primary-blue-light)' }}; color: {{ ($lesson->is_project || $lesson->type === 'project') ? '#b45309' : 'var(--primary-blue)' }}; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 900; box-shadow: 0 2px 0 {{ ($lesson->is_project || $lesson->type === 'project') ? '#fde68a' : '#bfdbfe' }}; flex-shrink: 0;">
                                            @if ($lesson->is_project || $lesson->type === 'project')
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            @else
                                                {{ $lesson->order_index }}
                                            @endif
                                        </div>
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span style="font-size: 16px; font-weight: 900; color: #0f172a;">{{ $lesson->title }}</span>
                                                @if ($lesson->is_project || $lesson->type === 'project')
                                                    <span style="font-size: 10px; font-weight: 900; color: #7e22ce; background: #f3e8ff; border: 1.5px solid #d8b4fe; padding: 2px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                        MINI PROJECT (PROYEK AKHIR)
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px;">
                                                Reward: <span style="color: var(--primary-blue); font-weight: 800;">+{{ $lesson->xp_reward }} XP</span> &bull; 
                                                <span style="color: #059669; font-weight: 800;">{{ $lesson->exercises->count() }} Soal / Tantangan</span>
                                                @if ($lesson->project_brief)
                                                    &bull; <span style="color: #475569; font-style: italic;">"{{ Str::limit($lesson->project_brief, 50) }}"</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <!-- Open Import Modal Button for this Lesson -->
                                        <button type="button" class="btn-3d btn-outline" onclick="openImportModal({{ $lesson->id }}, '{{ addslashes($lesson->title) }}')" style="padding: 8px 14px; font-size: 12px; border-radius: 10px; background: #ffffff;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                            Import Excel ke Modul Ini
                                        </button>

                                        <form action="{{ route('mentor.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Hapus modul pelajaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-red" style="padding: 8px 12px; font-size: 12px; border-radius: 10px;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Exercise List in Lesson -->
                                @if ($lesson->exercises->count() > 0)
                                    <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                                        @foreach ($lesson->exercises as $exIdx => $ex)
                                            @php
                                                $typeBadgeBg = match($ex->question_type) {
                                                    'multiple_choice' => '#eff6ff',
                                                    'fill_blank' => '#fef3c7',
                                                    'output_prediction' => '#f3e8ff',
                                                    'code_ordering' => '#ecfdf5',
                                                    'matching_pair' => '#fff1f2',
                                                    default => '#f1f5f9'
                                                };
                                                $typeBadgeColor = match($ex->question_type) {
                                                    'multiple_choice' => '#2563eb',
                                                    'fill_blank' => '#b45309',
                                                    'output_prediction' => '#7e22ce',
                                                    'code_ordering' => '#047857',
                                                    'matching_pair' => '#be123c',
                                                    default => '#475569'
                                                };
                                                $typeLabel = match($ex->question_type) {
                                                    'multiple_choice' => 'PILIHAN GANDA',
                                                    'fill_blank' => 'ISIAN KOSONG',
                                                    'output_prediction' => 'TEBAK OUTPUT',
                                                    'code_ordering' => 'PARSONS (SUSUN KODE)',
                                                    'matching_pair' => 'COCOKKAN PASANGAN',
                                                    default => strtoupper($ex->question_type)
                                                };
                                            @endphp
                                            <div style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; padding: 12px 16px; border-radius: 12px; border: 1.5px solid #e2e8f0; gap: 12px;">
                                                <div style="font-size: 13px; color: #0f172a; font-weight: 600; flex: 1; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                    <span style="font-size: 10px; font-weight: 800; color: {{ $typeBadgeColor }}; background: {{ $typeBadgeBg }}; padding: 3px 8px; border-radius: 6px; flex-shrink: 0;">
                                                        {{ $typeLabel }}
                                                    </span>
                                                    <span style="flex: 1; min-width: 200px;">{{ $ex->prompt }}</span>
                                                </div>
                                                <form action="{{ route('mentor.exercises.destroy', $ex->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 12px; font-weight: 800; padding: 4px 8px; border-radius: 6px;" title="Hapus Soal">
                                                        ✕ Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Interactive Dynamic Exercise Builder Accordion -->
                                <details class="exercise-builder-details" style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 16px; padding: 16px;">
                                    <summary style="font-size: 13px; font-weight: 800; color: var(--primary-blue); cursor: pointer; user-select: none; display: flex; align-items: center; gap: 8px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        + Buat Soal Baru Secara Interaktif di Modul Ini
                                    </summary>

                                    <form action="{{ route('mentor.exercises.store', $lesson->id) }}" method="POST" class="exercise-form" style="margin-top: 16px; display: flex; flex-direction: column; gap: 16px;">
                                        @csrf

                                        <!-- Question Type Switcher -->
                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 8px;">PILIH TIPE SOAL INTERAKTIF</label>
                                            <div class="type-selector-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 10px;">
                                                
                                                <label class="type-card-label">
                                                    <input type="radio" name="question_type" value="multiple_choice" checked onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                    <div class="type-card-content">
                                                        <div class="type-card-title">Pilihan Ganda</div>
                                                        <div class="type-card-desc">Pilihan A, B, C, D</div>
                                                    </div>
                                                </label>

                                                <label class="type-card-label">
                                                    <input type="radio" name="question_type" value="fill_blank" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                    <div class="type-card-content">
                                                        <div class="type-card-title">Isian Kosong</div>
                                                        <div class="type-card-desc">Isi celah titik-titik kode</div>
                                                    </div>
                                                </label>

                                                <label class="type-card-label">
                                                    <input type="radio" name="question_type" value="output_prediction" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                    <div class="type-card-content">
                                                        <div class="type-card-title">Tebak Output</div>
                                                        <div class="type-card-desc">Tebak hasil cetak kode</div>
                                                    </div>
                                                </label>

                                                <label class="type-card-label">
                                                    <input type="radio" name="question_type" value="code_ordering" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                    <div class="type-card-content">
                                                        <div class="type-card-title">Susun Kode (Parsons)</div>
                                                        <div class="type-card-desc">Puzzle urutan baris kode</div>
                                                    </div>
                                                </label>

                                                <label class="type-card-label">
                                                    <input type="radio" name="question_type" value="matching_pair" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                    <div class="type-card-content">
                                                        <div class="type-card-title">Cocokkan Pasangan</div>
                                                        <div class="type-card-desc">Jodohkan item Kiri &bull; Kanan</div>
                                                    </div>
                                                </label>

                                            </div>
                                        </div>

                                        <!-- Common Prompt Field -->
                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Pertanyaan / Instruksi Soal</label>
                                            <textarea name="prompt" required rows="2" placeholder="Tuliskan pertanyaan atau instruksi yang jelas bagi siswa..." style="width: 100%; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;"></textarea>
                                        </div>

                                        <!-- Optional Code Snippet -->
                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Potongan Baris Kode (Opsional)</label>
                                            <textarea name="code_snippet" rows="2" class="code-font" placeholder="Contoh: nama = 'Andi'\nprint('Halo ' + nama)" style="width: 100%; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 13px; font-weight: 600; outline: none; background: #f8fafc;"></textarea>
                                        </div>

                                        <!-- Dynamic Section 1: Multiple Choice Options -->
                                        <div id="section-mc-{{ $lesson->id }}" class="type-section" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                            <div style="font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">
                                                PILIHAN JAWABAN (Centang Radio untuk Kunci Jawaban yang Benar):
                                            </div>
                                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                                @foreach (['A', 'B', 'C', 'D'] as $idx => $opt)
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <input type="radio" name="correct_choice_radio_{{ $lesson->id }}" value="{{ $idx }}" {{ $idx === 0 ? 'checked' : '' }} onchange="updateCorrectChoice(this, '{{ $lesson->id }}')" style="width: 18px; height: 18px; accent-color: #10b981;">
                                                        <span style="font-weight: 800; font-size: 13px; color: #64748b; width: 20px;">{{ $opt }}.</span>
                                                        <input type="text" name="options[]" placeholder="Isi pilihan {{ $opt }}..." value="{{ $idx === 0 ? 'Opsi Jawaban Benar' : '' }}" class="mc-input-{{ $lesson->id }}" oninput="syncRadioValues('{{ $lesson->id }}')" style="flex: 1; padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none; background: #ffffff;">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="correct_choice" id="correct_choice_hidden_{{ $lesson->id }}" value="Opsi Jawaban Benar">
                                        </div>

                                        <!-- Dynamic Section 2: Fill Blank -->
                                        <div id="section-fill-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                            <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">KUNCI KATA/FUNGSI YANG HARUS DIISI</label>
                                            <input type="text" name="answer_raw" placeholder="Contoh: print" style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 700; outline: none; background: #ffffff; margin-bottom: 12px;">
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 6px;">PILIHAN DISTRAKTOR LAINNYA (1 per baris)</label>
                                            <textarea name="options_raw" rows="3" placeholder="echo&#10;input&#10;write" style="width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none; background: #ffffff;"></textarea>
                                        </div>

                                        <!-- Dynamic Section 3: Parsons Code Ordering -->
                                        <div id="section-ordering-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                <span style="font-size: 12px; font-weight: 800; color: #0f172a;">BARIS KODE PUZZLE (Tuliskan dalam urutan yang BENAR dari atas ke bawah):</span>
                                                <button type="button" onclick="addOrderingRow('{{ $lesson->id }}')" style="background: var(--primary-blue-light); color: var(--primary-blue); border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">+ Tambah Baris</button>
                                            </div>
                                            <div id="ordering-rows-container-{{ $lesson->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px;">#1</span>
                                                    <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-1 (Contoh: umur = 15)" style="flex: 1; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                </div>
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px;">#2</span>
                                                    <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-2 (Contoh: print('Umur saya:'))" style="flex: 1; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                </div>
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px;">#3</span>
                                                    <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-3 (Contoh: print(umur))" style="flex: 1; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dynamic Section 4: Matching Pairs -->
                                        <div id="section-matching-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                <span style="font-size: 12px; font-weight: 800; color: #0f172a;">PASANGAN MENJODOHKAN (Item Kiri &bull; Item Kanan):</span>
                                                <button type="button" onclick="addMatchingRow('{{ $lesson->id }}')" style="background: var(--primary-blue-light); color: var(--primary-blue); border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">+ Tambah Pasangan</button>
                                            </div>
                                            <div id="matching-rows-container-{{ $lesson->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                                <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                    <input type="text" name="pair_keys[]" placeholder="Item Kiri (contoh: int)" style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                                                    <span style="font-size: 13px; color: #64748b; font-weight: 800;">&harr;</span>
                                                    <input type="text" name="pair_values[]" placeholder="Pasangan Kanan (contoh: 17)" style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                                                </div>
                                                <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;">
                                                    <input type="text" name="pair_keys[]" placeholder="Item Kiri (contoh: str)" style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                                                    <span style="font-size: 13px; color: #64748b; font-weight: 800;">&harr;</span>
                                                    <input type="text" name="pair_values[]" placeholder="Pasangan Kanan (contoh: 'Belajar')" style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Explanation Field -->
                                        <div>
                                            <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Penjelasan / Pembahasan Konsep (Muncul Saat Siswa Menjawab)</label>
                                            <input type="text" name="explanation" placeholder="Contoh: print() adalah perintah standar Python untuk menampilkan nilai ke layar." style="width: 100%; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 13px; outline: none;">
                                        </div>

                                        <button type="submit" class="btn-3d btn-blue" style="padding: 12px 24px; font-size: 13px; align-self: flex-start;">
                                            Simpan Soal ke Modul Ini
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
                    <div style="background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 18px;">
                        <h3 style="font-size: 14px; font-weight: 900; color: #0f172a; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Tambah Modul Pelajaran / Mini Project ke {{ $unit->title }}
                        </h3>
                        <form action="{{ route('mentor.lessons.store', $unit->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 12px;">
                            @csrf
                            
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <input type="text" name="title" required placeholder="Judul Modul (Contoh: Mini Project: Program Kasir Sederhana)" style="flex: 2; min-width: 240px; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none;">
                                <input type="number" name="xp_reward" id="xp_reward_{{ $unit->id }}" value="20" min="5" max="100" placeholder="XP" style="width: 80px; padding: 10px 12px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 700; outline: none;" title="Reward XP">
                            </div>

                            <!-- Mini Project Checkbox Option -->
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; background: #f8fafc; padding: 10px 14px; border-radius: 10px; border: 1.5px solid #e2e8f0;">
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 800; color: #0f172a; cursor: pointer;">
                                    <input type="checkbox" name="is_project" value="1" onchange="toggleProjectBrief(this, '{{ $unit->id }}')" style="width: 18px; height: 18px; accent-color: #7e22ce;">
                                    <span style="color: #7e22ce;">⭐ Jadikan Mini Project (Proyek Akhir Bab)</span>
                                </label>
                                <span style="font-size: 11px; color: #64748b;">(Proyek penentu evaluasi sebelum melangkah ke bab berikutnya / klaim sertifikat)</span>
                            </div>

                            <!-- Optional Project Brief (Hidden by default until checked) -->
                            <div id="project_brief_box_{{ $unit->id }}" style="display: none;">
                                <label style="display: block; font-size: 11px; font-weight: 800; color: #7e22ce; text-transform: uppercase; margin-bottom: 4px;">Instruksi Brief Tugas Proyek Siswa</label>
                                <textarea name="project_brief" rows="2" placeholder="Contoh: Buatlah program kasir sederhana dengan variabel total belanja, logika diskon if-else, dan cetak struk pembayaran." style="width: 100%; padding: 10px 14px; border: 1.5px solid #d8b4fe; border-radius: 10px; font-size: 13px; outline: none; background: #faf5ff;"></textarea>
                            </div>

                            <button type="submit" class="btn-3d btn-outline" style="padding: 10px 20px; font-size: 12px; align-self: flex-start;">
                                Simpan Modul Pelajaran
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

    <!-- Excel / CSV Import Modal Dialog -->
    <div id="import-modal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; padding: 20px;">
        <div class="card-3d" style="background: #ffffff; max-width: 540px; width: 100%; padding: 28px; border-radius: 24px; position: relative;">
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 18px; font-weight: 900; color: #0f172a;">Import Soal dari Excel / CSV</h2>
                        <span id="import-target-label" style="font-size: 12px; color: var(--primary-blue); font-weight: 700;">Modul Target</span>
                    </div>
                </div>
                <button type="button" onclick="closeImportModal()" style="background: none; border: none; font-size: 20px; color: #94a3b8; cursor: pointer; padding: 4px 8px;">✕</button>
            </div>

            <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 14px;">
                Unggah file spreadsheet (.xlsx / .csv) berisi soal latihan. Sistem otomatis mendukung 5 jenis soal (Pilihan Ganda, Isian, Tebak Output, Susun Baris Kode/Parsons, dan Pasangan).
            </p>

            <!-- Interactive Guide Accordion Inside Modal -->
            <details style="margin-bottom: 16px; background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 14px; padding: 12px 16px;">
                <summary style="font-size: 13px; font-weight: 800; color: var(--primary-blue); cursor: pointer; display: flex; align-items: center; gap: 8px; user-select: none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Lihat Panduan Singkat Format Kolom & 5 Jenis Soal
                </summary>
                <div style="margin-top: 12px; font-size: 12px; color: #334155; display: flex; flex-direction: column; gap: 8px;">
                    <div style="background: #ffffff; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;">1. Pilihan Ganda (multiple_choice):</strong><br>
                        <code>options:</code> Pilihan dipisah tanda pipa (contoh: <code>A|B|C|D</code>)<br>
                        <code>answer:</code> Tulis salah satu pilihan yang tepat persis.
                    </div>
                    <div style="background: #ffffff; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;">2. Isian Singkat (fill_blank):</strong><br>
                        <code>code_snippet:</code> Beri tanda rumpang <code>____</code> (4 garis bawah)<br>
                        <code>options:</code> Kata pengisi dipisah <code>|</code> &bull; <code>answer:</code> Kata jawaban yang tepat.
                    </div>
                    <div style="background: #ffffff; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;">3. Tebak Output (output_prediction):</strong><br>
                        <code>code_snippet:</code> Kode program &bull; <code>options:</code> Opsi tebakan dipisah <code>|</code> &bull; <code>answer:</code> Hasil output program.
                    </div>
                    <div style="background: #ffffff; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;">4. Susun Kode / Parsons (code_ordering):</strong><br>
                        <code>options:</code> Baris kode acak dipisah <code>|</code> &bull; <code>answer:</code> Urutan nomor index yang benar (contoh: <code>1|2|3</code>).
                    </div>
                    <div style="background: #ffffff; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong style="color: #0f172a;">5. Pasangan Kiri-Kanan (matching_pair):</strong><br>
                        <code>options:</code> dan <code>answer:</code> Format pasangan <code>Kiri => Kanan</code> dipisah <code>|</code> (contoh: <code>int => Angka|str => Teks</code>).
                    </div>
                </div>
            </details>

            <form id="import-form" action="" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px;">
                @csrf
                
                <div style="border: 2px dashed #cbd5e1; border-radius: 16px; padding: 24px; text-align: center; background: #f8fafc; cursor: pointer;" onclick="document.getElementById('import-file-input').click()">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" style="margin: 0 auto 8px auto;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                    <div style="font-size: 14px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">Klik untuk Pilih File Spreadsheet</div>
                    <div style="font-size: 12px; color: #64748b;">Format didukung: .csv, .xlsx, .xls, .txt (Maks 5 MB)</div>
                    <input type="file" name="file" id="import-file-input" required accept=".csv,.xlsx,.xls,.txt" style="display: none;" onchange="handleFileSelected(this)">
                    <div id="selected-file-name" style="margin-top: 10px; font-size: 13px; font-weight: 800; color: var(--primary-blue); display: none;"></div>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center; flex-wrap: wrap; margin-top: 6px;">
                    <button type="button" onclick="downloadXlsxTemplate(event)" class="btn-3d btn-green" style="padding: 10px 14px; font-size: 12px; cursor: pointer;">
                        Format Excel (.xlsx) + Panduan
                    </button>
                    <button type="button" onclick="downloadCsvTemplate(event)" class="btn-3d btn-outline" style="padding: 10px 14px; font-size: 12px; cursor: pointer; background: #ffffff;">
                        Format CSV
                    </button>
                    <button type="submit" class="btn-3d btn-blue" style="padding: 10px 20px; font-size: 12px;">
                        Mulai Import Sekarang
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- UI Logic & Style -->
    <style>
        .type-card-label {
            cursor: pointer;
        }
        .type-card-label input {
            display: none;
        }
        .type-card-content {
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            padding: 10px 12px;
            background: #ffffff;
            transition: all 0.15s ease;
        }
        .type-card-title {
            font-size: 12px;
            font-weight: 800;
            color: #0f172a;
        }
        .type-card-desc {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .type-card-label input:checked + .type-card-content {
            border-color: var(--primary-blue);
            background: #eff6ff;
            box-shadow: 0 3px 0 #bfdbfe;
        }
        .type-card-label input:checked + .type-card-content .type-card-title {
            color: var(--primary-blue);
        }
    </style>

    <!-- SheetJS for Instant Native XLSX Generation & Processing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        // Instant Client-Side XLSX Excel Download with Guide Sheet
        function downloadXlsxTemplate(e) {
            if (e) e.preventDefault();
            try {
                if (typeof XLSX !== 'undefined') {
                    const wb = XLSX.utils.book_new();
                    
                    // 1. Sheet: Template Soal
                    const ws_data = [
                        ["question_type", "prompt", "code_snippet", "options", "answer", "explanation"],
                        [
                            "multiple_choice",
                            "Tipe data manakah di Python yang digunakan untuk menyimpan nilai True atau False?",
                            "",
                            "bool (Boolean)|int (Integer)|str (String)|float (Desimal)",
                            "bool (Boolean)",
                            "Tipe data boolean hanya memiliki dua nilai: True atau False."
                        ],
                        [
                            "fill_blank",
                            "Lengkapi kode Python berikut agar menampilkan teks \"Halo Dunia\" ke layar:",
                            "____(\"Halo Dunia\")",
                            "print|echo|input|write",
                            "print",
                            "Fungsi bawaan Python untuk mencetak teks adalah print()."
                        ],
                        [
                            "output_prediction",
                            "Apa output yang dihasilkan dari kode Python berikut?",
                            "nama = 'Andi'\nprint('Halo ' + nama)",
                            "Halo Andi|Halo nama|Andi|Error",
                            "Halo Andi",
                            "Operator + menggabungkan string 'Halo ' dengan nilai variabel nama."
                        ],
                        [
                            "code_ordering",
                            "Susun baris kode berikut dengan urutan yang benar untuk membuat variabel lalu mencetaknya:",
                            "",
                            "umur = 15|print('Umur saya:')|print(umur)",
                            "1|2|3",
                            "Variabel harus dideklarasikan terlebih dahulu sebelum nilainya dicetak."
                        ],
                        [
                            "matching_pair",
                            "Cocokkan tipe data Python dengan contoh nilainya yang tepat:",
                            "",
                            "int => 17|str => \"Belajar\"|bool => True|float => 3.14",
                            "int => 17|str => \"Belajar\"|bool => True|float => 3.14",
                            "int adalah bilangan bulat, str adalah teks, bool adalah nilai kebenaran, dan float adalah bilangan desimal."
                        ]
                    ];
                    const ws = XLSX.utils.aoa_to_sheet(ws_data);
                    ws['!cols'] = [
                        { wch: 18 }, { wch: 45 }, { wch: 25 }, { wch: 45 }, { wch: 25 }, { wch: 45 }
                    ];
                    XLSX.utils.book_append_sheet(wb, ws, "Template Soal");

                    // 2. Sheet: Panduan & Format Soal
                    const guide_data = [
                        ["PANDUAN LENGKAP PENGISIAN TEMPLATE SOAL EXCEL EDUSKILL"],
                        ["Gunakan petunjuk di bawah ini untuk mengisi soal pada sheet 'Template Soal'."],
                        [""],
                        ["1. PENJELASAN KOLOM HEADER"],
                        ["Nama Kolom", "Status", "Fungsi & Penjelasan", "Contoh Format / Isian"],
                        ["question_type", "WAJIB", "Tipe/jenis soal interaktif yang akan dibuat.", "multiple_choice / fill_blank / output_prediction / code_ordering / matching_pair"],
                        ["prompt", "WAJIB", "Pertanyaan, narasi, atau instruksi soal untuk siswa.", "Tipe data manakah yang digunakan untuk nilai True/False?"],
                        ["code_snippet", "OPSIONAL", "Potongan baris kode yang ditampilkan di kotak kode sebelum opsi.", "nama = 'Andi'\\nprint('Halo ' + nama)"],
                        ["options", "WAJIB", "Pilihan jawaban / potongan kode / pasangan (dipisah tanda pipa | ).", "bool (Boolean)|int (Integer)|str (String)|float (Desimal)"],
                        ["answer", "WAJIB", "Kunci jawaban yang benar sesuai tipe soal.", "bool (Boolean)"],
                        ["explanation", "OPSIONAL", "Penjelasan / pembahasan yang muncul setelah siswa menjawab.", "Tipe data boolean hanya memiliki dua nilai: True atau False."],
                        [""],
                        ["2. ATURAN PENULISAN 5 TIPE SOAL"],
                        ["Tipe Soal (question_type)", "Penjelasan", "Format Kolom options", "Format Kolom answer", "Contoh Kasus"],
                        ["multiple_choice", "Pilihan Ganda standar (A, B, C, D)", "Pisahkan tiap pilihan dengan tanda | (pipa)", "Tulis salah satu pilihan yang sama persis", "options: bool|int|str|float  -->  answer: bool"],
                        ["fill_blank", "Melengkapi bagian kode yang rumpang", "Pisahkan opsi kata pengisi dengan |", "Tulis kata pengisi yang tepat", "code_snippet: ____(\"Halo\")  -->  options: print|echo  -->  answer: print"],
                        ["output_prediction", "Tebak output eksekusi program", "Pisahkan opsi tebakan dengan |", "Tulis output hasil yang tepat", "code_snippet: print(2 + 3 * 2)  -->  options: 8|10|7  -->  answer: 8"],
                        ["code_ordering", "Susun baris kode berantakan (Parsons Problem)", "Tulis baris-baris kode acak dipisah |", "Tulis urutan index baris yang benar (1|2|3)", "options: print(x)|x = 10  -->  answer: 2|1"],
                        ["matching_pair", "Mencocokkan pasangan item kiri dan kanan", "Tulis format: Kiri => Kanan dipisah |", "Tulis sama persis dengan kolom options", "options: int => Angka|str => Teks  -->  answer: int => Angka|str => Teks"],
                        [""],
                        ["3. TIPS PENTING"],
                        ["* Jangan mengubah nama kolom pada baris 1 Sheet 'Template Soal'."],
                        ["* Anda bisa menambahkan baris soal sebanyak yang dibutuhkan."],
                        ["* Sistem mendukung import file dalam format .xlsx, .xls, maupun .csv."]
                    ];
                    const ws_guide = XLSX.utils.aoa_to_sheet(guide_data);
                    ws_guide['!cols'] = [
                        { wch: 25 }, { wch: 45 }, { wch: 45 }, { wch: 45 }, { wch: 45 }
                    ];
                    XLSX.utils.book_append_sheet(wb, ws_guide, "Panduan & Format Soal");

                    XLSX.writeFile(wb, "template_soal_eduskill.xlsx");
                    return;
                }
            } catch (err) {
                console.warn('SheetJS error, falling back to server download:', err);
            }
            window.location.href = "{{ route('mentor.exercises.template', ['format' => 'xlsx']) }}";
        }

        // Instant Client-Side CSV Download
        function downloadCsvTemplate(e) {
            if (e) e.preventDefault();
            const csvData = "\uFEFF" + 
                "question_type,prompt,code_snippet,options,answer,explanation\r\n" +
                'multiple_choice,"Tipe data manakah di Python yang digunakan untuk menyimpan nilai True atau False?","","bool (Boolean)|int (Integer)|str (String)|float (Desimal)","bool (Boolean)","Tipe data boolean hanya memiliki dua nilai: True atau False."\r\n' +
                'fill_blank,"Lengkapi kode Python berikut agar menampilkan teks ""Halo Dunia"" ke layar:","____(""Halo Dunia"")","print|echo|input|write",print,"Fungsi bawaan Python untuk mencetak teks adalah print()."\r\n' +
                'output_prediction,"Apa output yang dihasilkan dari kode Python berikut?","nama = \'Andi\'\\nprint(\'Halo \' + nama)","Halo Andi|Halo nama|Andi|Error","Halo Andi","Operator + menggabungkan string \'Halo \' dengan nilai variabel nama."\r\n' +
                'code_ordering,"Susun baris kode berikut dengan urutan yang benar untuk membuat variabel lalu mencetaknya:","","umur = 15|print(\'Umur saya:\')|print(umur)","1|2|3","Variabel harus dideklarasikan terlebih dahulu sebelum nilainya dicetak."\r\n' +
                'matching_pair,"Cocokkan tipe data Python dengan contoh nilainya yang tepat:","","int => 17|str => ""Belajar""|bool => True|float => 3.14","int => 17|str => ""Belajar""|bool => True|float => 3.14","int adalah bilangan bulat, str adalah teks, bool adalah nilai kebenaran, dan float adalah bilangan desimal."\r\n';

            const blob = new Blob([csvData], { type: 'text/csv;charset=utf-8;' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', 'template_soal_eduskill.csv');
            document.body.appendChild(link);
            link.click();
            setTimeout(() => {
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
            }, 200);
        }

        function switchExerciseType(radio, lessonId) {
            const type = radio.value;
            const form = radio.closest('form');

            form.querySelectorAll('.type-section').forEach(s => s.style.display = 'none');

            if (type === 'multiple_choice') {
                document.getElementById(`section-mc-${lessonId}`).style.display = 'block';
            } else if (type === 'fill_blank' || type === 'output_prediction') {
                document.getElementById(`section-fill-${lessonId}`).style.display = 'block';
            } else if (type === 'code_ordering') {
                document.getElementById(`section-ordering-${lessonId}`).style.display = 'block';
            } else if (type === 'matching_pair') {
                document.getElementById(`section-matching-${lessonId}`).style.display = 'block';
            }
        }

        function syncRadioValues(lessonId) {
            const inputs = document.querySelectorAll(`.mc-input-${lessonId}`);
            const radios = document.querySelectorAll(`input[name="correct_choice_radio_${lessonId}"]`);
            
            radios.forEach((r, idx) => {
                if (inputs[idx]) {
                    r.value = inputs[idx].value;
                    if (r.checked) {
                        document.getElementById(`correct_choice_hidden_${lessonId}`).value = inputs[idx].value;
                    }
                }
            });
        }

        function updateCorrectChoice(radio, lessonId) {
            document.getElementById(`correct_choice_hidden_${lessonId}`).value = radio.value;
        }

        function addOrderingRow(lessonId) {
            const container = document.getElementById(`ordering-rows-container-${lessonId}`);
            const count = container.children.length + 1;
            const div = document.createElement('div');
            div.style = "display: flex; align-items: center; gap: 8px;";
            div.innerHTML = `
                <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px;">#${count}</span>
                <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-${count}..." style="flex: 1; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
            `;
            container.appendChild(div);
        }

        function addMatchingRow(lessonId) {
            const container = document.getElementById(`matching-rows-container-${lessonId}`);
            const div = document.createElement('div');
            div.style = "display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center;";
            div.innerHTML = `
                <input type="text" name="pair_keys[]" placeholder="Item Kiri..." style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                <span style="font-size: 13px; color: #64748b; font-weight: 800;">&harr;</span>
                <input type="text" name="pair_values[]" placeholder="Pasangan Kanan..." style="padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
            `;
            container.appendChild(div);
        }

        function openImportModal(lessonId, lessonTitle) {
            const modal = document.getElementById('import-modal');
            const form = document.getElementById('import-form');
            const label = document.getElementById('import-target-label');

            label.innerText = `Modul Target: ${lessonTitle}`;
            form.action = `/mentor/lessons/${lessonId}/import-exercises`;
            modal.style.display = 'flex';
        }

        function closeImportModal() {
            document.getElementById('import-modal').style.display = 'none';
        }

        function toggleProjectBrief(checkbox, unitId) {
            const box = document.getElementById(`project_brief_box_${unitId}`);
            const xpInput = document.getElementById(`xp_reward_${unitId}`);
            if (checkbox.checked) {
                box.style.display = 'block';
                if (xpInput && xpInput.value == '20') {
                    xpInput.value = '50';
                }
            } else {
                box.style.display = 'none';
                if (xpInput && xpInput.value == '50') {
                    xpInput.value = '20';
                }
            }
        }

        function handleFileSelected(input) {
            if (input.files && input.files[0]) {
                const label = document.getElementById('selected-file-name');
                label.innerText = `File Terpilih: ${input.files[0].name} (${Math.round(input.files[0].size / 1024)} KB)`;
                label.style.display = 'block';
            }
        }
    </script>
</x-app-layout>
