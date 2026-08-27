<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserProgress;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_cannot_claim_certificate_if_course_not_fully_completed(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $course = Course::first();

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/v1/certificates/claim/{$course->id}");

        $response->assertStatus(400)
            ->assertJsonPath('success', false);
    }

    public function test_can_claim_certificate_and_verify_publicly_when_all_lessons_completed(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $course = Course::first();

        // Mark all lessons completed
        $allLessons = Lesson::all();
        foreach ($allLessons as $lesson) {
            UserProgress::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'is_completed' => true,
                'score' => 95,
                'completed_at' => now(),
            ]);
        }

        // Claim Certificate
        $response = $this->actingAs($user, 'sanctum')->postJson("/api/v1/certificates/claim/{$course->id}");

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['cert_code', 'cert_hash', 'recipient_name', 'course_title', 'qr_code_url'],
            ]);

        $certCode = $response->json('data.cert_code');

        // Test API verification endpoint
        $verifyApiResponse = $this->getJson("/api/v1/certificates/verify/{$certCode}");
        $verifyApiResponse->assertStatus(200)
            ->assertJsonPath('data.cert_code', $certCode)
            ->assertJsonPath('data.is_valid', true);

        // Test Public Web verification page (QR Code destination)
        $verifyWebResponse = $this->get("/verify/{$certCode}");
        $verifyWebResponse->assertStatus(200)
            ->assertSee('SERTIFIKAT RESMI')
            ->assertSee($user->name)
            ->assertSee($certCode);
    }
}
