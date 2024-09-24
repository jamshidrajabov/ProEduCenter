@extends('layouts.student_app')
@section('title','ProEduSystem | Mavzu')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Mavzuni ko'rish</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Mavzuni ko'rish</li>
              </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')

<div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lesson->title }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $lesson->description }}</p>
                        <p class="card-text">
                            <i class="far fa-calendar-alt"></i>
                            <span class="ml-2">{{ $lesson->created_at->format('d-m-Y H:i') }}</span>
                        </p>
                        @if($lesson->files && count($lesson->files) > 0)
                              <h5>Biriktirilgan fayllar</h5>
                              <ul class="list-group">
                                  @foreach($lesson->files as $file)
                                      <li class="list-group-item">
                                          <i class="fas fa-file"></i> 
                                          <a href="{{Storage::url($file->path)}}" target="_blank" class="text-primary">{{ basename($file->name) }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                    </div>
                </div>
            </div>
    
            <!-- Vazifalar jadvali -->
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="card-title">Vazifalar</h4>
                    </div>
                    <div class="card-body">
                        @if($homeworks->isEmpty())
                            <p class="text-center">Hozirda vazifalar mavjud emas.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Nomi</th>
                                            <th>Berilgan vaqt</th>
                                            <th>Oxirgi sana va vaqt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($homeworks as $homework)
                                            @if ($homework->lesson->course->status=='completed')
                                                @include('seehomeworkmodal')
                                                <tr style="cursor: pointer" data-toggle="modal" data-target="#seehomework{{$homework->id}}" data-homework-id="{{ $homework->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $homework->title }}</td>
                                                    <td>{{ $homework->created_at->format('d-m-Y H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date)->format('Y-m-d H:i') }}</td>

                                                </tr>
                                            @else
                                                @include('sendhomeworkmodal')
                                                <tr style="cursor: pointer" data-toggle="modal" data-target="#sendhomework{{$homework->id}}" data-homework-id="{{ $homework->id }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $homework->title }}</td>
                                                    <td>{{ $homework->created_at->format('d-m-Y H:i') }}</td>
                                                    <td>{{ \Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date)->format('Y-m-d H:i') }}</td>

                                                </tr>
                                            @endif
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
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