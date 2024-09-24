<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Carbon\Carbon;

class Homework extends Model
{
    
    use HasFactory;
    protected $fillable = ['lesson_id','course_id','title', 'description', 'due_date','type','score_max'];
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
