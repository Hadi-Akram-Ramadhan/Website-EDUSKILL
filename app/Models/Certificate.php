<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_code',
        'cert_hash',
        'user_id',
        'course_id',
        'recipient_name',
        'course_title',
        'mentor_name',
        'score_average',
        'issue_date',
        'qr_code_url',
        'pdf_path',
        'is_valid',
    ];

    protected function casts(): array
    {
        return [
            'score_average' => 'float',
            'issue_date' => 'date',
            'is_valid' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get calculated grade and predicate.
     */
    public function getGradeInfoAttribute(): array
    {
        $score = (float) $this->score_average;
        if ($score >= 90.0) {
            return [
                'grade' => 'A',
                'predicate' => 'Sangat Memuaskan (Distinction)',
                'badge_color' => '#059669',
                'badge_bg' => '#ecfdf5',
                'badge_border' => '#a7f3d0',
            ];
        } elseif ($score >= 80.0) {
            return [
                'grade' => 'B',
                'predicate' => 'Memuaskan (Merit)',
                'badge_color' => '#2563eb',
                'badge_bg' => '#eff6ff',
                'badge_border' => '#bfdbfe',
            ];
        } elseif ($score >= 70.0) {
            return [
                'grade' => 'C',
                'predicate' => 'Lulus (Pass)',
                'badge_color' => '#d97706',
                'badge_bg' => '#fffbeb',
                'badge_border' => '#fde68a',
            ];
        }

        return [
            'grade' => 'D',
            'predicate' => 'Cukup',
            'badge_color' => '#475569',
            'badge_bg' => '#f1f5f9',
            'badge_border' => '#cbd5e1',
        ];
    }
}
