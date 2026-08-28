<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\UserProgress;
use App\Services\CertificateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CertificateWebController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Certificates List & Status Page.
     */
    public function index(): View
    {
        $user = Auth::user();

        $courses = Course::with(['units.lessons'])->where('is_published', true)->get();
        $userCompletedLessonIds = UserProgress::where('user_id', $user->id)->where('is_completed', true)->pluck('lesson_id')->toArray();
        $claimedCerts = Certificate::where('user_id', $user->id)->get()->keyBy('course_id');

        $coursesData = $courses->map(function ($course) use ($userCompletedLessonIds, $claimedCerts) {
            $totalLessons = $course->units->flatMap->lessons->count();
            $courseLessonIds = $course->units->flatMap->lessons->pluck('id')->toArray();
            $completedCount = count(array_intersect($courseLessonIds, $userCompletedLessonIds));

            $isCompleted = $totalLessons > 0 && $completedCount >= $totalLessons;
            $percentage = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;
            $certificate = $claimedCerts->get($course->id);

            return [
                'course' => $course,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedCount,
                'progress_percentage' => $percentage,
                'is_completed' => $isCompleted,
                'certificate' => $certificate,
            ];
        });

        return view('certificates.index', compact('coursesData', 'user'));
    }

    /**
     * Claim Certificate via Web.
     */
    public function claim(int $courseId): RedirectResponse
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        try {
            $cert = $this->certificateService->generateCertificate($user, $course);

            return redirect()->route('certificate.verify', $cert->cert_code)->with('success', 'Selamat! Sertifikat resmi kamu berhasil diterbitkan 🎓');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
