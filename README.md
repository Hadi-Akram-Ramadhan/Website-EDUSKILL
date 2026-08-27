# ⚡ Gamified Coding Learning Platform (Duolingo for SMP/SMA)

Platform pembelajaran pemrograman dasar berbasis gamifikasi interaktif ala Duolingo yang dirancang khusus untuk siswa SMP dan SMA. Projek ini menyediakan backend **Laravel 12** yang melayani aplikasi **Fullstack Web** sekaligus **REST API untuk Mobile Android (Flutter)** lengkap dengan **Dokumentasi OpenAPI 3.0** dan sistem penerbitan sertifikat digital ber-QR Code resmi.

---

## 🎮 Fitur Utama

### 1. Sistem Gamifikasi (Duolingo-Style)
* **XP & Leveling:** Siswa memperoleh XP setiap menyelesaikan materi dan kuis (+ bonus reward untuk skor 100%).
* **Hearts (Nyawa / HP):** Siswa memiliki batas 5 hati. Salah menjawab kuis mengurangi 1 hati. Hati otomatis terisi kembali 1 hati / 30 menit atau dapat diisi instan menggunakan Gems (`20 Gems`).
* **Daily Streaks:** Menghitung keaktifan belajar harian tanpa putus (streak counter).
* **Badges & Achievements:** Membuka lencana prestasi (*Langkah Pertama*, *3 Hari Beruntun*, *Bug Hunter Handal*, dll).
* **Leaderboard Mingguan:** Klasemen ranking siswa berdasarkan perolehan XP dan Streaks.

### 2. Bank Soal & Tantangan Kode Interaktif
Mendukung 5 model latihan pemrograman:
1. **Parsons Problem (Code Ordering):** Menyusun potongan kode algoritma ke urutan yang benar.
2. **Fill in the Blank:** Mengisi sintaks atau fungsi yang rumpang (contoh: `____("Halo Dunia")`).
3. **Output Prediction:** Memprediksi keluaran dari sebaris atau seblok kode pemrograman.
4. **Matching Pairs:** Mencocokkan tipe data / istilah dengan nilainya (contoh: `int` $\leftrightarrow$ `17`).
5. **Multiple Choice:** Soal pilihan ganda konsep logika & percabangan.

### 3. Sertifikat Resmi & Terverifikasi
* **Syarat Kelulusan:** Otomatis dapat diklaim hanya jika seluruh modul/lesson dalam kursus telah diselesaikan.
* **Cryptographically Signed:** Dilengkapi nomor sertifikat unik (contoh: `CERT-PYDASAR-202608-XXXXXX`) dan tanda tangan kriptografis SHA-256.
* **Public QR Verification:** Setiap sertifikat memiliki QR Code yang saat discan mengarah ke halaman verifikasi resmi web `/verify/{cert_code}`.

### 4. Dokumentasi API Terstandarisasi (OpenAPI 3.0)
* Dokumentasi interaktif bawaan menggunakan **Scalar API Reference** dengan dark theme, fitur *Try-It Console*, serta contoh kode cURL, Dart (Flutter), JavaScript, PHP, dan Python di `/docs/api`.
* Spesifikasi OpenAPI 3.0 YAML dapat diakses di `/docs/openapi.yaml`.

---

## 🛠️ Tech Stack & Ekosistem

* **Backend:** [Laravel 12](https://laravel.com) (PHP 8.2+)
* **Authentication:** Laravel Sanctum (Bearer Token untuk Flutter Mobile & Web)
* **API Documentation:** OpenAPI 3.0.3 + Scalar UI
* **Database:** SQLite / MySQL / PostgreSQL
* **Clients:**
  * **Web:** Laravel Blade & Vite
  * **Mobile:** Flutter (Android / iOS)

---

## 🚀 Panduan Instalasi & Menjalankan Projek

### 1. Clone & Setup Dependensi
```bash
# Masuk ke direktori projek
cd semester-3-web

# Install package PHP
composer install

# Salin environment file
cp .env.example .env

# Generate Application Key
php artisan key:generate
```

### 2. Migrasi Database & Seeder
```bash
# Jalankan migrasi dan seeder data awal
php artisan migrate:fresh --seed
```

### 3. Menjalankan Server Lokal
```bash
php artisan serve
```
Aplikasi backend dan web akan berjalan di `http://localhost:8000`.

---

## 📖 Akses Dokumentasi & Halaman Publik

* **Interactive API Reference (OpenAPI 3.0):** [http://localhost:8000/docs/api](http://localhost:8000/docs/api)
* **Raw OpenAPI 3.0 Spec:** [http://localhost:8000/docs/openapi.yaml](http://localhost:8000/docs/openapi.yaml)
* **Halaman Verifikasi Sertifikat:** [http://localhost:8000/verify/{cert_code}](http://localhost:8000/verify/CERT-DASARP-202608-XXXX)

---

## 🔑 Akun Demo / Data Awal (Hasil Seeding)

| Role | Nama | Email | Password |
| :--- | :--- | :--- | :--- |
| **Super Admin** | Super Admin | `admin@kodein.id` | `password` |
| **Guru / Mentor** | Pak Hendra, S.Kom | `guru@kodein.id` | `password` |
| **Siswa (SMP)** | Budi Santoso | `budi@smp.sch.id` | `password` |
| **Siswa (SMA)** | Siti Nurhaliza | `siti@sma.sch.id` | `password` |

---

## 📡 Ringkasan Endpoint REST API (`/api/v1`)

### Autentikasi & Akun
* `POST /api/v1/auth/register` - Pendaftaran akun baru (Siswa / Guru)
* `POST /api/v1/auth/login` - Login dan dapatkan Bearer Token Sanctum
* `GET /api/v1/auth/me` - Ambil profil pengguna yang login beserta statistik & badges
* `POST /api/v1/auth/logout` - Logout dan hapus token aktif

### Profil & Gamifikasi
* `PUT /api/v1/profile` - Update nama & avatar siswa
* `POST /api/v1/profile/refill-hearts` - Isi ulang nyawa (5/5 hearts) dengan 20 gems
* `GET /api/v1/profile/badges` - Ambil daftar lencana yang telah diraih
* `GET /api/v1/leaderboard` - Papan peringkat siswa (`?type=global` atau `?type=streak`)

### Kurikulum & Tantangan Belajar
* `GET /api/v1/courses` - Daftar kursus beserta persentase progress belajar
* `GET /api/v1/courses/{id}` - Pohon roadmap kursus (Unit & Lesson dengan status unlocked/locked)
* `GET /api/v1/lessons/{id}` - Konten materi singkat & soal latihan interaktif
* `POST /api/v1/lessons/{id}/submit` - Kirim jawaban kuis, kalkulasi XP, pengurangan nyawa, update streak

### Sertifikasi
* `GET /api/v1/certificates` - Daftar sertifikat milik siswa yang sedang login
* `GET /api/v1/certificates/eligibility/{course_id}` - Cek status kelayakan klaim sertifikat
* `POST /api/v1/certificates/claim/{course_id}` - Klaim dan terbitkan sertifikat resmi
* `GET /api/v1/certificates/verify/{cert_code}` - Verifikasi data sertifikat via API

---

## 🧪 Menjalankan Automated Unit & Feature Tests

Projek ini dilengkapi dengan test suite lengkap untuk memvalidasi auth, logika gamifikasi, pengurangan hati, evaluasi kuis, klaim sertifikat, dan route dokumentasi:

```bash
php artisan test
```

---

## 📄 Lisensi
Platform ini didistribusikan di bawah lisensi [MIT License](LICENSE).
