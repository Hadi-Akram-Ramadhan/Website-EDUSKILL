<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use App\Services\ExerciseImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MentorLessonController extends Controller
{
    protected ExerciseImportService $importService;

    public function __construct(ExerciseImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Curriculum Builder Arena for a course.
     */
    public function manage(Course $course): View
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $course->load(['units.lessons.exercises']);

        return view('mentor.courses.manage', compact('course', 'user'));
    }

    /**
     * Store new Unit.
     */
    public function storeUnit(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $maxOrder = $course->units()->max('order_index') ?? 0;

        Unit::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'order_index' => $maxOrder + 1,
        ]);

        return back()->with('success', "Unit '{$validated['title']}' berhasil ditambahkan.");
    }

    /**
     * Delete Unit.
     */
    public function destroyUnit(Unit $unit): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $title = $unit->title;
        $unit->delete();

        return back()->with('success', "Unit '{$title}' berhasil dihapus.");
    }

    /**
     * Store new Lesson in Unit.
     */
    public function storeLesson(Request $request, Unit $unit): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'theory_content' => 'nullable|string',
            'xp_reward' => 'nullable|integer|min:5|max:100',
        ]);

        $maxOrder = $unit->lessons()->max('order_index') ?? 0;
        $slug = Str::slug($validated['title']).'-'.Str::random(4);

        Lesson::create([
            'unit_id' => $unit->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? '',
            'type' => 'quiz',
            'theory_content' => $validated['theory_content'] ?? '',
            'xp_reward' => $validated['xp_reward'] ?? 20,
            'order_index' => $maxOrder + 1,
        ]);

        return back()->with('success', "Modul pelajaran '{$validated['title']}' berhasil ditambahkan.");
    }

    /**
     * Delete Lesson.
     */
    public function destroyLesson(Lesson $lesson): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $lesson->unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $title = $lesson->title;
        $lesson->delete();

        return back()->with('success', "Modul '{$title}' berhasil dihapus.");
    }

    /**
     * Store interactive Exercise inside Lesson.
     */
    public function storeExercise(Request $request, Lesson $lesson): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $lesson->unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'question_type' => 'required|in:multiple_choice,fill_blank,output_prediction,code_ordering,matching_pair',
            'prompt' => 'required|string',
            'code_snippet' => 'nullable|string',
            'explanation' => 'nullable|string',
            'options_raw' => 'nullable|string',
            'answer_raw' => 'nullable|string',
            'options' => 'nullable|array',
            'ordering_lines' => 'nullable|array',
            'pair_keys' => 'nullable|array',
            'pair_values' => 'nullable|array',
            'correct_choice' => 'nullable|string',
        ]);

        $maxOrder = $lesson->exercises()->max('order_index') ?? 0;
        $type = $validated['question_type'];

        // Determine options and answer based on form structure
        $optionsJson = null;
        $answerJson = null;

        if ($type === 'multiple_choice' || $type === 'fill_blank' || $type === 'output_prediction') {
            if (! empty($validated['options'])) {
                $optionsJson = array_values(array_filter(array_map('trim', $validated['options']), fn ($v) => $v !== ''));
            } else {
                $optionsJson = array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? '')), fn ($v) => $v !== ''));
            }

            if (empty($optionsJson)) {
                $optionsJson = ['Pilihan A', 'Pilihan B', 'Pilihan C', 'Pilihan D'];
            }

            $answerJson = trim($validated['correct_choice'] ?? ($validated['answer_raw'] ?? ''));
            if (empty($answerJson)) {
                $answerJson = $optionsJson[0] ?? '';
            }
        } elseif ($type === 'code_ordering') {
            $lines = ! empty($validated['ordering_lines'])
                ? array_values(array_filter(array_map('trim', $validated['ordering_lines']), fn ($v) => $v !== ''))
                : array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? '')), fn ($v) => $v !== ''));

            $optionsJson = [];
            $answerJson = [];
            foreach ($lines as $i => $line) {
                $id = (string) ($i + 1);
                $optionsJson[] = ['id' => $id, 'text' => $line];
                $answerJson[] = $id;
            }
        } elseif ($type === 'matching_pair') {
            $pairs = [];
            if (! empty($validated['pair_keys']) && ! empty($validated['pair_values'])) {
                foreach ($validated['pair_keys'] as $idx => $k) {
                    $v = $validated['pair_values'][$idx] ?? '';
                    if (trim($k) !== '' && trim($v) !== '') {
                        $pairs[trim($k)] = trim($v);
                    }
                }
            } else {
                $lines = array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? '')), fn ($v) => $v !== ''));
                foreach ($lines as $line) {
                    if (str_contains($line, '=>')) {
                        [$k, $v] = explode('=>', $line, 2);
                        $pairs[trim($k)] = trim($v);
                    }
                }
            }

            if (empty($pairs)) {
                $pairs = ['A' => '1', 'B' => '2'];
            }

            $optionsJson = ['pairs' => $pairs];
            $answerJson = $pairs;
        }

        Exercise::create([
            'lesson_id' => $lesson->id,
            'question_type' => $type,
            'prompt' => $validated['prompt'],
            'code_snippet' => $validated['code_snippet'] ?? null,
            'options_json' => $optionsJson,
            'answer_json' => $answerJson,
            'explanation' => $validated['explanation'] ?? '',
            'order_index' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Soal latihan interaktif berhasil ditambahkan.');
    }

    /**
     * Download sample Excel/CSV template for bulk question import.
     */
    public function downloadTemplate(): Response
    {
        $csvContent = $this->importService->generateTemplateCsv();

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_soal_eduskill.csv"',
        ]);
    }

    /**
     * Import exercises from uploaded CSV file.
     */
    public function importExercises(Request $request, Lesson $lesson): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $lesson->unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $result = $this->importService->importFromCsv($request->file('file'), $lesson);

        if ($result['success'] > 0) {
            $msg = "Berhasil mengimpor {$result['success']} soal latihan ke modul '{$lesson->title}'.";
            if (! empty($result['errors'])) {
                $msg .= ' Catatan: beberapa baris dilewati ('.implode(', ', array_slice($result['errors'], 0, 3)).')';
            }

            return back()->with('success', $msg);
        }

        $errMsg = ! empty($result['errors']) ? implode(' ', $result['errors']) : 'Gagal mengimpor file.';

        return back()->withErrors(['file' => $errMsg]);
    }

    /**
     * Delete Exercise.
     */
    public function destroyExercise(Exercise $exercise): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $exercise->lesson->unit->course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $exercise->delete();

        return back()->with('success', 'Soal latihan berhasil dihapus.');
    }
}
