@extends('layouts.teacher_app')
@section('title','ProEduCenter | Bosh sahifa')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Darsni ko'rish sahifasi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Bosh sahifa</a></li>
              <li class="breadcrumb-item"><a href="{{ route('lessons.show',['lesson'=>$lesson]) }}">Dars ko'rish</a></li>
              <li class="breadcrumb-item active">Topshiriq yaratish</li>
            </ol>
          </div><!-- /.col -->
          
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Topshiriq yaratish</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('homeworks.store')}}" role="form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="lesson_id" value="{{ $lesson }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Topshiriq nomi</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="description">Masala sharti</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                    <div class="input-group mb-2">
                        
                        <div class="custom-file">
                          <input type="file" name="files[]" id="files" class="custom-file-input" multiple>
                          <label class="custom-file-label" for="files">Fayl yoki fayllar jamlanmasini tanlang: (Agar zarur bo'lsa)</label>
                        </div>
                      </div>
                    <div class="form-group">
                        <label>Topshiriqni bajarishning oxirgi mudddati</label>
                        <div class="input-group date " id="reservationdatetime" data-target-input="nearest">
                            <input name="due_date" type="text" class="form-control datetimepicker-input " data-target="#reservationdatetime"/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanlang:</label>
                        <select name="type" class="form-control" style="width: 100%;">
                            <option selected="selected" value="">Tanlovni tanlang</option>
                            <option value="file_upload">File Yuklash</option>
                            <option value="php_code">PHP Kod Yozish</option>
                            <option value="python_code">Python Kod Yozish</option>
                            <option value="java_code">Java Kod Yozish</option>
                            <option value="csharp_code">C# Kod Yozish</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="score_max">Maksimal qo'yish mumkin bo'lgan ball</label>
                        <input id="score_max" class="form-control" type="number" name="score_max">
                    </div>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection