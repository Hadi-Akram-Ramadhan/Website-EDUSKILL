<?php

namespace App\Http\Controllers\Api;

use App\Models\Lesson;
use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends BaseApiController
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Get lesson content & interactive exercises for Flutter / Web.
     */
    public function show($id, Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $this->gamificationService->syncHearts($user);
        }

        $lesson = Lesson::with(['unit.course', 'exercises'])->find($id);

        if (! $lesson) {
            return $this->sendError('Lesson not found', [], 404);
        }

        // Clean exercises so raw answers aren't exposed directly
        $exercisesData = $lesson->exercises->map(function ($ex) {
            return [
                'id' => $ex->id,
                'question_type' => $ex->question_type,
                'prompt' => $ex->prompt,
                'code_snippet' => $ex->code_snippet,
                'options' => $ex->options_json,
                'order_index' => $ex->order_index,
            ];
        });

        return $this->sendResponse([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'slug' => $lesson->slug,
            'type' => $lesson->type,
            'description' => $lesson->description,
            'theory_content' => $lesson->theory_content,
            'xp_reward' => $lesson->xp_reward,
            'unit' => [
                'id' => $lesson->unit->id,
                'title' => $lesson->unit->title,
                'course_id' => $lesson->unit->course_id,
                'course_title' => $lesson->unit->course->title,
            ],
            'exercises' => $exercisesData,
            'user_hearts' => $user ? $user->hearts : 5,
        ], 'Lesson loaded successfully');
    }

    /**
     * Submit completed exercises for evaluation.
     */
    public function submit($id, Request $request): JsonResponse
    {
        $user = $request->user();

        // Check if user has hearts
        $this->gamificationService->syncHearts($user);
        if ($user->hearts <= 0) {
            return $this->sendError('Kamu kehabisan hati (0/5) ❤️. Tunggu hati terisi kembali atau isi dengan gems!', [
                'hearts' => 0,
                'need_refill' => true,
            ], 403);
        }

        $lesson = Lesson::with('exercises')->find($id);

        if (! $lesson) {
            return $this->sendError('Lesson not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array',
            'answers.*.exercise_id' => 'required|integer',
            'answers.*.answer' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Format jawaban tidak valid', $validator->errors()->toArray(), 422);
        }

        $result = $this->gamificationService->submitLesson($user, $lesson, $request->input('answers'));

        return $this->sendResponse($result, $result['passed'] ? 'Selamat! Kamu menyelesaikan modul ini!' : 'Coba lagi! Pelajari kembali materi dan perbaiki jawabanmu.');
    }
}
