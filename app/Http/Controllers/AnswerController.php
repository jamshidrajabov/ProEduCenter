<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Homework;
use Illuminate\Http\Request;


class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function checking(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        // Validatsiya (agar kerak bo'lsa)
        $request->validate([
            'score' => 'required',
        ]);

        $answer->score = $request->score;
        $answer->save();

        // To'g'ri `homework` id'sini olish
        return redirect()->route('homeworks.show', ['homework' => $answer->homework->id]);
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
    public function store(StoreAnswerRequest $request)
    {
        $homework=Homework::findOrFail($request->homework_id);
        $answer = Answer::create([
            
            'user_id'=>auth()->user()->id,
            'homework_id' => $homework->id,
            'answer' => "\n" . $request->answer,
        ]);
        if ($homework->type=='file_upload')
        {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = $file->getClientOriginalName();
    
                    // Faylni 'public/uploads' papkasiga saqlash
                    $path = $file->storeAs('public/uploads', time() . '_' . $filename);
    
                    $answer->files()->create([
                        'name' => $filename,
                        'path' => $path,
                    ]);
                }
            }
        }
        
        // Fayllarni saqlash
        
        return redirect()->back();
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
