<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'question_type',
        'prompt',
        'code_snippet',
        'options_json',
        'answer_json',
        'explanation',
        'order_index',
    ];

    protected function casts(): array
    {
        return [
            'options_json' => 'array',
            'answer_json' => 'array',
            'order_index' => 'integer',
        ];
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
