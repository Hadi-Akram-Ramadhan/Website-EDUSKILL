# Dokumentasi Lengkap Analisis & Perancangan Sistem (ERD, DFD Level 0-2, Flowchart, & Kamus Data)
**Platform Edukasi Pemrograman Interaktif & Visualisasi Spasial 3D — EduSkill**

---

## DAFTAR ISI
1. [Status Penyelesaian Masalah Sebelumnya (Verification Report)](#1-status-penyelesaian-masalah-sebelumnya)
2. [Notasi & Standar Bentuk Simbol (Akademis ANSI & Gane-Sarson)](#2-notasi--standar-bentuk-simbol)
3. [Entity Relationship Diagram (ERD) & Kamus Data](#3-entity-relationship-diagram-erd--kamus-data)
   - 3.1 Skema Relasi Fisik (Crow's Foot Notation)
   - 3.2 Notasi Konseptual Chen
   - 3.3 Kamus Data Lengkap (Data Dictionary)
4. [Data Flow Diagram (DFD)](#4-data-flow-diagram-dfd)
   - 4.1 DFD Level 0 (Diagram Konteks)
   - 4.2 DFD Level 1 (Dekomposisi Sistem Utama)
   - 4.3 DFD Level 2.1 (Sub-Proses Manajemen Kurikulum & Studio 3D)
   - 4.4 DFD Level 2.2 (Sub-Proses Lesson Player & Evaluasi Gamifikasi)
   - 4.5 DFD Level 2.3 (Sub-Proses Klaim & Verifikasi Sertifikat)
5. [Flowchart Sistem (Diagram Alir Proses Lengkap)](#5-flowchart-sistem-diagram-alir-proses-lengkap)
   - 5.1 Flowchart Autentikasi & Role Redirection
   - 5.2 Flowchart Siswa (Belajar, Pengerjaan Kuis 3D, & Gamifikasi)
   - 5.3 Flowchart Guru/Mentor (Manajemen Kurikulum, Studio 3D, & Import Excel)
   - 5.4 Flowchart Super Admin (Manajemen User & Monitoring)
   - 5.5 Flowchart Verifikasi Sertifikat Publik (QR & Hash SHA-256)

---

## 1. Status Penyelesaian Masalah Sebelumnya

Sebelum masuk ke diagram, berikut konfirmasi status teknis perbaikan yang telah diverifikasi:

1. **Problem WebGL Context Exhaustion (`WARNING: Too many active WebGL contexts`)**:
   - **Status**: **SOLVED & ZERO WARNINGS**.
   - **Perbaikan**: Menggunakan *Singleton Pattern Session* pada Three.js preview canvas. Render ulang mesh/material hanya memodifikasi objek di memori (`_updateMentor3DScene`) tanpa membuat context `WebGLRenderer` baru. Saat berpindah tipe kuis, `renderer.forceContextLoss()` dipanggil untuk pelepasan memori GPU seketika.
2. **Problem Responsivitas Layar Mobile (Ukuran HP 375px–400px)**:
   - **Status**: **SOLVED & 100% RESPONSIVE**.
   - **Perbaikan**:
     - Nested card padding disesuaikan proporsional (`12px` di mobile vs `24px` di desktop).
     - Input pasangan menjodohkan (*Matching Pairs*) dibungkus dengan class responsif (`min-width: 0`, auto flex/grid).
     - Radio button 3D yang sebelumnya bocor ke tipe soal lain akibat tag penutup div yang salah telah diperbaiki ke dalam `#section-3d`.
     - Tombol Action Hub & Summary Auto-Fill dapat melipat rapi tanpa menyebabkan horizontal scroll.
3. **Automated Unit & Feature Testing**:
   - **Hasil**: **68 tests PASSED (327 assertions)** (100% lolos via `php artisan test`).
   - **Branch Git**: Tetap aman di branch `prototype`.

---

## 2. Notasi & Standar Bentuk Simbol

### A. Simbol Entity Relationship Diagram (ERD - Chen & Crow's Foot)
```
  ┌───────────────┐        ╭───────────────╮        ╱╲
  │    ENTITAS    │        │    ATRIBUT    │       ╱  ╲   RELASI
  │ (Tabel Data)  │        │ (Kolom/Field) │      ╱ REL ╲ (Hubungan)
  └───────────────┘        ╰───────────────╯      ╲  ASI ╱
                                                   ╲  ╱
                                                    ╲╱
```

### B. Simbol Data Flow Diagram (DFD - Gane & Sarson / Yourdon)
```
  ┌───────────────┐           ╭───────────────╮           ┌──────────────┐
  │ENTITAS LUAR / │           │ PROSES SISTEM │          ═╡  DATA STORE  ╞═
  │  TERMINATOR   │           │ (Pengolahan)  │           └──────────────┘
  └───────────────┘           ╰───────────────╯
          │                           │                           │
          └───────────── ➔ DATA FLOW (Panah Aliran) ──────────────┘
```

### C. Simbol Flowchart (Standar ANSI)
```
        ╭──────────────╮                  ┌────────────────┐
       (   TERMINATOR   )                 │ PROSES / AKSI  │
        ╰──────────────╯                  └────────────────┘
          Start / End                     Eksekusi Sistem

              ╱╲                                ╱────────────────╱
             ╱  ╲   DECISION                   ╱ INPUT / OUTPUT ╱
            ╱    ╲  (Percabangan              ╱────────────────╱
            ╲    ╱   Logika Ya/Tidak)           Input Data / Tampilan
             ╲  ╱
              ╲╱                                ╭────────────────╮
                                               (    CONNECTOR   )
              │                                 ╰────────────────╯
              ▼ FLOWLINE (Arah Alir)             Titik Sambung Alur
```

---

## 3. Entity Relationship Diagram (ERD) & Kamus Data

### 3.1 Skema Relasi Fisik Database (Crow's Foot Notation)

```mermaid
erDiagram
    USERS ||--o{ COURSES : "creates / owns (Role: Guru)"
    USERS ||--o{ USER_PROGRESS : "tracks progress (Role: Siswa)"
    USERS ||--o{ CERTIFICATES : "receives upon completion"
    USERS ||--o{ USER_BADGES : "unlocks achievements"
    USERS ||--o{ USER_STREAKS : "records daily study"

    COURSES ||--|{ UNITS : "organized into"
    COURSES ||--o{ CERTIFICATES : "qualifies for"

    UNITS ||--|{ LESSONS : "contains"

    LESSONS ||--|{ EXERCISES : "contains questions"
    LESSONS ||--o{ USER_PROGRESS : "recorded in"

    USERS {
        bigint id PK
        string name "Nama Lengkap"
        string email "Email Unik Login"
        string password "Bcrypt Hash"
        enum role "super_admin | guru | siswa"
        int xp "Total Poin Belajar"
        int level "Tingkatan Level"
        int hearts "Nyawa (1-5)"
        int gems "Mata Uang Gamifikasi"
        int streak_count "Hari Berturut-turut"
        date last_active_date "Tanggal Aktif Terakhir"
        timestamp last_heart_refill_at "Waktu Terakhir Isi Nyawa"
        timestamp created_at
        timestamp updated_at
    }

    COURSES {
        bigint id PK
        bigint mentor_id FK "References users(id)"
        string title "Judul Kursus"
        string slug "URL Friendly Slug (Unique)"
        text description "Deskripsi Lengkap"
        string category "Kategori Materi"
        string target_audience "Target Usia / Jenjang"
        string thumbnail "Path Gambar Cover"
        enum level "beginner | intermediate | advanced"
        int total_xp "Total Akumulasi XP"
        boolean is_published "Status Rilis"
        boolean is_upcoming "Status Roadmap Mendatang"
        timestamp created_at
        timestamp updated_at
    }

    UNITS {
        bigint id PK
        bigint course_id FK "References courses(id)"
        string title "Judul Bab / Unit"
        text description "Deskripsi Singkat"
        int order_index "Urutan Bab (1, 2, 3..)"
        timestamp created_at
        timestamp updated_at
    }

    LESSONS {
        bigint id PK
        bigint unit_id FK "References units(id)"
        string title "Judul Modul Pelajaran"
        string slug "URL Friendly Slug"
        text description "Tujuan Pembelajaran"
        enum type "theory | quiz | milestone | project"
        boolean is_project "Penanda Proyek Akhir Bab"
        text project_brief "Instruksi Pengerjaan Proyek"
        longText theory_content "Konten Teks Materi (Opsional)"
        int xp_reward "Reward XP (Default: 15-50)"
        int order_index "Urutan Modul dalam Bab"
        timestamp created_at
        timestamp updated_at
    }

    EXERCISES {
        bigint id PK
        bigint lesson_id FK "References lessons(id)"
        enum question_type "multiple_choice | fill_blank | code_ordering | output_prediction | matching_pair | interactive_3d"
        text prompt "Pertanyaan / Instruksi Soal"
        text code_snippet "Snippet Baris Kode (Opsional)"
        json options_json "Array Opsi Jawaban / Distraktor"
        json answer_json "Kunci Jawaban Benar"
        json model_3d_json "Parameter Visual 3D (Preset, Warna, Animasi, Target XYZ)"
        text explanation "Pembahasan Konsep saat Dijawab"
        int order_index "Urutan Soal dalam Modul"
        timestamp created_at
        timestamp updated_at
    }

    USER_PROGRESS {
        bigint id PK
        bigint user_id FK "References users(id)"
        bigint lesson_id FK "References lessons(id)"
        boolean is_completed "Status Lulus Modul"
        int score "Skor Evaluasi (0 - 100)"
        timestamp completed_at "Waktu Penyelesaian"
        timestamp created_at
        timestamp updated_at
    }

    CERTIFICATES {
        bigint id PK
        string cert_code UK "Kode Publik (Format: ES-PY-YYYY-XXXX)"
        string cert_hash UK "SHA-256 Unique Hash"
        bigint user_id FK "References users(id)"
        bigint course_id FK "References courses(id)"
        string recipient_name "Nama Siswa Pemilik"
        string course_title "Judul Kursus Lulus"
        string mentor_name "Nama Guru / Pengampu"
        decimal score_average "Nilai Rata-rata Akhir (Grade A/B/C)"
        date issue_date "Tanggal Penerbitan"
        string qr_code_url "QR Code SVG Verifikasi"
        string pdf_path "File PDF Cetak"
        boolean is_valid "Status Validitas Sertifikat"
        timestamp created_at
        timestamp updated_at
    }

    USER_BADGES {
        bigint id PK
        bigint user_id FK "References users(id)"
        string badge_code "Kode Unik Badge (STREAK_7, FIRST_3D, dll)"
        string badge_name "Nama Lencana"
        string badge_description "Kriteria Pembukaan"
        string icon "Icon Badge"
        timestamp unlocked_at "Waktu Didapatkan"
        timestamp created_at
        timestamp updated_at
    }

    USER_STREAKS {
        bigint id PK
        bigint user_id FK "References users(id)"
        date active_date "Tanggal Sesi Belajar Harian"
        timestamp created_at
        timestamp updated_at
    }
```

---

### 3.2 Kamus Data Lengkap (Data Dictionary)

| Nama Tabel | Atribut / Kolom | Tipe Data | Nullable | Keterangan & Aturan Bisnis |
| :--- | :--- | :--- | :---: | :--- |
| **users** | `id` | BIGINT (PK) | No | Auto increment primary key |
| | `name` | VARCHAR(255) | No | Nama lengkap pengguna |
| | `email` | VARCHAR(255) | No | Email akun unik (*Unique Index*) |
| | `password` | VARCHAR(255) | No | Password terenkripsi Bcrypt |
| | `role` | ENUM | No | Hak akses: `super_admin`, `guru`, `siswa` |
| | `xp` | INT | No | Akumulasi poin pengalaman belajar (XP) |
| | `level` | INT | No | Level siswa (dihitung otomatis per kelipatan XP) |
| | `hearts` | INT | No | Nyawa siswa (maksimal 5, berkurang 1 jika salah) |
| | `gems` | INT | No | Permata hadiah penyelesaian misi/refill |
| | `streak_count` | INT | No | Jumlah hari berturut-turut aktif belajar |
| | `last_active_date` | DATE | Yes | Tanggal terakhir login/berlatih |
| **courses** | `id` | BIGINT (PK) | No | Primary key kursus |
| | `mentor_id` | BIGINT (FK) | No | Relasi ke `users.id` pembuat kursus |
| | `title` | VARCHAR(255) | No | Judul kursus materi |
| | `slug` | VARCHAR(255) | No | Slug URL SEO-friendly (*Unique*) |
| | `category` | VARCHAR(100) | No | Kategori pemrograman |
| | `level` | ENUM | No | Tingkat kesulitan: `beginner`, `intermediate`, `advanced` |
| | `is_published` | BOOLEAN | No | Status rilis (True = Aktif ke Siswa) |
| | `is_upcoming` | BOOLEAN | No | Status roadmap mendatang (True = Teaser) |
| **units** | `id` | BIGINT (PK) | No | Primary key bab |
| | `course_id` | BIGINT (FK) | No | Relasi ke `courses.id` (*Cascade Delete*) |
| | `title` | VARCHAR(255) | No | Nama bab/unit materi |
| | `order_index` | INT | No | Nomor urut bab di kurikulum |
| **lessons** | `id` | BIGINT (PK) | No | Primary key modul |
| | `unit_id` | BIGINT (FK) | No | Relasi ke `units.id` (*Cascade Delete*) |
| | `title` | VARCHAR(255) | No | Judul modul latihan |
| | `type` | ENUM | No | Jenis: `theory`, `quiz`, `milestone`, `project` |
| | `is_project` | BOOLEAN | No | Penanda tugas Mini Project akhir bab |
| | `project_brief`| TEXT | Yes | Petunjuk skenario tugas proyek |
| | `xp_reward` | INT | No | Hadiah XP saat modul diselesaikan |
| **exercises** | `id` | BIGINT (PK) | No | Primary key butir soal |
| | `lesson_id` | BIGINT (FK) | No | Relasi ke `lessons.id` (*Cascade Delete*) |
| | `question_type`| ENUM | No | `multiple_choice`, `fill_blank`, `code_ordering`, `output_prediction`, `matching_pair`, `interactive_3d` |
| | `prompt` | TEXT | No | Teks instruksi/pertanyaan soal |
| | `code_snippet` | TEXT | Yes | Potongan baris kode (editor) |
| | `options_json` | JSON | Yes | Opsi distraktor pilihan jawaban |
| | `answer_json` | JSON | Yes | Kunci jawaban yang benar |
| | `model_3d_json` | JSON | Yes | Konfigurasi objek 3D (preset, warna, animasi, matrix target XYZ, skala) |
| | `explanation` | TEXT | Yes | Teks pembahasan solusi |
| **user_progress**| `id` | BIGINT (PK) | No | Primary key riwayat progres |
| | `user_id` | BIGINT (FK) | No | Relasi ke `users.id` siswa |
| | `lesson_id` | BIGINT (FK) | No | Relasi ke `lessons.id` modul |
| | `is_completed` | BOOLEAN | No | Status kelulusan modul |
| | `score` | INT | No | Nilai pengerjaan soal (0-100) |
| | `completed_at` | TIMESTAMP | Yes | Waktu tuntas modul |
| **certificates**| `id` | BIGINT (PK) | No | Primary key sertifikat |
| | `cert_code` | VARCHAR(50) | No | Kode unik sertifikat (*Unique*) |
| | `cert_hash` | VARCHAR(64) | No | SHA-256 hash digital signature (*Unique*) |
| | `user_id` | BIGINT (FK) | No | Relasi ke `users.id` peraih sertifikat |
| | `course_id` | BIGINT (FK) | No | Relasi ke `courses.id` |
| | `score_average`| DECIMAL(5,2)| No | Rata-rata nilai kuis seluruh modul |
| | `issue_date` | DATE | No | Tanggal terbit sertifikat |
| | `qr_code_url` | VARCHAR(255) | Yes | URL / Path QR Code verifikasi publik |
| | `is_valid` | BOOLEAN | No | Status keaslian (True = Sah) |

---

## 4. Data Flow Diagram (DFD)

### 4.1 DFD Level 0 (Diagram Konteks)

```mermaid
flowchart TD
    subgraph TERMINATORS ["Entitas Luar / External Entities"]
        SISWA["👤 SISWA (STUDENT)"]
        GURU["👨‍🏫 GURU / MENTOR"]
        ADMIN["🛡️ SUPER ADMIN"]
        PUBLIK["🌐 VERIFIKATOR PUBLIK"]
    end

    SYS(("⚡ 0.0<br/><b>SISTEM EDUSKILL</b><br/>Platform Gamifikasi & Kuis 3D"))

    %% Siswa
    SISWA -- "1. Data Akun & Kredensial Login" --> SYS
    SISWA -- "2. Input Jawaban Kuis (MCQ, Isian, Parsons, Pasangan, 3D)" --> SYS
    SISWA -- "3. Permintaan Refill Nyawa (Tukar 20 Gems)" --> SYS
    SISWA -- "4. Permintaan Klaim Sertifikat Kursus" --> SYS

    SYS -- "1. Data Roadmap Belajar & Status Modul" --> SISWA
    SYS -- "2. Objek 3D Spasial & Feedback Hasil Jawaban" --> SISWA
    SYS -- "3. Update XP, Level, Sisa Hearts, Gems, & Badge" --> SISWA
    SYS -- "4. Dokumen Sertifikat Digital & QR Code" --> SISWA

    %% Guru
    GURU -- "1. Data Profil & Kursus Baru" --> SYS
    GURU -- "2. Struktur Bab, Modul, & Mini Project" --> SYS
    GURU -- "3. Konfigurasi 3D Studio & Template Excel XLSX" --> SYS
    GURU -- "4. Perintah Rilis / Arsipkan Roadmap" --> SYS

    SYS -- "1. Live 3D Studio Preview (Three.js)" --> GURU
    SYS -- "2. Ringkasan Modul & Hasil Import Soal" --> GURU

    %% Admin
    ADMIN -- "1. Manajemen Akun Guru & Siswa" --> SYS
    ADMIN -- "2. Kontrol Hak Akses & Monitoring Platform" --> SYS
    SYS -- "1. Laporan Statistik & Aktivitas Sistem" --> ADMIN

    %% Publik
    PUBLIK -- "1. Request Verifikasi Hash / Scan QR Sertifikat" --> SYS
    SYS -- "1. Status Keabsahan, Nilai, & Pemilik Sertifikat" --> PUBLIK
```

---

### 4.2 DFD Level 1 (Dekomposisi Sistem Utama)

```mermaid
flowchart TD
    %% Entitas Luar
    E_SISWA["👤 Siswa"]
    E_GURU["👨‍🏫 Guru / Mentor"]
    E_ADMIN["🛡️ Super Admin"]
    E_PUBLIK["🌐 Verifikator Publik"]

    %% Data Stores
    D1[("💾 D1: Users & Auth")]
    D2[("💾 D2: Courses & Units")]
    D3[("💾 D3: Lessons & Exercises (Termasuk 3D)")]
    D4[("💾 D4: Progress, Streaks, & Badges")]
    D5[("💾 D5: Certificates")]

    %% Proses Utama Level 1
    P1(("1.0<br/>Autentikasi &<br/>Manajemen Profil"))
    P2(("2.0<br/>Manajemen Kurikulum<br/>& Studio Soal 3D"))
    P3(("3.0<br/>Penyajian Roadmap<br/>& Runner Kuis 3D"))
    P4(("4.0<br/>Evaluasi Jawaban &<br/>Gamifikasi (XP/Hati)"))
    P5(("5.0<br/>Penerbitan &<br/>Verifikasi Sertifikat"))

    %% Hubungan Aliran Data
    E_SISWA & E_GURU & E_ADMIN -- "Kredensial Login / Register" --> P1
    P1 <--> D1
    P1 -- "Akses Diberikan & Info Sesi" --> E_SISWA & E_GURU & E_ADMIN

    E_GURU -- "Kelola Kursus, Bab, Soal 3D, File XLSX" --> P2
    P2 <--> D2
    P2 <--> D3
    P2 -- "Tampilan Kurikulum & Live 3D Preview" --> E_GURU

    E_SISWA -- "Pilih Kursus & Buka Modul" --> P3
    D2 & D3 --> P3
    P3 -- "Render Canvas 3D & Soal Interaktif" --> E_SISWA

    E_SISWA -- "Kirim Jawaban Kuis / Soal 3D" --> P4
    D3 --> P4
    P4 -- "Update Progres Selesai & Nilai" --> D4
    P4 -- "Tambah XP, Kurangi Hati, Tambah Gems" --> D1
    P4 -- "Hasil Jawaban & Pembahasan Konsep" --> E_SISWA

    E_SISWA -- "Klaim Sertifikat Selesai 100%" --> P5
    D4 & D2 --> P5
    P5 -- "Simpan Record Sertifikat & Generate Hash" --> D5
    P5 -- "File Sertifikat & Link QR" --> E_SISWA

    E_PUBLIK -- "Cek Kode Hash / Scan QR" --> P5
    D5 --> P5
    P5 -- "Tampilkan Status Sah & Data Nilai" --> E_PUBLIK
```

---

### 4.3 DFD Level 2.1 (Sub-Proses 2.0: Manajemen Kurikulum & Studio 3D Guru)

```mermaid
flowchart TD
    GURU["👨‍🏫 Guru / Mentor"]
    
    D2[("💾 D2: Courses & Units")]
    D3[("💾 D3: Lessons & Exercises")]

    P2_1(("2.1<br/>Kelola Kursus &<br/>Status Rilis"))
    P2_2(("2.2<br/>Kelola Bab &<br/>Mini Project"))
    P2_3(("2.3<br/>Studio Kustomisasi<br/>Visual Soal 3D"))
    P2_4(("2.4<br/>Batch Import<br/>Excel XLSX / CSV"))

    GURU -- "Judul, Kategori, Level, Toggle Rilis" --> P2_1 <--> D2
    GURU -- "Tambah Unit & Flag Mini Project" --> P2_2 <--> D2 & D3
    GURU -- "Preset 3D, Warna, Target XYZ, Animasi" --> P2_3 <--> D3
    P2_3 -- "Preview Real-Time 3D" --> GURU
    GURU -- "Upload File Excel Template" --> P2_4
    P2_4 -- "Validasi Baris & Batch Insert" --> D3
    P2_4 -- "Laporan Hasil Import" --> GURU
```

---

### 4.4 DFD Level 2.2 (Sub-Proses 3.0 & 4.0: Lesson Player & Gamifikasi Siswa)

```mermaid
flowchart TD
    SISWA["👤 Siswa"]
    
    D1[("💾 D1: Users")]
    D3[("💾 D3: Lessons & Exercises")]
    D4[("💾 D4: User Progress & Streaks")]

    P3_1(("3.1<br/>Pengecekan Kuota<br/>Nyawa (Hearts)"))
    P3_2(("3.2<br/>Inisialisasi 3D<br/>Three.js Runtime"))
    P4_1(("4.1<br/>Validasi Jawaban<br/>(Algoritma Gamifikasi)"))
    P4_2(("4.2<br/>Kalkulasi XP,<br/>Level, & Streak"))
    P4_3(("4.3<br/>Refill Hearts<br/>via Gems"))

    SISWA -- "Mulai Modul" --> P3_1
    D1 --> P3_1
    P3_1 -- "Hearts > 0" --> P3_2
    P3_1 -- "Hearts == 0" --> P4_3
    SISWA -- "Tukar 20 Gems" --> P4_3 <--> D1

    D3 --> P3_2 -- "Tampilkan Soal & 3D Model" --> SISWA
    SISWA -- "Submit Jawaban" --> P4_1
    D3 --> P4_1
    
    P4_1 -- "Jawaban Salah" --> P4_2
    P4_2 -- "Hearts - 1" --> D1
    
    P4_1 -- "Jawaban Benar" --> P4_2
    P4_2 -- "+XP, +Streak, Catat Lulus" --> D1 & D4
    P4_2 -- "Feedback Suara & UI" --> SISWA
```

---

### 4.5 DFD Level 2.3 (Sub-Proses 5.0: Klaim & Verifikasi Sertifikat)

```mermaid
flowchart TD
    SISWA["👤 Siswa"]
    PUBLIK["🌐 Verifikator Publik"]

    D2[("💾 D2: Courses")]
    D4[("💾 D4: User Progress")]
    D5[("💾 D5: Certificates")]

    P5_1(("5.1<br/>Validasi Kelulusan<br/>100% Modul"))
    P5_2(("5.2<br/>Hitung Rata-rata Skor<br/>& Generate SHA-256"))
    P5_3(("5.3<br/>Generate QR Code<br/>& Simpan Sertifikat"))
    P5_4(("5.4<br/>Pengecekan Publik<br/>& Verifikasi Status"))

    SISWA -- "Request Klaim" --> P5_1
    D4 & D2 --> P5_1
    P5_1 -- "Lulus Semua Modul" --> P5_2
    P5_2 -- "Data Nilai & Hash" --> P5_3
    P5_3 --> D5
    P5_3 -- "Sertifikat Sah & QR Code" --> SISWA

    PUBLIK -- "Scan QR / Akses Hash URL" --> P5_4
    D5 --> P5_4
    P5_4 -- "Detail Nilai, Nama, & Status Valid" --> PUBLIK
```

---

## 5. Flowchart Sistem (Diagram Alir Proses Lengkap)

### 5.1 Flowchart Autentikasi & Role Redirection

```mermaid
flowchart TD
    Start(["Mulai: Buka Aplikasi EduSkill"]) --> OpenLogin[/"Akses Halaman Login"/]
    OpenLogin --> InputCred[/"Input Email & Password"/]
    InputCred --> CheckAuth{"Kredensial Valid?"}
    
    CheckAuth -- "Tidak" --> AlertErr[/"Tampilkan Pesan Error: Email atau Password Salah"/] --> OpenLogin
    CheckAuth -- "Ya" --> CheckRole{"Cek Hak Akses (Role)"}
    
    CheckRole -- "super_admin" --> DashAdmin["Redirect ke Dashboard Super Admin"] --> EndAdmin(["Selesai"])
    CheckRole -- "guru" --> DashMentor["Redirect ke Dashboard Guru / Mentor"] --> EndMentor(["Selesai"])
    CheckRole -- "siswa" --> LearnRoadmap["Redirect ke Halaman Belajar Siswa"] --> EndSiswa(["Selesai"])
```

---

### 5.2 Flowchart Siswa (Belajar, Pengerjaan Kuis 3D, & Gamifikasi)

```mermaid
flowchart TD
    Start(["Mulai: Siswa Memilih Modul"]) --> CheckHearts{"Nyawa (Hearts) > 0?"}
    
    %% Alur Habis Nyawa
    CheckHearts -- "Tidak" --> CheckGems{"Gems >= 20?"}
    CheckGems -- "Ya" --> ModalRefill[/"Tampilkan Opsi: Tukar 20 Gems untuk Isi Penuh Nyawa"/]
    ModalRefill --> ConfirmRefill{"Siswa Menyetujui?"}
    ConfirmRefill -- "Ya" --> DoRefill["Potong 20 Gems, Reset Hearts = 5"] --> Start
    ConfirmRefill -- "Tidak" --> WaitRefill["Tunggu Regenerasi Nyawa Otomatis"] --> EndFinish(["Selesai"])
    CheckGems -- "Tidak" --> WaitRefill
    
    %% Alur Mulai Latihan
    CheckHearts -- "Ya" --> LoadExercise["Inisialisasi Lesson Runner & Objek 3D"]
    LoadExercise --> ShowQuestion[/"Tampilkan Soal, Editor Kode, & Model 3D Interaktif"/]
    ShowQuestion --> UserAnswer[/"Siswa Memilih Jawaban / Mengatur Posisi 3D"/]
    UserAnswer --> ClickSubmit[/"Klik Tombol 'Periksa Jawaban'"/]
    
    ClickSubmit --> EvaluateAnswer{"Jawaban Benar?"}
    
    %% Evaluasi Salah
    EvaluateAnswer -- "Tidak" --> DeductHeart["Kurangi 1 Heart, Mainkan Suara Error"]
    DeductHeart --> ShowExplain[/"Tampilkan Pembahasan Soal"/]
    ShowExplain --> CheckHeartsLeft{"Sisa Hearts > 0?"}
    CheckHeartsLeft -- "Ya" --> RetryQuestion[/"Coba Kerjakan Ulang Soal"/] --> ShowQuestion
    CheckHeartsLeft -- "Tidak" --> ShowOutModal[/"Tampilkan Modal 'Nyawa Habis'"/] --> EndFinish
    
    %% Evaluasi Benar
    EvaluateAnswer -- "Ya" --> PlaySuccess["Mainkan Efek Suara Sukses & Animasi Kemenangan"]
    PlaySuccess --> AddRewards["Tambah XP, Catat Skor, Update Streak Harian"]
    AddRewards --> SaveProgressDB[("Database: Simpan user_progress is_completed = true")]
    SaveProgressDB --> CheckAllCompleted{"Seluruh Modul Kursus 100% Selesai?"}
    
    CheckAllCompleted -- "Ya" --> EnableCertClaim[/"Tombol 'Klaim Sertifikat' Aktif di Roadmap"/]
    CheckAllCompleted -- "Tidak" --> NextModuleBtn[/"Lanjut ke Modul Berikutnya di Roadmap"/]
    
    EnableCertClaim --> EndFinish
    NextModuleBtn --> EndFinish
```

---

### 5.3 Flowchart Guru / Mentor (Kurikulum, Studio 3D, & Import Excel)

```mermaid
flowchart TD
    StartM(["Mulai: Guru Buka Kelola Kurikulum"]) --> ViewManage["Buka Halaman Kursus"]
    ViewManage --> SelectAction{"Pilih Aksi Guru"}
    
    %% Tambah Unit / Modul
    SelectAction -- "Tambah Bab / Modul" --> FormUnitLesson[/"Input Judul Bab & Flag Mini Project"/]
    FormUnitLesson --> SaveUnitDB[("Database: Simpan Unit & Lesson")] --> RefreshUI["Refresh Daftar Kurikulum"]
    
    %% Import Excel
    SelectAction -- "Import Excel Soal" --> DownloadTemplate[/"Download File Template XLSX/CSV"/]
    DownloadTemplate --> FillExcelData[/"Guru Mengisi Daftar Soal di Excel"/]
    FillExcelData --> UploadExcel[/"Upload File XLSX ke Modul Target"/]
    UploadExcel --> ParseExcel{"Format & Header Valid?"}
    ParseExcel -- "Tidak" --> ShowImportError[/"Tampilkan Notifikasi Baris yang Salah"/] --> UploadExcel
    ParseExcel -- "Ya" --> BatchInsertDB[("Database: Batch Insert Seluruh Soal")] --> RefreshUI
    
    %% Buat Soal Manual & 3D Studio
    SelectAction -- "Buat Soal Interaktif" --> ChooseType[/"Pilih Tipe: 3D Interaktif / MCQ / Isian / Susun / Pasangan"/]
    ChooseType --> CheckIs3D{"Tipe == 3D Interaktif?"}
    
    CheckIs3D -- "Ya" --> Set3DOptions[/"Pilih Preset Geometri, Animasi, Warna, Target X/Y/Z"/]
    Set3DOptions --> RealtimeRender["Three.js Engine Render Preview Real-Time"]
    RealtimeRender --> InputQuestions[/"Isi Pertanyaan, Pilihan A-D, & Kunci"/]
    
    CheckIs3D -- "Tidak" --> InputStandard[/"Isi Pertanyaan & Pilihan Jawaban Standar"/]
    
    InputQuestions --> ClickSaveEx[/"Klik Simpan Soal"/]
    InputStandard --> ClickSaveEx
    ClickSaveEx --> SaveExDB[("Database: Simpan exercises")] --> RefreshUI
    
    %% Rilis Roadmap
    RefreshUI --> WantRelease{"Rilis Kursus ke Siswa?"}
    WantRelease -- "Ya" --> SetPublish["Update courses: is_published = true, is_upcoming = false"]
    WantRelease -- "Tidak" --> SetDraft["Update courses: is_upcoming = true / Draft"]
    
    SetPublish --> EndM(["Selesai"])
    SetDraft --> EndM
```

---

### 5.4 Flowchart Super Admin (Manajemen User & Monitoring)

```mermaid
flowchart TD
    StartA(["Mulai: Super Admin Login"]) --> AdminDash["Buka Admin Control Panel"]
    AdminDash --> ChooseAdminMenu{"Pilih Menu Kelola"}
    
    ChooseAdminMenu -- "Manajemen Pengguna" --> ViewUsers[/"Lihat Daftar Seluruh User"/]
    ViewUsers --> UserAction{"Aksi User"}
    UserAction -- "Ubah Role" --> ChangeRole["Ubah Role Siswa/Guru/Admin"] --> SaveUserDB[("Update Database Users")]
    UserAction -- "Reset Password" --> ResetPass["Generate Password Baru"] --> SaveUserDB
    UserAction -- "Hapus Akun" --> DeleteUser["Hapus User Beserta Relasi"] --> SaveUserDB
    
    ChooseAdminMenu -- "Monitoring Kursus" --> ViewCourses[/"Lihat Seluruh Kursus Platform"/]
    ViewCourses --> CourseAction{"Aksi Kursus"}
    CourseAction -- "Verifikasi Kelayakan" --> ApproveCourse["Setujui / Publikasikan Kursus"] --> SaveCourseDB[("Update Database Courses")]
    CourseAction -- "Hapus Kursus Tidak Sesuai" --> DropCourse["Hapus Kursus"] --> SaveCourseDB
    
    SaveUserDB --> AdminDash
    SaveCourseDB --> AdminDash
```

---

### 5.5 Flowchart Verifikasi Sertifikat Publik (QR & SHA-256 Hash)

```mermaid
flowchart TD
    StartV(["Mulai: Pihak Ketiga Ingin Memverifikasi Sertifikat"]) --> ChooseMethod{"Metode Pengecekan"}
    
    %% Melalui QR
    ChooseMethod -- "Scan QR Code" --> ScanQR[/"Scan QR Code di Sertifikat Cetak/PDF"/]
    ScanQR --> ExtractHash["Ambil URL /certificate/verify/{hash}"]
    
    %% Melalui Input Manual
    ChooseMethod -- "Input Kode / Hash" --> OpenVerifyPage[/"Buka Halaman Web Verifikasi Sertifikat"/]
    OpenVerifyPage --> InputHashOrCode[/"Masukkan Kode Sertifikat / Hash SHA-256"/]
    InputHashOrCode --> ExtractHash
    
    ExtractHash --> QueryCert[("Database: Cari di Tabel certificates berdasarkan cert_hash / cert_code")]
    QueryCert --> FoundCert{"Data Ditemukan & is_valid == true?"}
    
    %% Hasil Valid
    FoundCert -- "Ya" --> DisplayValidBadge[/"Tampilkan Badge Hijau: RESMI & TERVERIFIKASI"/]
    DisplayValidBadge --> RenderDetails[/"Tampilkan: Nama Siswa, Judul Kursus, Nilai Rata-rata, Tanggal Terbit, & Nama Guru"/]
    
    %% Hasil Tidak Valid
    FoundCert -- "Tidak" --> DisplayInvalidBadge[/"Tampilkan Badge Merah: SERTIFIKAT TIDAK DITEMUKAN / TIDAK VALID"/]
    
    RenderDetails --> EndV(["Selesai"])
    DisplayInvalidBadge --> EndV
```

---

## 6. Kesimpulan & Penjelasan untuk Dosen

1. **Integritas Relasional & Normalisasi 3NF**:
   - Struktur database telah dinormalisasi hingga tahap **Third Normal Form (3NF)**.
   - Menggunakan *Foreign Key Constraints* dengan `onDelete('cascade')` untuk mencegah *orphan records*.
2. **Kesesuaian dengan Implementasi Nyata**:
   - Diagram ini mencerminkan 100% kode implementasi Laravel yang aktif di repository `Hadi-Akram-Ramadhan/Website-EDUSKILL`, termasuk fitur kuis 3D Three.js, gamifikasi Hearts & Gems, import XLSX SheetJS/Laravel-Excel, serta validasi QR hash digital certificate.
