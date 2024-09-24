@extends('layouts.teacher_app')
@section('title','ProEduCenter | Bosh sahifa')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Topshiriq</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
              <li class="breadcrumb-item"><a href="{{ route('lessons.show',['lesson'=>$homework->lesson->id]) }}">Dars ko'rish</a></li>
              <li class="breadcrumb-item active">Topshiriq</li>
            </ol>
          </div><!-- /.col -->
          
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Homework haqida umumiy ma'lumotlar -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>{{ $homework->title }}</h4>
            </div>
            <div class="card-body">
                <!-- Lesson ID -->
                <p><strong>Biriktirilgan mavzu:</strong> {{ $homework->lesson->title }}</p>
                
                <!-- Description -->
                <p><strong>Masala sharti:</strong> {{ $homework->description }}</p>

                <div class="form-group">
                    <label for="created_at"><strong>Yaratilgan vaqti:</strong></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" id="created_at" value="{{ $homework->created_at->format('d.m.Y') }}" disabled>
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                        <input type="text" class="form-control" value="{{ $homework->created_at->format('H:i') }}" disabled>
                    </div>
                </div>

                <!-- Due Date -->
                <div class="form-group">
                    <label for="created_at"><strong>Bajarish uchun oxirgi muddat:</strong></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" id="created_at" value="{{ \Carbon\Carbon::parse($homework->due_date)->format('d.m.Y') }}" disabled>
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($homework->due_date)->format('H:i') }}" disabled>
                    </div>
                </div>
                
                <!-- Score Max -->
                <p class="d-flex align-items-center">
                    <strong class="text-success fw-bold shadow-sm" style="margin-right: 10px;">Maksimal ball:</strong>
                    <span class="badge bg-success shadow" style="font-size: 1rem; padding: 8px;">
                        {{ $homework->score_max }}
                    </span>
                </p>
                
                <!-- Fayllar bo'limi -->
                @if($homework->files->count() > 0)
                <div class="mt-4">
                    <h5><strong>Yuklangan fayllar:</strong></h5>
                    <ul class="list-group">
                        @foreach($homework->files as $file)
                            <li class="list-group-item">
                                <a href="{{Storage::url($file->path)}}" target="_blank">{{ $file->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <p class="mt-4 text-muted">Hech qanday fayl yuklanmagan.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">O'quvchilar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr class="text-center">
                  <th>Ism va familiya</th>
                  <th>Ball</th>
                  <th>Ko'rish</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($students as $studentData)
                <tr>
                    @php
                        $student = $studentData['student'];
                        $answer = $studentData['answer'];
                    @endphp
                    @if ($answer)
                        <div class="modal fade" id="checking{{$answer->id}}">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Baholash</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('checking', ['id' => $answer->id]) }}" class="modal-body" method="POST">
                                    @csrf
                                    <b>Ball</b>
                                    <span>{{$answer->score}}</span>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <select id="score-select" name="score" class="form-control">
                                                @foreach (range(1, $answer->homework->score_max) as $score)
                                                    <option value="{{ $score }}">{{ $score }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary btn-block">Saqlash</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="modal-body">
                              <div class="card card-primary">
                                  <div class="card-body">
                                    @if ($answer->answer==null)
                                    <div class="form-group">
                                        <ul class="list-group">
                                            @foreach ($answer->files as $file)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{Storage::url($file->path)}}" target="_blank" class="text-info">
                                                        <i class="fas fa-file-alt"></i> {{ $file->name }}
                                                    </a>
                                                    <span class="badge badge-info badge-pill">File</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @else
                                    @if ($answer->homework->type=="python_code")
                                    <div class="container mt-4">
                                        <pre><code class="language-python">
                                            {{$answer->answer}}
                                            </code></pre>
                                    </div>
                                    @endif
                                    @if ($answer->homework->type=="php_code")
                                    <div class="container mt-4">
                                        <pre><code class="language-php">
                                            {{$answer->answer}}
                                            </code></pre>
                                    </div>
                                    @endif
                                    @if ($answer->homework->type=="java_code")
                                    <div class="container mt-4">
                                        <pre><code class="language-java">
                                            {{$answer->answer}}
                                            </code></pre>
                                    </div>
                                    @endif
                                    @if ($answer->homework->type=="csharp_code")
                                    <div class="container mt-4">
                                        <pre><code class="language-csharp">
                                            {{$answer->answer}}
                                            </code></pre>
                                    </div>
                                    @endif
                                    @if ($answer->type=="file_upload")
                                    <div class="container mt-4">
                                      @if($answer->files && count($answer->files) > 0)
                                        <ul class="list-group">
                                            @foreach($answer->files as $file)
                                                <li class="list-group-item">
                                                    <i class="fas fa-file"></i> 
                                                    <a href="{{Storage::url($file->path)}}" target="_blank" class="text-success">{{ $file->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                      @endif
                                    </div>
                                  @endif
                                    
                                    @endif
                                  </div>
                                  <!-- /.card-body -->
                              
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        </div>
                    @endif
                    <td>{{$student->surname}} {{$student->name}}</td>
                    <td>{{$studentData['answer']?$studentData['answer']->score:"Yuborilmagan"}}</td>
                    <td>
                        @if ($studentData['answer'])
                            @if ($studentData['answer']->score==null)
                                <button data-toggle="modal" data-target="#checking{{$answer->id}}" class="btn btn-block btn-success">Baholash</button>
                            @else
                                <button data-toggle="modal" data-target="#checking{{$answer->id}}" class="btn btn-block btn-warning">Tekshirilgan</button>
                            @endif
                        @else

                        @endif
                    </td>
                </tr>
                   
                @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>        
    </div>
</div>

@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">
   
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<script>hljs.highlightAll();</script>
<script>
    $(document).ready(function() {
        $('#score-search').on('input', function () {
            var searchValue = $(this).val().toLowerCase();
            $('#score-select option').each(function () {
                var text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(searchValue));
            });
        });
    });
</script>

@endsection