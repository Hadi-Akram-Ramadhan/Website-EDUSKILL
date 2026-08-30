<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of all platform courses.
     */
    public function index(Request $request): View
    {
        $query = Course::with(['mentor', 'units.lessons']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $courses = $query->orderByDesc('id')->paginate(10)->withQueryString();
        $categories = Course::distinct('category')->pluck('category')->filter();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): View
    {
        $mentors = User::whereIn('role', ['guru', 'super_admin'])->get();

        return view('admin.courses.create', compact('mentors'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
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
            'mentor_id' => $validated['mentor_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'level' => $validated['level'],
            'description' => $validated['description'] ?? '',
            'target_audience' => $validated['target_audience'] ?? 'Siswa SMP & SMA',
            'thumbnail' => $validated['thumbnail'] ?? 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&auto=format&fit=crop&q=80',
            'total_xp' => 100,
            'is_published' => $request->has('is_published'),
            'is_upcoming' => $request->has('is_upcoming'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', "Kursus '{$course->title}' berhasil dibuat.");
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): View
    {
        $mentors = User::whereIn('role', ['guru', 'super_admin'])->get();

        return view('admin.courses.edit', compact('course', 'mentors'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'mentor_id' => 'required|exists:users,id',
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
            'mentor_id' => $validated['mentor_id'],
            'title' => $validated['title'],
            'category' => $validated['category'],
            'level' => $validated['level'],
            'description' => $validated['description'] ?? '',
            'target_audience' => $validated['target_audience'] ?? $course->target_audience,
            'thumbnail' => $validated['thumbnail'] ?? $course->thumbnail,
            'is_published' => $request->has('is_published'),
            'is_upcoming' => $request->has('is_upcoming'),
        ]);

        return redirect()->route('admin.courses.index')->with('success', "Kursus '{$course->title}' berhasil diperbarui.");
    }

    /**
     * Toggle course publish status.
     */
    public function togglePublish(Course $course): RedirectResponse
    {
        $course->update(['is_published' => ! $course->is_published]);
        $status = $course->is_published ? 'dipublikasikan' : 'diarsipkan (draft)';

        return back()->with('success', "Status kursus '{$course->title}' diubah menjadi {$status}.");
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $title = $course->title;
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', "Kursus '{$title}' berhasil dihapus.");
    }
}
