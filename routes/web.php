<?php

use App\Http\Controllers\Docs\OpenApiController;
use App\Http\Controllers\Web\CertificateVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// OpenAPI 3.0 Documentation & Spec
Route::get('/docs/api', [OpenApiController::class, 'view'])->name('docs.api');
Route::get('/docs/openapi.yaml', [OpenApiController::class, 'yaml'])->name('docs.yaml');

// Public Certificate Verification (QR Code Scan Target)
Route::get('/verify/{cert_code}', [CertificateVerificationController::class, 'verify'])->name('certificate.verify');
