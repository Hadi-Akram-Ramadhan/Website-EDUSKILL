<?php

namespace App\Http\Controllers\Api;

use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaderboardController extends BaseApiController
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Get Leaderboard rankings.
     */
    public function index(Request $request): JsonResponse
    {
        $type = $request->query('type', 'global');
        $limit = min(50, (int) $request->query('limit', 20));

        $leaderboard = $this->gamificationService->getLeaderboard($type, $limit);

        // Add rank number
        $rankedData = $leaderboard->values()->map(function ($student, $index) {
            return [
                'rank' => $index + 1,
                'id' => $student->id,
                'name' => $student->name,
                'avatar' => $student->avatar,
                'xp' => $student->xp,
                'level' => $student->level,
                'streak_count' => $student->streak_count,
            ];
        });

        return $this->sendResponse([
            'type' => $type,
            'leaderboard' => $rankedData,
        ], 'Leaderboard retrieved successfully');
    }
}
