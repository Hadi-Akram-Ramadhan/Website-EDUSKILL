<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserProgress;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiniProjectAndCertificateScoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_mentor_can_create_mini_project_lesson(): void
    {
        $mentor = User::where('role', 'guru')->first();
        $unit = Unit::first();

        $response = $this->actingAs($mentor)->post("/mentor/units/{$unit->id}/lessons", [
            'title' => 'Mini Project: Game Tebak Angka',
            'xp_reward' => 50,
            'is_project' => '1',
            'project_brief' => 'Buat program game tebak angka rahasia menggunakan loop while dan percabangan if-else.',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('lessons', [
            'unit_id' => $unit->id,
            'title' => 'Mini Project: Game Tebak Angka',
            'is_project' => true,
            'type' => 'project',
            'project_brief' => 'Buat program game tebak angka rahasia menggunakan loop while dan percabangan if-else.',
            'xp_reward' => 50,
        ]);
    }

    public function test_student_can_view_roadmap_with_mini_project_indicators(): void
    {
        $student = User::where('role', 'siswa')->first();
        $course = Course::first();

        $response = $this->actingAs($student)->get("/learn?course={$course->id}");

        $response->assertStatus(200)
            ->assertSee('PROYEK AKHIR')
            ->assertSee('Mini Project: Kartu Profil Siswa Digital');
    }

    public function test_certificate_grade_and_score_calculation(): void
    {
        $certA = new Certificate(['score_average' => 95.0]);
        $this->assertEquals('A', $certA->grade_info['grade']);
        $this->assertEquals('Sangat Memuaskan (Distinction)', $certA->grade_info['predicate']);

        $certB = new Certificate(['score_average' => 84.5]);
        $this->assertEquals('B', $certB->grade_info['grade']);
        $this->assertEquals('Memuaskan (Merit)', $certB->grade_info['predicate']);

        $certC = new Certificate(['score_average' => 72.0]);
        $this->assertEquals('C', $certC->grade_info['grade']);
        $this->assertEquals('Lulus (Pass)', $certC->grade_info['predicate']);

        $certD = new Certificate(['score_average' => 60.0]);
        $this->assertEquals('D', $certD->grade_info['grade']);
        $this->assertEquals('Cukup', $certD->grade_info['predicate']);
    }

    public function test_public_certificate_verification_displays_score_and_grade(): void
    {
        $cert = Certificate::first();
        $this->assertNotNull($cert);

        $response = $this->get("/verify/{$cert->cert_code}");

        $response->assertStatus(200)
            ->assertSee(number_format($cert->score_average, 1))
            ->assertSee($cert->grade_info['grade'])
            ->assertSee($cert->grade_info['predicate']);
    }
}
