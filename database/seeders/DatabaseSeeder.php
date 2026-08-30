<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserProgress;
use App\Models\UserStreak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users (Super Admin, Mentors/Teachers, Students)
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kodein.id',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=admin_kodein',
            'xp' => 1500,
            'level' => 16,
            'hearts' => 5,
            'gems' => 500,
            'streak_count' => 15,
        ]);

        $guru1 = User::create([
            'name' => 'Pak Hendra, S.Kom',
            'email' => 'guru@kodein.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=hendra_guru',
            'xp' => 950,
            'level' => 10,
            'hearts' => 5,
            'gems' => 250,
            'streak_count' => 8,
        ]);

        $guru2 = User::create([
            'name' => 'Ibu Maya Lestari, M.Kom',
            'email' => 'maya@kodein.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=maya_guru',
            'xp' => 820,
            'level' => 9,
            'hearts' => 5,
            'gems' => 200,
            'streak_count' => 6,
        ]);

        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smp.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=budi_smp',
            'xp' => 480,
            'level' => 5,
            'hearts' => 5,
            'gems' => 90,
            'streak_count' => 7,
            'last_active_date' => Carbon::today(),
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@sma.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=siti_sma',
            'xp' => 620,
            'level' => 7,
            'hearts' => 4,
            'gems' => 140,
            'streak_count' => 14,
            'last_active_date' => Carbon::today(),
        ]);

        $siswa3 = User::create([
            'name' => 'Reza Pratama',
            'email' => 'reza@smp.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=reza_smp',
            'xp' => 380,
            'level' => 4,
            'hearts' => 5,
            'gems' => 60,
            'streak_count' => 4,
            'last_active_date' => Carbon::today(),
        ]);

        $siswa4 = User::create([
            'name' => 'Anisa Rahma',
            'email' => 'anisa@sma.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=anisa_sma',
            'xp' => 290,
            'level' => 3,
            'hearts' => 3,
            'gems' => 40,
            'streak_count' => 3,
            'last_active_date' => Carbon::today(),
        ]);

        $siswa5 = User::create([
            'name' => 'Dimas Setiawan',
            'email' => 'dimas@smp.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=dimas_smp',
            'xp' => 150,
            'level' => 2,
            'hearts' => 5,
            'gems' => 50,
            'streak_count' => 1,
            'last_active_date' => Carbon::today(),
        ]);

        // 2. Badges for students
        $badgesCatalog = [
            ['code' => 'first_lesson', 'name' => 'Langkah Pertama', 'desc' => 'Menyelesaikan modul pemrograman pertama kamu', 'icon' => 'code'],
            ['code' => 'streak_3', 'name' => '3 Hari Beruntun', 'desc' => 'Belajar 3 hari berturut-turut tanpa putus', 'icon' => 'flame'],
            ['code' => 'streak_7', 'name' => 'Pejuang 1 Minggu', 'desc' => 'Menjaga streak belajar selama 7 hari penuh', 'icon' => 'trophy'],
            ['code' => 'perfect_score', 'name' => 'Bug Hunter Handal', 'desc' => 'Menjawab 100% benar semua soal dalam satu modul', 'icon' => 'target'],
        ];

        foreach ([$siswa1, $siswa2] as $student) {
            foreach ($badgesCatalog as $badge) {
                UserBadge::create([
                    'user_id' => $student->id,
                    'badge_code' => $badge['code'],
                    'badge_name' => $badge['name'],
                    'badge_description' => $badge['desc'],
                    'icon' => $badge['icon'],
                    'unlocked_at' => Carbon::now()->subDays(rand(1, 5)),
                ]);
            }
        }

        // 3. Streaks
        for ($i = 0; $i < 7; $i++) {
            UserStreak::create([
                'user_id' => $siswa1->id,
                'active_date' => Carbon::today()->subDays($i)->toDateString(),
            ]);
        }

        // 4. Course 1: Pemrograman Python Dasar
        $course1 = Course::create([
            'mentor_id' => $guru1->id,
            'title' => 'Dasar Pemrograman Python untuk SMP & SMA',
            'slug' => 'dasar-pemrograman-python',
            'description' => 'Pelajari logika algoritma dan sintaks dasar bahasa Python dengan metode interaktif terstruktur.',
            'category' => 'Python Dasar',
            'target_audience' => 'Siswa SMP & SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&auto=format&fit=crop&q=80',
            'level' => 'beginner',
            'total_xp' => 160,
            'is_published' => true,
        ]);

        // Unit 1
        $unit1 = Unit::create([
            'course_id' => $course1->id,
            'title' => 'Unit 1: Perintah Cetak & Variabel',
            'description' => 'Mengenal instruksi print() dan cara menyimpan data dalam variabel.',
            'order_index' => 1,
        ]);

        // Lesson 1
        $lesson1 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Instruksi print() dan Teks',
            'slug' => 'instruksi-print-dan-teks',
            'description' => 'Pelajari cara komputer menampilkan teks ke layar menggunakan print().',
            'type' => 'quiz',
            'theory_content' => 'Fungsi print() dalam Python digunakan untuk menampilkan teks ke layar komputer. Teks harus diapit tanda petik dua atau petik satu.',
            'xp_reward' => 20,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lesson1->id,
            'question_type' => 'fill_blank',
            'prompt' => 'Lengkapi kode berikut agar komputer mencetak teks "Halo Dunia" ke layar:',
            'code_snippet' => '____("Halo Dunia")',
            'options_json' => ['print', 'echo', 'input', 'write'],
            'answer_json' => 'print',
            'explanation' => 'Fungsi standar Python untuk menampilkan teks ke layar adalah print().',
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lesson1->id,
            'question_type' => 'output_prediction',
            'prompt' => 'Apa output yang dihasilkan dari kode Python berikut?',
            'code_snippet' => "nama = 'Andi'\nprint('Halo ' + nama)",
            'options_json' => ['Halo Andi', 'Halo nama', 'Andi', 'Error'],
            'answer_json' => 'Halo Andi',
            'explanation' => "Operator '+' menggabungkan teks 'Halo ' dengan nilai variabel nama yaitu 'Andi'.",
            'order_index' => 2,
        ]);

        Exercise::create([
            'lesson_id' => $lesson1->id,
            'question_type' => 'code_ordering',
            'prompt' => 'Susun potongan kode berikut dengan urutan yang benar untuk membuat variabel umur lalu mencetaknya:',
            'options_json' => [
                ['id' => '1', 'text' => 'umur = 15'],
                ['id' => '2', 'text' => 'print("Umur saya:")'],
                ['id' => '3', 'text' => 'print(umur)'],
            ],
            'answer_json' => ['1', '2', '3'],
            'explanation' => 'Variabel harus dideklarasikan terlebih dahulu sebelum nilainya bisa dicetak ke layar.',
            'order_index' => 3,
        ]);

        // Lesson 2
        $lesson2 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Tipe Data: Angka, Teks, & Boolean',
            'slug' => 'tipe-data-dasar',
            'description' => 'Mengenal integer, float, string, dan boolean.',
            'type' => 'quiz',
            'theory_content' => 'Tipe data utama di Python: str (String), int (Integer), float (Desimal), dan bool (Boolean).',
            'xp_reward' => 25,
            'order_index' => 2,
        ]);

        Exercise::create([
            'lesson_id' => $lesson2->id,
            'question_type' => 'matching_pair',
            'prompt' => 'Cocokkan tipe data Python di sebelah kiri dengan contoh nilainya yang tepat:',
            'options_json' => [
                'pairs' => [
                    'int' => '17',
                    'str' => '"Belajar"',
                    'bool' => 'True',
                    'float' => '3.14',
                ],
            ],
            'answer_json' => [
                'int' => '17',
                'str' => '"Belajar"',
                'bool' => 'True',
                'float' => '3.14',
            ],
            'explanation' => 'int adalah angka bulat, str adalah teks, bool adalah nilai logika (True/False), dan float adalah angka pecahan.',
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lesson2->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Tipe data manakah yang digunakan untuk menyimpan nilai True atau False?',
            'options_json' => ['bool (Boolean)', 'int (Integer)', 'str (String)', 'float (Float)'],
            'answer_json' => 'bool (Boolean)',
            'explanation' => 'Tipe data boolean (bool) hanya memiliki dua nilai: True atau False.',
            'order_index' => 2,
        ]);

        // Unit 2
        $unit2 = Unit::create([
            'course_id' => $course1->id,
            'title' => 'Unit 2: Percabangan Logika (If-Else)',
            'description' => 'Mengajarkan komputer mengambil keputusan menggunakan percabangan if, elif, dan else.',
            'order_index' => 2,
        ]);

        $lesson3 = Lesson::create([
            'unit_id' => $unit2->id,
            'title' => 'Logika Keputusan (If-Else)',
            'slug' => 'logika-keputusan-if-else',
            'description' => 'Mengecek syarat kondisi benar atau salah.',
            'type' => 'quiz',
            'theory_content' => 'Struktur if mengevaluasi kondisi. Jika bernilai True, blok if dijalankan. Jika tidak, blok else yang dijalankan.',
            'xp_reward' => 30,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lesson3->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Jika nilai skor = 85, apa hasil dari kondisi if skor >= 75 ?',
            'options_json' => ['True (Kondisi Terpenuhi)', 'False (Kondisi Gagal)', 'Error', 'None'],
            'answer_json' => 'True (Kondisi Terpenuhi)',
            'explanation' => 'Karena 85 lebih besar dari atau sama dengan 75, maka kondisi bernilai True.',
            'order_index' => 1,
        ]);

        // Course 2: Web Dasar HTML & CSS
        $course2 = Course::create([
            'mentor_id' => $guru2->id,
            'title' => 'Dasar Web HTML & CSS untuk Pemula',
            'slug' => 'dasar-web-html-css',
            'description' => 'Belajar membuat halaman web pertama kamu dengan tag HTML dan styling CSS modern.',
            'category' => 'Web Dasar',
            'target_audience' => 'Siswa SMP & SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=600&auto=format&fit=crop&q=80',
            'level' => 'beginner',
            'total_xp' => 120,
            'is_published' => true,
        ]);

        // Course 2 - Unit 1
        $unitWeb1 = Unit::create([
            'course_id' => $course2->id,
            'title' => 'Unit 1: Struktur & Tag Dasar HTML',
            'description' => 'Mengenal struktur halaman web, tag judul h1, paragraf, dan hyperlink.',
            'order_index' => 1,
        ]);

        $lessonWeb1 = Lesson::create([
            'unit_id' => $unitWeb1->id,
            'title' => 'Heading dan Paragraf Web',
            'slug' => 'heading-dan-paragraf-web',
            'description' => 'Membuat judul utama dan paragraf pada halaman website.',
            'type' => 'quiz',
            'theory_content' => 'Tag h1 digunakan untuk judul utama, dan tag p digunakan untuk paragraf.',
            'xp_reward' => 20,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lessonWeb1->id,
            'question_type' => 'fill_blank',
            'prompt' => 'Lengkapi tag HTML berikut untuk membuat judul utama:',
            'code_snippet' => '<____>Selamat Datang di Web Saya</____>',
            'options_json' => ['h1', 'p', 'div', 'span'],
            'answer_json' => 'h1',
            'explanation' => 'Tag <h1> adalah tag standar HTML untuk judul utama halaman.',
            'order_index' => 1,
        ]);

        $lessonWeb2 = Lesson::create([
            'unit_id' => $unitWeb1->id,
            'title' => 'Link Tautan & Gambar',
            'slug' => 'link-tautan-dan-gambar',
            'description' => 'Menyematkan tautan antar-halaman (anchor) dan gambar.',
            'type' => 'quiz',
            'theory_content' => 'Tag <a> digunakan untuk membuat tautan web, dan tag <img> untuk menampilkan gambar.',
            'xp_reward' => 25,
            'order_index' => 2,
        ]);

        Exercise::create([
            'lesson_id' => $lessonWeb2->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Atribut HTML manakah yang digunakan pada tag <a> untuk menentukan alamat link tujuan?',
            'options_json' => ['href', 'src', 'link', 'target'],
            'answer_json' => 'href',
            'explanation' => 'Atribut "href" (Hypertext Reference) menentukan URL halaman tujuan pada tag <a>.',
            'order_index' => 1,
        ]);

        // Course 2 - Unit 2
        $unitWeb2 = Unit::create([
            'course_id' => $course2->id,
            'title' => 'Unit 2: Styling Dasar CSS Modern',
            'description' => 'Mengatur warna latar, font teks, dan margin tata letak elemen web.',
            'order_index' => 2,
        ]);

        $lessonWeb3 = Lesson::create([
            'unit_id' => $unitWeb2->id,
            'title' => 'Warna & Font Teks CSS',
            'slug' => 'warna-dan-font-teks-css',
            'description' => 'Menghias tampilan elemen dengan properti color dan font-size.',
            'type' => 'quiz',
            'theory_content' => 'Properti color mengatur warna teks, sedangkan font-size mengatur ukuran teks.',
            'xp_reward' => 25,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lessonWeb3->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Properti CSS manakah yang digunakan untuk mengubah warna teks menjadi biru?',
            'options_json' => ['color: blue;', 'text-color: blue;', 'font-color: blue;', 'background: blue;'],
            'answer_json' => 'color: blue;',
            'explanation' => 'Properti CSS yang tepat untuk memberi warna font teks adalah "color".',
            'order_index' => 1,
        ]);

        // Course 3: Logika Algoritma & Flowchart
        $course3 = Course::create([
            'mentor_id' => $guru1->id,
            'title' => 'Logika Pemrograman & Algoritma',
            'slug' => 'logika-pemrograman-dan-algoritma',
            'description' => 'Asah kemampuan berpikir komputasional, diagram alur logika, dan pemecahan masalah coding.',
            'category' => 'Algoritma',
            'target_audience' => 'Siswa SMP & SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1516116211227-bbc13c72b226?w=600&auto=format&fit=crop&q=80',
            'level' => 'intermediate',
            'total_xp' => 140,
            'is_published' => true,
        ]);

        // Course 3 - Unit 1
        $unitAlgo1 = Unit::create([
            'course_id' => $course3->id,
            'title' => 'Unit 1: Pola Berpikir Komputasional',
            'description' => 'Dekomposisi masalah dan pengenalan pola algoritma secara terstruktur.',
            'order_index' => 1,
        ]);

        $lessonAlgo1 = Lesson::create([
            'unit_id' => $unitAlgo1->id,
            'title' => 'Konsep Input, Proses, & Output',
            'slug' => 'konsep-input-proses-output',
            'description' => 'Memahami siklus pemrosesan data dasar dalam komputasi.',
            'type' => 'quiz',
            'theory_content' => 'Setiap program komputer menerima input, melakukan pemrosesan data, dan menghasilkan output ke pengguna.',
            'xp_reward' => 25,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lessonAlgo1->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Dalam siklus komputasi, apa tahapan yang terjadi setelah komputer menerima Input dari pengguna?',
            'options_json' => ['Proses (Processing)', 'Output', 'Shutdown', 'Error'],
            'answer_json' => 'Proses (Processing)',
            'explanation' => 'Setelah data diterima (Input), komputer melakukan tahap pemrosesan (Proses) sebelum menghasilkan output.',
            'order_index' => 1,
        ]);

        $lessonAlgo2 = Lesson::create([
            'unit_id' => $unitAlgo1->id,
            'title' => 'Diagram Alur & Urutan Langkah',
            'slug' => 'diagram-alur-dan-urutan-langkah',
            'description' => 'Menyusun langkah algoritma sekuensial yang presisi dan efisien.',
            'type' => 'quiz',
            'theory_content' => 'Algoritma harus berurutan secara logis (sekuensial) agar menghasilkan solusi yang tepat.',
            'xp_reward' => 30,
            'order_index' => 2,
        ]);

        Exercise::create([
            'lesson_id' => $lessonAlgo2->id,
            'question_type' => 'code_ordering',
            'prompt' => 'Susun langkah algoritma membuat secangkir teh manis berikut dengan urutan yang benar:',
            'options_json' => [
                ['id' => '1', 'text' => 'Rebus air sampai mendidih'],
                ['id' => '2', 'text' => 'Celupkan teh dan masukkan gula ke cangkir'],
                ['id' => '3', 'text' => 'Tuang air panas lalu aduk hingga larut'],
            ],
            'answer_json' => ['1', '2', '3'],
            'explanation' => 'Algoritma harus runtut: menyiapkan air panas, bahan, lalu mencampurnya.',
            'order_index' => 1,
        ]);

        // Course 3 - Unit 2
        $unitAlgo2 = Unit::create([
            'course_id' => $course3->id,
            'title' => 'Unit 2: Pengambilan Keputusan Algoritma',
            'description' => 'Memahami percabangan kondisi dan perbandingan nilai logika.',
            'order_index' => 2,
        ]);

        $lessonAlgo3 = Lesson::create([
            'unit_id' => $unitAlgo2->id,
            'title' => 'Kondisi Logika Benar atau Salah',
            'slug' => 'kondisi-logika-benar-salah',
            'description' => 'Mengevaluasi kondisi Boolean dalam alur logika program.',
            'type' => 'quiz',
            'theory_content' => 'Percabangan logika membantu algoritma mengambil jalur tindakan yang berbeda sesuai syarat.',
            'xp_reward' => 30,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lessonAlgo3->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Jika kondisi "Lampu Merah == Menyala", aksi logika yang benar adalah:',
            'options_json' => ['Kendaraan Berhenti', 'Kendaraan Berjalan Cepat', 'Kendaraan Mundur', 'Putar Balik'],
            'answer_json' => 'Kendaraan Berhenti',
            'explanation' => 'Kondisi lampu merah bernilai True mengharuskan kendaraan untuk berhenti.',
            'order_index' => 1,
        ]);

        // Upcoming Courses Roadmap (Can be edited/managed by Admin & Mentors)
        $upcomingCourse1 = Course::create([
            'mentor_id' => $guru2->id,
            'title' => 'JavaScript Interaktif & Web App',
            'slug' => 'javascript-interaktif',
            'description' => 'Jadikan website hidup dengan tombol interaktif, animasi dinamis, dan manipulasi elemen web secara real-time.',
            'category' => 'JavaScript',
            'target_audience' => 'Siswa SMP & SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=600&auto=format&fit=crop&q=80',
            'level' => 'intermediate',
            'total_xp' => 200,
            'is_published' => true,
            'is_upcoming' => true,
        ]);

        $upcomingCourse2 = Course::create([
            'mentor_id' => $guru1->id,
            'title' => 'C++ & Olimpiade Komputer (OSN)',
            'slug' => 'cpp-olimpiade-komputer',
            'description' => 'Asah kemampuan logika pemecahan masalah tingkat kompetisi sains dan olimpiade informatika nasional.',
            'category' => 'C++',
            'target_audience' => 'Siswa SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=600&auto=format&fit=crop&q=80',
            'level' => 'advanced',
            'total_xp' => 300,
            'is_published' => true,
            'is_upcoming' => true,
        ]);

        $upcomingCourse3 = Course::create([
            'mentor_id' => $guru2->id,
            'title' => 'SQL & Manajemen Basis Data',
            'slug' => 'sql-basis-data',
            'description' => 'Pahami cara menyimpan, mencari, dan mengolah data dalam jumlah besar dengan query basis data relasional.',
            'category' => 'Database',
            'target_audience' => 'Siswa SMP & SMA',
            'thumbnail' => 'https://images.unsplash.com/photo-1544383835-bda2bc66a55d?w=600&auto=format&fit=crop&q=80',
            'level' => 'intermediate',
            'total_xp' => 180,
            'is_published' => true,
            'is_upcoming' => true,
        ]);

        // 5. Seed progress for Siti (Course 1 Completed -> Certificate Issued)
        foreach ([$lesson1, $lesson2, $lesson3] as $l) {
            UserProgress::create([
                'user_id' => $siswa2->id,
                'lesson_id' => $l->id,
                'is_completed' => true,
                'score' => 100,
                'completed_at' => Carbon::now()->subDays(1),
            ]);
        }

        // Certificate for Siti
        $certCode = 'CERT-DASARP-202608-8AM0AQ';
        Certificate::create([
            'cert_code' => $certCode,
            'cert_hash' => hash_hmac('sha256', "{$siswa2->id}|{$course1->id}|{$certCode}", config('app.key') ?: 'secret-key'),
            'user_id' => $siswa2->id,
            'course_id' => $course1->id,
            'recipient_name' => $siswa2->name,
            'course_title' => $course1->title,
            'mentor_name' => $guru1->name,
            'score_average' => 100.0,
            'issue_date' => Carbon::now()->toDateString(),
            'qr_code_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.urlencode(url("/verify/{$certCode}")),
            'is_valid' => true,
        ]);
    }
}
