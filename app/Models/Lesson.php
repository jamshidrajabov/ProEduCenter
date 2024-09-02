<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'title', 'description'];
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class);
    }
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
