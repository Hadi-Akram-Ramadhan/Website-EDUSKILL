<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MentorCourseController extends Controller
{
    /**
     * Display a listing of mentor's courses.
     */
    public function index(): View
    {
        $user = Auth::user();

        $courses = Course::with(['units.lessons.exercises'])
            ->where(function ($q) use ($user) {
                if ($user->role !== 'super_admin') {
                    $q->where('mentor_id', $user->id);
                }
            })
            ->orderByDesc('id')
            ->get();

        return view('mentor.courses.index', compact('courses', 'user'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): View
    {
        return view('mentor.courses.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'description' => 'nullable|string',
            'target_audience' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|url|max:500',
            'is_published' => 'nullable|boolean',
            'is_upcoming' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']).'-'.Str::random(5);

        $course = Course::create([
            'mentor_id' => $user->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'level' => $validated['level'],
            'description' => $validated['description'] ?? '',
            'target_audience' => $validated['target_audience'] ?? 'Siswa SMP & SMA',
            'thumbnail' => $validated['thumbnail'] ?? 'https://images.unsplash.com/photo-1516116211227-bbc13c72b226?w=600&auto=format&fit=crop&q=80',
            'total_xp' => 100,
            'is_published' => $request->has('is_published'),
            'is_upcoming' => $request->has('is_upcoming'),
        ]);

        return redirect()->route('mentor.courses.manage', $course->id)->with('success', "Kursus '{$course->title}' berhasil dibuat. Silakan tambahkan unit dan modul pelajaran!");
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): View
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('mentor.courses.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'description' => 'nullable|string',
            'target_audience' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|url|max:500',
            'is_published' => 'nullable|boolean',
            'is_upcoming' => 'nullable|boolean',
        ]);

        $course->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'level' => $validated['level'],
            'description' => $validated['description'] ?? '',
            'target_audience' => $validated['target_audience'] ?? $course->target_audience,
            'thumbnail' => $validated['thumbnail'] ?? $course->thumbnail,
            'is_published' => $request->has('is_published'),
            'is_upcoming' => $request->has('is_upcoming'),
        ]);

        return redirect()->route('mentor.courses.index')->with('success', "Kursus '{$course->title}' berhasil diperbarui.");
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $title = $course->title;
        $course->delete();

        return redirect()->route('mentor.courses.index')->with('success', "Kursus '{$title}' berhasil dihapus.");
    }

    /**
     * Release or toggle course roadmap status (Upcoming -> Active Siap Belajar).
     */
    public function toggleRelease(Course $course): RedirectResponse
    {
        $user = Auth::user();
        if ($user->role !== 'super_admin' && $course->mentor_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($course->is_upcoming || ! $course->is_published) {
            $course->update([
                'is_published' => true,
                'is_upcoming' => false,
            ]);

            return back()->with('success', "🚀 Roadmap '{$course->title}' BERHASIL DIRILIS! Status kursus kini Aktif (Siap Belajar) dan dapat langsung diakses oleh seluruh siswa.");
        } else {
            $course->update([
                'is_upcoming' => true,
            ]);

            return back()->with('success', "Kursus '{$course->title}' dialihkan kembali ke status 'Roadmap Mendatang'.");
        }
    }
}
