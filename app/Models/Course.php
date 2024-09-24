<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Course extends Model
{
    use HasFactory;
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('type')
                    ->wherePivot('type', 'student')
                    ->orderBy('surname');  // Alfavit tartibida saralash
    }
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('type')
                    ->wherePivot('type', 'teacher')
                    ->orderBy('surname');  // Alfavit tartibida saralash
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
    public function homeworks(): HasMany
    {
        return $this->hasMany(Homework::class);
    }
    protected $fillable = ['name','status'];
}
