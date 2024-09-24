@extends('layouts.student_app')
@section('title','ProEduSystem | Bosh sahifa')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bosh sahifa</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Bosh sahifa</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')

<div class="row">
  {{-- <div class="col-md-12">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 custom-carousel-img" src="https://placehold.it/900x500/39CCCC/ffffff&text=Mening kurslarim" alt="First slide">
            </div>
            @foreach ($courses as $course)
            <div class="carousel-item">
              <a href="{{ route('courses.show', $course->id) }}">
                  <img class="d-block w-100 custom-carousel-img" src="https://placehold.it/900x500/3c8dbc/ffffff&text={{$course->name}}" alt="slide img">
              </a>
          </div>
          
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-custom-icon" aria-hidden="true">
                <i class="fas fa-chevron-left"></i>
            </span>
            <span class="sr-only">Oldingi</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-custom-icon" aria-hidden="true">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span class="sr-only">Keyingi</span>
        </a>
    </div>
</div> --}}
<div class="col-md-12 m-2">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th class="text-center">Guruh nomi</th>
      <th class="text-center">Status</th>
      <th class="text-center">To'plangan ball</th>
      <th class="text-center">O'zlashtirish</th>
    </tr>
    </thead>
    <tbody>
      @foreach ($courses->reverse() as $course)
        <tr>
          <td>{{$course->name}}</td>
          <td class="text-center" style="color: green">Davom etmoqda</td>
          <td class="text-center">{{$course->total_user_score}}</td>
          <td class="text-center">
            @if ($course->score_max !== 0)
                {{ number_format(($course->total_user_score / $course->score_max) * 100, 2) }}%
            @else
              Topshiriq mavjud emas
            @endif
        </td>
        
        </tr>
      @endforeach
      @foreach ($CompletedCourses->reverse() as $course)
        <tr>
          <td >{{$course->name}}</td>
          <td class="text-center" style="color: rgb(247, 10, 30)">Tugallangan</td>
          <td class="text-center">{{$course->total_user_score}}</td>
          <td class="text-center">
            @if ($course->score_max !== 0)
                {{ number_format(($course->total_user_score / $course->score_max) * 100, 2) }}%
            @else
                Topshiriq mavjud emas
            @endif
        </td>
        
        </tr>
      @endforeach
    

    </tfoot>
  </table>
</div>
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Topshiriqlarim</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
      <div id="accordion">
        @foreach ($courses->reverse() as $course)
          <div class="card card-primary">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$course->id}}">
                  {{$course->name}} 
                </a>
              </h4>
            </div>
            @if ($loop->iteration==1)
            <div id="collapse{{$course->id}}" class="collapse show" data-parent="#accordion">
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                  <tr class="text-center">
                    <th>Mavzu</th>
                    <th>Topshiriq</th>
                    <th>Berilgan vaqti</th>
                    <th>Topshirishning oxirgi sanasi</th>
                    <th>Eng yuqori ball</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($course->lessons->reverse() as $lesson)
                      @foreach ($lesson->homeworks->reverse() as $homework)
                        @include('sendhomeworkmodal')
                        <tr  style="cursor: pointer" data-toggle="modal" data-target="#sendhomework{{$homework->id}}" data-homework-id="{{ $homework->id }}">
                            <td class="text-center">{{$lesson->title}}</td>
                            <td class="text-center">{{ $homework->title }}</td>
                            <td>
                                <!-- Kalendar ikonkasi va sana -->
                                <div>
                                    <i class="fa fa-calendar"></i> <!-- Kalendar ikonkasi -->
                                    <span>{{ $homework->created_at->format('d.m.Y') }}</span> <!-- Sana: Kun.Oy.Yil -->
                                </div>
                                <!-- Soat ikonkasi va vaqt -->
                                <div>
                                    <i class="fa fa-clock"></i> <!-- Soat ikonkasi -->
                                    <span>{{ $homework->created_at->format('H:i') }}</span> <!-- Soat: Daqiqa (24 soat formatda) -->
                                </div>
                            </td>
                            @php
                                $dateTime = Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date);
                            @endphp
                            <td>
                                <!-- Kalendar ikonkasi va sana -->
                                <div>
                                    <i class="fa fa-calendar"></i> <!-- Kalendar ikonkasi -->
                                    <span>{{ $dateTime->format('d.m.Y') }}</span> <!-- Sana: Kun.Oy.Yil -->
                                </div>
                                <!-- Soat ikonkasi va vaqt -->
                                <div>
                                    <i class="fa fa-clock"></i> <!-- Soat ikonkasi -->
                                    <span>{{ $dateTime->format('H:i') }}</span> <!-- Soat: Daqiqa (24 soat formatda) -->
                                </div>
                            </td>
                            <td class="text-center">{{ $homework->score_max }}</td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tfoot>
                </table>
              </div>
            </div>
            @else
            <div id="collapse{{$course->id}}" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Mavzu</th>
                    <th>Topshiriq</th>
                    <th>Berilgan vaqti</th>
                    <th>Topshirishning oxirgi sanasi</th>
                    <th>Eng yuqori ball</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($course->lessons->reverse() as $lesson)
                      @foreach ($lesson->homeworks->reverse() as $homework)
                        @include('sendhomeworkmodal')
                        <tr data-toggle="modal" data-target="#sendhomework{{$homework->id}}" data-homework-id="{{ $homework->id }}">
                            <td>{{$lesson->title}}</td>
                            <td>{{ $homework->title }}</td>
                            <td>
                                <!-- Kalendar ikonkasi va sana -->
                                <div>
                                    <i class="fa fa-calendar"></i> <!-- Kalendar ikonkasi -->
                                    <span>{{ $homework->created_at->format('d.m.Y') }}</span> <!-- Sana: Kun.Oy.Yil -->
                                </div>
                                <!-- Soat ikonkasi va vaqt -->
                                <div>
                                    <i class="fa fa-clock"></i> <!-- Soat ikonkasi -->
                                    <span>{{ $homework->created_at->format('H:i') }}</span> <!-- Soat: Daqiqa (24 soat formatda) -->
                                </div>
                            </td>
                            @php
                                $dateTime = Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date);
                            @endphp
                            <td>
                                <!-- Kalendar ikonkasi va sana -->
                                <div>
                                    <i class="fa fa-calendar"></i> <!-- Kalendar ikonkasi -->
                                    <span>{{ $dateTime->format('d.m.Y') }}</span> <!-- Sana: Kun.Oy.Yil -->
                                </div>
                                <!-- Soat ikonkasi va vaqt -->
                                <div>
                                    <i class="fa fa-clock"></i> <!-- Soat ikonkasi -->
                                    <span>{{ $dateTime->format('H:i') }}</span> <!-- Soat: Daqiqa (24 soat formatda) -->
                                </div>
                            </td>
                            <td class="text-center">{{ $homework->score_max }}</td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tfoot>
                </table>
              </div>
            </div>
            @endif
            
          </div>
        @endforeach
        @foreach ($CompletedCourses as $course)
          <div class="card card-danger">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" href="#collapse{{$course->id}}">
                  {{$course->name}}
                </a>
              </h4>
            </div>
            <div id="collapse{{$course->id}}" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                      <thead>
                      <tr class="text-center">
                          <th>Mavzu</th>
                          <th>Topshiriq</th>
                          <th>Berilgan vaqti</th>
                          <th>Topshirishning oxirgi sanasi</th>
                          <th>Eng yuqori ball</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach ($course->lessons->reverse() as $lesson)
                              @foreach ($lesson->homeworks->reverse() as $homework)
                                  @include('seehomeworkmodal')
                                  <tr style="cursor: pointer;" data-toggle="modal" data-target="#seehomework{{$homework->id}}" data-homework-id="{{ $homework->id }}">
                                      <td>{{ $lesson->title }}</td>
                                      <td>{{ $homework->title }}</td>
                                      <td>
                                          <!-- Kalendar ikonkasi va sana -->
                                          <div>
                                              <i class="fa fa-calendar"></i>
                                              <span>{{ $homework->created_at->format('d.m.Y') }}</span>
                                          </div>
                                          <div>
                                              <i class="fa fa-clock"></i>
                                              <span>{{ $homework->created_at->format('H:i') }}</span>
                                          </div>
                                      </td>
                                      @php
                                          $dateTime = Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date);
                                      @endphp
                                      <td>
                                          <div>
                                              <i class="fa fa-calendar"></i>
                                              <span>{{ $dateTime->format('d.m.Y') }}</span>
                                          </div>
                                          <div>
                                              <i class="fa fa-clock"></i>
                                              <span>{{ $dateTime->format('H:i') }}</span>
                                          </div>
                                      </td>
                                      <td class="text-center">{{ $homework->score_max }}</td>
                                  </tr>
                              @endforeach
                          @endforeach
                      </tfoot>
                  </table>
              </div>
              
              </div>
            </div>
          </div>
        @endforeach
        
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

</div>

@endsection
@section('css')
 <!-- AdminLTE CSS -->
 <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    
 <!-- Highlight.js CSS -->
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
 <style>
  pre code {
  text-align: left; /* Kodni chap tomondan boshlash */
  white-space: pre; /* Oq joylarni saqlab qolish */
}
 </style>

@endsection
@section('script')
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/languages/python.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('pre code').forEach((el) => {
            hljs.highlightElement(el);
        });
    });
</script>
@endsection