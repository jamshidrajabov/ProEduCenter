@extends('layouts.teacher_app')
@section('title','ProEduCenter | O\'quvchilar')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kurs haqida</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Kurs haqida</li>
              </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <h3 class="text-secondary font-weight-bold text-center" style="font-size: 1.5rem; margin-bottom: 10px;">
      <i class="fas fa-book mr-2"></i> {{ $course->name }}
  </h3>
  </div>
    @php
      // Talabalarni mark bo'yicha kamayish tartibida sortlash
      $sortedStudents = $course->students->sortByDesc(function ($user) use ($course) {
          // Talabaning umumiy markini hisoblash
          $totalScore = 0;
          foreach ($user->courses as $studentCourse) {
              if ($studentCourse->id == $course->id) {
                  foreach ($studentCourse->lessons as $lesson) {
                      foreach ($lesson->homeworks as $homework) {
                          $userAnswer = $user->answers->where('homework_id', $homework->id)->first();
                          $score = $userAnswer ? $userAnswer->score : 0;
                          $totalScore += $score;
                      }
                  }
              }
          }
          // Ballar summasini qaytarish
          return $totalScore;
      });
    @endphp
  <div class="col-md-12">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr class="text-center">
        <th>Foto</th>
        <th>Ism va Familiya</th>
        <th>Pasport raqami</th>
        <th>Telefon raqami</th>
        <th>Ball</th>
      </tr>
      </thead>
      <tbody>
          @foreach ($sortedStudents as $user)
            @php
              // Ballar summasini hisoblash
              $totalScore = 0;
              foreach ($user->courses as $studentCourse) {
                  if ($studentCourse->id == $course->id) {
                      foreach ($studentCourse->lessons as $lesson) {
                          foreach ($lesson->homeworks as $homework) {
                              $userAnswer = $user->answers->where('homework_id', $homework->id)->first();
                              $score = $userAnswer ? $userAnswer->score : 0;
                              $totalScore += $score;
                          }
                      }
                  }
              }
              // Ballar summasini student ob'ekti sifatida qo'shish
              $user->mark = $totalScore;
            @endphp
            <tr class="text-center">
              <td >
                <img src="{{Storage::url($user->photo)}}" alt="User Photo" style="width: 100px; height: 100px; object-fit: cover;">
            </td>
            <td>{{$user->surname.' '.$user->name}}</td>
            <td>{{$user->passport}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$totalScore}}</td>
            </tr>
          @endforeach
      </tfoot>
    </table>
  </div>
</div>
<div class="row mb-4">
  <div class="col-12">

    <!-- Mavzular ro'yxati -->
    <h4 class="text-primary font-weight-bold text-center" style="border-bottom: 2px solid #1e88e5; padding-bottom: 10px;">
        <i class="fas fa-list-alt mr-2"></i> Mavzular ro'yxati
    </h4>
</div>


</div>
<div class="row">
  <style>
    a.btn:hover {
        background: linear-gradient(45deg, #1e88e5, #4caf50); /* Hover-da ranglarni almashtirish */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); /* Hoverda soyaga qo'shish */

    }
    .card:hover {
        transform: translateY(-5px); /* Hover effekti bilan kartani biroz ko'tarish */
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1); /* Hoverda yanada chuqurroq soya */
    }

    /* Ikonlarni ranglari */
    .card-footer i {
      font-size: 1.2rem; /* Ikonlarning kattaligi */
    }
</style>

<!-- Lesson Cards -->
@foreach ($course->lessons as $lesson)
  <div class="col-md-6 mt-2 mb-4">
      <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden;">
          <a href="{{route('lessons.show', ['lesson' => $lesson->id])}}" class="text-decoration-none">
              <div class="card-body">
                  <!-- Darsning sarlavhasi -->
                  <h5 class="card-title text-primary font-weight-bold">
                      <i class="fas fa-book-open mr-2"></i> {{$lesson->title}}
                  </h5>

                  <!-- Darsning tavsifi -->
                  <p class="card-text text-muted mt-3">
                      <i class="fas fa-info-circle mr-2 text-secondary"></i> {{$lesson->description}}
                  </p>
              </div>

              <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                  <div>
                      <!-- Sana icon va matn -->
                      <i class="fas fa-calendar-alt text-info mr-2"></i> 
                      <span class="text-dark">{{$lesson->created_at->format('d.m.Y')}}</span>
                  </div>
                  <div>
                      <!-- Vaqt icon va matn -->
                      <i class="fas fa-clock text-warning mr-2"></i>
                      <span class="text-dark">{{$lesson->created_at->format('H:i')}}</span>
                  </div>
              </div>
          </a>
      </div>
  </div>
@endforeach
</div>
@endsection