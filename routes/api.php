<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificateApiController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Public Leaderboard & Verification
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/certificates/verify/{cert_code}', [CertificateApiController::class, 'show']);

    // Protected Routes (Flutter Mobile & Web Auth)
    Route::middleware('auth:sanctum')->group(function () {
        // User & Profile
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::put('/profile', [ProfileController::class, 'updateProfile']);
        Route::post('/profile/refill-hearts', [ProfileController::class, 'refillHearts']);
        Route::get('/profile/badges', [ProfileController::class, 'getBadges']);

        // Courses & Roadmap
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);

        // Lessons & Interactive Coding Exercises
        Route::get('/lessons/{id}', [LessonController::class, 'show']);
        Route::post('/lessons/{id}/submit', [LessonController::class, 'submit']);

        // Certificates
        Route::get('/certificates', [CertificateApiController::class, 'index']);
        Route::get('/certificates/eligibility/{course_id}', [CertificateApiController::class, 'checkEligibility']);
        Route::post('/certificates/claim/{course_id}', [CertificateApiController::class, 'claim']);
    });
});
