<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lesson::create([
            'title' => 'Laravel Basics',
            'description' => 'Learn the fundamentals of Laravel',
            'course_id' => 1]);
        Lesson::create([
            'title' => 'Laravel Intermediate',
            'description' => 'Learn advanced Laravel features',
            'course_id' => 1]);
    }
}
