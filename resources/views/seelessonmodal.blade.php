<div class="modal fade" id="seelesson{{$lesson->id}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mavzu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid mt-4">
          <div class="row">
              <!-- Lesson card -->
              <div class="col-md-6">
                  <div class="card card-outline card-primary shadow">
                      <div class="card-header">
                          <h3 class="card-title">{{ $lesson->title }}</h3>
                      </div>
                      <div class="card-body">
                          <p>{{ $lesson->description }}</p>
      
                          <!-- Darsga biriktirilgan fayllar -->
                          @if($lesson->files && count($lesson->files) > 0)
                              <h5>Biriktirilgan fayllar</h5>
                              <ul class="list-group">
                                  @foreach($lesson->files as $file)
                                      <li class="list-group-item">
                                          <i class="fas fa-file"></i> 
                                          <a href="{{ $file->path }}" target="_blank" class="text-primary">{{ basename($file->path) }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                      </div>
                      <div class="card-footer">
                          <span class="badge badge-info"><i class="fas fa-book"></i> Mavzu ma'lumotlari</span>
                      </div>
                  </div>
              </div>
          </div>
          
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiqish</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

