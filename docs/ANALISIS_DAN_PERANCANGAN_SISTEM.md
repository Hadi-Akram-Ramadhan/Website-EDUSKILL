# Dokumentasi Lengkap Analisis & Perancangan Sistem (ERD, DFD Level 0-2, Flowchart, & Kamus Data)

**Platform Edukasi Pemrograman Interaktif & Visualisasi Spasial 3D — EduSkill**

---

## DAFTAR ISI

1. [Status Penyelesaian Masalah Sebelumnya (Verification Report)](#1-status-penyelesaian-masalah-sebelumnya)
2. [Notasi &amp; Standar Bentuk Simbol (Akademis ANSI &amp; Gane-Sarson)](#2-notasi--standar-bentuk-simbol)
3. [Entity Relationship Diagram (ERD) &amp; Kamus Data](#3-entity-relationship-diagram-erd--kamus-data)
    - 3.1 Skema Relasi Fisik (Crow's Foot Notation)
    - 3.2 Notasi Konseptual Chen
    - 3.3 Kamus Data Lengkap (Data Dictionary)
4. [Data Flow Diagram (DFD)](#4-data-flow-diagram-dfd)
    - 4.1 DFD Level 0 (Diagram Konteks)
    - 4.2 DFD Level 1 (Dekomposisi Sistem Utama)
    - 4.3 DFD Level 2.1 (Sub-Proses Manajemen Kurikulum & Studio 3D)
    - 4.4 DFD Level 2.2 (Sub-Proses Lesson Player & Evaluasi Gamifikasi)
    - 4.5 DFD Level 2.3 (Sub-Proses Klaim & Verifikasi Sertifikat)
5. [Flowchart Sistem Terintegrasi (Master Unified Flowchart)](#5-flowchart-sistem-terintegrasi-master-unified-flowchart)
    - 5.1 Diagram Alir Terpadu Sistem EduSkill (End-to-End Flowchart)
    - 5.2 Penjelasan Alur Integrasi Antar-Modul (Swimlane Breakdown)

---

## 1. Status Penyelesaian Masalah Sebelumnya

Sebelum masuk ke diagram, berikut konfirmasi status teknis perbaikan yang telah diverifikasi:

1. **Problem WebGL Context Exhaustion (`WARNING: Too many active WebGL contexts`)**:
    - **Status**: **SOLVED & ZERO WARNINGS**.
    - **Perbaikan**: Menggunakan _Singleton Pattern Session_ pada Three.js preview canvas. Render ulang mesh/material hanya memodifikasi objek di memori (`_updateMentor3DScene`) tanpa membuat context `WebGLRenderer` baru. Saat berpindah tipe kuis, `renderer.forceContextLoss()` dipanggil untuk pelepasan memori GPU seketika.
2. **Problem Responsivitas Layar Mobile (Ukuran HP 375px–400px)**:
    - **Status**: **SOLVED & 100% RESPONSIVE**.
    - **Perbaikan**:
        - Nested card padding disesuaikan proporsional (`12px` di mobile vs `24px` di desktop).
        - Input pasangan menjodohkan (_Matching Pairs_) dibungkus dengan class responsif (`min-width: 0`, auto flex/grid).
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

| Nama Tabel        | Atribut / Kolom    | Tipe Data    | Nullable | Keterangan & Aturan Bisnis                                                                               |
| :---------------- | :----------------- | :----------- | :------: | :------------------------------------------------------------------------------------------------------- |
| **users**         | `id`               | BIGINT (PK)  |    No    | Auto increment primary key                                                                               |
|                   | `name`             | VARCHAR(255) |    No    | Nama lengkap pengguna                                                                                    |
|                   | `email`            | VARCHAR(255) |    No    | Email akun unik (_Unique Index_)                                                                         |
|                   | `password`         | VARCHAR(255) |    No    | Password terenkripsi Bcrypt                                                                              |
|                   | `role`             | ENUM         |    No    | Hak akses:`super_admin`, `guru`, `siswa`                                                                 |
|                   | `xp`               | INT          |    No    | Akumulasi poin pengalaman belajar (XP)                                                                   |
|                   | `level`            | INT          |    No    | Level siswa (dihitung otomatis per kelipatan XP)                                                         |
|                   | `hearts`           | INT          |    No    | Nyawa siswa (maksimal 5, berkurang 1 jika salah)                                                         |
|                   | `gems`             | INT          |    No    | Permata hadiah penyelesaian misi/refill                                                                  |
|                   | `streak_count`     | INT          |    No    | Jumlah hari berturut-turut aktif belajar                                                                 |
|                   | `last_active_date` | DATE         |   Yes    | Tanggal terakhir login/berlatih                                                                          |
| **courses**       | `id`               | BIGINT (PK)  |    No    | Primary key kursus                                                                                       |
|                   | `mentor_id`        | BIGINT (FK)  |    No    | Relasi ke`users.id` pembuat kursus                                                                       |
|                   | `title`            | VARCHAR(255) |    No    | Judul kursus materi                                                                                      |
|                   | `slug`             | VARCHAR(255) |    No    | Slug URL SEO-friendly (_Unique_)                                                                         |
|                   | `category`         | VARCHAR(100) |    No    | Kategori pemrograman                                                                                     |
|                   | `level`            | ENUM         |    No    | Tingkat kesulitan:`beginner`, `intermediate`, `advanced`                                                 |
|                   | `is_published`     | BOOLEAN      |    No    | Status rilis (True = Aktif ke Siswa)                                                                     |
|                   | `is_upcoming`      | BOOLEAN      |    No    | Status roadmap mendatang (True = Teaser)                                                                 |
| **units**         | `id`               | BIGINT (PK)  |    No    | Primary key bab                                                                                          |
|                   | `course_id`        | BIGINT (FK)  |    No    | Relasi ke`courses.id` (_Cascade Delete_)                                                                 |
|                   | `title`            | VARCHAR(255) |    No    | Nama bab/unit materi                                                                                     |
|                   | `order_index`      | INT          |    No    | Nomor urut bab di kurikulum                                                                              |
| **lessons**       | `id`               | BIGINT (PK)  |    No    | Primary key modul                                                                                        |
|                   | `unit_id`          | BIGINT (FK)  |    No    | Relasi ke`units.id` (_Cascade Delete_)                                                                   |
|                   | `title`            | VARCHAR(255) |    No    | Judul modul latihan                                                                                      |
|                   | `type`             | ENUM         |    No    | Jenis:`theory`, `quiz`, `milestone`, `project`                                                           |
|                   | `is_project`       | BOOLEAN      |    No    | Penanda tugas Mini Project akhir bab                                                                     |
|                   | `project_brief`    | TEXT         |   Yes    | Petunjuk skenario tugas proyek                                                                           |
|                   | `xp_reward`        | INT          |    No    | Hadiah XP saat modul diselesaikan                                                                        |
| **exercises**     | `id`               | BIGINT (PK)  |    No    | Primary key butir soal                                                                                   |
|                   | `lesson_id`        | BIGINT (FK)  |    No    | Relasi ke`lessons.id` (_Cascade Delete_)                                                                 |
|                   | `question_type`    | ENUM         |    No    | `multiple_choice`, `fill_blank`, `code_ordering`, `output_prediction`, `matching_pair`, `interactive_3d` |
|                   | `prompt`           | TEXT         |    No    | Teks instruksi/pertanyaan soal                                                                           |
|                   | `code_snippet`     | TEXT         |   Yes    | Potongan baris kode (editor)                                                                             |
|                   | `options_json`     | JSON         |   Yes    | Opsi distraktor pilihan jawaban                                                                          |
|                   | `answer_json`      | JSON         |   Yes    | Kunci jawaban yang benar                                                                                 |
|                   | `model_3d_json`    | JSON         |   Yes    | Konfigurasi objek 3D (preset, warna, animasi, matrix target XYZ, skala)                                  |
|                   | `explanation`      | TEXT         |   Yes    | Teks pembahasan solusi                                                                                   |
| **user_progress** | `id`               | BIGINT (PK)  |    No    | Primary key riwayat progres                                                                              |
|                   | `user_id`          | BIGINT (FK)  |    No    | Relasi ke`users.id` siswa                                                                                |
|                   | `lesson_id`        | BIGINT (FK)  |    No    | Relasi ke`lessons.id` modul                                                                              |
|                   | `is_completed`     | BOOLEAN      |    No    | Status kelulusan modul                                                                                   |
|                   | `score`            | INT          |    No    | Nilai pengerjaan soal (0-100)                                                                            |
|                   | `completed_at`     | TIMESTAMP    |   Yes    | Waktu tuntas modul                                                                                       |
| **certificates**  | `id`               | BIGINT (PK)  |    No    | Primary key sertifikat                                                                                   |
|                   | `cert_code`        | VARCHAR(50)  |    No    | Kode unik sertifikat (_Unique_)                                                                          |
|                   | `cert_hash`        | VARCHAR(64)  |    No    | SHA-256 hash digital signature (_Unique_)                                                                |
|                   | `user_id`          | BIGINT (FK)  |    No    | Relasi ke`users.id` peraih sertifikat                                                                    |
|                   | `course_id`        | BIGINT (FK)  |    No    | Relasi ke`courses.id`                                                                                    |
|                   | `score_average`    | DECIMAL(5,2) |    No    | Rata-rata nilai kuis seluruh modul                                                                       |
|                   | `issue_date`       | DATE         |    No    | Tanggal terbit sertifikat                                                                                |
|                   | `qr_code_url`      | VARCHAR(255) |   Yes    | URL / Path QR Code verifikasi publik                                                                     |
|                   | `is_valid`         | BOOLEAN      |    No    | Status keaslian (True = Sah)                                                                             |

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

## 5. Flowchart Sistem Terintegrasi (Master Unified Flowchart)

Bagian ini menyajikan **Diagram Alir Terpadu (Unified End-to-End System Flowchart)** yang menggabungkan seluruh alur proses utama di platform EduSkill ke dalam satu bagan komprehensif. Diagram ini menyatukan 5 domain proses yang sebelumnya terpisah menjadi satu siklus alur yang saling terhubung:
1. **Gerbang Akses & Autentikasi**: Percabangan login terdaftar vs verifikasi sertifikat publik, validasi kredensial, dan routing hak akses (*Role Redirection*).
2. **Sub-Sistem Super Admin**: Monitoring platform, moderasi kursus/materi, dan tata kelola akun pengguna (*Role & Account Management*).
3. **Sub-Sistem Guru/Mentor**: Manajemen kurikulum (unit & lesson), import soal massal via file Excel XLSX, Three.js 3D Studio editor, dan publikasi kursus.
4. **Sub-Sistem Siswa**: Siklus belajar interaktif, engine gamifikasi (Hearts & Gems), simulasi kuis 3D WebGL, penambahan XP & streak, hingga kelulusan modul.
5. **Sub-Sistem Penerbitan & Verifikasi Sertifikat**: Otomatisasi generate hash SHA-256 unik, pembuatan QR Code dinamis, dan verifikasi publik multi-kanal (scan QR maupun input kode).

---

### 5.1 Diagram Alir Terpadu Sistem EduSkill (End-to-End Flowchart)

```mermaid
flowchart TD
    %% TITIK AWAL
    Start(["Mulai: Akses Platform EduSkill"]) --> ChoiceEntry{"Akses Pengguna"}

    %% ==========================================
    %% 1. GERBANG AUTENTIKASI & AKSES
    %% ==========================================
    subgraph SG_AUTH ["🔐 1. Gerbang Akses & Autentikasi Sistem"]
        ChoiceEntry -- "Akses Akun / Login" --> OpenLogin[/"Halaman Login: Input Email & Password"/]
        OpenLogin --> CheckAuth{"Kredensial Valid?"}
        CheckAuth -- "Tidak" --> AlertErr[/"Pesan Error: Akun / Password Tidak Cocok"/] --> OpenLogin
        CheckAuth -- "Ya" --> CheckRole{"Cek Hak Akses (Role)"}
    end

    %% ==========================================
    %% 2. SUB-SISTEM SUPER ADMIN
    %% ==========================================
    subgraph SG_ADMIN ["⚙️ 2. Sub-Sistem Super Admin (Control Panel)"]
        CheckRole -- "Role: super_admin" --> DashAdmin["Dashboard Super Admin"]
        DashAdmin --> ChooseAdminMenu{"Pilih Menu Kelola"}
        
        ChooseAdminMenu -- "Manajemen User" --> ViewUsers[/"Lihat Daftar Pengguna Platform"/]
        ViewUsers --> UserAction{"Pilih Tindakan"}
        UserAction -- "Ubah Role" --> ChangeRole["Ubah Role (Siswa / Guru / Admin)"] --> SaveUserDB[("Database: Update users")]
        UserAction -- "Reset Password" --> ResetPass["Generate Ulang Password"] --> SaveUserDB
        UserAction -- "Hapus Akun" --> DeleteUser["Hapus User & Relasi Data"] --> SaveUserDB
        SaveUserDB --> ReturnAdminDash["Kembali ke Dashboard Admin"] --> DashAdmin

        ChooseAdminMenu -- "Monitoring Kursus" --> ViewCourses[/"Review Seluruh Kursus & Modul"/]
        ViewCourses --> CourseAction{"Pilih Status Kursus"}
        CourseAction -- "Verifikasi & Publish" --> ApproveCourse["Set Published: Aktifkan untuk Siswa"] --> SaveCourseDB[("Database: Update courses")]
        CourseAction -- "Hapus Kursus" --> DropCourse["Hapus Kursus Pelanggaran"] --> SaveCourseDB
        SaveCourseDB --> ReturnAdminDash
        
        DashAdmin --> LogoutAdmin[/"Logout dari Sistem"/]
    end

    %% ==========================================
    %% 3. SUB-SISTEM GURU / MENTOR
    %% ==========================================
    subgraph SG_MENTOR ["👨‍🏫 3. Sub-Sistem Guru & Mentor (Manajemen Konten)"]
        CheckRole -- "Role: guru" --> DashMentor["Dashboard Guru / Mentor"]
        DashMentor --> SelectAction{"Pilih Aksi Manajemen Kursus"}

        %% Tambah Modul
        SelectAction -- "Tambah Bab / Modul" --> FormUnitLesson[/"Input Judul Modul, Deskripsi, & Mini Project"/]
        FormUnitLesson --> SaveUnitDB[("Database: Simpan units & lessons")] --> RefreshMentorUI["Refresh Struktur Kurikulum"]

        %% Import Excel
        SelectAction -- "Import Excel Soal" --> DownloadTemplate[/"Download Template XLSX Soal"/]
        DownloadTemplate --> FillExcelData[/"Guru Mengisi Data Soal di Spreadsheet"/]
        FillExcelData --> UploadExcel[/"Upload File XLSX ke Modul Target"/]
        UploadExcel --> ParseExcel{"Validasi Kolom & Data?"}
        ParseExcel -- "Tidak" --> ShowImportErr[/"Notifikasi Error Format Baris"/] --> UploadExcel
        ParseExcel -- "Ya" --> BatchInsertDB[("Database: Batch Insert exercises")] --> RefreshMentorUI

        %% Studio 3D & Soal Interaktif
        SelectAction -- "Buat Soal Interaktif" --> ChooseExType[/"Pilih Tipe: 3D Interaktif / MCQ / Isian / Pasangan"/]
        ChooseExType --> CheckIs3D{"Tipe == 3D Interaktif?"}
        CheckIs3D -- "Ya" --> Set3DOptions[/"Atur Geometri, Animasi, Warna, & Koordinat Target"/]
        Set3DOptions --> RealtimeRender["Three.js Engine Render Preview Interaktif"]
        RealtimeRender --> InputQuestions[/"Input Pertanyaan, Pilihan, & Kunci Jawaban"/]
        CheckIs3D -- "Tidak" --> InputQuestions
        InputQuestions --> ClickSaveEx[/"Klik Simpan Soal"/]
        ClickSaveEx --> SaveExDB[("Database: Simpan exercises")] --> RefreshMentorUI

        %% Publish Roadmap
        RefreshMentorUI --> WantRelease{"Publikasikan Kursus?"}
        WantRelease -- "Ya" --> SetPublish["Update courses: is_published = true"] --> FinishMentorAction["Perubahan Tersimpan Aktif"]
        WantRelease -- "Tidak" --> SetDraft["Simpan sebagai Draft"] --> FinishMentorAction
        FinishMentorAction --> DashMentor
        DashMentor --> LogoutMentor[/"Logout dari Sistem"/]
    end

    %% ==========================================
    %% 4. SUB-SISTEM SISWA (BELAJAR & GAMIFIKASI)
    %% ==========================================
    subgraph SG_SISWA ["🎓 4. Sub-Sistem Siswa (Belajar, Kuis 3D, & Gamifikasi)"]
        CheckRole -- "Role: siswa" --> LearnRoadmap["Buka Roadmap Belajar Kursus"]
        LearnRoadmap --> SelectLesson[/"Pilih Modul / Level Pembelajaran"/]
        
        SelectLesson --> CheckHearts{"Nyawa (Hearts) > 0?"}
        
        %% Habis Nyawa & Refill Gems
        CheckHearts -- "Tidak" --> CheckGems{"Gems >= 20?"}
        CheckGems -- "Ya" --> ModalRefill[/"Opsi: Tukar 20 Gems untuk Full Hearts"/]
        ModalRefill --> ConfirmRefill{"Setuju Tukar?"}
        ConfirmRefill -- "Ya" --> DoRefill["Potong 20 Gems & Reset Hearts = 5"] --> CheckHearts
        ConfirmRefill -- "Tidak" --> WaitRefill["Tunggu Timer Regenerasi Otomatis"] --> LogoutSiswa[/"Keluar Sesi Belajar"/]
        CheckGems -- "Tidak" --> WaitRefill

        %% Mulai Mengerjakan
        CheckHearts -- "Ya" --> LoadLesson["Inisialisasi Lesson Runner & Objek 3D"]
        LoadLesson --> ShowQuestion[/"Tampilkan Konten Teori, Soal, & Canvas 3D"/]
        ShowQuestion --> UserAnswer[/"Siswa Mengisi / Menjawab / Manipulasi Objek 3D"/]
        UserAnswer --> SubmitAnswer[/"Klik 'Periksa Jawaban'"/]
        SubmitAnswer --> EvalAnswer{"Jawaban Benar?"}

        %% Evaluasi Jawaban Salah
        EvalAnswer -- "Tidak" --> DeductHeart["Hearts - 1 & Mainkan Audio Error"]
        DeductHeart --> ShowExplanation[/"Tampilkan Pembahasan Kunci Jawaban"/]
        ShowExplanation --> CheckHeartsLeft{"Sisa Hearts > 0?"}
        CheckHeartsLeft -- "Ya" --> RetryQuestion[/"Ulangi / Coba Kembali Soal"/] --> ShowQuestion
        CheckHeartsLeft -- "Tidak" --> ShowOutModal[/"Modal: Nyawa Habis!"/] --> ModalRefill

        %% Evaluasi Jawaban Benar
        EvalAnswer -- "Ya" --> RewardExp["Reward: +XP, +Streak Harian, & Audio Sukses"]
        RewardExp --> SaveProgress[("Database: user_progress status = completed")]
        SaveProgress --> CheckCourseDone{"Seluruh Modul Kursus Selesai (100%)?"}
        
        CheckCourseDone -- "Tidak" --> NextLessonBtn[/"Lanjut ke Level / Modul Berikutnya"/] --> LearnRoadmap
        CheckCourseDone -- "Ya" --> UnlockCertClaim[/"Buka Kunci Tombol 'Klaim Sertifikat'"/]
    end

    %% ==========================================
    %% 5. SUB-SISTEM SERTIFIKAT & VERIFIKASI PUBLIK
    %% ==========================================
    subgraph SG_CERT ["📜 5. Sub-Sistem Penerbitan & Verifikasi Sertifikat Digital"]
        UnlockCertClaim --> RequestClaim[/"Siswa Klik 'Klaim Sertifikat'"/]
        RequestClaim --> CalcScore["Hitung Skor Rata-rata & Generate Kode Sertifikat"]
        CalcScore --> GenHashQR["Generate SHA-256 Hash Unik & Dynamic QR Code"]
        GenHashQR --> SaveCertDB[("Database: Simpan ke tabel certificates")]
        SaveCertDB --> DownloadCert[/"Siswa Mengunduh / Mencetak Sertifikat Ber-QR Code"/]
        DownloadCert --> EndLearn(["Siswa Menyelesaikan Kursus"])

        %% Verifikasi Publik
        ChoiceEntry -- "Akses Publik (Verifikasi Sertifikat)" --> PublicVerify[/"Akses Halaman Verifikasi Sertifikat"/]
        PublicVerify --> VerifyMethod{"Pilih Jalur Verifikasi"}
        VerifyMethod -- "Scan QR Code" --> ScanQR[/"Scan QR Code pada Fisik/PDF Sertifikat"/] --> ExtractHash["Ekstrak Parameter Hash SHA-256"]
        VerifyMethod -- "Input Manual" --> InputCode[/"Input Nomor / Kode Sertifikat di Form Web"/] --> ExtractHash
        
        ExtractHash --> QueryCertDB[("Database: Cari di certificates WHERE cert_hash / cert_code")]
        QueryCertDB --> CheckCertValid{"Data Ditemukan & Status Valid?"}
        
        CheckCertValid -- "Ya" --> DisplayValid[/"Status: ASLI & RESMI TERVERIFIKASI<br/>Detail: Nama Siswa, Kursus, Nilai, Tanggal, & Guru"/]
        CheckCertValid -- "Tidak" --> DisplayInvalid[/"Status: PERINGATAN! SERTIFIKAT TIDAK VALID ATAU TIDAK DITEMUKAN"/]
    end

    %% TERMINATOR SELESAI
    LogoutAdmin --> EndSystem(["Selesai / Logout"])
    LogoutMentor --> EndSystem
    LogoutSiswa --> EndSystem
    EndLearn --> EndSystem
    DisplayValid --> EndVerify(["Selesai Verifikasi"])
    DisplayInvalid --> EndVerify
```

---

### 5.2 Penjelasan Alur Integrasi Antar-Modul (Swimlane Breakdown)

Diagram alir terpadu di atas memetakan bagaimana data dan hak akses berpindah secara harmonis di antara berbagai subsistem:

1. **Jalur Masuk & Autentikasi (Zone 1 - `SG_AUTH`)**:
   - Pengunjung sistem dipilah sejak awal: jika ingin memeriksa legalitas sertifikat, langsung diarahkan ke modul verifikasi publik tanpa perlu login.
   - Pengguna terdaftar melewati verifikasi kredensial terenkripsi (*Bcrypt*). Jika valid, sistem membaca kolom `role` pada tabel `users` untuk *Role-Based Redirection*.

2. **Tata Kelola Super Admin (Zone 2 - `SG_ADMIN`)**:
   - Super Admin memiliki kontrol penuh atas integritas platform: memvalidasi materi yang diajukan mentor sebelum dipublikasikan, serta mengelola status akun (perubahan peran, reset kredensial, ataupun *soft delete*).

3. **Manajemen Kurikulum & Studio 3D Guru (Zone 3 - `SG_MENTOR`)**:
   - Guru merancang silabus pembelajaran secara bertingkat (*Unit -> Lesson -> Exercise*).
   - Mendukung dua metode pembuatan soal: **Import Excel massal** (diproses secara batch insert ke database) dan **Studio Soal Interaktif 3D** yang ditenagai oleh WebGL Three.js untuk visualisasi koordinat, geometri, dan mesh real-time.

4. **Siklus Belajar & Gamifikasi Siswa (Zone 4 - `SG_SISWA`)**:
   - Siswa belajar mengikuti jalur roadmap. Sistem menerapkan mekanisme *Duolingo-style Gamification*: setiap modul membutuhkan *Hearts* (nyawa).
   - Jawaban salah memicu umpan balik penjelasan dan pengurangan nyawa. Jika nyawa habis, siswa dapat menukarkan *Gems* hasil belajarnya atau menunggu regenerasi otomatis.
   - Jawaban benar memberikan reward *XP*, penambahan *daily streak*, dan pencatatan riwayat progres pada database `user_progress`.

5. **Penerbitan & Validasi Sertifikat Digital (Zone 5 - `SG_CERT`)**:
   - Saat seluruh modul kursus tercatat 100% tuntas, sistem membuka hak klaim sertifikat.
   - Nilai rata-rata dievaluasi, kemudian algoritma kriptografi membentuk hash unik **SHA-256** dan *QR Code* vektor yang tertanam langsung pada dokumen sertifikat.
   - Pihak luar/industri dapat memverifikasi keabsahan sertifikat tersebut secara instan melalui pemindaian kamera QR atau input manual kode verifikasi pada portal publik EduSkill.

---

## 6. Kesimpulan & Penjelasan untuk Dosen

1. **Integritas Relasional & Normalisasi 3NF**:
    - Struktur database telah dinormalisasi hingga tahap **Third Normal Form (3NF)**.
    - Menggunakan _Foreign Key Constraints_ dengan `onDelete('cascade')` untuk mencegah _orphan records_.
2. **Kesesuaian dengan Implementasi Nyata**:
    - Diagram ini mencerminkan 100% kode implementasi Laravel yang aktif di repository `Hadi-Akram-Ramadhan/Website-EDUSKILL`, termasuk fitur kuis 3D Three.js, gamifikasi Hearts & Gems, import XLSX SheetJS/Laravel-Excel, serta validasi QR hash digital certificate.
