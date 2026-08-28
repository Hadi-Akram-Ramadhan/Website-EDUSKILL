<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_super_admin_is_redirected_to_admin_dashboard_on_login(): void
    {
        $admin = User::where('email', 'admin@kodein.id')->first();

        $response = $this->post('/login', [
            'email' => 'admin@kodein.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');

        $dashResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $dashResponse->assertStatus(200)
            ->assertSee('Dashboard Super Admin')
            ->assertSee('Total Pengguna')
            ->assertSee('Kurikulum Kursus');
    }

    public function test_mentor_is_redirected_to_mentor_dashboard_on_login(): void
    {
        $guru = User::where('email', 'guru@kodein.id')->first();

        $response = $this->post('/login', [
            'email' => 'guru@kodein.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/mentor/dashboard');

        $dashResponse = $this->actingAs($guru)->get('/mentor/dashboard');
        $dashResponse->assertStatus(200)
            ->assertSee('Dashboard Mentor')
            ->assertSee('Kursus Binaan')
            ->assertSee('Aktivitas Pengerjaan Siswa');
    }

    public function test_student_is_redirected_to_learn_roadmap_on_login(): void
    {
        $student = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->post('/login', [
            'email' => 'budi@smp.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/learn');
    }

    public function test_student_cannot_access_admin_or_mentor_dashboards(): void
    {
        $student = User::where('email', 'budi@smp.sch.id')->first();

        $adminAttempt = $this->actingAs($student)->get('/admin/dashboard');
        $adminAttempt->assertRedirect('/learn');

        $mentorAttempt = $this->actingAs($student)->get('/mentor/dashboard');
        $mentorAttempt->assertRedirect('/learn');
    }

    public function test_mentor_cannot_access_admin_dashboard(): void
    {
        $guru = User::where('email', 'guru@kodein.id')->first();

        $response = $this->actingAs($guru)->get('/admin/dashboard');
        $response->assertRedirect('/mentor/dashboard');
    }
}
