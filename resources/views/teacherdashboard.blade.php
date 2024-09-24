@extends('layouts.teacher_app')
@section('title','ProEduCenter | Bosh sahifa')
@section('breadcrumb')
<div class="col-md-12">
  <div class="content-header ">
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
</div>

@endsection
@section('content')
<div class="modal fade" id="studentadd">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">O'quvchi qo'shish</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">O'quvchi qo'shish</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{route('course_user.store')}}" method="POST">
            @csrf
            <input name="course_id" type="hidden" id="course_id" name="course_id" value="">
            <div class="card-body">
              <div class="form-group">
                <label>O'quvchilarni tanlang</label>
                <select name="students[]" class="select2" multiple="multiple" data-placeholder="O'quvchini tanlang:" style="width: 100%;">
                  @foreach ($students as $student)
                  <option value="{{$student->id}}">{{$student->surname.' '.$student->name.' ('.$student->email.')'}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Saqlash</button>
            </div>

            <!-- /.card-body -->
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="lessonadd">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Dars qo'shish</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Dars qo'shish</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="lessonForm" action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input name="course_id" type="hidden" id="course_id" value="">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Dars nomi</label>
                    <input name="title" type="text" class="form-control" id="title" placeholder="Dars nomini kiriting">
                </div>
                <div class="form-group">
                    <label for="description">Darsga izoh</label>
                    <textarea class="form-control" name="description" id="description" cols="20" rows="5"></textarea>
                </div>
                <div class="input-group mb-2">
                  <div class="custom-file">
                    <input type="file" name="files[]" id="files" class="custom-file-input" multiple>
                    <label class="custom-file-label" for="files">Fayl yoki fayllar jamlanmasini tanlang:</label>
                  </div>
                </div>
                <p class="form-group" style="color:red">Bir necha fayl tanlash uchun Ctrl tugmasidan foydalaning</p>
              <button type="submit" class="btn btn-primary">Saqlash</button>
            </div>
            <!-- /.card-body -->
        </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<section class="content col-md-12">
  <div class="row">
      <div class="col-12" id="accordion">
        @foreach ($courses as $course)
        <div class="card card-warning card-outline">
          <a class="d-block w-100" data-toggle="collapse" href="#{{'course'.$course->id}}">
            <div class="card-header d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-book fa-lg mr-3 text-primary"></i> <!-- Kurs ikonasi -->
                    <h4 class="card-title mb-0">
                        {{$loop->iteration}}. {{$course->name}}
                    </h4>
                </div>
                <div class="ml-auto d-flex align-items-center">
                    <i class="fas fa-clock mr-2 text-muted"></i> <!-- Vaqt ikonkasi -->
                    <span class="text-muted">{{$course->created_at->format('d.m.Y')}}</span>
                </div>
            </div>
        </a>
        
          @if ($loop->iteration==1)
          <div id="{{'course'.$course->id}}" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                  <div class="row">
                    <!-- Dars qo'shish button -->
                    <div class="col-md-3 mb-3">
                        <a class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #4caf50, #1e88e5); border: none; border-radius: 50px; padding: 15px 30px;" 
                           data-toggle="modal" data-target="#lessonadd" data-course-id="{{ $course->id }}">
                           <i class="fas fa-chalkboard-teacher mr-2"></i> <span>Dars qo'shish</span>
                        </a>
                    </div>
                    
                    <!-- O'quvchi biriktirish button -->
                    <div class="col-md-3 mb-3">
                        <a class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #ff9800, #f44336); border: none; border-radius: 50px; padding: 15px 30px;" 
                           data-toggle="modal" data-target="#studentadd" data-course-id="{{ $course->id }}">
                           <i class="fas fa-user-plus mr-2"></i> <span>O'quvchi biriktirish</span>
                        </a>
                    </div>
                
                    <!-- O'quvchilarim button -->
                    <div class="col-md-3 mb-3">
                        <a href="{{route('showcourse',['course'=>$course->id])}}"
                           class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #673ab7, #3f51b5); border: none; border-radius: 50px; padding: 15px 30px;">
                           <i class="fas fa-users mr-2"></i> <span>O'quvchilarim</span>
                        </a>
                    </div>

                    <div class="col-md-3 mb-3">
                      <a class="btn btn-lg text-white d-flex align-items-center justify-content-center" 
                        href="{{route('completecourse',['course'=>$course->id])}}"
                        style="background: linear-gradient(45deg, #007bff, #0056b3); border: none; border-radius: 50px; padding: 15px 30px;">
                        <i class="fas fa-check mr-2"></i> <span>Kursni yakunlash</span> 
                      </a>
                  </div>
                  
                
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
                      <div class="col-md-6 mb-4">
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
            </div>
            </div>
          @else
          <div id="{{'course'.$course->id}}" class="collapse" data-parent="#accordion">
            <div class="card-body">
                  <div class="row">
                    <!-- Dars qo'shish button -->
                    <div class="col-md-4 mb-3">
                        <a class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #4caf50, #1e88e5); border: none; border-radius: 50px; padding: 15px 30px;" 
                           data-toggle="modal" data-target="#lessonadd" data-course-id="{{ $course->id }}">
                           <i class="fas fa-chalkboard-teacher mr-2"></i> <span>Dars qo'shish</span>
                        </a>
                    </div>
                    
                    <!-- O'quvchi biriktirish button -->
                    <div class="col-md-4 mb-3">
                        <a class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #ff9800, #f44336); border: none; border-radius: 50px; padding: 15px 30px;" 
                           data-toggle="modal" data-target="#studentadd" data-course-id="{{ $course->id }}">
                           <i class="fas fa-user-plus mr-2"></i> <span>O'quvchi biriktirish</span>
                        </a>
                    </div>
                
                    <!-- O'quvchilarim button -->
                    <div class="col-md-4 mb-3">
                        <a href="{{route('showcourse',['course'=>$course->id])}}"
                           class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #673ab7, #3f51b5); border: none; border-radius: 50px; padding: 15px 30px;">
                           <i class="fas fa-users mr-2"></i> <span>O'quvchilarim</span>
                        </a>
                    </div>
                
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
                      <div class="col-md-6 mb-4">
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
            </div>
            </div>
          @endif
        </div> 
        @endforeach
        @foreach ($CompletedCourses as $course)
          <div class="card card-warning card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#{{'course'.$course->id}}">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        {{$loop->iteration}}. {{$course->name}}
                    </h4>
                    <div class="d-flex justify-content-end align-items-center">
                      <i class="fas fa-clock mr-2"></i> <!-- Font Awesome ikonkasi -->
                      <span>{{$course->created_at->format('d.m.Y')}}</span>
                    </div>
                </div>
            </a>
            <div id="{{'course'.$course->id}}" class="collapse" data-parent="#accordion">
                <div class="card-body">
                  
                  <div class="row">
                    <!-- Dars qo'shish button -->
                    <div class="col-md-6 mb-3">
                      <a class="btn btn-lg text-white d-flex align-items-center justify-content-center" 
                         style="background: linear-gradient(45deg, #f44336, #d32f2f); border: none; border-radius: 50px; padding: 15px 30px;" 
                         >
                         <i class="fas fa-check-circle mr-2"></i> <span>Siz bu kursni tugallagansiz</span>
                      </a>
                  </div>
                  
                
                    <!-- O'quvchilarim button -->
                    <div class="col-md-6 mb-3">
                        <a href="{{route('showcourse',['course'=>$course->id])}}"
                           class="btn btn-lg btn-primary text-white d-flex align-items-center justify-content-center" 
                           style="background: linear-gradient(45deg, #673ab7, #3f51b5); border: none; border-radius: 50px; padding: 15px 30px;">
                           <i class="fas fa-users mr-2"></i> <span>O'quvchilarim</span>
                        </a>
                    </div>
                
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
                      <div class="col-md-6 mb-4">
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
                </div>
            </div>
          </div> 
        @endforeach
      </div>
  </div>
</section>

@endsection
@section('script')
<script>
// Modal ochilganda data attribute'dan course_id ni olish
$('#lessonadd').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget); // Modalni ochayotgan tugma
var courseId = button.data('course-id'); // `data-course-id` dan qiymatni olamiz

var modal = $(this);
modal.find('#course_id').val(courseId); // `course_id` inputiga qiymatni o'rnatamiz
});
</script>
<script>
  $('#studentadd').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget); // Modalni ochayotgan tugma
var courseId = button.data('course-id'); // `data-course-id` dan qiymatni olamiz

var modal = $(this);
modal.find('#course_id').val(courseId); // `course_id` inputiga qiymatni o'rnatamiz
});
</script>

@endsection