<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiCourseLearnTest extends TestCase
{
    use RefreshDatabase;

    protected User $student;

    protected User $mentor;

    protected Course $course1;

    protected Course $course2;

    protected Lesson $lessonC1;

    protected Lesson $lessonC2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mentor = User::factory()->create(['role' => 'guru']);
        $this->student = User::factory()->create(['role' => 'siswa', 'hearts' => 5, 'xp' => 100]);

        // Course 1
        $this->course1 = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Python Basics',
            'slug' => 'python-basics',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
        ]);
        $unit1 = Unit::create(['course_id' => $this->course1->id, 'title' => 'Unit 1', 'order_index' => 1]);
        $this->lessonC1 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Lesson Python 1',
            'slug' => 'lesson-python-1',
            'order_index' => 1,
            'xp_reward' => 20,
        ]);

        // Course 2
        $this->course2 = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Web HTML Basics',
            'slug' => 'web-html-basics',
            'category' => 'Web',
            'level' => 'beginner',
            'is_published' => true,
        ]);
        $unit2 = Unit::create(['course_id' => $this->course2->id, 'title' => 'Unit 2', 'order_index' => 1]);
        $this->lessonC2 = Lesson::create([
            'unit_id' => $unit2->id,
            'title' => 'Lesson Web 1',
            'slug' => 'lesson-web-1',
            'order_index' => 1,
            'xp_reward' => 20,
        ]);
    }

    public function test_student_can_switch_between_courses_on_learn_roadmap(): void
    {
        // 1. View default course
        $resp1 = $this->actingAs($this->student)->get(route('learn.index'));
        $resp1->assertStatus(200);
        $resp1->assertSee('Python Basics');

        // 2. Switch to Course 2 via query param
        $resp2 = $this->actingAs($this->student)->get(route('learn.index', ['course' => $this->course2->id]));
        $resp2->assertStatus(200);
        $resp2->assertSee('Web HTML Basics');
        $resp2->assertSee('Lesson Web 1');
    }

    public function test_student_can_view_certificate_progress_for_all_courses(): void
    {
        // Mark lessonC1 completed
        UserProgress::create([
            'user_id' => $this->student->id,
            'lesson_id' => $this->lessonC1->id,
            'is_completed' => true,
            'score' => 100,
        ]);

        $response = $this->actingAs($this->student)->get(route('certificates.web'));
        $response->assertStatus(200);
        $response->assertSee('Python Basics');
        $response->assertSee('Web HTML Basics');
        $response->assertSee('100%'); // Course 1 is 100%
        $response->assertSee('0%');   // Course 2 is 0%
    }

    public function test_student_can_claim_certificate_for_completed_course(): void
    {
        // Mark lessonC1 completed
        UserProgress::create([
            'user_id' => $this->student->id,
            'lesson_id' => $this->lessonC1->id,
            'is_completed' => true,
            'score' => 100,
        ]);

        $response = $this->actingAs($this->student)->post(route('certificates.claim', $this->course1->id));
        $response->assertStatus(302);

        $this->assertDatabaseHas('certificates', [
            'user_id' => $this->student->id,
            'course_id' => $this->course1->id,
        ]);
    }

    public function test_active_course_is_persisted_after_quiz_and_lesson_completion(): void
    {
        // 1. Student opens Course 2 lesson
        $response = $this->actingAs($this->student)->get(route('learn.lesson', $this->lessonC2->id));
        $response->assertStatus(200);
        $response->assertSessionHas('active_learn_course_id', $this->course2->id);

        // 2. Student completes lesson and submits
        $submitResponse = $this->actingAs($this->student)->postJson(route('learn.submit', $this->lessonC2->id), [
            'answers' => [],
        ]);
        $submitResponse->assertStatus(200);
        $this->assertEquals($this->course2->id, session('active_learn_course_id'));

        // 3. Student navigates back to /learn without explicit query param
        $roadmapResponse = $this->actingAs($this->student)->get(route('learn.index'));
        $roadmapResponse->assertStatus(200);
        // It must display Course 2 (Web HTML Basics) instead of jumping back to Course 1 (Python Basics)
        $roadmapResponse->assertSee('Web HTML Basics');
        $roadmapResponse->assertSee('Lesson Web 1');
    }
}
