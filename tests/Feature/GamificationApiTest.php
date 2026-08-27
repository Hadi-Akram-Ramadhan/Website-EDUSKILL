<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GamificationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_can_fetch_course_roadmap(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $course = Course::first();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'units' => [
                        '*' => [
                            'id',
                            'title',
                            'lessons' => [
                                '*' => ['id', 'title', 'is_unlocked', 'is_completed']
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_can_submit_lesson_exercises_and_gain_xp(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $initialXp = $user->xp;

        $lesson = Lesson::where('title', 'Instruksi print() dan Teks')->first();
        $exercises = $lesson->exercises()->get();

        $answers = [
            ['exercise_id' => $exercises[0]->id, 'answer' => 'print'],
            ['exercise_id' => $exercises[1]->id, 'answer' => 'Halo Andi'],
            ['exercise_id' => $exercises[2]->id, 'answer' => ['1', '2', '3']],
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/v1/lessons/{$lesson->id}/submit", [
            'answers' => $answers,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.passed', true)
            ->assertJsonPath('data.score', 100);

        $user->refresh();
        $this->assertGreaterThan($initialXp, $user->xp);
    }

    public function test_wrong_answer_deducts_heart(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $user->hearts = 5;
        $user->save();

        $lesson = Lesson::where('title', 'Instruksi print() dan Teks')->first();
        $exercises = $lesson->exercises()->get();

        $answers = [
            ['exercise_id' => $exercises[0]->id, 'answer' => 'wrong_answer'],
            ['exercise_id' => $exercises[1]->id, 'answer' => 'wrong_answer'],
            ['exercise_id' => $exercises[2]->id, 'answer' => ['3', '2', '1']],
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/v1/lessons/{$lesson->id}/submit", [
            'answers' => $answers,
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertLessThan(5, $user->hearts);
    }

    public function test_can_refill_hearts_with_gems(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $user->hearts = 2;
        $user->gems = 50;
        $user->save();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/profile/refill-hearts');

        $response->assertStatus(200)
            ->assertJsonPath('data.hearts', 5);

        $user->refresh();
        $this->assertEquals(5, $user->hearts);
        $this->assertEquals(30, $user->gems); // 50 - 20 = 30
    }
}
