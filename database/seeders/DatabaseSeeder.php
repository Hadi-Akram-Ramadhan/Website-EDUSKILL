<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserBadge;
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
        // 1. Users
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kodein.id',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'xp' => 1500,
            'level' => 16,
            'hearts' => 5,
            'gems' => 500,
            'streak_count' => 15,
        ]);

        $guru = User::create([
            'name' => 'Pak Hendra, S.Kom',
            'email' => 'guru@kodein.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=guru1',
            'xp' => 800,
            'level' => 9,
            'hearts' => 5,
            'gems' => 200,
            'streak_count' => 8,
        ]);

        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smp.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=budi',
            'xp' => 340,
            'level' => 4,
            'hearts' => 5,
            'gems' => 70,
            'streak_count' => 5,
            'last_active_date' => Carbon::today(),
        ]);

        $siswa2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@sma.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'avatar' => 'https://api.dicebear.com/7.x/bottts/svg?seed=siti',
            'xp' => 520,
            'level' => 6,
            'hearts' => 4,
            'gems' => 120,
            'streak_count' => 12,
            'last_active_date' => Carbon::today(),
        ]);

        // 2. Badges for siswa
        UserBadge::create([
            'user_id' => $siswa1->id,
            'badge_code' => 'first_lesson',
            'badge_name' => 'Langkah Pertama',
            'badge_description' => 'Menyelesaikan modul pemrograman pertama 🎉',
            'icon' => 'rocket',
            'unlocked_at' => Carbon::now()->subDays(3),
        ]);

        UserBadge::create([
            'user_id' => $siswa1->id,
            'badge_code' => 'streak_3',
            'badge_name' => '3 Hari Beruntun!',
            'badge_description' => 'Belajar 3 hari berturut-turut tanpa putus 🔥',
            'icon' => 'fire',
            'unlocked_at' => Carbon::now()->subDays(2),
        ]);

        // 3. Course: Pemrograman Python Dasar
        $course = Course::create([
            'mentor_id' => $guru->id,
            'title' => 'Dasar Pemrograman Python untuk SMP & SMA',
            'slug' => 'dasar-pemrograman-python',
            'description' => 'Pelajari logika algoritma dan sintaks dasar bahasa Python dengan metode interaktif & gamifikasi seru.',
            'category' => 'Python Dasar',
            'target_audience' => 'Siswa SMP / SMA Pemula',
            'thumbnail' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&auto=format&fit=crop&q=80',
            'level' => 'beginner',
            'total_xp' => 120,
            'is_published' => true,
        ]);

        // 4. Unit 1: Perkenalan & Variabel
        $unit1 = Unit::create([
            'course_id' => $course->id,
            'title' => 'Unit 1: Perintah Cetak & Variabel',
            'description' => 'Mengenal instruksi print() dan cara menyimpan data dalam variabel.',
            'order_index' => 1,
        ]);

        // Lesson 1: Perintah Print
        $lesson1 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Instruksi print() dan Teks',
            'slug' => 'instruksi-print-dan-teks',
            'description' => 'Pelajari cara komputer menampilkan teks ke layar menggunakan print().',
            'type' => 'quiz',
            'theory_content' => "Dalam Python, fungsi `print()` digunakan untuk menampilkan pesan atau teks ke layar komputer. Teks harus diapit oleh tanda petik dua `\"...\"` atau petik satu `'...'`.",
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

        // Lesson 2: Tipe Data Dasar
        $lesson2 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Tipe Data: Angka, Teks, & Boolean',
            'slug' => 'tipe-data-dasar',
            'description' => 'Mengenal integer, float, string, dan boolean.',
            'type' => 'quiz',
            'theory_content' => "Tipe data utama di Python:\n- `str` (String): Teks seperti 'Halo'\n- `int` (Integer): Angka bulat seperti 10, -5\n- `float`: Angka desimal seperti 3.14\n- `bool` (Boolean): Bernilai True atau False",
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
                    'float' => '3.14'
                ]
            ],
            'answer_json' => [
                'int' => '17',
                'str' => '"Belajar"',
                'bool' => 'True',
                'float' => '3.14'
            ],
            'explanation' => 'int adalah angka bulat, str adalah teks, bool adalah nilai logika (True/False), dan float adalah angka pecahan.',
            'order_index' => 1,
        ]);

        // 5. Unit 2: Percabangan Logika (If-Else)
        $unit2 = Unit::create([
            'course_id' => $course->id,
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
            'theory_content' => "Struktur `if` mengevaluasi kondisi. Jika kondisi bernilai True, blok kode di dalamnya dijalankan. Jika tidak, blok `else` yang akan dijalankan.",
            'xp_reward' => 30,
            'order_index' => 1,
        ]);

        Exercise::create([
            'lesson_id' => $lesson3->id,
            'question_type' => 'multiple_choice',
            'prompt' => 'Jika nilai `skor = 85`, apa hasil dari kondisi `if skor >= 75:` ?',
            'options_json' => ['True (Kondisi Terpenuhi)', 'False (Kondisi Gagal)', 'Error', 'None'],
            'answer_json' => 'True (Kondisi Terpenuhi)',
            'explanation' => 'Karena 85 lebih besar dari atau sama dengan 75, maka kondisi bernilai True.',
            'order_index' => 1,
        ]);
    }
}
