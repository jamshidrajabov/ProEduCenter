<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_user')->insert([
            'course_id' => 1,
            'user_id' => 2,
            'type'=>'teacher',
        ]);
        DB::table('course_user')->insert([
            'course_id' => 2,
            'user_id' => 2,
            'type'=>'teacher',
        ]);
        DB::table('course_user')->insert([
            'course_id' => 2,
            'user_id' => 3,
            'type'=>'student',
        ]);

    }
}
