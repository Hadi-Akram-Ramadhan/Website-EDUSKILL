<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCertificateController extends Controller
{
    /**
     * Display all issued certificates.
     */
    public function index(Request $request): View
    {
        $query = Certificate::with(['user', 'course']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('recipient_name', 'like', "%{$search}%")
                    ->orWhere('cert_code', 'like', "%{$search}%")
                    ->orWhere('course_title', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderByDesc('id')->paginate(12)->withQueryString();

        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Delete / Revoke certificate.
     */
    public function destroy(Certificate $certificate): RedirectResponse
    {
        $code = $certificate->cert_code;
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', "Sertifikat '{$code}' berhasil dicabut/dihapus.");
    }
}
