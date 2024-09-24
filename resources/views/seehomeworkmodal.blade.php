<div class="modal fade" id="seehomework{{$homework->id}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Topshiriq</h4>
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
      
                          <!-- Darsga biriktirilgan fayllar -->
                          @if($lesson->files && count($lesson->files) > 0)
                              <h5>Biriktirilgan fayllar</h5>
                              <ul class="list-group">
                                  @foreach($lesson->files as $file)
                                      <li class="list-group-item">
                                          <i class="fas fa-file"></i> 
                                          <a href="{{Storage::url($file->path)}}" target="_blank" class="text-primary">{{ basename($file->path) }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                          <p>{{ $lesson->description }}</p>

                      </div>
                      <div class="card-footer">
                          <span class="badge badge-info"><i class="fas fa-book"></i> Mavzu ma'lumotlari</span>
                      </div>
                  </div>
              </div>
      
              <!-- Homework card -->
              <div class="col-md-6">
                  <div class="card card-outline card-success shadow">
                      <div class="card-header">
                          <h3 class="card-title">{{ $homework->title }}</h3>
                      </div>
                      <div class="card-body">
                          <p>{{ $homework->description }}</p>
      
                          <!-- Due date va created_at ni kalendar va soat ikonkalari bilan chiqarish -->
                          <div class="mb-3">
                              <i class="fas fa-calendar-alt text-success"></i> 
                              <strong>Tugatilish muddati:</strong> 
                              <span class="badge badge-pill badge-secondary">{{ \Carbon\Carbon::createFromFormat('m/d/Y g:i A', $homework->due_date)->format('Y-m-d H:i') }}</span>
                          </div>
                          <div class="mb-3">
                              <i class="fas fa-calendar text-success"></i> 
                              <strong>Yaratilgan vaqti:</strong> 
                              <span class="badge badge-pill badge-secondary">{{ $homework->created_at->format('H:i - Y-m-d') }}</span>
                          </div>
      
                          <!-- Score max ni progress bar bilan chiqarish -->
                          <div class="mb-3">
                            <strong>Ball:</strong>
                        
                            @php
                                // Answerni olish va mavjudligini tekshirish
                                $userAnswer = $homework->answers->where('user_id', $userr->id)->first();
                                $currentScore = isset($userAnswer) ? $userAnswer->score : 0;
                                $maxScore = $homework->score_max;
                        
                                // Foiz hisoblash (aniq qiymat emas, progress bar uchun)
                                $percentage = ($maxScore > 0) ? ($currentScore / $maxScore) * 100 : 0;
                            @endphp
                        
                            <!-- Progress barni qalin va keng qilish uchun progress-lg sinfi qo'shildi -->
                            <div class="progress progress-lg mt-2">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
                                    style="width: {{ $percentage }}%;" aria-valuenow="{{ $currentScore }}" aria-valuemin="0" aria-valuemax="{{ $maxScore }}">
                                    {{ $currentScore }} / {{ $maxScore }}
                                </div>
                            </div>
                        </div>
                        
                        
      
                          <!-- Homework biriktirilgan fayllar -->
                          @if($homework->files && count($homework->files) > 0)
                              <h5>Homeworkga biriktirilgan fayllar</h5>
                              <ul class="list-group">
                                  @foreach($homework->files as $file)
                                      <li class="list-group-item">
                                          <i class="fas fa-file"></i> 
                                          <a href="{{Storage::url($file->path)}}" target="_blank" class="text-success">{{ $file->name }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          @endif
                      </div>
                      <div class="card-footer">
                          <span class="badge badge-success"><i class="fas fa-tasks"></i> Topshiriq ma'lumotlari</span>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-success shadow">
                  <div class="card-header">
                      <h3 class="card-title">Mening javobim</h3>
                  </div>
                  <div class="card-body">
                    @if ($userAnswer)
                      @if ($homework->type == "python_code")
                        <div class="container mt-4">
                          <pre><code class="language-python">{{ trim($userAnswer->answer) }}</code></pre>
                        </div>
                      @endif

                      @if ($homework->type=="php_code")
                        <div class="container mt-4">
                            <pre><code class="language-php">
                              {{$userAnswer->answer}}
                                </code></pre>
                        </div>
                      @endif
                      @if ($homework->type=="java_code")
                        <div class="container mt-4">
                            <pre><code class="language-java">
                              {{$userAnswer->answer}}
                                </code></pre>
                        </div>
                      @endif
                      @if ($homework->type=="csharp_code")
                        <div class="container mt-4">
                            <pre><code class="language-csharp">
                              {{$userAnswer->answer}}
                                </code></pre>
                        </div>
                      @endif
                      @if ($userAnswer->type=="file_upload")
                        <div class="container mt-4">
                          @if($userAnswer->files && count($userAnswer->files) > 0)
                            <h5>Homeworkga biriktirilgan fayllar</h5>
                            <ul class="list-group">
                                @foreach($userAnswer->files as $file)
                                    <li class="list-group-item">
                                        <i class="fas fa-file"></i> 
                                        <a href="{{Storage::url($file->path)}}" target="_blank" class="text-success">{{ $file->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                          @endif
                        </div>
                      @endif
                    @else
                    <p class="text-center">Siz bu topshiriq uchun javob yubormagansiz</p>
                    @endif
                  </div>
                  <div class="card-footer">
                      <span class="badge badge-success"><i class="fas fa-tasks"></i> Mening javobim</span>
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

