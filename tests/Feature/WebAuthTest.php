<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
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
            ->assertSee('EDUSKILL')
            ->assertSee('Platform Belajar Interaktif');
    }

    public function test_can_view_login_page_with_demo_accounts(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200)
            ->assertSee('Masuk ke EduSkill')
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

    public function test_can_logout_via_get_request(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_custom_404_error_page_renders(): void
    {
        $response = $this->get('/halaman-acak-yang-pasti-tidak-ada-12345');

        $response->assertStatus(404)
            ->assertSee('ERROR 404')
            ->assertSee('Halaman Tidak Ditemukan')
            ->assertSee('Kembali ke Beranda');
    }

    public function test_custom_403_error_page_renders(): void
    {
        Route::get('/test-403-forbidden', function () {
            abort(403);
        });

        $response = $this->get('/test-403-forbidden');

        $response->assertStatus(403)
            ->assertSee('ERROR 403')
            ->assertSee('Akses Dibatasi');
    }
}
