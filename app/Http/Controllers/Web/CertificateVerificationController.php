<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CertificateService;
use Illuminate\View\View;

class CertificateVerificationController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Public verification page for certificates (accessed via QR Code or URL).
     */
    public function verify(string $certCode): View
    {
        $certificate = $this->certificateService->verifyCertificate($certCode);

        return view('certificate.verify', [
            'certificate' => $certificate,
            'certCode' => $certCode,
            'isValid' => (bool) $certificate,
        ]);
    }
}
