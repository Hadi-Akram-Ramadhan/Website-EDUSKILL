<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use App\Services\ExerciseImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MentorExerciseImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $mentor;

    protected Course $course;

    protected Unit $unit;

    protected Lesson $lesson;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mentor = User::factory()->create([
            'name' => 'Pak Hendra',
            'email' => 'hendra@eduskill.test',
            'role' => 'guru',
        ]);

        $this->course = Course::create([
            'mentor_id' => $this->mentor->id,
            'title' => 'Python Cepat',
            'slug' => 'python-cepat',
            'category' => 'Python',
            'level' => 'beginner',
            'is_published' => true,
        ]);

        $this->unit = Unit::create([
            'course_id' => $this->course->id,
            'title' => 'Unit 1: Sintaks Dasar',
            'description' => 'Materi dasar',
            'order_index' => 1,
        ]);

        $this->lesson = Lesson::create([
            'unit_id' => $this->unit->id,
            'title' => 'Modul 1: Variabel dan Cetak',
            'slug' => 'modul-1-variabel-dan-cetak',
            'description' => 'Latihan dasar',
            'type' => 'quiz',
            'xp_reward' => 20,
            'order_index' => 1,
        ]);
    }

    public function test_mentor_can_download_exercise_template_csv(): void
    {
        $response = $this->actingAs($this->mentor)->get(route('mentor.exercises.template', ['format' => 'csv']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename="template_soal_eduskill.csv"');
        $this->assertStringContainsString('question_type,prompt,code_snippet,options,answer,explanation', $response->getContent());
        $this->assertStringContainsString('multiple_choice', $response->getContent());
        $this->assertStringContainsString('fill_blank', $response->getContent());
        $this->assertStringContainsString('code_ordering', $response->getContent());
        $this->assertStringContainsString('matching_pair', $response->getContent());
        $this->assertStringContainsString('interactive_3d', $response->getContent());
    }

    public function test_mentor_can_download_exercise_template_xlsx(): void
    {
        $response = $this->actingAs($this->mentor)->get(route('mentor.exercises.template', ['format' => 'xlsx']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename="template_soal_eduskill.xlsx"');
        $this->assertNotEmpty($response->getContent());
    }

    public function test_mentor_can_import_exercises_from_xlsx(): void
    {
        $service = app(ExerciseImportService::class);
        $xlsxBinary = $service->generateTemplateXlsx();

        $file = UploadedFile::fake()->createWithContent('template.xlsx', $xlsxBinary);

        $response = $this->actingAs($this->mentor)->post(route('mentor.exercises.import', $this->lesson->id), [
            'file' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertGreaterThanOrEqual(6, $this->lesson->exercises()->count());
    }

    public function test_mentor_can_import_exercises_from_csv(): void
    {
        $csvContent = <<<'CSV'
question_type,prompt,code_snippet,options,answer,explanation
multiple_choice,"Apa tipe data angka bulat di Python?",,"int|float|str|bool","int","int adalah integer."
fill_blank,"Lengkapi kode agar mencetak 10:","____(10)","print|echo|write","print","Fungsi print mencetak nilai."
code_ordering,"Susun baris kode agar mencetak nama:",,"nama = 'Budi'|print(nama)","1|2","Deklarasi variabel sebelum diprint."
matching_pair,"Jodohkan tipe data dengan contohnya:",,"int => 10|str => 'Halo'","int => 10|str => 'Halo'","int integer, str string."
interactive_3d,"Tentukan posisi balok hijau pada matriks 3D:",,"matriks[1][0][1]|matriks[0][0][0]","matriks[1][0][1]","Akses array 3D X Y Z."
CSV;

        $file = UploadedFile::fake()->createWithContent('soal_latihan.csv', $csvContent);

        $response = $this->actingAs($this->mentor)->post(route('mentor.exercises.import', $this->lesson->id), [
            'file' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertEquals(5, $this->lesson->exercises()->count());

        $mc = Exercise::where('lesson_id', $this->lesson->id)->where('question_type', 'multiple_choice')->first();
        $this->assertNotNull($mc);
        $this->assertEquals('int', $mc->answer_json);

        $ordering = Exercise::where('lesson_id', $this->lesson->id)->where('question_type', 'code_ordering')->first();
        $this->assertNotNull($ordering);
        $this->assertEquals(['1', '2'], $ordering->answer_json);

        $matching = Exercise::where('lesson_id', $this->lesson->id)->where('question_type', 'matching_pair')->first();
        $this->assertNotNull($matching);
        $this->assertEquals(['int' => '10', 'str' => "'Halo'"], $matching->answer_json);

        $threeD = Exercise::where('lesson_id', $this->lesson->id)->where('question_type', 'interactive_3d')->first();
        $this->assertNotNull($threeD);
        $this->assertEquals('matriks[1][0][1]', $threeD->answer_json);
        $this->assertIsArray($threeD->model_3d_json);
    }

    public function test_other_mentor_cannot_import_to_unauthorized_course(): void
    {
        $otherMentor = User::factory()->create([
            'name' => 'Guru Lain',
            'email' => 'lain@eduskill.test',
            'role' => 'guru',
        ]);

        $csvContent = 'question_type,prompt,code_snippet,options,answer,explanation\nmultiple_choice,"Soal 1",,"A|B","A",""';
        $file = UploadedFile::fake()->createWithContent('soal.csv', $csvContent);

        $response = $this->actingAs($otherMentor)->post(route('mentor.exercises.import', $this->lesson->id), [
            'file' => $file,
        ]);

        $response->assertStatus(403);
    }
}
