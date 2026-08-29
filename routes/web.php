<?php

use App\Http\Controllers\Docs\OpenApiController;
use App\Http\Controllers\Web\AdminCertificateController;
use App\Http\Controllers\Web\AdminCourseController;
use App\Http\Controllers\Web\AdminDashboardController;
use App\Http\Controllers\Web\AdminUserController;
use App\Http\Controllers\Web\CertificateVerificationController;
use App\Http\Controllers\Web\CertificateWebController;
use App\Http\Controllers\Web\LeaderboardWebController;
use App\Http\Controllers\Web\LearnController;
use App\Http\Controllers\Web\MentorCourseController;
use App\Http\Controllers\Web\MentorDashboardController;
use App\Http\Controllers\Web\MentorLessonController;
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
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Super Admin Area
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management CRUD
    Route::resource('users', AdminUserController::class);

    // Global Course Management
    Route::resource('courses', AdminCourseController::class);
    Route::post('courses/{course}/toggle-publish', [AdminCourseController::class, 'togglePublish'])->name('courses.toggle-publish');

    // Certificates Oversight
    Route::get('certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
    Route::delete('certificates/{certificate}', [AdminCertificateController::class, 'destroy'])->name('certificates.destroy');
});

// Mentor / Guru Area
Route::middleware(['auth', 'role:guru,super_admin'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');

    // Mentor Course Management CRUD
    Route::resource('courses', MentorCourseController::class);

    // Curriculum Builder (Units, Lessons, Exercises)
    Route::get('courses/{course}/manage', [MentorLessonController::class, 'manage'])->name('courses.manage');
    Route::post('courses/{course}/units', [MentorLessonController::class, 'storeUnit'])->name('units.store');
    Route::delete('units/{unit}', [MentorLessonController::class, 'destroyUnit'])->name('units.destroy');

    Route::post('units/{unit}/lessons', [MentorLessonController::class, 'storeLesson'])->name('lessons.store');
    Route::delete('lessons/{lesson}', [MentorLessonController::class, 'destroyLesson'])->name('lessons.destroy');

    Route::post('lessons/{lesson}/exercises', [MentorLessonController::class, 'storeExercise'])->name('exercises.store');
    Route::delete('exercises/{exercise}', [MentorLessonController::class, 'destroyExercise'])->name('exercises.destroy');
});

// Protected Student / Shared Web Portal
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
