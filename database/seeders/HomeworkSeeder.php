<?php

namespace Database\Seeders;

use App\Models\Homework;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Homework::create([
                'lesson_id' => 1, 
                'title' => 'Homework 1',
                'description' => 'Complete the given task',
                'type' => 'php',
                'due_date' => now()->addDays(1),
                'score_max' => 50]);
        Homework::create([
                'lesson_id' => 1, 
                'title' => 'Homework 2',
                'description' => 'Solve the given problem',
                'type' => 'php',
                'due_date' => now()->addDays(2),
                'score_max' => 50]);
        Homework::create([
                'lesson_id' => 2, 
                'title' => 'Homework 1',
                'description' => 'Complete the given task',
                'due_date' => now()->addDays(1),
                'score_max' => 100]);
    }
}
