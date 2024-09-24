@extends('layouts.teacher_app')
@section('title','ProEduCenter | Mavzu')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Topshiriq yaratish</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Dars ko'rish</li>
              </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
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
<div class="container-fluid">
  <!-- Lesson Details Section -->
  <div class="row">
      <!-- Lesson Information Card -->
      <div class="col-md-8">
          <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                  <h3 class="card-title">Mavzu haqida ma'lumot</h3>
              </div>
              <div class="card-body">
                  <!-- Lesson Name -->
                  <div class="form-group">
                      <label for="lessonName" class="font-weight-bold">Mavzu nomi:</label>
                      <h4 id="lessonName" class="text-primary">{{ $lesson->title     }}</h4>
                  </div>

                  <!-- Lesson Description -->
                  <div class="form-group">
                      <label for="lessonDescription" class="font-weight-bold">Ma'lumot:</label>
                      <p id="lessonDescription" class="text-muted">{{ $lesson->description }}</p>
                  </div>

                  <!-- Attached Files -->
                  <div class="form-group">
                      <ul class="list-group">
                          @foreach ($lesson->files as $file)
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <a href="{{Storage::url($file->path)}}" target="_blank" class="text-info">
                                      <i class="fas fa-file-alt"></i> {{ $file->name }}
                                  </a>
                                  <span class="badge badge-info badge-pill">Fayl</span>
                              </li>
                          @endforeach
                      </ul>
                  </div>
              </div>
          </div>
      </div>

      <!-- Add Homework Section -->
      <div class="col-md-4">
          <div class="card shadow-sm">
              <div class="card-header bg-success text-white">
                  <h3 class="card-title">Topshiriq qo'shish</h3>
              </div>
              <div class="card-body text-center">
                @if ($lesson->course->status=='completed')
                    <a href="" class="btn btn-light btn-lg">
                        Siz kursni tugallagansiz!
                    </a>
                @else
                    <a href="{{ route('homeworkss.create', ['lesson' => $lesson->id]) }}" class="btn btn-light btn-lg">
                        <i class="fas fa-plus-circle"></i> Topshiriq qo'shish
                    </a>
                @endif
                  
              </div>
          </div>
      </div>
  </div>

  <!-- Homework List Section -->
  <!-- Homework List Section -->
<div class="row mt-3">
  <div class="col-12">
      <div class="card shadow-sm">
          <div class="card-header bg-secondary text-white">
              <h3 class="card-title">Berilgan topshiriqlar</h3>
          </div>
          <div class="card-body">
              @if($homeworks->isEmpty())
                  <p class="text-center">Topshiriq mavjud emas!!!</p>
              @else
              <ul class="list-group">
                @foreach ($homeworks as $homework)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('homeworks.show', $homework->id) }}">
                            {{ $homework->title }}
                        </a>
                        <span class="badge badge-warning badge-pill">{{$homework->status}}</span>
                    </li>
                @endforeach
            </ul>
            
              @endif
          </div>
      </div>
  </div>
</div>
<!-- Students List Section -->
<div class="row mt-3">
  <div class="col-12">
      <div class="card shadow-sm">
          <div class="card-header bg-info text-white">
              <h3 class="card-title">O'quvchilar ro'yxati</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Ism va familiya</th>
                        <th>Maksimum ball</th>
                        <th>Ball</th>
                      </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="text-centr">
                        <td>{{$student->id}}</td>
                        <td>{{$student->surname.' '.$student->name }}</td>
                        <td>{{ $scoreMax }}</td>
                        <td>{{ $student->totalScore }}</td>
                    </tr>
                @endforeach
                </tfoot>
              </table>
            
          </div>
      </div>
  </div>
</div>
</div>
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
@endsection