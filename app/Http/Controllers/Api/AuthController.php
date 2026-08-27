<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseApiController
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Register a new user (default role: siswa).
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'sometimes|string|in:siswa,guru',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'siswa',
            'xp'       => 0,
            'level'    => 1,
            'hearts'   => 5,
            'gems'     => 50,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'user'  => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully', 201);
    }

    /**
     * Login user and issue Sanctum token.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid email or password', [], 401);
        }

        // Sync hearts regeneration
        $this->gamificationService->syncHearts($user);

        // Revoke older tokens if desired or issue new token
        $token = $user->createToken('flutter_mobile_token')->plainTextToken;

        return $this->sendResponse([
            'user'  => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Get authenticated user profile with badges and progress.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->gamificationService->syncHearts($user);

        $badges = $user->badges()->get();
        $completedLessonsCount = $user->progress()->where('is_completed', true)->count();
        $certificatesCount = $user->certificates()->count();

        return $this->sendResponse([
            'user' => $user,
            'stats' => [
                'completed_lessons' => $completedLessonsCount,
                'certificates_count' => $certificatesCount,
                'badges_count' => $badges->count(),
            ],
            'badges' => $badges,
        ], 'User profile retrieved');
    }

    /**
     * Logout user (Revoke token).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'Logged out successfully');
    }
}
