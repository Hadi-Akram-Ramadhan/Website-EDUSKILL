<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Super Admin Overview Dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'siswa')->count(),
            'total_mentors' => User::where('role', 'guru')->count(),
            'total_courses' => Course::count(),
            'total_units' => Unit::count(),
            'total_lessons' => Lesson::count(),
            'total_certificates' => Certificate::count(),
            'total_xp' => User::sum('xp'),
        ];

        $recentUsers = User::orderByDesc('id')->limit(8)->get();
        $courses = Course::with(['mentor', 'units.lessons'])->orderByDesc('id')->get();
        $recentCertificates = Certificate::with(['user', 'course'])->orderByDesc('id')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'courses', 'recentCertificates'));
    }
}
