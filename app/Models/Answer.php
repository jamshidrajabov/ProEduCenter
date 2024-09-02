<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Answer extends Model
{
    use HasFactory;
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
