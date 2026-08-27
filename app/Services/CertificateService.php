<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use App\Models\UserProgress;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Check if a student is eligible to receive a certificate for a course.
     */
    public function isEligibleForCertificate(User $user, Course $course): array
    {
        // Get all lessons in this course
        $courseLessonIds = $course->units()->with('lessons')->get()
            ->flatMap(fn($unit) => $unit->lessons->pluck('id'))
            ->toArray();

        $totalLessons = count($courseLessonIds);

        if ($totalLessons === 0) {
            return [
                'eligible' => false,
                'completed_lessons' => 0,
                'total_lessons' => 0,
                'message' => 'Course belum memiliki lesson.',
            ];
        }

        $completedProgress = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $courseLessonIds)
            ->where('is_completed', true)
            ->get();

        $completedCount = $completedProgress->count();
        $isEligible = $completedCount >= $totalLessons;

        $averageScore = $completedCount > 0 ? (float) round($completedProgress->avg('score'), 2) : 0.0;

        return [
            'eligible' => $isEligible,
            'completed_lessons' => $completedCount,
            'total_lessons' => $totalLessons,
            'average_score' => $averageScore,
            'message' => $isEligible 
                ? 'Selamat! Kamu telah menyelesaikan seluruh modul kursus ini.' 
                : "Selesaikan semua ($completedCount/$totalLessons) materi untuk mendapatkan sertifikat.",
        ];
    }

    /**
     * Issue/generate certificate for user.
     */
    public function generateCertificate(User $user, Course $course): Certificate
    {
        // Check if already exists
        $existing = Certificate::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ($existing) {
            return $existing;
        }

        $eligibility = $this->isEligibleForCertificate($user, $course);
        if (!$eligibility['eligible']) {
            throw new \Exception($eligibility['message']);
        }

        $now = Carbon::now();
        $dateSlug = $now->format('Ym');
        $randomCode = strtoupper(Str::random(6));
        $categoryPrefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $course->slug), 0, 6));
        $certCode = "CERT-{$categoryPrefix}-{$dateSlug}-{$randomCode}";

        $secretKey = config('app.key') ?: 'secret-signing-key';
        $certHash = hash_hmac('sha256', "{$user->id}|{$course->id}|{$certCode}|{$now->timestamp}", $secretKey);

        $verificationUrl = url("/verify/{$certCode}");
        $mentorName = $course->mentor ? $course->mentor->name : 'Instruktur Resmi';

        $certificate = Certificate::create([
            'cert_code' => $certCode,
            'cert_hash' => $certHash,
            'user_id' => $user->id,
            'course_id' => $course->id,
            'recipient_name' => $user->name,
            'course_title' => $course->title,
            'mentor_name' => $mentorName,
            'score_average' => $eligibility['average_score'],
            'issue_date' => $now->toDateString(),
            'qr_code_url' => "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($verificationUrl),
            'is_valid' => true,
        ]);

        return $certificate;
    }

    /**
     * Verify a certificate code.
     */
    public function verifyCertificate(string $certCode): ?Certificate
    {
        return Certificate::with(['user', 'course.mentor'])
            ->where('cert_code', trim($certCode))
            ->where('is_valid', true)
            ->first();
    }
}
