<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserProgress;
use App\Models\UserStreak;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GamificationService
{
    const MAX_HEARTS = 5;
    const HEART_REFILL_MINUTES = 30;
    const XP_PER_LEVEL = 100;
    const REFILL_GEM_COST = 20;

    /**
     * Regenerate hearts automatically based on elapsed time.
     */
    public function syncHearts(User $user): User
    {
        if ($user->hearts >= self::MAX_HEARTS) {
            return $user;
        }

        if (!$user->last_heart_refill_at) {
            return $user;
        }

        $now = Carbon::now();
        $lastRefill = Carbon::parse($user->last_heart_refill_at);
        $minutesPassed = $lastRefill->diffInMinutes($now);

        $heartsToAdd = (int) floor($minutesPassed / self::HEART_REFILL_MINUTES);

        if ($heartsToAdd > 0) {
            $newHearts = min(self::MAX_HEARTS, $user->hearts + $heartsToAdd);
            $user->hearts = $newHearts;
            
            if ($newHearts >= self::MAX_HEARTS) {
                $user->last_heart_refill_at = null;
            } else {
                $user->last_heart_refill_at = $lastRefill->addMinutes($heartsToAdd * self::HEART_REFILL_MINUTES);
            }
            $user->save();
        }

        return $user;
    }

    /**
     * Deduct 1 heart on incorrect answer.
     */
    public function deductHeart(User $user): int
    {
        $this->syncHearts($user);

        if ($user->hearts > 0) {
            $user->hearts -= 1;
            if (!$user->last_heart_refill_at) {
                $user->last_heart_refill_at = Carbon::now();
            }
            $user->save();
        }

        return $user->hearts;
    }

    /**
     * Refill hearts instantly using gems.
     */
    public function refillHeartsWithGems(User $user): bool
    {
        $this->syncHearts($user);

        if ($user->gems < self::REFILL_GEM_COST || $user->hearts >= self::MAX_HEARTS) {
            return false;
        }

        $user->gems -= self::REFILL_GEM_COST;
        $user->hearts = self::MAX_HEARTS;
        $user->last_heart_refill_at = null;
        $user->save();

        return true;
    }

    /**
     * Award XP to user and calculate level ups.
     */
    public function awardXp(User $user, int $amount): array
    {
        $oldLevel = $user->level;
        $user->xp += $amount;
        $newLevel = (int) floor($user->xp / self::XP_PER_LEVEL) + 1;
        $user->level = $newLevel;
        $user->save();

        $leveledUp = $newLevel > $oldLevel;

        return [
            'xp_earned' => $amount,
            'total_xp' => $user->xp,
            'level' => $user->level,
            'leveled_up' => $leveledUp,
        ];
    }

    /**
     * Update user daily streak.
     */
    public function updateStreak(User $user): int
    {
        $today = Carbon::today();
        $lastActive = $user->last_active_date ? Carbon::parse($user->last_active_date)->startOfDay() : null;

        if (!$lastActive) {
            $user->streak_count = 1;
            $user->last_active_date = $today;
            $user->save();
            UserStreak::firstOrCreate(['user_id' => $user->id, 'active_date' => $today->toDateString()]);
        } elseif ($lastActive->equalTo($today)) {
            // Already active today, streak remains same
        } elseif ($lastActive->equalTo($today->copy()->subDay())) {
            // Consecutive day
            $user->streak_count += 1;
            $user->last_active_date = $today;
            $user->save();
            UserStreak::firstOrCreate(['user_id' => $user->id, 'active_date' => $today->toDateString()]);
        } else {
            // Streak broken
            $user->streak_count = 1;
            $user->last_active_date = $today;
            $user->save();
            UserStreak::firstOrCreate(['user_id' => $user->id, 'active_date' => $today->toDateString()]);
        }

        $this->checkStreakBadges($user);

        return $user->streak_count;
    }

    /**
     * Evaluate single exercise answer.
     */
    public function evaluateExercise(Exercise $exercise, mixed $userAnswer): bool
    {
        $correctAnswer = $exercise->answer_json;

        switch ($exercise->question_type) {
            case 'multiple_choice':
            case 'fill_blank':
            case 'output_prediction':
                if (is_array($correctAnswer)) {
                    $expected = $correctAnswer['answer'] ?? ($correctAnswer[0] ?? '');
                } else {
                    $expected = $correctAnswer;
                }
                return trim(strtolower((string)$userAnswer)) === trim(strtolower((string)$expected));

            case 'code_ordering':
                // $correctAnswer should be an ordered array of strings or indices: e.g. ["1", "2", "3"]
                if (!is_array($userAnswer) || !is_array($correctAnswer)) {
                    return false;
                }
                $expected = $correctAnswer['order'] ?? $correctAnswer;
                return array_values($userAnswer) == array_values($expected);

            case 'matching_pair':
                // $correctAnswer should be key-value pairs: e.g. {"int": "Angka Bulat", "str": "Teks"}
                if (!is_array($userAnswer) || !is_array($correctAnswer)) {
                    return false;
                }
                $expectedPairs = $correctAnswer['pairs'] ?? $correctAnswer;
                foreach ($expectedPairs as $k => $v) {
                    if (!isset($userAnswer[$k]) || $userAnswer[$k] !== $v) {
                        return false;
                    }
                }
                return true;

            default:
                return false;
        }
    }

    /**
     * Submit an entire lesson attempt.
     * $submissions: array of ['exercise_id' => int, 'answer' => mixed]
     */
    public function submitLesson(User $user, Lesson $lesson, array $submissions): array
    {
        $this->syncHearts($user);

        $exercises = $lesson->exercises()->get()->keyBy('id');
        $total = $exercises->count();
        $correctCount = 0;
        $evaluations = [];

        foreach ($submissions as $sub) {
            $exerciseId = $sub['exercise_id'] ?? null;
            $userAnswer = $sub['answer'] ?? null;

            if ($exerciseId && isset($exercises[$exerciseId])) {
                $exercise = $exercises[$exerciseId];
                $isCorrect = $this->evaluateExercise($exercise, $userAnswer);

                if ($isCorrect) {
                    $correctCount++;
                } else {
                    $this->deductHeart($user);
                }

                $evaluations[] = [
                    'exercise_id' => $exerciseId,
                    'is_correct' => $isCorrect,
                    'explanation' => $exercise->explanation,
                ];
            }
        }

        $score = $total > 0 ? (int) round(($correctCount / $total) * 100) : 100;
        $passed = $score >= 60; // 60% passing threshold for lesson

        $xpEarned = 0;
        $newBadges = [];

        if ($passed) {
            // Award lesson XP
            $xpReward = $lesson->xp_reward ?? 15;
            // Bonus for 100% score
            if ($score === 100) {
                $xpReward += 5;
            }

            $xpResult = $this->awardXp($user, $xpReward);
            $xpEarned = $xpReward;

            // Update Progress
            $progress = UserProgress::updateOrCreate(
                ['user_id' => $user->id, 'lesson_id' => $lesson->id],
                [
                    'is_completed' => true,
                    'score' => max($score, UserProgress::where('user_id', $user->id)->where('lesson_id', $lesson->id)->value('score') ?? 0),
                    'completed_at' => Carbon::now(),
                ]
            );

            // Update streak
            $this->updateStreak($user);

            // Check milestone badges
            $newBadges = $this->checkMilestoneBadges($user, $score);
        }

        $user->refresh();

        return [
            'passed' => $passed,
            'score' => $score,
            'correct_count' => $correctCount,
            'total_exercises' => $total,
            'xp_earned' => $xpEarned,
            'user' => [
                'id' => $user->id,
                'xp' => $user->xp,
                'level' => $user->level,
                'hearts' => $user->hearts,
                'streak_count' => $user->streak_count,
                'gems' => $user->gems,
            ],
            'evaluations' => $evaluations,
            'new_badges' => $newBadges,
        ];
    }

    /**
     * Check streak-related badges.
     */
    protected function checkStreakBadges(User $user): void
    {
        if ($user->streak_count >= 3) {
            $this->grantBadge($user, 'streak_3', '3 Hari Beruntun!', 'Belajar 3 hari berturut-turut tanpa putus 🔥', 'fire');
        }
        if ($user->streak_count >= 7) {
            $this->grantBadge($user, 'streak_7', 'Pejuang 1 Minggu!', 'Menjaga streak belajar selama 7 hari penuh 🏆', 'trophy');
        }
        if ($user->streak_count >= 30) {
            $this->grantBadge($user, 'streak_30', 'Master Konsistensi!', 'Streak 30 hari berturut-turut 🌟', 'star');
        }
    }

    /**
     * Check milestone-related badges.
     */
    protected function checkMilestoneBadges(User $user, int $score): array
    {
        $newBadges = [];

        // First lesson badge
        $completedCount = UserProgress::where('user_id', $user->id)->where('is_completed', true)->count();
        if ($completedCount >= 1) {
            $b = $this->grantBadge($user, 'first_lesson', 'Langkah Pertama', 'Menyelesaikan modul pemrograman pertama 🎉', 'rocket');
            if ($b) $newBadges[] = $b;
        }

        // Perfect score badge
        if ($score === 100) {
            $b = $this->grantBadge($user, 'perfect_score', 'Bug Hunter Handal', 'Menjawab 100% benar semua soal dalam satu lesson 🎯', 'target');
            if ($b) $newBadges[] = $b;
        }

        // 5 lessons completed
        if ($completedCount >= 5) {
            $b = $this->grantBadge($user, 'coder_level_5', 'Calon Programmer', 'Telah menyelesaikan 5 modul belajar 💻', 'code');
            if ($b) $newBadges[] = $b;
        }

        return $newBadges;
    }

    /**
     * Grant a badge safely if not already owned.
     */
    public function grantBadge(User $user, string $code, string $name, string $description, string $icon): ?UserBadge
    {
        $existing = UserBadge::where('user_id', $user->id)->where('badge_code', $code)->first();
        if ($existing) {
            return null;
        }

        return UserBadge::create([
            'user_id' => $user->id,
            'badge_code' => $code,
            'badge_name' => $name,
            'badge_description' => $description,
            'icon' => $icon,
            'unlocked_at' => Carbon::now(),
        ]);
    }

    /**
     * Get Leaderboard.
     */
    public function getLeaderboard(string $type = 'global', int $limit = 20): Collection
    {
        if ($type === 'streak') {
            return User::where('role', 'siswa')
                ->orderByDesc('streak_count')
                ->orderByDesc('xp')
                ->limit($limit)
                ->get(['id', 'name', 'avatar', 'xp', 'level', 'streak_count']);
        }

        // Default global XP leaderboard
        return User::where('role', 'siswa')
            ->orderByDesc('xp')
            ->orderByDesc('level')
            ->limit($limit)
            ->get(['id', 'name', 'avatar', 'xp', 'level', 'streak_count']);
    }
}
