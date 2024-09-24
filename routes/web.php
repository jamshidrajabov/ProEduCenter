<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[DashboardController::class, 'redirect']);

Route::get('/dashboard',[DashboardController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('teacher')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('lessons', LessonController::class);
    Route::resource('homeworks', HomeworkController::class);
    Route::get('homework/create/{lesson}', [HomeworkController::class, 'create'])->name('homeworkss.create');
    Route::resource('course_user', CourseUserController::class);
    Route::post('checking/{id}', [AnswerController::class, 'checking'])->name('checking');
    Route::get('showstudents/{course}', [CourseController::class, 'showcourse'])->name('showcourse');
    Route::get('complete/{course}', [CourseController::class, 'completecourse'])->name('completecourse');

});
Route::middleware('student')->group(function () {
    Route::get('showlesson/{lesson}', [LessonController::class, 'showlesson'])->name('showlesson');
    Route::resource('answers', AnswerController::class);

   
});



require __DIR__.'/auth.php';
