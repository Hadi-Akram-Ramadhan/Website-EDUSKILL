<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_can_view_landing_page(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200)
            ->assertSee('KODEIN')
            ->assertSee('Platform Belajar Interaktif');
    }

    public function test_can_view_login_page_with_demo_accounts(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
            ->assertSee('Masuk ke Kodein')
            ->assertSee('Demo Akun Uji Coba')
            ->assertSee('Budi Santoso');
    }

    public function test_can_login_via_web_form(): void
    {
        $response = $this->post('/login', [
            'email' => 'budi@smp.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect('/learn');
        $this->assertAuthenticated();
    }

    public function test_can_use_one_click_demo_login(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->get("/auth/quick-login/{$user->id}");

        $response->assertRedirect('/learn');
        $this->assertAuthenticatedAs($user);
    }

    public function test_can_register_new_student_via_web(): void
    {
        $response = $this->post('/register', [
            'name' => 'Doni Siswa Baru',
            'email' => 'doni@smp.sch.id',
            'role' => 'siswa',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/learn');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'doni@smp.sch.id']);
    }

    public function test_can_logout_via_web(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
