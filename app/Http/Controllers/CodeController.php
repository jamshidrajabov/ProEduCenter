<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Http\Request;
class CodeController extends Controller
{
    public function run(Request $request)
    {
        // Foydalanuvchidan olingan Python kodini olish
        $pythonCode = $request->input('code');

        // Python kodini vaqtincha faylga yozamiz
        $filePath = storage_path('app/temp_code.py');
        
        // Python kodini faylga yozish
        file_put_contents($filePath, $pythonCode, LOCK_EX);

        // Python faylini ishga tushirish
        $process = new Process(['python', $filePath]); // yoki ['python3', $filePath] agar Python 3 ishlatilsa

        try {
            $process->run();
        } catch (ProcessFailedException $e) {
            // Agar Python kodi xato bersa
            return response()->json([
                'status' => 'error',
                'output' => $e->getMessage()
            ]);
        }

        // Python kodi muvaffaqiyatli bajarganida javobni qaytarish
        $output = mb_convert_encoding($process->getOutput(), 'UTF-8', 'auto');
        $errorOutput = mb_convert_encoding($process->getErrorOutput(), 'UTF-8', 'auto');

        return response()->json([
            'status' => $process->isSuccessful() ? 'success' : 'error',
            'output' => $process->isSuccessful() ? $output : $errorOutput
        ]);
    }
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Code $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Code $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCodeRequest $request, Code $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Code $code)
    {
        //
    }
}
