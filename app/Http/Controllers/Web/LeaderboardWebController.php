<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        // Top 3 Podium
        $podium = $students->take(3);
        $rankings = $students->skip(3);
        $user = $currentUser;

        return view('leaderboard.index', compact('podium', 'rankings', 'students', 'type', 'user', 'currentUser'));
    }
}
