<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_via_api(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Ahmad Siswa',
            'email' => 'ahmad@smp.sch.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'siswa',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email', 'role', 'xp', 'level', 'hearts', 'gems'],
                    'token',
                    'token_type',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'ahmad@smp.sch.id',
            'role' => 'siswa',
        ]);
    }

    public function test_user_can_login_and_get_sanctum_token(): void
    {
        $user = User::factory()->create([
            'email' => 'login_test@smp.sch.id',
            'password' => bcrypt('secret123'),
            'role' => 'siswa',
            'hearts' => 5,
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'login_test@smp.sch.id',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['user', 'token', 'token_type'],
            ]);
    }

    public function test_user_can_get_profile_when_authenticated(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
            'xp' => 150,
            'level' => 2,
            'hearts' => 5,
            'streak_count' => 3,
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', $user->email)
            ->assertJsonPath('data.user.xp', 150);
    }
}
