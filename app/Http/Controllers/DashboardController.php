<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role_id==1)
            {
                $user=auth()->user();
                return view('admindashboard',[
                    'user'=>$user
                ]);
            }
        else if (auth()->user()->role_id==2)
            {
                $user=auth()->user();
                $courses=$user->courses->where('status','continue');
                $CompletedCourses=$user->courses->where('status','completed');
                // Faqat role_id = 3 (student) bo'lgan foydalanuvchilarni olamiz
    $students = User::where('role_id', 3)
    ->get()
    ->map(function($student) {
        // Studentning kurslarini olamiz (davom etayotganlar)
        $courses = $student->courses->where('status', 'continue');

        // Har bir kurs uchun barcha lessonlar va homeworklar orqali answerlarni yig'amiz
        $student->mark = 0;

        foreach ($courses as $course) {
            foreach ($course->lessons as $lesson) {
                foreach ($lesson->homeworks as $homework) {
                    // Studentning `answer`lari orqali `score`ni yig'amiz
                    $score = $student->answers
                        ->where('homework_id', $homework->id)
                        ->sum('score');

                    // Agar answer bo'lmasa, 0 qo'shiladi
                    $student->mark += $score;
                }
            }
        }

        return $student;
    })
    ->sortByDesc('mark'); // Ballar bo'yicha kamayish tartibida saralash

// Bladega yuborish
                return view('teacherdashboard',[
                    'userr'=>$user,
                    'courses'=>$courses,
                    'CompletedCourses'=>$CompletedCourses,
                    'students' => $students
                ]);
            }
        else
            {
                $user=auth()->user();
                $courses = $user->courses->where('status', 'continue')->map(function ($course) use ($user) {
                    // Hamma lessonlardagi homeworklarning maksimal ballini hisoblash
                    $scoreMax = 0;
                    $totalUserScore = 0;
                
                    foreach ($course->lessons as $lesson) {
                        foreach ($lesson->homeworks as $homework) {
                            // Homework maksimal ballini yig'indisi
                            $scoreMax += $homework->score_max;
                
                            // Foydalanuvchining homeworklarga bergan javoblaridan ball yig'ish
                            $userAnswer = $user->answers->where('homework_id', $homework->id)->first();
                            $totalUserScore += $userAnswer ? $userAnswer->score : 0;
                        }
                    }
                
                    // Qiymatlarni course ob'ektiga qo'shish
                    $course->score_max = $scoreMax;
                    $course->total_user_score = $totalUserScore;
                
                    return $course;
                });
                $CompletedCourses = $user->courses->where('status', 'completed')->map(function ($course) use ($user) {
                    // Hamma lessonlardagi homeworklarning maksimal ballini hisoblash
                    $scoreMax = 0;
                    $totalUserScore = 0;
                
                    foreach ($course->lessons as $lesson) {
                        foreach ($lesson->homeworks as $homework) {
                            // Homework maksimal ballini yig'indisi
                            $scoreMax += $homework->score_max;
                
                            // Foydalanuvchining homeworklarga bergan javoblaridan ball yig'ish
                            $userAnswer = $user->answers->where('homework_id', $homework->id)->first();
                            $totalUserScore += $userAnswer ? $userAnswer->score : 0;
                        }
                    }
                
                    // Qiymatlarni course ob'ektiga qo'shish
                    $course->score_max = $scoreMax;
                    $course->total_user_score = $totalUserScore;
                
                    return $course;
                });
                
                return view('studentdashboard',[
                    'userr'=>$user,
                    'courses'=>$courses,
                    'CompletedCourses'=>$CompletedCourses,
                ]);
            }

    }
    public function redirect()
    {
        return redirect()->route('login');
    }
}
