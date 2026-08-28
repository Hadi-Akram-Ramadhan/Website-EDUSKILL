<?php

use App\Http\Controllers\Docs\OpenApiController;
use App\Http\Controllers\Web\CertificateVerificationController;
use App\Http\Controllers\Web\CertificateWebController;
use App\Http\Controllers\Web\LeaderboardWebController;
use App\Http\Controllers\Web\LearnController;
use App\Http\Controllers\Web\ProfileWebController;
use App\Http\Controllers\Web\WebAuthController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Web Authentication & 1-Click Demo Switcher
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login'])->name('auth.login.submit');
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register'])->name('auth.register.submit');
});

// Quick 1-Click login for instant demo testing
Route::get('/auth/quick-login/{id}', [WebAuthController::class, 'quickLogin'])->name('auth.quick-login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('auth.logout');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Protected Student Web Portal
Route::middleware('auth')->group(function () {
    // Learning Path / Roadmap & Quiz Player
    Route::get('/learn', [LearnController::class, 'index'])->name('learn.index');
    Route::get('/learn/lesson/{id}', [LearnController::class, 'showLesson'])->name('learn.lesson');
    Route::post('/learn/lesson/{id}/submit', [LearnController::class, 'submitLesson'])->name('learn.submit');
    Route::post('/learn/refill-hearts', [LearnController::class, 'refillHearts'])->name('learn.refill-hearts');

    // Leaderboard
    Route::get('/leaderboard', [LeaderboardWebController::class, 'index'])->name('leaderboard.web');

    // Profile & Badges
    Route::get('/profile', [ProfileWebController::class, 'index'])->name('profile.web');
    Route::post('/profile', [ProfileWebController::class, 'update'])->name('profile.update');

    // Certificates
    Route::get('/certificates', [CertificateWebController::class, 'index'])->name('certificates.web');
    Route::post('/certificates/claim/{course_id}', [CertificateWebController::class, 'claim'])->name('certificates.claim');
});

// OpenAPI 3.0 Documentation & Spec
Route::get('/docs/api', [OpenApiController::class, 'view'])->name('docs.api');
Route::get('/docs/openapi.yaml', [OpenApiController::class, 'yaml'])->name('docs.yaml');

// Public Certificate Verification (QR Code Scan Destination)
Route::get('/verify/{cert_code}', [CertificateVerificationController::class, 'verify'])->name('certificate.verify');
