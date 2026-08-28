<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MentorDashboardController extends Controller
{
    /**
     * Mentor / Guru Dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Get courses taught by this mentor
        $courses = Course::with(['units.lessons.exercises'])
            ->where('mentor_id', $user->id)
            ->get();

        $courseIds = $courses->pluck('id')->toArray();
        $lessonIds = $courses->flatMap->units->flatMap->lessons->pluck('id')->toArray();

        $totalLessons = count($lessonIds);
        $totalExercises = $courses->flatMap->units->flatMap->lessons->flatMap->exercises->count();

        // Student completions on this mentor's lessons
        $recentProgress = UserProgress::with(['user', 'lesson.unit.course'])
            ->whereIn('lesson_id', $lessonIds)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        $activeStudentsCount = UserProgress::whereIn('lesson_id', $lessonIds)
            ->distinct('user_id')
            ->count('user_id');

        $stats = [
            'total_courses' => $courses->count(),
            'total_lessons' => $totalLessons,
            'total_exercises' => $totalExercises,
            'active_students' => $activeStudentsCount,
        ];

        return view('mentor.dashboard', compact('user', 'courses', 'recentProgress', 'stats'));
    }
}
