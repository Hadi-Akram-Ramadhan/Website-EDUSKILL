<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MentorLessonController extends Controller
{
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
            'answer_raw' => 'required|string',
        ]);

        $maxOrder = $lesson->exercises()->max('order_index') ?? 0;

        // Parse options based on question type
        $optionsJson = null;
        $answerJson = null;

        if ($validated['question_type'] === 'multiple_choice' || $validated['question_type'] === 'fill_blank' || $validated['question_type'] === 'output_prediction') {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? ''))));
            $optionsJson = ! empty($lines) ? $lines : ['Option A', 'Option B', 'Option C', 'Option D'];
            $answerJson = trim($validated['answer_raw']);
        } elseif ($validated['question_type'] === 'code_ordering') {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? ''))));
            $optionsJson = [];
            $answerJson = [];
            foreach ($lines as $i => $line) {
                $id = (string) ($i + 1);
                $optionsJson[] = ['id' => $id, 'text' => $line];
                $answerJson[] = $id;
            }
        } elseif ($validated['question_type'] === 'matching_pair') {
            // Format: Left => Right per line
            $lines = array_values(array_filter(array_map('trim', explode("\n", $validated['options_raw'] ?? ''))));
            $pairs = [];
            foreach ($lines as $line) {
                if (str_contains($line, '=>')) {
                    [$k, $v] = explode('=>', $line, 2);
                    $pairs[trim($k)] = trim($v);
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
            'question_type' => $validated['question_type'],
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
