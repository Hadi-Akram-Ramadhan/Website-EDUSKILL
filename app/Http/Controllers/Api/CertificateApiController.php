<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use App\Models\Course;
use App\Services\CertificateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateApiController extends BaseApiController
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Get user's certificates.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $certificates = Certificate::with('course:id,title,category')
            ->where('user_id', $user->id)
            ->orderByDesc('issue_date')
            ->get();

        return $this->sendResponse($certificates, 'Certificates retrieved successfully');
    }

    /**
     * Check eligibility for a specific course.
     */
    public function checkEligibility($courseId, Request $request): JsonResponse
    {
        $user = $request->user();
        $course = Course::find($courseId);

        if (!$course) {
            return $this->sendError('Course not found', [], 404);
        }

        $existing = Certificate::where('user_id', $user->id)->where('course_id', $course->id)->first();
        $status = $this->certificateService->isEligibleForCertificate($user, $course);

        return $this->sendResponse([
            'already_claimed' => (bool) $existing,
            'certificate' => $existing,
            'eligibility' => $status,
        ], 'Eligibility checked');
    }

    /**
     * Claim official certificate upon completing course.
     */
    public function claim($courseId, Request $request): JsonResponse
    {
        $user = $request->user();
        $course = Course::find($courseId);

        if (!$course) {
            return $this->sendError('Course not found', [], 404);
        }

        try {
            $certificate = $this->certificateService->generateCertificate($user, $course);

            return $this->sendResponse($certificate, 'Selamat! Sertifikat resmi kamu berhasil diterbitkan 🎓', 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 400);
        }
    }

    /**
     * Get certificate detail by code.
     */
    public function show($certCode): JsonResponse
    {
        $certificate = $this->certificateService->verifyCertificate($certCode);

        if (!$certificate) {
            return $this->sendError('Sertifikat tidak ditemukan atau tidak valid.', [], 404);
        }

        return $this->sendResponse($certificate, 'Sertifikat valid dan terverifikasi');
    }
}
