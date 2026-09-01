<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class Interactive3DQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = User::where('role', 'guru')->first() ?? User::first();
        if (! $guru) {
            return;
        }

        // 1. Create or Find Course for 3D Computing
        $course = Course::firstOrCreate(
            ['slug' => 'pemrograman-3d-spasial-interaktif'],
            [
                'mentor_id' => $guru->id,
                'title' => 'Pemrograman 3D & Komputasi Spasial',
                'description' => 'Eksplorasi visualisasi data 3 dimensi, sistem koordinat robotika, struktur pohon biner, dan tata letak memori interaktif.',
                'category' => '3D & Spasial',
                'target_audience' => 'Siswa SMP & SMA',
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=600&auto=format&fit=crop&q=80',
                'level' => 'intermediate',
                'total_xp' => 250,
                'is_published' => true,
                'is_upcoming' => false,
            ]
        );

        // 2. Unit 1: Matriks 3D & Koordinat Spasial
        $unit1 = Unit::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Unit 1: Sistem Koordinat & Matriks 3D'],
            [
                'description' => 'Memahami array 3 dimensi dan sistem sumbu koordinat spasial X, Y, Z.',
                'order_index' => 1,
            ]
        );

        // Lesson 1.1: Array 3D Matrix Grid
        $lesson1 = Lesson::firstOrCreate(
            ['unit_id' => $unit1->id, 'slug' => 'struktur-array-matriks-3d'],
            [
                'title' => 'Struktur Array Matriks 3D [3x3x3]',
                'description' => 'Memahami cara mengakses data pada ruang kubus array multi-dimensi.',
                'type' => 'quiz',
                'theory_content' => 'Array 3 dimensi merepresentasikan data dalam bentuk balok/kubus dengan tiga sumbu koordinat [X][Y][Z].',
                'xp_reward' => 30,
                'order_index' => 1,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson1->id, 'prompt' => 'Perhatikan model 3D Matrix Grid berikut. Elemen hijau neon berada di koordinat X=1, Y=0, Z=1. Tentukan sintaks akses array 3D yang tepat:'],
            [
                'question_type' => 'interactive_3d',
                'options_json' => ['matriks[1][0][1]', 'matriks[0][1][1]', 'matriks[1][1][0]', 'matriks[2][1][2]'],
                'answer_json' => 'matriks[1][0][1]',
                'model_3d_json' => [
                    'preset' => 'matrix_grid',
                    'color' => '#2563eb',
                    'accent_color' => '#10b981',
                    'animation' => 'rotate',
                    'wireframe' => false,
                    'show_grid' => true,
                    'label' => 'Struktur Data Matriks 3D (Array Multi-dimensi)',
                ],
                'explanation' => 'Akses indeks array 3 dimensi berurutan berdasarkan sumbu [X][Y][Z], sehingga elemen pada X=1, Y=0, Z=1 diakses dengan matriks[1][0][1].',
                'order_index' => 1,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson1->id, 'prompt' => 'Jika ukuran array matriks 3D adalah 3x3x3, berapakah total seluruh elemen sel yang dapat ditampung dalam kubus tersebut?'],
            [
                'question_type' => 'multiple_choice',
                'options_json' => ['27 elemen (3 * 3 * 3)', '9 elemen (3 * 3)', '18 elemen (3 * 6)', '81 elemen (3^4)'],
                'answer_json' => '27 elemen (3 * 3 * 3)',
                'explanation' => 'Kapasitas total array 3 dimensi berdimensi 3x3x3 adalah 3 x 3 x 3 = 27 sel elemen.',
                'order_index' => 2,
            ]
        );

        // Lesson 1.2: Robot Axis & Vector Coordinates
        $lesson2 = Lesson::firstOrCreate(
            ['unit_id' => $unit1->id, 'slug' => 'sistem-koordinat-robotika-3d'],
            [
                'title' => 'Navigasi Spasial Robotika 3D',
                'description' => 'Mengarahkan pergerakan robot dan drone pada sumbu 3D Cartesian.',
                'type' => 'quiz',
                'theory_content' => 'Sistem koordinat 3D Cartesian menggunakan 3 sumbu: X (Kanan-Kiri), Y (Tinggi-Rendah), dan Z (Maju-Mundur).',
                'xp_reward' => 35,
                'order_index' => 2,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson2->id, 'prompt' => 'Perhatikan arah vektor sumbu robot 3D berikut. Bola target hijau neon berada di posisi koordinat (+X, +Y, +Z). Jika robot ingin mencapai target, operator logika apa yang memastikan seluruh sumbu terpenuhi?'],
            [
                'question_type' => 'interactive_3d',
                'options_json' => ['if pos_x >= target_x and pos_y >= target_y and pos_z >= target_z:', 'if pos_x == 0 or pos_y == 0:', 'if pos_x < target_x and pos_y < target_y:', 'if not pos_z:'],
                'answer_json' => 'if pos_x >= target_x and pos_y >= target_y and pos_z >= target_z:',
                'model_3d_json' => [
                    'preset' => 'robot_axis',
                    'color' => '#2563eb',
                    'accent_color' => '#10b981',
                    'animation' => 'hover',
                    'wireframe' => false,
                    'show_grid' => true,
                    'label' => 'Sistem Koordinat 3D Robot Navigasi',
                ],
                'explanation' => 'Semua koordinat (X, Y, dan Z) harus tercapai secara bersamaan, sehingga kita wajib menggunakan operator logika AND.',
                'order_index' => 1,
            ]
        );

        // 3. Unit 2: Struktur Data & Arsitektur Komputer 3D
        $unit2 = Unit::firstOrCreate(
            ['course_id' => $course->id, 'title' => 'Unit 2: Pohon Biner & Register Memori 3D'],
            [
                'description' => 'Visualisasi pohon biner 3 dimensi dan tumpukan register memori CPU.',
                'order_index' => 2,
            ]
        );

        // Lesson 2.1: Binary Tree 3D
        $lesson3 = Lesson::firstOrCreate(
            ['unit_id' => $unit2->id, 'slug' => 'pohon-biner-3d-visual'],
            [
                'title' => 'Visualisasi Pohon Biner 3D (Binary Tree)',
                'description' => 'Menjelajahi hierarki node parent dan child pada graf 3 dimensi.',
                'type' => 'quiz',
                'theory_content' => 'Setiap node pada Binary Tree memiliki maksimal dua child: Left Child dan Right Child.',
                'xp_reward' => 35,
                'order_index' => 1,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson3->id, 'prompt' => 'Perhatikan struktur 3D Binary Tree berikut. Node hijau neon yang menyala merupakan child node sisi kanan dari root. Berapakah kedalaman (depth level) node hijau tersebut?'],
            [
                'question_type' => 'interactive_3d',
                'options_json' => ['Depth Level 1', 'Depth Level 0 (Root)', 'Depth Level 2', 'Depth Level 3'],
                'answer_json' => 'Depth Level 1',
                'model_3d_json' => [
                    'preset' => 'binary_tree',
                    'color' => '#6366f1',
                    'accent_color' => '#10b981',
                    'animation' => 'rotate',
                    'wireframe' => false,
                    'show_grid' => true,
                    'label' => 'Visualisasi Pohon Biner 3D (Binary Search Tree)',
                ],
                'explanation' => 'Root node berada di level 0, sedangkan child langsung tepat di bawah root berada di level 1 (depth = 1).',
                'order_index' => 1,
            ]
        );

        // Lesson 2.2: Memory Registers 3D
        $lesson4 = Lesson::firstOrCreate(
            ['unit_id' => $unit2->id, 'slug' => 'tumpukan-register-memori-3d'],
            [
                'title' => 'Stack Register Memori CPU 3D',
                'description' => 'Memahami alamat memori bertingkat pada arsitektur komputer.',
                'type' => 'quiz',
                'theory_content' => 'Memori komputer diorganisir sebagai blok-blok beralamat heksadesimal (0x00, 0x04, 0x08, ...).',
                'xp_reward' => 35,
                'order_index' => 2,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson4->id, 'prompt' => 'Perhatikan tumpukan blok memori 3D berikut. Setiap blok memori berukuran 4 byte. Jika blok pertama beralamat 0x00 dan blok kedua 0x04, beralamat di manakah blok ke-3 yang menyala hijau neon?'],
            [
                'question_type' => 'interactive_3d',
                'options_json' => ['0x08 (Byte ke-8)', '0x06 (Byte ke-6)', '0x0C (Byte ke-12)', '0x10 (Byte ke-16)'],
                'answer_json' => '0x08 (Byte ke-8)',
                'model_3d_json' => [
                    'preset' => 'memory_block',
                    'color' => '#2563eb',
                    'accent_color' => '#10b981',
                    'animation' => 'pulse',
                    'wireframe' => false,
                    'show_grid' => true,
                    'label' => 'Visualisasi Stack Register Memori 3D',
                ],
                'explanation' => 'Dengan offset 4 byte tiap slot: Blok 0 = 0x00, Blok 1 = 0x04, Blok 2 = 0x08 (0 + 4 + 4 = 8).',
                'order_index' => 1,
            ]
        );

        // Lesson 2.3: Mini Project 3D Visual Loop
        $lesson5 = Lesson::firstOrCreate(
            ['unit_id' => $unit2->id, 'slug' => 'mini-project-circular-buffer-3d'],
            [
                'title' => 'Mini Project: Antrean Sirkular (Ring Buffer Torus 3D)',
                'description' => 'Menerapkan konsep struktur data Circular Queue menggunakan visualisasi Torus 3D.',
                'type' => 'project',
                'is_project' => true,
                'project_brief' => 'Pahami cara kerja antrean sirkular: indeks berputar kembali ke awal menggunakan operasi modulo (% kapasitas).',
                'theory_content' => 'Torus merepresentasikan struktur data melingkar (Circular Buffer) di mana ujung akhir terhubung kembali ke awal.',
                'xp_reward' => 75,
                'order_index' => 3,
            ]
        );

        Exercise::firstOrCreate(
            ['lesson_id' => $lesson5->id, 'prompt' => 'Mini Project Task: Perhatikan visualisasi Torus Ring 3D berikut. Jika antrean memiliki kapasitas 8 elemen, rumus indeks berikutnya untuk pointer berputar adalah:'],
            [
                'question_type' => 'interactive_3d',
                'options_json' => ['next_index = (current_index + 1) % 8', 'next_index = current_index + 8', 'next_index = current_index / 8', 'next_index = current_index * 8'],
                'answer_json' => 'next_index = (current_index + 1) % 8',
                'model_3d_json' => [
                    'preset' => 'geometry_torus',
                    'color' => '#7e22ce',
                    'accent_color' => '#f59e0b',
                    'animation' => 'orbit',
                    'wireframe' => true,
                    'show_grid' => true,
                    'label' => 'Struktur Data Melingkar: Torus Ring Buffer 3D',
                ],
                'explanation' => 'Operasi modulo (% 8) memastikan nilai indeks selalu berada di rentang 0 sampai 7 saat berputar melingkar.',
                'order_index' => 1,
            ]
        );
    }
}
