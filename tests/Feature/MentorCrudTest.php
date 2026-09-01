<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentorCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $mentor;

    protected User $otherMentor;

    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mentor = User::factory()->create([
            'name' => 'Mentor Alpha',
            'email' => 'alpha@test.com',
            'role' => 'guru',
        ]);

        $this->otherMentor = User::factory()->create([
            'name' => 'Mentor Beta',
            'email' => 'beta@test.com',
            'role' => 'guru',
        ]);

        $this->student = User::factory()->create([
            'name' => 'Student Charlie',
            'email' => 'charlie@test.com',
            'role' => 'siswa',
        ]);
    }

    public function test_mentor_can_view_their_courses(): void
    {
        Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Kursus Alpha',
            'slug' => 'kursus-alpha',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->mentor)->get(route('mentor.courses.index'));
        $response->assertStatus(200);
        $response->assertSee('Kursus Alpha');
    }

    public function test_mentor_can_create_course(): void
    {
        $response = $this->actingAs($this->mentor)->post(route('mentor.courses.store'), [
            'title' => 'Kursus Baru Buatan Mentor',
            'category' => 'Web',
            'level' => 'beginner',
            'description' => 'Deskripsi kursus baru',
            'target_audience' => 'Siswa SMP',
            'is_published' => '1',
        ]);

        $course = Course::where('title', 'Kursus Baru Buatan Mentor')->first();
        $this->assertNotNull($course);
        $this->assertEquals($this->mentor->id, $course->mentor_id);
        $response->assertRedirect(route('mentor.courses.manage', $course->id));
    }

    public function test_mentor_cannot_manage_other_mentor_course(): void
    {
        $otherCourse = Course::create([
            'mentor_id' => $this->otherMentor->id,
            'title' => 'Kursus Beta',
            'slug' => 'kursus-beta',
            'category' => 'Web',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->mentor)->get(route('mentor.courses.manage', $otherCourse->id));
        $response->assertStatus(403);
    }

    public function test_mentor_can_add_unit_lesson_and_exercise(): void
    {
        $course = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Kursus Python',
            'slug' => 'kursus-python',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        // 1. Add Unit
        $unitResp = $this->actingAs($this->mentor)->post(route('mentor.units.store', $course->id), [
            'title' => 'Unit 1: Pengenalan',
            'description' => 'Materi dasar',
        ]);
        $unitResp->assertStatus(302);
        $unit = Unit::where('course_id', $course->id)->first();
        $this->assertNotNull($unit);

        // 2. Add Lesson
        $lessonResp = $this->actingAs($this->mentor)->post(route('mentor.lessons.store', $unit->id), [
            'title' => 'Modul 1: Print Teks',
            'xp_reward' => 20,
        ]);
        $lessonResp->assertStatus(302);
        $lesson = Lesson::where('unit_id', $unit->id)->first();
        $this->assertNotNull($lesson);

        // 3. Add Exercise (Multiple Choice)
        $exerciseResp = $this->actingAs($this->mentor)->post(route('mentor.exercises.store', $lesson->id), [
            'question_type' => 'multiple_choice',
            'prompt' => 'Apa fungsi print() di Python?',
            'options_raw' => "Mencetak teks ke layar\nMenghapus file\nMematikan komputer",
            'answer_raw' => 'Mencetak teks ke layar',
            'explanation' => 'print() untuk mencetak teks.',
        ]);
        $exerciseResp->assertStatus(302);
        $exercise = Exercise::where('lesson_id', $lesson->id)->first();
        $this->assertNotNull($exercise);
        $this->assertEquals('multiple_choice', $exercise->question_type);

        // 4. Delete Exercise
        $deleteExResp = $this->actingAs($this->mentor)->delete(route('mentor.exercises.destroy', $exercise->id));
        $deleteExResp->assertStatus(302);
        $this->assertDatabaseMissing('exercises', ['id' => $exercise->id]);
    }

    public function test_student_cannot_access_mentor_portal(): void
    {
        $response = $this->actingAs($this->student)->get(route('mentor.courses.index'));
        $response->assertRedirect(route('learn.index'));
    }

    public function test_mentor_can_toggle_and_release_roadmap_course(): void
    {
        $course = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Kursus Mendatang',
            'slug' => 'kursus-mendatang',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
            'is_upcoming' => true,
        ]);

        // Release upcoming course into active learning mode
        $response = $this->actingAs($this->mentor)
            ->post(route('mentor.courses.toggle-release', $course->id));

        $response->assertRedirect();
        $course->refresh();
        $this->assertTrue($course->is_published);
        $this->assertFalse($course->is_upcoming);

        // Toggle back to upcoming
        $response = $this->actingAs($this->mentor)
            ->post(route('mentor.courses.toggle-release', $course->id));

        $response->assertRedirect();
        $course->refresh();
        $this->assertTrue($course->is_upcoming);
    }
}
