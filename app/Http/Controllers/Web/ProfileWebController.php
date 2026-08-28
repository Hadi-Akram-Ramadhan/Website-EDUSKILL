<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\GamificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileWebController extends Controller
{
    protected GamificationService $gamificationService;

    public function __construct(GamificationService $gamificationService)
    {
        $this->gamificationService = $gamificationService;
    }

    /**
     * Profile & Badges Page.
     */
    public function index(): View
    {
        $user = Auth::user();
        $this->gamificationService->syncHearts($user);

        $unlockedBadges = $user->badges()->get()->keyBy('badge_code');

        // All system achievements catalog
        $allBadges = [
            [
                'code' => 'first_lesson',
                'name' => 'Langkah Pertama',
                'description' => 'Selesaikan modul pemrograman pertama kamu 🎉',
                'icon' => '🚀',
            ],
            [
                'code' => 'perfect_score',
                'name' => 'Bug Hunter Handal',
                'description' => 'Jawab 100% benar semua soal dalam satu modul 🎯',
                'icon' => '🎯',
            ],
            [
                'code' => 'streak_3',
                'name' => '3 Hari Beruntun!',
                'description' => 'Belajar 3 hari berturut-turut tanpa putus 🔥',
                'icon' => '🔥',
            ],
            [
                'code' => 'streak_7',
                'name' => 'Pejuang 1 Minggu',
                'description' => 'Menjaga streak belajar selama 7 hari penuh 🏆',
                'icon' => '🏆',
            ],
            [
                'code' => 'coder_level_5',
                'name' => 'Calon Programmer',
                'description' => 'Telah menyelesaikan 5 modul belajar pemrograman 💻',
                'icon' => '💻',
            ],
            [
                'code' => 'streak_30',
                'name' => 'Master Konsistensi',
                'description' => 'Streak 30 hari berturut-turut tanpa henti 🌟',
                'icon' => '🌟',
            ],
        ];

        $completedLessonsCount = $user->progress()->where('is_completed', true)->count();
        $certificatesCount = $user->certificates()->count();

        return view('profile.index', compact('user', 'unlockedBadges', 'allBadges', 'completedLessonsCount', 'certificatesCount'));
    }

    /**
     * Update user profile info.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $validated['name'],
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
