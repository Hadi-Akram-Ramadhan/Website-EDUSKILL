<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserProgress;
use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LearnController extends Controller
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Learning Path Roadmap View (Duolingo snake path).
     */
    public function index(): View
    {
        $user = Auth::user();
        $this->gamificationService->syncHearts($user);

        // Fetch active published course with units and lessons
        $course = Course::with(['units.lessons.exercises'])->where('is_published', true)->first();

        $userProgress = UserProgress::where('user_id', $user->id)->get()->keyBy('lesson_id');

        $previousLessonCompleted = true; // First lesson is unlocked
        $activeLesson = null;

        $units = $course ? $course->units->map(function ($unit) use ($userProgress, &$previousLessonCompleted, &$activeLesson) {
            $lessons = $unit->lessons->map(function ($lesson) use ($userProgress, &$previousLessonCompleted, &$activeLesson) {
                $prog = $userProgress->get($lesson->id);
                $isCompleted = $prog ? (bool) $prog->is_completed : false;
                $score = $prog ? (int) $prog->score : 0;
                $isUnlocked = $isCompleted || $previousLessonCompleted;

                // Identify current target lesson
                $isCurrent = false;
                if ($isUnlocked && ! $isCompleted && ! $activeLesson) {
                    $isCurrent = true;
                    $activeLesson = $lesson;
                }

                $previousLessonCompleted = $isCompleted;

                return [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'slug' => $lesson->slug,
                    'description' => $lesson->description,
                    'type' => $lesson->type,
                    'xp_reward' => $lesson->xp_reward,
                    'order_index' => $lesson->order_index,
                    'is_completed' => $isCompleted,
                    'is_unlocked' => $isUnlocked,
                    'is_current' => $isCurrent,
                    'score' => $score,
                ];
            });

            return [
                'id' => $unit->id,
                'title' => $unit->title,
                'description' => $unit->description,
                'order_index' => $unit->order_index,
                'lessons' => $lessons,
            ];
        }) : collect([]);

        // Top 3 leaderboard snippet
        $topStudents = User::where('role', 'siswa')->orderByDesc('xp')->limit(3)->get();

        return view('learn.index', compact('user', 'course', 'units', 'activeLesson', 'topStudents'));
    }

    /**
     * Show interactive full-screen lesson session.
     */
    public function showLesson(int $id): View|RedirectResponse
    {
        $user = Auth::user();
        $this->gamificationService->syncHearts($user);

        if ($user->hearts <= 0) {
            return redirect()->route('learn.index')->with('error', 'Nyawa kamu habis (0/5). Isi ulang dengan gems atau tunggu sebentar!');
        }

        $lesson = Lesson::with(['unit.course', 'exercises'])->findOrFail($id);

        // Sanitize exercise options for the frontend engine
        $exercises = $lesson->exercises->map(function ($ex) {
            return [
                'id' => $ex->id,
                'question_type' => $ex->question_type,
                'prompt' => $ex->prompt,
                'code_snippet' => $ex->code_snippet,
                'options_json' => $ex->options_json,
                'options' => $ex->options_json,
                'answer_json' => $ex->answer_json,
                'explanation' => $ex->explanation,
                'order_index' => $ex->order_index,
            ];
        });

        return view('learn.lesson', compact('lesson', 'exercises', 'user'));
    }

    /**
     * Submit Lesson Result via Web (AJAX/Fetch).
     */
    public function submitLesson(int $id, Request $request): JsonResponse
    {
        $user = Auth::user();
        $this->gamificationService->syncHearts($user);

        if ($user->hearts <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Nyawa kamu habis (0/5)',
            ], 403);
        }

        $lesson = Lesson::with('exercises')->findOrFail($id);
        $answers = $request->input('answers', []);

        $result = $this->gamificationService->submitLesson($user, $lesson, $answers);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Refill hearts using gems in Web session.
     */
    public function refillHearts(): RedirectResponse
    {
        $user = Auth::user();
        $success = $this->gamificationService->refillHeartsWithGems($user);

        if (! $success) {
            return back()->with('error', 'Gems tidak cukup atau nyawa sudah penuh.');
        }

        return back()->with('success', 'Nyawa berhasil diisi penuh (5/5)!');
    }
}
