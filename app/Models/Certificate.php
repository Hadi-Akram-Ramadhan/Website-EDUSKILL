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
}
