<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserProgress;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebLeaderboardAndProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_can_view_leaderboard_page(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->actingAs($user)->get('/leaderboard');

        $response->assertStatus(200)
            ->assertSee('Liga Berlian')
            ->assertSee('Total XP')
            ->assertSee('Hari Streak');
    }

    public function test_can_view_profile_and_badges(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200)
            ->assertSee($user->name)
            ->assertSee('Statistik Belajar')
            ->assertSee('Koleksi Lencana');
    }

    public function test_can_view_certificates_and_claim_when_completed(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $course = Course::first();

        // Mark all lessons completed
        foreach (Lesson::all() as $lesson) {
            UserProgress::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'is_completed' => true,
                'score' => 100,
                'completed_at' => now(),
            ]);
        }

        $response = $this->actingAs($user)->get('/certificates');
        $response->assertStatus(200)
            ->assertSee('KLAIM SERTIFIKAT RESMI');

        // Claim Certificate
        $claimResponse = $this->actingAs($user)->post("/certificates/claim/{$course->id}");
        $claimResponse->assertRedirect();
    }
}
