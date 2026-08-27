<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends BaseApiController
{
    /**
     * List all published courses with user progress.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $courses = Course::with(['mentor:id,name,avatar'])
            ->where('is_published', true)
            ->get();

        $userCompletedLessonIds = $user
            ? UserProgress::where('user_id', $user->id)->where('is_completed', true)->pluck('lesson_id')->toArray()
            : [];

        $data = $courses->map(function ($course) use ($userCompletedLessonIds) {
            $totalLessons = $course->units->flatMap->lessons->count();
            $courseLessonIds = $course->units->flatMap->lessons->pluck('id')->toArray();
            $completedCount = count(array_intersect($courseLessonIds, $userCompletedLessonIds));

            $percentage = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;

            return [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'description' => $course->description,
                'category' => $course->category,
                'target_audience' => $course->target_audience,
                'thumbnail' => $course->thumbnail,
                'level' => $course->level,
                'total_xp' => $course->total_xp,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedCount,
                'progress_percentage' => $percentage,
                'mentor' => $course->mentor,
            ];
        });

        return $this->sendResponse($data, 'Courses retrieved successfully');
    }

    /**
     * Get detailed learning path / roadmap of a course.
     */
    public function show($id, Request $request): JsonResponse
    {
        $user = $request->user();

        $course = Course::with([
            'mentor:id,name,avatar',
            'units.lessons',
        ])->find($id);

        if (! $course) {
            return $this->sendError('Course not found', [], 404);
        }

        $userProgress = $user
            ? UserProgress::where('user_id', $user->id)->get()->keyBy('lesson_id')
            : collect([]);

        $previousLessonCompleted = true; // First lesson is unlocked by default

        $unitsData = $course->units->map(function ($unit) use ($userProgress, &$previousLessonCompleted) {
            $lessonsData = $unit->lessons->map(function ($lesson) use ($userProgress, &$previousLessonCompleted) {
                $prog = $userProgress->get($lesson->id);
                $isCompleted = $prog ? (bool) $prog->is_completed : false;
                $score = $prog ? (int) $prog->score : 0;

                // A lesson is unlocked if it's already completed or if the preceding lesson was completed
                $isUnlocked = $isCompleted || $previousLessonCompleted;

                // Update $previousLessonCompleted for next lesson in sequence
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
                    'score' => $score,
                    'completed_at' => $prog?->completed_at,
                ];
            });

            return [
                'id' => $unit->id,
                'title' => $unit->title,
                'description' => $unit->description,
                'order_index' => $unit->order_index,
                'lessons' => $lessonsData,
            ];
        });

        return $this->sendResponse([
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'description' => $course->description,
            'category' => $course->category,
            'level' => $course->level,
            'mentor' => $course->mentor,
            'units' => $unitsData,
        ], 'Course roadmap retrieved');
    }
}
