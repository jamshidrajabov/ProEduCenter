<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Models\File;
use App\Models\Lesson;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($lesson)
    { 
        $user=auth()->user();
        $courses=$user->courses->where('status','continue');
        $CompletedCourses=$user->courses->where('status','completed');
        return view('homework_create',[
            'userr'=>$user,
            'courses'=>$courses,
            'CompletedCourses'=>$CompletedCourses,
            'lesson'=>$lesson
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomeworkRequest $request)
    {
        $lessonId = $request->input('lesson_id');
        $lesson = Lesson::findOrFail($lessonId);
        
        // Kurs ID sini olish
        $courseId = $lesson->course->id;
        
        // Homework modelini yaratish
        $homework = Homework::create([
            'lesson_id' => $lessonId,
            'course_id' => 1,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'type' => $request->input('type'),
            'score_max' => $request->input('score_max')
        ]);
        

        // Fayllarni saqlash
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->getClientOriginalName();

                // Faylni 'public/uploads' papkasiga saqlash
                $path = $file->storeAs('public/uploads', time() . '_' . $filename);

                $homework->files()->create([
                    'name' => $filename,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('lessons.show',['lesson'=>$lesson->id])->with('success', 'Homework saved successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Homework $homework)
    {
        $user=auth()->user();
        $courses=$user->courses->where('status','continue');
        $CompletedCourses=$user->courses->where('status','completed');
        $studentsWithAnswers = $homework->lesson->course->students->map(function ($student) use ($homework) {
            $answer = $student->answers()->where('homework_id', $homework->id)->first();
            
            return [
                'student' => $student,
                'answer' => $answer
            ];
        });
        return view('homework_show',[
            'userr'=>$user,
            'courses'=>$courses,
            'CompletedCourses'=>$CompletedCourses,
            'homework'=>$homework,
            'students'=>$studentsWithAnswers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Homework $homework)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHomeworkRequest $request, Homework $homework)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homework $homework)
    {
        //
    }
}
