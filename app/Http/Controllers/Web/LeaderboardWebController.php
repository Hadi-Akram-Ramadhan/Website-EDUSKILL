<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LeaderboardWebController extends Controller
{
    /**
     * Leaderboard Page.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type', 'global');
        $currentUser = Auth::user();

        $query = User::where('role', 'siswa');

        if ($type === 'streak') {
            $query->orderByDesc('streak_count')->orderByDesc('xp');
        } else {
            $query->orderByDesc('xp')->orderByDesc('level');
        }

        $students = $query->limit(50)->get();

        // Calculate tier for each student
        $students->each(function ($s) {
            $s->tier = GamificationService::getTierDetails($s->xp ?? 0);
        });

        // Top 3 Podium
        $podium = $students->take(3);
        $rankings = $students->skip(3);
        $user = $currentUser;
        $userTier = $currentUser ? GamificationService::getTierDetails($currentUser->xp ?? 0) : GamificationService::getTierDetails(0);

        return view('leaderboard.index', compact('podium', 'rankings', 'students', 'type', 'user', 'currentUser', 'userTier'));
    }
}
