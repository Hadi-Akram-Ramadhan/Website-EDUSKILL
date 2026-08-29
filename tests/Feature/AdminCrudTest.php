<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $mentor;

    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'role' => 'super_admin',
        ]);

        $this->mentor = User::factory()->create([
            'name' => 'Mentor Test',
            'email' => 'mentor@test.com',
            'role' => 'guru',
        ]);

        $this->student = User::factory()->create([
            'name' => 'Student Test',
            'email' => 'student@test.com',
            'role' => 'siswa',
        ]);
    }

    public function test_admin_can_view_users_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertSee('Manajemen Pengguna');
        $response->assertSee('Student Test');
    }

    public function test_admin_can_create_new_user(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'New Student',
            'email' => 'newstudent@test.com',
            'password' => 'secret123',
            'role' => 'siswa',
            'xp' => 50,
            'gems' => 100,
            'hearts' => 5,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'newstudent@test.com',
            'role' => 'siswa',
        ]);
    }

    public function test_admin_can_edit_user(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $this->student->id), [
            'name' => 'Student Updated',
            'email' => 'student_updated@test.com',
            'role' => 'siswa',
            'xp' => 200,
            'gems' => 50,
            'hearts' => 4,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->student->id,
            'name' => 'Student Updated',
            'xp' => 200,
        ]);
    }

    public function test_admin_can_delete_user_but_not_self(): void
    {
        // Admin deletes student
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->student->id));
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $this->student->id]);

        // Admin attempts to delete self
        $responseSelf = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin->id));
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_manage_courses_and_toggle_publish(): void
    {
        $course = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Admin Course Test',
            'slug' => 'admin-course-test',
            'category' => 'Test',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        // Toggle publish
        $toggleResp = $this->actingAs($this->admin)->post(route('admin.courses.toggle-publish', $course->id));
        $toggleResp->assertStatus(302);
        $this->assertFalse($course->fresh()->is_published);

        // Delete course
        $deleteResp = $this->actingAs($this->admin)->delete(route('admin.courses.destroy', $course->id));
        $deleteResp->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_student_and_mentor_cannot_access_admin_user_crud(): void
    {
        $respStudent = $this->actingAs($this->student)->get(route('admin.users.index'));
        $respStudent->assertRedirect(route('learn.index'));

        $respMentor = $this->actingAs($this->mentor)->get(route('admin.users.index'));
        $respMentor->assertRedirect(route('mentor.dashboard'));
    }
}
