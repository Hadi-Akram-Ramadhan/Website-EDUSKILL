<?php

namespace App\Http\Controllers\Api;

use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends BaseApiController
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Update user profile info.
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'avatar' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('avatar')) {
            $user->avatar = $request->avatar;
        }

        $user->save();

        return $this->sendResponse($user, 'Profile updated successfully');
    }

    /**
     * Refill hearts using gems.
     */
    public function refillHearts(Request $request): JsonResponse
    {
        $user = $request->user();

        $success = $this->gamificationService->refillHeartsWithGems($user);

        if (! $success) {
            return $this->sendError('Tidak dapat mengisi hati. Pastikan gems kamu cukup (min. 20 gems) atau hati kamu belum penuh.', [], 400);
        }

        return $this->sendResponse([
            'hearts' => $user->hearts,
            'gems' => $user->gems,
        ], 'Hati berhasil diisi penuh (5/5)! ❤️');
    }

    /**
     * Get user unlocked badges.
     */
    public function getBadges(Request $request): JsonResponse
    {
        $user = $request->user();
        $badges = $user->badges()->orderByDesc('unlocked_at')->get();

        return $this->sendResponse($badges, 'Badges retrieved successfully');
    }
}
