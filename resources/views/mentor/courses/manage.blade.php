@php
    $title = 'Kelola Kurikulum: ' . $course->title . ' - EduSkill';
@endphp

<x-app-layout :title="$title">
    <style>
        .manage-root-container {
            max-width: 960px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }
        .type-card-label {
            display: block;
            cursor: pointer;
            position: relative;
        }
        .type-card-label input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .type-card-content {
            border: 2px solid #cbd5e1;
            border-radius: 12px;
            padding: 10px 12px;
            background: #ffffff;
            transition: all 0.15s ease;
            text-align: center;
            height: 100%;
            box-sizing: border-box;
        }
        .type-card-label input[type="radio"]:checked + .type-card-content {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 0 0 1px #2563eb;
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
        .matching-pair-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 8px;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }
        .matching-pair-row input {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding: 8px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: #ffffff;
        }
        .matching-pair-row .matching-arrow {
            font-size: 13px;
            color: #64748b;
            font-weight: 800;
            text-align: center;
            flex-shrink: 0;
        }
        .responsive-input, input[type="text"], input[type="number"], textarea, select {
            max-width: 100%;
            box-sizing: border-box;
        }

        /* Mobile & Tablet Responsiveness */
        @media (max-width: 768px) {
            .manage-root-container {
                padding: 0 4px !important;
                overflow-x: hidden;
            }
            .card-3d {
                padding: 16px 12px !important;
                border-radius: 16px !important;
            }
            .unit-card-box {
                padding: 16px 12px !important;
            }
            .lesson-card-box {
                padding: 14px 10px !important;
                border-radius: 14px !important;
            }
            .exercise-builder-details {
                padding: 12px 10px !important;
                border-radius: 12px !important;
            }
            .type-section {
                padding: 12px 10px !important;
                border-radius: 10px !important;
            }
            .type-selector-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 6px !important;
            }
            .type-card-content {
                padding: 8px 4px !important;
            }
            .type-card-title {
                font-size: 11px !important;
            }
            .type-card-desc {
                font-size: 9px !important;
            }
            .quick-action-hub-bar {
                width: 100% !important;
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 8px !important;
            }
            .quick-action-hub-bar > * {
                width: 100% !important;
                padding: 8px 10px !important;
                font-size: 11px !important;
                justify-content: center !important;
            }
            .quick-import-card {
                padding: 14px 12px !important;
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }
            .quick-import-buttons {
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                gap: 8px !important;
            }
            .quick-import-buttons button {
                width: 100% !important;
                justify-content: center !important;
            }
            .add-unit-form-flex {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .add-unit-form-flex input {
                width: 100% !important;
                min-width: 0 !important;
            }
            .add-unit-form-flex button {
                width: 100% !important;
            }
            .lesson-header-flex {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
            }
            .lesson-actions-flex {
                display: flex !important;
                width: 100% !important;
                justify-content: space-between !important;
                gap: 8px !important;
            }
            .lesson-actions-flex > * {
                flex: 1 !important;
            }
            .lesson-actions-flex button {
                width: 100% !important;
                justify-content: center !important;
                padding: 8px 10px !important;
                font-size: 11px !important;
            }
            .exercise-item-row {
                padding: 10px 10px !important;
                gap: 6px !important;
            }
            .summary-flex-header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 8px !important;
            }
            .summary-flex-header button {
                width: 100% !important;
                justify-content: center !important;
            }
            .studio-3d-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 8px !important;
            }
            .color-picker-grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 8px !important;
            }
        }

        @media (max-width: 480px) {
            .matching-pair-row {
                display: flex !important;
                flex-direction: column !important;
                gap: 4px !important;
                background: #f1f5f9;
                padding: 8px !important;
                border-radius: 8px !important;
            }
            .matching-pair-row .matching-arrow {
                transform: rotate(90deg);
                margin: 2px 0;
            }
            .quick-action-hub-bar {
                grid-template-columns: 1fr !important;
            }
            .studio-3d-grid {
                grid-template-columns: 1fr !important;
            }
            .color-picker-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div class="manage-root-container">
        
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
            <div class="quick-action-hub-bar" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="openQuestionGuideModal()" class="btn-3d btn-yellow" style="font-size: 12px; padding: 10px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; background: #fef08a; color: #854d0e; border: 2px solid #facc15; box-shadow: 0 4px 0 #ca8a04;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>Panduan &amp; Tips Buat Soal</span>
                </button>

                @if ($course->is_upcoming || !$course->is_published)
                    <form action="{{ route('mentor.courses.toggle-release', $course->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-3d btn-green" style="font-size: 12px; padding: 10px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" title="Rilis kursus ini ke siswa">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Rilis Roadmap ke Siswa
                        </button>
                    </form>
                @else
                    <form action="{{ route('mentor.courses.toggle-release', $course->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Alihkan kursus ini kembali ke status Roadmap Mendatang?')">
                        @csrf
                        <button type="submit" class="btn-3d btn-outline" style="font-size: 12px; padding: 10px 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; color: #b45309; border-color: #fde68a; background: #fffbeb;" title="Alihkan kembali ke status Roadmap Mendatang">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            Tarik ke Mendatang
                        </button>
                    </form>
                @endif

                <button type="button" onclick="downloadXlsxTemplate(event)" class="btn-3d btn-blue" style="font-size: 12px; padding: 10px 16px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Download Template Excel (.xlsx)
                </button>

                <a href="{{ route('learn.index', ['course' => $course->id]) }}" class="btn-3d btn-outline" style="font-size: 12px; padding: 10px 16px; display: inline-flex; align-items: center; gap: 6px;">
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
        <div class="card-3d quick-import-card" style="padding: 20px 24px; margin-bottom: 28px; background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%); border-color: #bfdbfe; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; flex-shrink: 0; border-radius: 14px; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 0 #1e40af;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 900; color: #0f172a; margin-bottom: 2px;">Ingin Tambah Banyak Soal Sekaligus?</h2>
                    <p style="font-size: 13px; color: #64748b;">Gunakan fitur import Excel (.xlsx) / CSV untuk memasukkan puluhan soal interaktif dalam sekali klik.</p>
                </div>
            </div>
            <div class="quick-import-buttons" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="button" onclick="downloadXlsxTemplate(event)" class="btn-3d btn-green" style="font-size: 12px; padding: 10px 16px; cursor: pointer;">
                    1. Download Template Excel (.xlsx)
                </button>
                <button type="button" onclick="downloadCsvTemplate(event)" class="btn-3d btn-outline" style="font-size: 12px; padding: 10px 14px; background: #ffffff; cursor: pointer;">
                    Format CSV
                </button>
            </div>
        </div>

        <!-- Add Unit Form Box -->
        <div class="card-3d unit-card-box" style="padding: 24px; margin-bottom: 32px; background: #ffffff; border-color: #cbd5e1;">
            <h2 style="font-size: 16px; font-weight: 900; color: var(--primary-blue); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Unit / Bab Baru
            </h2>
            <form action="{{ route('mentor.units.store', $course->id) }}" method="POST" class="add-unit-form-flex" style="display: flex; gap: 12px; flex-wrap: wrap;">
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
                <div class="card-3d unit-card-box" style="padding: 24px;">
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
                            <div class="lesson-card-box" style="background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 18px; padding: 20px;">
                                
                                <!-- Lesson Header Bar -->
                                <div class="lesson-header-flex" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
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

                                    <div class="lesson-actions-flex" style="display: flex; align-items: center; gap: 8px;">
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
                                                    'interactive_3d' => '#e0e7ff',
                                                    default => '#f1f5f9'
                                                };
                                                $typeBadgeColor = match($ex->question_type) {
                                                    'multiple_choice' => '#2563eb',
                                                    'fill_blank' => '#b45309',
                                                    'output_prediction' => '#7e22ce',
                                                    'code_ordering' => '#047857',
                                                    'matching_pair' => '#be123c',
                                                    'interactive_3d' => '#4338ca',
                                                    default => '#475569'
                                                };
                                                $typeLabel = match($ex->question_type) {
                                                    'multiple_choice' => 'PILIHAN GANDA',
                                                    'fill_blank' => 'ISIAN KOSONG',
                                                    'output_prediction' => 'TEBAK OUTPUT',
                                                    'code_ordering' => 'PARSONS (SUSUN KODE)',
                                                    'matching_pair' => 'COCOKKAN PASANGAN',
                                                    'interactive_3d' => '3D INTERAKTIF',
                                                    default => strtoupper($ex->question_type)
                                                };
                                            @endphp
                                            <div class="exercise-item-row" style="display: flex; align-items: center; justify-content: space-between; background: #ffffff; padding: 12px 16px; border-radius: 12px; border: 1.5px solid #e2e8f0; gap: 12px;">
                                                <div style="font-size: 13px; color: #0f172a; font-weight: 600; flex: 1; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                                    <span style="font-size: 10px; font-weight: 800; color: {{ $typeBadgeColor }}; background: {{ $typeBadgeBg }}; padding: 3px 8px; border-radius: 6px; flex-shrink: 0;">
                                                        {{ $typeLabel }}
                                                    </span>
                                                    <span style="flex: 1; min-width: 160px;">{{ $ex->prompt }}</span>
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
                                <details id="exercise-details-{{ $lesson->id }}" class="exercise-builder-details" style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 16px; padding: 16px;">
                                     <summary class="summary-flex-header" style="font-size: 13px; font-weight: 800; color: var(--primary-blue); cursor: pointer; user-select: none; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; list-style: none;">
                                         <div style="display: flex; align-items: center; gap: 8px;">
                                             <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                             <span>Buat Soal Baru Secara Interaktif di Modul Ini</span>
                                         </div>
                                         <button type="button" onclick="event.preventDefault(); event.stopPropagation(); autoFillQuestionTemplate('{{ $lesson->id }}');" class="btn-3d btn-green" style="font-size: 11px; padding: 5px 12px; display: inline-flex; align-items: center; gap: 6px;" title="Isi otomatis form dengan contoh soal yang siap pakai">
                                             <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                             <span>Isi Contoh Otomatis</span>
                                         </button>
                                     </summary>

                                     <form id="exercise-form-{{ $lesson->id }}" action="{{ route('mentor.exercises.store', $lesson->id) }}" method="POST" class="exercise-form" style="margin-top: 16px; display: flex; flex-direction: column; gap: 16px;">
                                         @csrf

                                         <!-- Question Type Switcher -->
                                         <div>
                                             <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; flex-wrap: wrap; gap: 6px;">
                                                 <label style="font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase;">PILIH TIPE SOAL INTERAKTIF</label>
                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                     <button type="button" onclick="autoFillQuestionTemplate('{{ $lesson->id }}');" class="btn-3d btn-green" style="font-size: 11px; padding: 4px 10px; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 2px 0 #059669;">
                                                         <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                                         <span>Isi Contoh Otomatis</span>
                                                     </button>
                                                     <button type="button" onclick="openQuestionGuideModal()" style="background: none; border: none; font-size: 11px; color: var(--primary-blue); font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; padding: 0;">
                                                         <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                                         <span>Panduan Tipe Soal</span>
                                                     </button>
                                                 </div>
                                             </div>
                                             <div class="type-selector-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px;">
                                                 
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
                                                         <div class="type-card-desc">Isi celah kode</div>
                                                     </div>
                                                 </label>

                                                 <label class="type-card-label">
                                                     <input type="radio" name="question_type" value="output_prediction" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                     <div class="type-card-content">
                                                         <div class="type-card-title">Tebak Output</div>
                                                         <div class="type-card-desc">Hasil cetak kode</div>
                                                     </div>
                                                 </label>

                                                 <label class="type-card-label">
                                                     <input type="radio" name="question_type" value="code_ordering" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                     <div class="type-card-content">
                                                         <div class="type-card-title">Susun Kode</div>
                                                         <div class="type-card-desc">Parsons puzzle</div>
                                                     </div>
                                                 </label>

                                                 <label class="type-card-label">
                                                     <input type="radio" name="question_type" value="matching_pair" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                     <div class="type-card-content">
                                                         <div class="type-card-title">Pasangan</div>
                                                         <div class="type-card-desc">Jodohkan item</div>
                                                     </div>
                                                 </label>

                                                 <label class="type-card-label">
                                                     <input type="radio" name="question_type" value="interactive_3d" onchange="switchExerciseType(this, '{{ $lesson->id }}')">
                                                     <div class="type-card-content">
                                                         <div class="type-card-title" style="color: #4338ca; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                             <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                                             <span>3D Interaktif</span>
                                                         </div>
                                                         <div class="type-card-desc">Visual Spasial 3D</div>
                                                     </div>
                                                 </label>

                                             </div>
                                         </div>

                                         <!-- Common Prompt Field -->
                                         <div>
                                             <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Pertanyaan / Instruksi Soal</label>
                                             <textarea name="prompt" required rows="2" placeholder="Tuliskan pertanyaan atau instruksi yang jelas bagi siswa..." style="width: 100%; min-width: 0; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;"></textarea>
                                         </div>

                                         <!-- Optional Code Snippet -->
                                         <div>
                                             <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Potongan Baris Kode (Opsional)</label>
                                             <textarea name="code_snippet" rows="2" class="code-font" placeholder="Contoh: nama = 'Andi'\nprint('Halo ' + nama)" style="width: 100%; min-width: 0; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 13px; font-weight: 600; outline: none; background: #f8fafc;"></textarea>
                                         </div>

                                         <!-- Dynamic Section 1: Multiple Choice Options -->
                                         <div id="section-mc-{{ $lesson->id }}" class="type-section" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                             <div style="font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 10px;">
                                                 PILIHAN JAWABAN (Centang Radio untuk Kunci Jawaban yang Benar):
                                             </div>
                                             <div style="display: flex; flex-direction: column; gap: 10px;">
                                                 @foreach (['A', 'B', 'C', 'D'] as $idx => $opt)
                                                     <div style="display: flex; align-items: center; gap: 10px;">
                                                         <input type="radio" name="correct_choice_radio_{{ $lesson->id }}" value="{{ $idx }}" {{ $idx === 0 ? 'checked' : '' }} onchange="updateCorrectChoice(this, '{{ $lesson->id }}')" style="width: 18px; height: 18px; accent-color: #10b981; flex-shrink: 0;">
                                                         <span style="font-weight: 800; font-size: 13px; color: #64748b; width: 20px; flex-shrink: 0;">{{ $opt }}.</span>
                                                         <input type="text" name="options[]" placeholder="Isi pilihan {{ $opt }}..." value="{{ $idx === 0 ? 'Opsi Jawaban Benar' : '' }}" class="mc-input-{{ $lesson->id }}" oninput="syncRadioValues('{{ $lesson->id }}')" style="flex: 1; min-width: 0; padding: 9px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 600; outline: none; background: #ffffff;">
                                                     </div>
                                                 @endforeach
                                             </div>
                                             <input type="hidden" name="correct_choice" id="correct_choice_hidden_{{ $lesson->id }}" value="Opsi Jawaban Benar">
                                         </div>

                                         <!-- Dynamic Section 2: Fill Blank -->
                                         <div id="section-fill-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                             <label style="display: block; font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">KUNCI KATA/FUNGSI YANG HARUS DIISI</label>
                                             <input type="text" name="answer_raw" placeholder="Contoh: print" style="width: 100%; min-width: 0; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; font-weight: 700; outline: none; background: #ffffff; margin-bottom: 12px;">
                                             <label style="display: block; font-size: 11px; font-weight: 800; color: #64748b; margin-bottom: 6px;">PILIHAN DISTRAKTOR LAINNYA (1 per baris)</label>
                                             <textarea name="options_raw" rows="3" placeholder="echo&#10;input&#10;write" style="width: 100%; min-width: 0; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 10px; font-size: 13px; outline: none; background: #ffffff;"></textarea>
                                         </div>

                                         <!-- Dynamic Section 3: Parsons Code Ordering -->
                                         <div id="section-ordering-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                             <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 6px;">
                                                 <span style="font-size: 12px; font-weight: 800; color: #0f172a;">BARIS KODE PUZZLE (Urutan BENAR dari atas ke bawah):</span>
                                                 <button type="button" onclick="addOrderingRow('{{ $lesson->id }}')" style="background: var(--primary-blue-light); color: var(--primary-blue); border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">+ Tambah Baris</button>
                                             </div>
                                             <div id="ordering-rows-container-{{ $lesson->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                     <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px; flex-shrink: 0;">#1</span>
                                                     <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-1 (Contoh: umur = 15)" style="flex: 1; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                 </div>
                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                     <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px; flex-shrink: 0;">#2</span>
                                                     <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-2 (Contoh: print('Umur saya:'))" style="flex: 1; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                 </div>
                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                     <span style="font-size: 12px; font-weight: 800; color: #64748b; width: 24px; flex-shrink: 0;">#3</span>
                                                     <input type="text" name="ordering_lines[]" placeholder="Baris kode ke-3 (Contoh: print(umur))" style="flex: 1; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-family: 'Fira Code', monospace; background: #ffffff;">
                                                 </div>
                                             </div>
                                         </div>

                                         <!-- Dynamic Section 4: Matching Pairs -->
                                         <div id="section-matching-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                             <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 6px;">
                                                 <span style="font-size: 12px; font-weight: 800; color: #0f172a;">PASANGAN MENJODOHKAN (Item Kiri &bull; Item Kanan):</span>
                                                 <button type="button" onclick="addMatchingRow('{{ $lesson->id }}')" style="background: var(--primary-blue-light); color: var(--primary-blue); border: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; cursor: pointer;">+ Tambah Pasangan</button>
                                             </div>
                                             <div id="matching-rows-container-{{ $lesson->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                                 <div class="matching-pair-row">
                                                     <input type="text" name="pair_keys[]" placeholder="Item Kiri (contoh: int)">
                                                     <span class="matching-arrow">&harr;</span>
                                                     <input type="text" name="pair_values[]" placeholder="Pasangan Kanan (contoh: 25)">
                                                 </div>
                                                 <div class="matching-pair-row">
                                                     <input type="text" name="pair_keys[]" placeholder="Item Kiri (contoh: str)">
                                                     <span class="matching-arrow">&harr;</span>
                                                     <input type="text" name="pair_values[]" placeholder="Pasangan Kanan (contoh: 'Belajar')">
                                                 </div>
                                             </div>
                                         </div>

                                         <!-- Dynamic Section 5: 3D Interactive Builder & Live Preview -->
                                         <div id="section-3d-{{ $lesson->id }}" class="type-section" style="display: none; background: #f8fafc; border: 2px solid #c7d2fe; border-radius: 16px; padding: 18px;">
                                             <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                     <span style="background: #4338ca; color: #fff; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                                         <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                                         <span>3D STUDIO</span>
                                                     </span>
                                                     <span style="font-size: 13px; font-weight: 800; color: #0f172a;">Kustomisasi Visual Spasial &amp; Elemen 3D</span>
                                                 </div>
                                                 <button type="button" onclick="refreshMentor3DPreview('{{ $lesson->id }}')" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; padding: 4px 10px; font-size: 11px; border-radius: 8px; font-weight: 800; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                                     <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                                     <span>Refresh Preview</span>
                                                 </button>
                                             </div>

                                             <div class="studio-3d-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 12px;">
                                                 <div>
                                                     <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;">Preset &amp; Bentuk Objek 3D</label>
                                                     <select name="model_3d_type" id="model_3d_type_{{ $lesson->id }}" onchange="handle3DPresetChange('{{ $lesson->id }}'); refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700; background: #ffffff;">
                                                         <optgroup label="Model Komputasi &amp; Data">
                                                             <option value="matrix_grid">3D Matrix Grid (Array 3D)</option>
                                                             <option value="robot_axis">Robot / Drone XYZ Axis Coordinates</option>
                                                             <option value="binary_tree">3D Binary Tree Nodes &amp; Graph</option>
                                                             <option value="memory_block">3D CPU Memory Register Stack</option>
                                                         </optgroup>
                                                         <optgroup label="Geometri &amp; Bentuk Spasial">
                                                             <option value="geometry_cube">Geometri: Kubus Data</option>
                                                             <option value="geometry_sphere">Geometri: Bola / Globe Spasial</option>
                                                             <option value="geometry_cylinder">Geometri: Silinder Buffer</option>
                                                             <option value="geometry_cone">Geometri: Kerucut Spasial</option>
                                                             <option value="geometry_torus">Geometri: Torus Ring (Buffer Sirkular)</option>
                                                             <option value="geometry_torus_knot">Geometri: Torus Knot Melingkar</option>
                                                             <option value="geometry_pyramid">Geometri: Piramida Data</option>
                                                             <option value="geometry_capsule">Geometri: Kapsul Token Data</option>
                                                         </optgroup>
                                                     </select>
                                                 </div>

                                                 <div>
                                                     <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;">Gaya Animasi</label>
                                                     <select name="model_3d_animation" id="model_3d_anim_{{ $lesson->id }}" onchange="refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 700; background: #ffffff;">
                                                         <option value="rotate">Putar Berkelanjutan (Rotate Y)</option>
                                                         <option value="pulse">Denyut Skala (Pulse / Scale)</option>
                                                         <option value="hover">Mengambang Halus (Hover Float)</option>
                                                         <option value="orbit">Orbit Diagonal (Orbit Angle)</option>
                                                         <option value="none">Statis (Tanpa Animasi)</option>
                                                     </select>
                                                 </div>
                                             </div>

                                             <!-- Manual Customization Studio Controls -->
                                             <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 14px; margin-bottom: 12px;">
                                                 <div style="font-size: 11px; font-weight: 800; color: #4338ca; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                                                     <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                                     <span>Kontrol Parameter Manual (Kustomisasi Bebas)</span>
                                                 </div>

                                                 <!-- Contextual: Matrix Grid Sliders -->
                                                 <div id="controls-matrix-{{ $lesson->id }}" class="context-3d-controls controls-3d-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px; margin-bottom: 10px;">
                                                     <div>
                                                         <label style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">
                                                             <span>Ukuran Matrix:</span>
                                                             <span id="lbl_matrix_size_{{ $lesson->id }}" style="color: #2563eb; font-weight: 900;">3x3x3</span>
                                                         </label>
                                                         <input type="range" name="model_3d_matrix_size" id="model_3d_matrix_size_{{ $lesson->id }}" min="2" max="5" value="3" oninput="document.getElementById('lbl_matrix_size_{{ $lesson->id }}').innerText = this.value + 'x' + this.value + 'x' + this.value; refreshMentor3DPreview('{{ $lesson->id }}');" style="width: 100%; accent-color: #2563eb;">
                                                     </div>
                                                     <div>
                                                         <label style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">
                                                             <span>Target X:</span>
                                                             <span id="lbl_target_x_{{ $lesson->id }}" style="color: #10b981; font-weight: 900;">1</span>
                                                         </label>
                                                         <input type="range" name="model_3d_target_x" id="model_3d_target_x_{{ $lesson->id }}" min="0" max="4" value="1" oninput="document.getElementById('lbl_target_x_{{ $lesson->id }}').innerText = this.value; refreshMentor3DPreview('{{ $lesson->id }}');" style="width: 100%; accent-color: #10b981;">
                                                     </div>
                                                     <div>
                                                         <label style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">
                                                             <span>Target Y:</span>
                                                             <span id="lbl_target_y_{{ $lesson->id }}" style="color: #10b981; font-weight: 900;">0</span>
                                                         </label>
                                                         <input type="range" name="model_3d_target_y" id="model_3d_target_y_{{ $lesson->id }}" min="0" max="4" value="0" oninput="document.getElementById('lbl_target_y_{{ $lesson->id }}').innerText = this.value; refreshMentor3DPreview('{{ $lesson->id }}');" style="width: 100%; accent-color: #10b981;">
                                                     </div>
                                                     <div>
                                                         <label style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">
                                                             <span>Target Z:</span>
                                                             <span id="lbl_target_z_{{ $lesson->id }}" style="color: #10b981; font-weight: 900;">1</span>
                                                         </label>
                                                         <input type="range" name="model_3d_target_z" id="model_3d_target_z_{{ $lesson->id }}" min="0" max="4" value="1" oninput="document.getElementById('lbl_target_z_{{ $lesson->id }}').innerText = this.value; refreshMentor3DPreview('{{ $lesson->id }}');" style="width: 100%; accent-color: #10b981;">
                                                     </div>
                                                 </div>

                                                 <!-- General Tweak Sliders (Scale, Speed, Material Style) -->
                                                 <div class="controls-3d-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px; border-top: 1px dashed #e2e8f0; padding-top: 10px;">
                                                     <div>
                                                         <label style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">
                                                             <span>Ukuran Skala:</span>
                                                             <span id="lbl_scale_{{ $lesson->id }}" style="color: #4338ca; font-weight: 900;">1.0x</span>
                                                         </label>
                                                         <input type="range" name="model_3d_scale" id="model_3d_scale_{{ $lesson->id }}" min="0.5" max="2.0" step="0.1" value="1.0" oninput="document.getElementById('lbl_scale_{{ $lesson->id }}').innerText = this.value + 'x'; refreshMentor3DPreview('{{ $lesson->id }}');" style="width: 100%; accent-color: #4338ca;">
                                                     </div>

                                                     <div>
                                                         <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">Kecepatan Putar</label>
                                                         <select name="model_3d_speed" id="model_3d_speed_{{ $lesson->id }}" onchange="refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; min-width: 0; padding: 4px 8px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12px; font-weight: 700; background: #ffffff;">
                                                             <option value="slow">Lambat (0.5x)</option>
                                                             <option value="normal" selected>Normal (1.0x)</option>
                                                             <option value="fast">Cepat (2.0x)</option>
                                                         </select>
                                                     </div>

                                                     <div>
                                                         <label style="display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 2px;">Gaya Material</label>
                                                         <select name="model_3d_material" id="model_3d_material_{{ $lesson->id }}" onchange="refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; min-width: 0; padding: 4px 8px; border: 1.5px solid #cbd5e1; border-radius: 6px; font-size: 12px; font-weight: 700; background: #ffffff;">
                                                             <option value="glossy" selected>Solid Glossy</option>
                                                             <option value="glow">Neon Glow</option>
                                                             <option value="glass">Kaca Glass</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="color-picker-grid" style="display: grid; grid-template-columns: 1fr 1fr 1.2fr; gap: 12px; margin-bottom: 12px;">
                                                 <div>
                                                     <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px;">Warna Objek</label>
                                                     <input type="color" name="model_3d_color" id="model_3d_color_{{ $lesson->id }}" value="#2563eb" onchange="refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; height: 38px; border: 1.5px solid #cbd5e1; border-radius: 8px; cursor: pointer; padding: 2px; background: #ffffff;">
                                                 </div>

                                                 <div>
                                                     <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; margin-bottom: 4px;">Warna Target</label>
                                                     <input type="color" name="model_3d_accent" id="model_3d_accent_{{ $lesson->id }}" value="#10b981" onchange="refreshMentor3DPreview('{{ $lesson->id }}')" style="width: 100%; height: 38px; border: 1.5px solid #cbd5e1; border-radius: 8px; cursor: pointer; padding: 2px; background: #ffffff;">
                                                 </div>

                                                 <div style="display: flex; flex-direction: column; justify-content: center; gap: 6px;">
                                                     <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #0f172a; cursor: pointer;">
                                                         <input type="checkbox" name="model_3d_wireframe" id="model_3d_wireframe_{{ $lesson->id }}" value="1" onchange="refreshMentor3DPreview('{{ $lesson->id }}')">
                                                         Mode Wireframe
                                                     </label>
                                                     <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #0f172a; cursor: pointer;">
                                                         <input type="checkbox" name="model_3d_grid" id="model_3d_grid_{{ $lesson->id }}" value="1" checked onchange="refreshMentor3DPreview('{{ $lesson->id }}')">
                                                         Tampilkan Grid
                                                     </label>
                                                 </div>
                                             </div>

                                             <div style="margin-bottom: 12px;">
                                                 <label style="display: block; font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 4px;">Label Judul 3D (Tampil di Header Siswa)</label>
                                                 <input type="text" name="model_3d_label" id="model_3d_label_{{ $lesson->id }}" placeholder="Contoh: Visualisasi Array 3D [3x3x3]" value="Visualisasi Objek 3D" style="width: 100%; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; background: #ffffff;">
                                             </div>

                                             <!-- LIVE 3D PREVIEW BOX -->
                                             <div style="background: #0f172a; border-radius: 14px; overflow: hidden; margin-bottom: 14px; border: 1.5px solid #334155;">
                                                 <div style="background: #1e293b; padding: 8px 14px; display: flex; align-items: center; justify-content: space-between; color: #94a3b8; font-size: 11px; font-weight: 700;">
                                                     <span style="display: inline-flex; align-items: center; gap: 6px;">
                                                         <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                         <span>LIVE 3D PREVIEW (Rotasi &amp; Zoom Interaktif)</span>
                                                     </span>
                                                     <span style="color: #38bdf8;">Three.js Runtime</span>
                                                 </div>
                                                 <div id="mentor-3d-preview-{{ $lesson->id }}" style="width: 100%; height: 220px; position: relative; cursor: grab;"></div>
                                             </div>

                                             <!-- 3D Multiple Choice Answer Options -->
                                             <div style="font-size: 12px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
                                                 PILIHAN JAWABAN (Centang Radio untuk Kunci Jawaban yang Benar):
                                             </div>
                                             <div style="display: flex; flex-direction: column; gap: 8px;">
                                                 @foreach (['A', 'B', 'C', 'D'] as $idx => $opt)
                                                     <div style="display: flex; align-items: center; gap: 10px;">
                                                         <input type="radio" name="correct_choice_radio_3d_{{ $lesson->id }}" value="{{ $idx === 0 ? 'Target [2, 1, 3]' : '' }}" {{ $idx === 0 ? 'checked' : '' }} onchange="updateCorrectChoice3D(this, '{{ $lesson->id }}')" style="width: 18px; height: 18px; accent-color: #10b981; flex-shrink: 0;">
                                                         <span style="font-weight: 800; font-size: 13px; color: #64748b; width: 20px; flex-shrink: 0;">{{ $opt }}.</span>
                                                         <input type="text" name="options_3d[]" placeholder="Pilihan jawaban {{ $opt }}..." value="{{ $idx === 0 ? 'Target [2, 1, 3]' : '' }}" class="mc-input-3d-{{ $lesson->id }}" oninput="syncRadioValues3D('{{ $lesson->id }}')" style="flex: 1; min-width: 0; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13px; font-weight: 600; outline: none; background: #ffffff;">
                                                     </div>
                                                 @endforeach
                                             </div>
                                             <input type="hidden" name="correct_choice_3d" id="correct_choice_3d_hidden_{{ $lesson->id }}" value="Target [2, 1, 3]">
                                         </div>

                                         <!-- Explanation Field -->
                                         <div>
                                             <label style="display: block; font-size: 11px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 6px;">Penjelasan / Pembahasan Konsep (Muncul Saat Siswa Menjawab)</label>
                                             <input type="text" name="explanation" placeholder="Contoh: print() adalah perintah standar Python untuk menampilkan nilai ke layar." style="width: 100%; min-width: 0; padding: 10px 14px; border: 2px solid #cbd5e1; border-radius: 12px; font-size: 13px; outline: none;">
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
                            <span>Tambah Modul Pelajaran / Mini Project ke {{ $unit->title }}</span>
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
                'matching_pair,"Cocokkan tipe data Python dengan contoh nilainya yang tepat:","","int => 17|str => ""Belajar""|bool => True|float => 3.14","int => 17|str => ""Belajar""|bool => True|float => 3.14","int adalah bilangan bulat, str adalah teks, bool adalah nilai kebenaran, dan float adalah bilangan desimal."\r\n' +
                'interactive_3d,"Perhatikan visualisasi matriks balok 3D berikut. Elemen target hijau neon berada pada koordinat [2, 1, 3]. Berapa nilai perpindahan pada sumbu Z?","# Sumbu: X (Kanan), Y (Atas), Z (Kedalaman)","3 Langkah|1 Langkah|2 Langkah|0 Langkah","3 Langkah","Perpindahan pada sumbu Z dari indeks 0 ke indeks 3 adalah sejauh 3 langkah kedalaman."\r\n';

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
            if (!radio) return;
            const type = radio.value;
            const form = radio.closest('form');
            if (!form) return;

            form.querySelectorAll('.type-section').forEach(s => s.style.display = 'none');

            if (type === 'multiple_choice') {
                document.getElementById(`section-mc-${lessonId}`).style.display = 'block';
                disposeMentor3DSession(lessonId);
            } else if (type === 'fill_blank' || type === 'output_prediction') {
                document.getElementById(`section-fill-${lessonId}`).style.display = 'block';
                disposeMentor3DSession(lessonId);
            } else if (type === 'code_ordering') {
                document.getElementById(`section-ordering-${lessonId}`).style.display = 'block';
                disposeMentor3DSession(lessonId);
            } else if (type === 'matching_pair') {
                document.getElementById(`section-matching-${lessonId}`).style.display = 'block';
                disposeMentor3DSession(lessonId);
            } else if (type === 'interactive_3d') {
                document.getElementById(`section-3d-${lessonId}`).style.display = 'block';
                setTimeout(() => {
                    initMentor3DPreview(lessonId);
                }, 50);
            }
        }

        function handle3DPresetChange(lessonId) {
            const preset = document.getElementById(`model_3d_type_${lessonId}`)?.value;
            const matrixControls = document.getElementById(`controls-matrix-${lessonId}`);
            if (matrixControls) {
                matrixControls.style.display = (preset === 'matrix_grid') ? 'grid' : 'none';
            }
        }

        // 1-Click Auto-Fill Question Template
        function autoFillQuestionTemplate(lessonId) {
            try {
                if (window.EduAudio && typeof window.EduAudio.playPop === 'function') {
                    window.EduAudio.playPop();
                } else if (window.EduAudio && typeof window.EduAudio.playTap === 'function') {
                    window.EduAudio.playTap();
                }
            } catch (e) {}

            const details = document.getElementById(`exercise-details-${lessonId}`);
            if (details) details.open = true;

            const form = document.getElementById(`exercise-form-${lessonId}`) || document.querySelector(`form[action*="/lessons/${lessonId}/exercises"]`);
            if (!form) {
                console.error('Form not found for lesson:', lessonId);
                return;
            }

            const selectedTypeRadio = form.querySelector('input[name="question_type"]:checked');
            const selectedType = selectedTypeRadio ? selectedTypeRadio.value : 'multiple_choice';

            if (selectedType === 'multiple_choice') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Tipe data manakah di Python yang digunakan untuk menyimpan nilai kebenaran True atau False?';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = '# Contoh deklarasi kebenaran:\nlulus_ujian = True';
                const inputs = form.querySelectorAll(`.mc-input-${lessonId}`);
                if (inputs[0]) inputs[0].value = 'bool (Boolean)';
                if (inputs[1]) inputs[1].value = 'int (Integer)';
                if (inputs[2]) inputs[2].value = 'str (String)';
                if (inputs[3]) inputs[3].value = 'float (Desimal)';
                syncRadioValues(lessonId);
                const firstRadio = form.querySelector(`input[name="correct_choice_radio_${lessonId}"][value="bool (Boolean)"]`) || form.querySelector(`input[name="correct_choice_radio_${lessonId}"]`);
                if (firstRadio) {
                    firstRadio.checked = true;
                    document.getElementById(`correct_choice_hidden_${lessonId}`).value = firstRadio.value;
                }
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'Tipe data boolean hanya memiliki dua kemungkinan nilai logis yaitu True dan False.';
            } else if (selectedType === 'fill_blank') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Lengkapi fungsi bawaan Python berikut agar menampilkan teks ke layar konsol:';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = '____("Halo, selamat datang di EduSkill!")';
                const ans = form.querySelector('input[name="answer_raw"]');
                if (ans) ans.value = 'print';
                const opts = form.querySelector('textarea[name="options_raw"]');
                if (opts) opts.value = "echo\ninput\nwrite\nshow";
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'Fungsi print() adalah instruksi standar Python untuk mencetak output teks ke layar.';
            } else if (selectedType === 'output_prediction') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Apa output yang dihasilkan dari eksekusi baris kode Python berikut?';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = "angka = 5\ntotal = angka * 2 + 3\nprint(total)";
                const ans = form.querySelector('input[name="answer_raw"]');
                if (ans) ans.value = '13';
                const opts = form.querySelector('textarea[name="options_raw"]');
                if (opts) opts.value = "25\n10\n16\nError";
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'Operasi perkalian (*) dieksekusi terlebih dahulu (5 * 2 = 10), lalu ditambah 3 menghasilkan 13.';
            } else if (selectedType === 'code_ordering') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Susun baris kode berikut dengan urutan logis yang benar untuk menghitung total belanja:';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = '';
                const lines = form.querySelectorAll('input[name="ordering_lines[]"]');
                if (lines[0]) lines[0].value = 'harga_barang = 50000';
                if (lines[1]) lines[1].value = 'jumlah_beli = 3';
                if (lines[2]) lines[2].value = "total = harga_barang * jumlah_beli\nprint(total)";
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'Variabel harga dan jumlah beli harus dibuat terlebih dahulu sebelum mengalikan dan mencetak totalnya.';
            } else if (selectedType === 'matching_pair') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Cocokkan tipe data dasar di sebelah kiri dengan contoh nilainya di sebelah kanan:';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = '';
                const keys = form.querySelectorAll('input[name="pair_keys[]"]');
                const vals = form.querySelectorAll('input[name="pair_values[]"]');
                if (keys[0] && vals[0]) { keys[0].value = 'int (Integer)'; vals[0].value = '25'; }
                if (keys[1] && vals[1]) { keys[1].value = 'str (String)'; vals[1].value = '"Belajar Coding"'; }
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'int adalah bilangan bulat tanpa koma, sedangkan str adalah rangkaian karakter teks yang diapit tanda petik.';
            } else if (selectedType === 'interactive_3d') {
                const promptEl = form.querySelector('textarea[name="prompt"]');
                if (promptEl) promptEl.value = 'Perhatikan visualisasi matriks 3D berikut. Elemen hijau neon berada di posisi koordinat indeks apa?';
                const snippetEl = form.querySelector('textarea[name="code_snippet"]');
                if (snippetEl) snippetEl.value = '# Format pengalamatan indeks: matriks[X][Y][Z]';
                const typeSelect = document.getElementById(`model_3d_type_${lessonId}`);
                if (typeSelect) typeSelect.value = 'matrix_grid';
                handle3DPresetChange(lessonId);
                const col = document.getElementById(`model_3d_color_${lessonId}`);
                if (col) col.value = '#2563eb';
                const acc = document.getElementById(`model_3d_accent_${lessonId}`);
                if (acc) acc.value = '#10b981';
                const anim = document.getElementById(`model_3d_anim_${lessonId}`);
                if (anim) anim.value = 'rotate';
                const matSize = document.getElementById(`model_3d_matrix_size_${lessonId}`);
                if (matSize) matSize.value = '3';
                const lblSize = document.getElementById(`lbl_matrix_size_${lessonId}`);
                if (lblSize) lblSize.innerText = '3x3x3';
                const tx = document.getElementById(`model_3d_target_x_${lessonId}`);
                if (tx) tx.value = '1';
                const ty = document.getElementById(`model_3d_target_y_${lessonId}`);
                if (ty) ty.value = '0';
                const tz = document.getElementById(`model_3d_target_z_${lessonId}`);
                if (tz) tz.value = '1';
                const lbl = document.getElementById(`model_3d_label_${lessonId}`);
                if (lbl) lbl.value = 'Visualisasi Matriks 3D [3x3x3]';
                const inputs = form.querySelectorAll(`.mc-input-3d-${lessonId}`);
                if (inputs[0]) inputs[0].value = 'matriks[1][0][1]';
                if (inputs[1]) inputs[1].value = 'matriks[0][1][1]';
                if (inputs[2]) inputs[2].value = 'matriks[2][2][2]';
                if (inputs[3]) inputs[3].value = 'matriks[0][0][0]';
                syncRadioValues3D(lessonId);
                const firstRadio3d = form.querySelector(`input[name="correct_choice_radio_3d_${lessonId}"][value="matriks[1][0][1]"]`) || form.querySelector(`input[name="correct_choice_radio_3d_${lessonId}"]`);
                if (firstRadio3d) {
                    firstRadio3d.checked = true;
                    document.getElementById(`correct_choice_3d_hidden_${lessonId}`).value = firstRadio3d.value;
                }
                const expEl = form.querySelector('input[name="explanation"]');
                if (expEl) expEl.value = 'Akses array 3 dimensi berurutan berdasarkan sumbu [X][Y][Z], sehingga koordinat X=1, Y=0, Z=1 diakses dengan matriks[1][0][1].';
            }

            switchExerciseType(selectedTypeRadio, lessonId);
        }

        // Guide Modal Actions
        function openQuestionGuideModal() {
            try {
                if (window.EduAudio && typeof window.EduAudio.playPop === 'function') {
                    window.EduAudio.playPop();
                } else if (window.EduAudio && typeof window.EduAudio.playTap === 'function') {
                    window.EduAudio.playTap();
                }
            } catch (e) {}
            const modal = document.getElementById('question-guide-modal');
            if (modal) modal.style.display = 'flex';
        }

        function closeQuestionGuideModal() {
            const modal = document.getElementById('question-guide-modal');
            if (modal) modal.style.display = 'none';
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

        function syncRadioValues3D(lessonId) {
            const inputs = document.querySelectorAll(`.mc-input-3d-${lessonId}`);
            const radios = document.querySelectorAll(`input[name="correct_choice_radio_3d_${lessonId}"]`);
            
            radios.forEach((r, idx) => {
                if (inputs[idx]) {
                    r.value = inputs[idx].value;
                    if (r.checked) {
                        document.getElementById(`correct_choice_3d_hidden_${lessonId}`).value = inputs[idx].value;
                    }
                }
            });
        }

        function updateCorrectChoice3D(radio, lessonId) {
            document.getElementById(`correct_choice_3d_hidden_${lessonId}`).value = radio.value;
        }

        // ==========================================
        // MENTOR 3D LIVE PREVIEW CONTROLLER (WebGL Context-Safe Singleton)
        // ==========================================
        const _mentor3DSessions = {};

        function _disposeGroupMeshes(group) {
            if (!group) return;
            while (group.children && group.children.length > 0) {
                const obj = group.children[0];
                group.remove(obj);
                if (obj.geometry) {
                    obj.geometry.dispose();
                }
                if (obj.material) {
                    if (Array.isArray(obj.material)) {
                        obj.material.forEach(m => m && m.dispose());
                    } else {
                        obj.material.dispose();
                    }
                }
                if (obj.children && obj.children.length > 0) {
                    _disposeGroupMeshes(obj);
                }
            }
        }

        function disposeMentor3DSession(lessonId) {
            const s = _mentor3DSessions[lessonId];
            if (!s) return;
            if (s.animId) cancelAnimationFrame(s.animId);
            if (s.controls) s.controls.dispose();
            if (s.rootGroup) _disposeGroupMeshes(s.rootGroup);
            if (s.gridGroup) _disposeGroupMeshes(s.gridGroup);
            if (s.renderer) {
                try {
                    s.renderer.forceContextLoss();
                } catch (e) {}
                s.renderer.dispose();
                if (s.renderer.domElement && s.renderer.domElement.parentElement) {
                    s.renderer.domElement.parentElement.removeChild(s.renderer.domElement);
                }
            }
            delete _mentor3DSessions[lessonId];
        }

        function initMentor3DPreview(lessonId) {
            const container = document.getElementById(`mentor-3d-preview-${lessonId}`);
            if (!container || typeof THREE === 'undefined') return;

            const section3d = document.getElementById(`section-3d-${lessonId}`);
            if (section3d && (section3d.style.display === 'none' || section3d.offsetParent === null)) {
                return;
            }

            // If session already exists, update scene in-place without creating new WebGLRenderer
            if (_mentor3DSessions[lessonId] && _mentor3DSessions[lessonId].renderer) {
                _updateMentor3DScene(lessonId);
                return;
            }

            const width = container.clientWidth || 400;
            const height = container.clientHeight || 220;

            const scene = new THREE.Scene();
            scene.background = new THREE.Color(0x0f172a);

            const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
            camera.position.set(6, 5, 7);

            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'low-power' });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            container.innerHTML = '';
            container.appendChild(renderer.domElement);

            let controls = null;
            if (typeof THREE.OrbitControls !== 'undefined') {
                controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.08;
            }

            // Lights
            const ambient = new THREE.AmbientLight(0xffffff, 0.7);
            scene.add(ambient);
            const dirLight = new THREE.DirectionalLight(0xffffff, 0.9);
            dirLight.position.set(5, 10, 7);
            scene.add(dirLight);

            const gridGroup = new THREE.Group();
            scene.add(gridGroup);

            const rootGroup = new THREE.Group();
            scene.add(rootGroup);

            const session = {
                scene,
                camera,
                renderer,
                controls,
                gridGroup,
                rootGroup,
                animId: null,
                clock: new THREE.Clock(),
                animType: 'rotate',
                speedMult: 1.0,
                scaleVal: 1.0
            };

            _mentor3DSessions[lessonId] = session;

            function animate() {
                session.animId = requestAnimationFrame(animate);
                const t = session.clock.getElapsedTime();
                if (session.controls) session.controls.update();

                if (session.animType === 'rotate') {
                    session.rootGroup.rotation.y = t * 0.4 * session.speedMult;
                    session.rootGroup.position.y = 0;
                } else if (session.animType === 'pulse') {
                    const s = (1 + Math.sin(t * 2.5 * session.speedMult) * 0.08) * session.scaleVal;
                    session.rootGroup.scale.set(s, s, s);
                    session.rootGroup.rotation.y = t * 0.2 * session.speedMult;
                    session.rootGroup.position.y = 0;
                } else if (session.animType === 'hover') {
                    session.rootGroup.position.y = Math.sin(t * 2 * session.speedMult) * 0.25;
                    session.rootGroup.rotation.y = t * 0.2 * session.speedMult;
                } else if (session.animType === 'orbit') {
                    session.rootGroup.rotation.y = t * 0.5 * session.speedMult;
                    session.rootGroup.rotation.x = Math.sin(t * 0.5 * session.speedMult) * 0.2;
                    session.rootGroup.position.y = 0;
                } else {
                    session.rootGroup.position.y = 0;
                }

                session.renderer.render(session.scene, session.camera);
            }

            animate();

            _updateMentor3DScene(lessonId);
        }

        function _updateMentor3DScene(lessonId) {
            const session = _mentor3DSessions[lessonId];
            if (!session) return;

            // Read form inputs
            const preset = document.getElementById(`model_3d_type_${lessonId}`)?.value || 'matrix_grid';
            const colorHex = document.getElementById(`model_3d_color_${lessonId}`)?.value || '#2563eb';
            const accentHex = document.getElementById(`model_3d_accent_${lessonId}`)?.value || '#10b981';
            const animType = document.getElementById(`model_3d_anim_${lessonId}`)?.value || 'rotate';
            const wireframe = !!document.getElementById(`model_3d_wireframe_${lessonId}`)?.checked;
            const showGrid = !!document.getElementById(`model_3d_grid_${lessonId}`)?.checked;

            const scaleVal = parseFloat(document.getElementById(`model_3d_scale_${lessonId}`)?.value) || 1.0;
            const speedVal = document.getElementById(`model_3d_speed_${lessonId}`)?.value || 'normal';
            const materialVal = document.getElementById(`model_3d_material_${lessonId}`)?.value || 'glossy';

            session.animType = animType;
            session.scaleVal = scaleVal;
            session.speedMult = speedVal === 'slow' ? 0.5 : (speedVal === 'fast' ? 2.0 : 1.0);

            // Update Grid
            _disposeGroupMeshes(session.gridGroup);
            if (showGrid) {
                const grid = new THREE.GridHelper(8, 8, 0x3b82f6, 0x334155);
                grid.position.y = -1.5;
                session.gridGroup.add(grid);

                const axes = new THREE.AxesHelper(2.5);
                axes.position.y = -1.49;
                session.gridGroup.add(axes);
            }

            // Update Object Meshes
            _disposeGroupMeshes(session.rootGroup);
            session.rootGroup.scale.set(scaleVal, scaleVal, scaleVal);
            session.rootGroup.rotation.set(0, 0, 0);

            _renderMentorPreset(session.rootGroup, preset, new THREE.Color(colorHex), new THREE.Color(accentHex), wireframe, lessonId, materialVal);
        }

        let _previewDebounceTimer = null;
        function refreshMentor3DPreview(lessonId) {
            if (_previewDebounceTimer) cancelAnimationFrame(_previewDebounceTimer);
            _previewDebounceTimer = requestAnimationFrame(() => {
                if (_mentor3DSessions[lessonId]) {
                    _updateMentor3DScene(lessonId);
                } else {
                    initMentor3DPreview(lessonId);
                }
            });
        }

        function _renderMentorPreset(group, preset, baseColor, accentColor, wireframe, lessonId, materialStyle = 'glossy') {
            const isGlass = materialStyle === 'glass';
            const isGlow = materialStyle === 'glow';

            if (preset === 'matrix_grid') {
                const size = parseInt(document.getElementById(`model_3d_matrix_size_${lessonId}`)?.value) || 3;
                const targetX = parseInt(document.getElementById(`model_3d_target_x_${lessonId}`)?.value) || 1;
                const targetY = parseInt(document.getElementById(`model_3d_target_y_${lessonId}`)?.value) || 0;
                const targetZ = parseInt(document.getElementById(`model_3d_target_z_${lessonId}`)?.value) || 1;

                const cubeGeo = new THREE.BoxGeometry(0.7, 0.7, 0.7);
                const half = (size - 1) / 2;

                for (let x = 0; x < size; x++) {
                    for (let y = 0; y < size; y++) {
                        for (let z = 0; z < size; z++) {
                            const isTarget = (x === targetX && y === targetY && z === targetZ);
                            const mat = new THREE.MeshStandardMaterial({
                                color: isTarget ? accentColor : baseColor,
                                roughness: isGlass ? 0.1 : 0.2,
                                metalness: isGlass ? 0.1 : 0.5,
                                wireframe: wireframe,
                                transparent: true,
                                opacity: isTarget ? 1.0 : (isGlass ? 0.3 : 0.45),
                                emissive: isTarget ? accentColor : (isGlow ? baseColor : 0x000000),
                                emissiveIntensity: isTarget ? 0.5 : (isGlow ? 0.2 : 0.0)
                            });
                            const mesh = new THREE.Mesh(cubeGeo, mat);
                            mesh.position.set((x - half) * 1.0, (y - half) * 1.0, (z - half) * 1.0);
                            group.add(mesh);

                            const edge = new THREE.LineSegments(new THREE.EdgesGeometry(cubeGeo), new THREE.LineBasicMaterial({ color: isTarget ? 0xffffff : 0x93c5fd }));
                            mesh.add(edge);
                        }
                    }
                }
            } else if (preset === 'robot_axis') {
                const body = new THREE.Mesh(new THREE.CylinderGeometry(0.8, 1.0, 0.5, 8), new THREE.MeshStandardMaterial({ color: baseColor, wireframe }));
                group.add(body);
                const target = new THREE.Mesh(new THREE.SphereGeometry(0.35, 16, 16), new THREE.MeshStandardMaterial({ color: accentColor, emissive: accentColor, emissiveIntensity: 0.6, wireframe }));
                target.position.set(1.8, 1.2, 1.8);
                group.add(target);
            } else if (preset === 'binary_tree') {
                const nodeGeo = new THREE.SphereGeometry(0.4, 16, 16);
                const coords = [[0, 1.8, 0], [-1.4, 0.5, 0.5], [1.4, 0.5, -0.5], [-2.0, -0.8, 0.8], [2.0, -0.8, -0.8]];
                coords.forEach((p, idx) => {
                    const isTarget = (idx === 2);
                    const mat = new THREE.MeshStandardMaterial({ color: isTarget ? accentColor : baseColor, wireframe, emissive: isTarget ? accentColor : 0x000000, emissiveIntensity: isTarget ? 0.4 : 0 });
                    const m = new THREE.Mesh(nodeGeo, mat);
                    m.position.set(p[0], p[1], p[2]);
                    group.add(m);
                });
            } else if (preset === 'memory_block') {
                const blockGeo = new THREE.BoxGeometry(2.2, 0.45, 1.2);
                for (let i = 0; i < 4; i++) {
                    const isTarget = (i === 2);
                    const m = new THREE.Mesh(blockGeo, new THREE.MeshStandardMaterial({ color: isTarget ? accentColor : baseColor, wireframe, emissive: isTarget ? accentColor : 0x000000, emissiveIntensity: isTarget ? 0.4 : 0 }));
                    m.position.set(0, (i - 1.5) * 0.6, 0);
                    group.add(m);
                }
            } else {
                let geo;
                if (preset === 'geometry_sphere') {
                    geo = new THREE.SphereGeometry(1.3, 32, 32);
                } else if (preset === 'geometry_cylinder') {
                    geo = new THREE.CylinderGeometry(1.0, 1.0, 2.0, 24);
                } else if (preset === 'geometry_cone') {
                    geo = new THREE.ConeGeometry(1.3, 2.4, 32);
                } else if (preset === 'geometry_torus') {
                    geo = new THREE.TorusGeometry(1.2, 0.4, 16, 40);
                } else if (preset === 'geometry_torus_knot') {
                    geo = new THREE.TorusKnotGeometry(0.9, 0.3, 80, 16);
                } else if (preset === 'geometry_pyramid') {
                    geo = new THREE.ConeGeometry(1.4, 2.2, 4);
                } else if (preset === 'geometry_capsule') {
                    geo = new THREE.CylinderGeometry(0.7, 0.7, 1.4, 20);
                } else {
                    geo = new THREE.BoxGeometry(1.8, 1.8, 1.8);
                }

                const mat = new THREE.MeshStandardMaterial({
                    color: baseColor,
                    roughness: isGlass ? 0.1 : 0.3,
                    metalness: isGlass ? 0.1 : 0.5,
                    wireframe,
                    transparent: isGlass,
                    opacity: isGlass ? 0.75 : 1.0,
                    emissive: isGlow ? baseColor : 0x000000,
                    emissiveIntensity: isGlow ? 0.3 : 0.0
                });

                const mesh = new THREE.Mesh(geo, mat);
                group.add(mesh);

                if (preset === 'geometry_capsule') {
                    const sphereGeo = new THREE.SphereGeometry(0.7, 20, 20);
                    const topSphere = new THREE.Mesh(sphereGeo, mat);
                    topSphere.position.set(0, 0.7, 0);
                    const botSphere = new THREE.Mesh(sphereGeo, mat);
                    botSphere.position.set(0, -0.7, 0);
                    group.add(topSphere);
                    group.add(botSphere);
                }
            }
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
            div.className = "matching-pair-row";
            div.innerHTML = `
                <input type="text" name="pair_keys[]" placeholder="Item Kiri...">
                <span class="matching-arrow">&harr;</span>
                <input type="text" name="pair_values[]" placeholder="Pasangan Kanan...">
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

    <!-- Modal Panduan Praktis Pembuat Soal untuk Guru Awam -->
    <div id="question-guide-modal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
        <div class="card-3d" style="background: #ffffff; width: 100%; max-width: 820px; max-height: 90vh; overflow-y: auto; padding: 28px; border-radius: 24px; position: relative;">
            
            <button type="button" onclick="closeQuestionGuideModal()" style="position: absolute; top: 20px; right: 20px; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; font-size: 16px; font-weight: 800; color: #64748b; display: flex; align-items: center; justify-content: center;">
                ✕
            </button>

            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 0 #bfdbfe;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                </div>
                <div>
                    <h2 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0;">Panduan Praktis Membuat Soal &amp; Modul</h2>
                    <p style="font-size: 13px; color: #64748b; margin: 0;">Pelajari cara membuat materi interaktif yang menarik untuk siswa dengan mudah.</p>
                </div>
            </div>

            <!-- Hierarchy Card -->
            <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 14px; padding: 14px 18px; margin-bottom: 20px;">
                <div style="font-size: 12px; font-weight: 800; color: #1e40af; text-transform: uppercase; margin-bottom: 8px;">
                    1. Struktur Hirarki Kurikulum
                </div>
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; font-size: 13px; font-weight: 700; color: #1e293b;">
                    <span style="background: #ffffff; padding: 4px 10px; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Kursus</span>
                    </span>
                    <span>&rarr;</span>
                    <span style="background: #ffffff; padding: 4px 10px; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        <span>Unit Bab</span>
                    </span>
                    <span>&rarr;</span>
                    <span style="background: #ffffff; padding: 4px 10px; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Modul Pelajaran</span>
                    </span>
                    <span>&rarr;</span>
                    <span style="background: #dbeafe; padding: 4px 10px; border-radius: 8px; border: 1px solid #93c5fd; color: #1d4ed8; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                        <span>Soal Latihan</span>
                    </span>
                </div>
            </div>

            <!-- 6 Question Types Cards Grid -->
            <div style="font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 12px;">
                2. Kamus 6 Tipe Soal &amp; Kapan Harus Dipakai:
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-bottom: 20px;">
                
                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #2563eb; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline></svg>
                        <span>Pilihan Ganda</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Pertanyaan konsep umum dengan 4 pilihan (A, B, C, D).<br>
                        <strong>Cocok untuk:</strong> Teori dasar, definisi, dan sintaks umum.
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #b45309; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        <span>Isian Kosong (Fill Blank)</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Melengkapi satu kata kunci yang rumpang pada baris kode.<br>
                        <strong>Cocok untuk:</strong> Mengingat nama fungsi penting seperti <code>print</code>, <code>input</code>, dll.
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #7e22ce; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                        <span>Tebak Output</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Menampilkan sepotong kode dan meminta siswa menebak hasil akhirnya.<br>
                        <strong>Cocok untuk:</strong> Melatih kemampuan tracing dan logika hitung kode.
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #047857; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Susun Kode (Parsons)</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Menyusun baris-baris algoritma yang diacak ke urutan yang benar.<br>
                        <strong>Cocok untuk:</strong> Melatih pola pikir sekuensial dan struktur program.
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #be123c; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                        <span>Cocokkan Pasangan</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Menghubungkan item di sebelah kiri dengan pasangannya di kanan.<br>
                        <strong>Cocok untuk:</strong> Pemetaan istilah, properti CSS, atau tipe data &amp; contohnya.
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 14px;">
                    <div style="font-size: 13px; font-weight: 900; color: #4338ca; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>3D Interaktif &amp; Spasial</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; line-height: 1.4;">
                        <strong>Fungsi:</strong> Siswa memutar objek 3D 360° untuk menjawab koordinat atau struktur data.<br>
                        <strong>Cocok untuk:</strong> Matriks 3D, Graf pohon biner, navigasi drone &amp; memori.
                    </div>
                </div>

            </div>

            <!-- Pro-tip Banner -->
            <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 14px; padding: 14px 18px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                </div>
                <div style="font-size: 12px; color: #065f46; font-weight: 600; line-height: 1.5;">
                    <strong>Tips Cepat Guru:</strong> Gunakan tombol <strong>"Isi Contoh Otomatis"</strong> di atas form pembuatan soal agar kolom pertanyaan, opsi, dan kunci jawaban langsung terisi contoh siap pakai tanpa perlu mengetik dari awal!
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
