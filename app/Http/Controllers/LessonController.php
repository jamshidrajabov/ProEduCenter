<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class LessonController extends Controller
{
    
    
   
    public function showlesson(Lesson $lesson)
    {
        $user = auth()->user();
        $courses = $user->courses->where('status', 'continue');
        $completedCourses = $user->courses->where('status', 'completed');
        $homeworks = $lesson->homeworks;
        return view('showlesson',[
            'userr' => $user,
            'courses' => $courses,
            'CompletedCourses' => $completedCourses,
            'lesson'=>$lesson,
            'homeworks' => $homeworks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
       

        // Darsni saqlash
        $lesson = Lesson::create([
            
            'course_id'=>$request->course_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        // Fayllarni saqlash
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();

                // Faylni 'public/uploads' papkasiga saqlash
                $path = $file->storeAs('public/uploads', time() . '_' . $filename);

                $lesson->files()->create([
                    'name' => $filename,
                    'path' => $path,
                ]);
            }
        }
        return redirect()->route('lessons.show',['lesson'=>$lesson->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
{
    $user = auth()->user();
    $courses = $user->courses->where('status', 'continue');
    $completedCourses = $user->courses->where('status', 'completed');
    $homeworks = $lesson->homeworks->map(function($homework) {
        // Hozirgi vaqtni olish
        $currentDate = now();

        // Homeworkning `due_date` ni formatlash va taqqoslash
        $dueDate = Carbon::parse($homework->due_date); // due_date stringni Carbon ob'ektiga o'zgartiramiz

        if ($dueDate->greaterThan($currentDate)) {
            // Agar `due_date` hozirgi vaqtdan keyin bo'lsa, "Jarayonda" deb belgilash
            $homework->status = 'Jarayonda';
        } else {
            // Aks holda, "Tugallandi" deb belgilash
            $homework->status = 'Tugallandi';
        }

        return $homework;
    });



    $homeworkIds = $lesson->homeworks->pluck('id');
    
    // Shu lessonning homeworklari uchun faqat type = 'student' bo'lgan studentlarni olish
    $students = User::whereHas('courses', function($query) use ($lesson) {
        $query->where('courses.id', $lesson->course_id)
              ->where('course_user.type', 'student'); // 'course_user' jadvali va 'type' ustuni aniq ko'rsatilmoqda
    })->get();

    // Har bir student uchun answerlar va ballar yig'indisini olish
    $students = $students->map(function($student) use ($homeworkIds) {
        $totalScore = $student->answers()
            ->whereIn('answers.homework_id', $homeworkIds) // 'answers' jadvali aniq ko'rsatilmoqda
            ->sum('answers.score'); // 'answers' jadvali aniq ko'rsatilmoqda
        
        // Answer topilmaganida default qiymatni 0 deb hisoblaymiz
        if (!$totalScore) {
            $totalScore = 0;
        }
        
        $student->totalScore = $totalScore;
        return $student;
    });

    // Score_max yig'indisini olish
    $scoreMax = $lesson->homeworks->sum('score_max');

    
    return view('lesson', [
        'userr' => $user,
        'courses' => $courses,
        'CompletedCourses' => $completedCourses,
        'lesson' => $lesson,
        'homeworks' => $homeworks,
        'students' => $students,
        'scoreMax' => $scoreMax
    ]);
}


    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
