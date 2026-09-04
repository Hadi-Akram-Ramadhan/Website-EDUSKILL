<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebLearnTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_guest_is_redirected_to_login_when_accessing_learn(): void
    {
        $response = $this->get('/learn');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_student_can_view_learning_roadmap(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();

        $response = $this->actingAs($user)->get('/learn');

        $response->assertStatus(200)
            ->assertSee('Unit 1: Perintah Cetak & Variabel')
            ->assertSee('Instruksi print() dan Teks')
            ->assertSee('Streak')
            ->assertSee('Nyawa');
    }

    public function test_can_load_interactive_lesson_player(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $lesson = Lesson::first();

        $response = $this->actingAs($user)->get("/learn/lesson/{$lesson->id}");

        $response->assertStatus(200)
            ->assertSee('Periksa Jawaban')
            ->assertSee($lesson->title);
    }

    public function test_can_submit_lesson_via_web_ajax(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $lesson = Lesson::first();
        $exercises = $lesson->exercises()->get();

        $answers = [
            ['exercise_id' => $exercises[0]->id, 'answer' => 'print'],
            ['exercise_id' => $exercises[1]->id, 'answer' => 'Halo Andi'],
            ['exercise_id' => $exercises[2]->id, 'answer' => ['1', '2', '3']],
        ];

        $response = $this->actingAs($user)->postJson("/learn/lesson/{$lesson->id}/submit", [
            'answers' => $answers,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.passed', true);
    }

    public function test_can_refill_hearts_via_web_action(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $user->hearts = 2;
        $user->gems = 50;
        $user->save();

        $response = $this->actingAs($user)->post('/learn/refill-hearts');

        $response->assertRedirect();
        $user->refresh();
        $this->assertEquals(5, $user->hearts);
        $this->assertEquals(30, $user->gems);
    }

    public function test_mascot_companion_and_developer_league_render_properly(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $user->xp = 350; // Should be Gold Engineer tier
        $user->save();

        $response = $this->actingAs($user)->get('/learn');

        $response->assertStatus(200)
            ->assertSee('eduskill-mascot-widget')
            ->assertSee('Byte • AI Companion')
            ->assertSee('Liga Pengembang')
            ->assertSee('Gold Engineer');
    }

    public function test_lesson_player_includes_mascot_and_combo_pill(): void
    {
        $user = User::where('email', 'budi@smp.sch.id')->first();
        $lesson = Lesson::first();

        $response = $this->actingAs($user)->get("/learn/lesson/{$lesson->id}");

        $response->assertStatus(200)
            ->assertSee('eduskill-mascot-widget')
            ->assertSee('combo-streak-pill')
            ->assertSee('victory-combo');
    }
}
