<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'title',
        'slug',
        'description',
        'type',
        'is_project',
        'project_brief',
        'theory_content',
        'xp_reward',
        'order_index',
    ];

    protected function casts(): array
    {
        return [
            'is_project' => 'boolean',
            'xp_reward' => 'integer',
            'order_index' => 'integer',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class)->orderBy('order_index');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }
}
