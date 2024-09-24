<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function showcourse(Course $course)
    {
        $user = auth()->user();
        $courses = $user->courses->where('status', 'continue');
        $completedCourses = $user->courses->where('status', 'completed');
        return view('showcourse',[
            'course' => $course,
            'userr' => $user,
            'courses' => $courses,
            'CompletedCourses' => $completedCourses,
        ]);
    }
    public function index()
    {
        //
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
    public function store(StoreCourseRequest $request)
    {
       $user=auth()->user();
        $course=Course::create([
            'name' => $request->name,
            'status' => 'continue'
        ]);
        $course->teachers()->attach($user->id,['type' => 'teacher']);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        
    }
    public function completecourse(Course $course)
    {
        $course->status="completed";
        $course->save();
        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
