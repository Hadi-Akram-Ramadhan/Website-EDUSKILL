<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Services\ExerciseImportService;
use App\Services\GamificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Interactive3DQuizTest extends TestCase
{
    use RefreshDatabase;

    protected User $mentor;

    protected User $student;

    protected Course $course;

    protected Unit $unit;

    protected Lesson $lesson;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mentor = User::factory()->create([
            'name' => 'Pak Hendra, S.Kom',
            'email' => 'guru@eduskill.test',
            'role' => 'guru',
        ]);

        $this->student = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@eduskill.test',
            'role' => 'siswa',
            'hearts' => 5,
            'xp' => 100,
        ]);

        $this->course = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Pemrograman 3D & Spasial',
            'slug' => 'pemrograman-3d-spasial',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $this->unit = Unit::create([
            'course_id' => $this->course->id,
            'title' => 'Unit 1: Visualisasi 3D Komputasi',
            'description' => 'Materi spasial 3D',
            'order_index' => 1,
        ]);

        $this->lesson = Lesson::create([
            'unit_id' => $this->unit->id,
            'title' => 'Modul 1: Koordinat dan Matriks 3D',
            'slug' => 'modul-1-koordinat-dan-matriks-3d',
            'description' => 'Latihan 3D Interaktif',
            'type' => 'quiz',
            'xp_reward' => 30,
            'order_index' => 1,
        ]);
    }

    public function test_mentor_can_create_interactive_3d_exercise(): void
    {
        $response = $this->actingAs($this->mentor)
            ->post(route('mentor.exercises.store', $this->lesson->id), [
                'question_type' => 'interactive_3d',
                'prompt' => 'Elemen hijau neon pada matriks 3D [3x3x3] berikut berada pada indeks apa?',
                'options_3d' => ['matriks[1][0][1]', 'matriks[0][1][1]', 'matriks[2][2][2]', 'matriks[0][0][0]'],
                'correct_choice_3d' => 'matriks[1][0][1]',
                'model_3d_type' => 'matrix_grid',
                'model_3d_color' => '#2563eb',
                'model_3d_accent' => '#10b981',
                'model_3d_animation' => 'rotate',
                'model_3d_wireframe' => 1,
                'model_3d_grid' => 1,
                'model_3d_label' => 'Visualisasi Matriks 3D',
                'explanation' => 'Akses indeks array 3 dimensi adalah [X][Y][Z].',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('exercises', [
            'lesson_id' => $this->lesson->id,
            'question_type' => 'interactive_3d',
            'prompt' => 'Elemen hijau neon pada matriks 3D [3x3x3] berikut berada pada indeks apa?',
        ]);

        $exercise = Exercise::where('lesson_id', $this->lesson->id)->first();
        $this->assertNotNull($exercise);
        $this->assertEquals('interactive_3d', $exercise->question_type);
        $this->assertIsArray($exercise->model_3d_json);
        $this->assertEquals('matrix_grid', $exercise->model_3d_json['preset']);
        $this->assertEquals('#2563eb', $exercise->model_3d_json['color']);
        $this->assertEquals('#10b981', $exercise->model_3d_json['accent_color']);
        $this->assertTrue($exercise->model_3d_json['wireframe']);
        $this->assertEquals('Visualisasi Matriks 3D', $exercise->model_3d_json['label']);
    }

    public function test_student_can_view_interactive_3d_exercise_in_lesson_player(): void
    {
        $exercise = Exercise::create([
            'lesson_id' => $this->lesson->id,
            'question_type' => 'interactive_3d',
            'prompt' => 'Tentukan koordinat waypoint drone 3D:',
            'options_json' => ['(1.8, 1.2, 1.8)', '(0, 0, 0)', '(5, 5, 5)'],
            'answer_json' => '(1.8, 1.2, 1.8)',
            'model_3d_json' => [
                'preset' => 'robot_axis',
                'color' => '#3b82f6',
                'accent_color' => '#10b981',
                'animation' => 'hover',
                'wireframe' => false,
                'show_grid' => true,
                'label' => 'Sistem Koordinat 3D Robot Navigasi',
            ],
            'order_index' => 1,
        ]);

        $response = $this->actingAs($this->student)
            ->get(route('learn.lesson', $this->lesson->id));

        $response->assertOk();
        $response->assertViewHas('exercises');
        $response->assertSee('Tentukan koordinat waypoint drone 3D:');
        $response->assertSee('three-viewport-container');
    }

    public function test_student_can_submit_correct_interactive_3d_answer_and_earn_xp(): void
    {
        $exercise = Exercise::create([
            'lesson_id' => $this->lesson->id,
            'question_type' => 'interactive_3d',
            'prompt' => 'Pilih indeks target 3D:',
            'options_json' => ['matriks[1][0][1]', 'matriks[0][0][0]'],
            'answer_json' => 'matriks[1][0][1]',
            'model_3d_json' => [
                'preset' => 'matrix_grid',
                'color' => '#2563eb',
            ],
            'order_index' => 1,
        ]);

        $initialXp = $this->student->xp;

        $response = $this->actingAs($this->student)
            ->postJson(route('learn.submit', $this->lesson->id), [
                'answers' => [
                    [
                        'exercise_id' => $exercise->id,
                        'answer' => 'matriks[1][0][1]',
                    ],
                ],
            ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data' => [
                'passed' => true,
                'score' => 100,
            ],
        ]);

        $this->student->refresh();
        $this->assertGreaterThan($initialXp, $this->student->xp);
    }

    public function test_gamification_service_evaluates_interactive_3d_correctly(): void
    {
        $exercise = Exercise::create([
            'lesson_id' => $this->lesson->id,
            'question_type' => 'interactive_3d',
            'prompt' => 'Pilih simpul pohon:',
            'options_json' => ['Depth 1', 'Depth 0'],
            'answer_json' => 'Depth 1',
            'model_3d_json' => ['preset' => 'binary_tree'],
            'order_index' => 1,
        ]);

        $service = app(GamificationService::class);

        $this->assertTrue($service->evaluateExercise($exercise, 'Depth 1'));
        $this->assertTrue($service->evaluateExercise($exercise, ' depth 1 '));
        $this->assertFalse($service->evaluateExercise($exercise, 'Depth 0'));
    }

    public function test_exercise_import_service_recognizes_3d_types(): void
    {
        $service = app(ExerciseImportService::class);

        $this->assertEquals('interactive_3d', $service->normalizeQuestionType('interactive_3d'));
        $this->assertEquals('interactive_3d', $service->normalizeQuestionType('soal_3d'));
        $this->assertEquals('interactive_3d', $service->normalizeQuestionType('3D'));
        $this->assertEquals('interactive_3d', $service->normalizeQuestionType('model_3d'));

        [$options, $answer] = $service->parseOptionsAndAnswer('interactive_3d', 'Indeks A|Indeks B|Indeks C', 'Indeks A');
        $this->assertEquals(['Indeks A', 'Indeks B', 'Indeks C'], $options);
        $this->assertEquals('Indeks A', $answer);
    }

    public function test_api_returns_model_3d_data_for_interactive_3d_exercise(): void
    {
        Exercise::create([
            'lesson_id' => $this->lesson->id,
            'question_type' => 'interactive_3d',
            'prompt' => 'Soal 3D API Test',
            'options_json' => ['A', 'B'],
            'answer_json' => 'A',
            'model_3d_json' => [
                'preset' => 'memory_block',
                'color' => '#10b981',
            ],
            'order_index' => 1,
        ]);

        $response = $this->actingAs($this->student, 'sanctum')
            ->getJson("/api/v1/lessons/{$this->lesson->id}");

        $response->assertOk();
        $response->assertJsonPath('data.exercises.0.question_type', 'interactive_3d');
        $response->assertJsonPath('data.exercises.0.model_3d.preset', 'memory_block');
    }

    public function test_mentor_can_create_custom_3d_exercise_with_advanced_parameters(): void
    {
        $response = $this->actingAs($this->mentor)
            ->post(route('mentor.exercises.store', $this->lesson->id), [
                'question_type' => 'interactive_3d',
                'prompt' => 'Di manakah target koordinat matrix?',
                'options_3d' => ['[2, 1, 2]', '[0, 0, 0]'],
                'correct_choice_3d' => '[2, 1, 2]',
                'model_3d_type' => 'matrix_grid',
                'model_3d_matrix_size' => 4,
                'model_3d_target_x' => 2,
                'model_3d_target_y' => 1,
                'model_3d_target_z' => 2,
                'model_3d_scale' => 1.5,
                'model_3d_speed' => 'fast',
                'model_3d_material' => 'glow',
                'model_3d_color' => '#6366f1',
                'model_3d_accent' => '#ec4899',
            ]);

        $response->assertRedirect();
        $exercise = Exercise::where('lesson_id', $this->lesson->id)
            ->where('prompt', 'Di manakah target koordinat matrix?')
            ->first();

        $this->assertNotNull($exercise);
        $this->assertEquals(4, $exercise->model_3d_json['matrix_size']);
        $this->assertEquals(2, $exercise->model_3d_json['target_x']);
        $this->assertEquals(1, $exercise->model_3d_json['target_y']);
        $this->assertEquals(2, $exercise->model_3d_json['target_z']);
        $this->assertEquals(1.5, $exercise->model_3d_json['scale']);
        $this->assertEquals('fast', $exercise->model_3d_json['speed']);
        $this->assertEquals('glow', $exercise->model_3d_json['material']);
    }
}
