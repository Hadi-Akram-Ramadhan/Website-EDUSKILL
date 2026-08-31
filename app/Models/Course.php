<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'title',
        'slug',
        'description',
        'category',
        'target_audience',
        'thumbnail',
        'level',
        'total_xp',
        'is_published',
        'is_upcoming',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_upcoming' => 'boolean',
            'total_xp' => 'integer',
        ];
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class)->orderBy('order_index');
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Unit::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
