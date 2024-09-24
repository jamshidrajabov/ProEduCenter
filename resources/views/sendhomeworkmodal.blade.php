  <div class="modal fade" id="sendhomework{{ $homework->id }}" tabindex="-1" aria-labelledby="sendhomeworkLabel{{ $homework->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Topshiriqni bajarish</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                            <h5>Darsga biriktirilgan fayllar</h5>
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
                            <span class="badge badge-pill badge-secondary">{{ $homework->created_at->format('Y-m-d H:i') }}</span>
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
                    <h3 class="card-title">Javob yuborish</h3>
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
                    @if ($homework->type=="file_upload")
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
                  <div class="container mt-4">
                    <!-- Answer form -->
                    @if (now()->lessThan($homework->due_date))
<form method="POST" action="{{ route('answers.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="homework_id" value="{{ $homework->id }}">

    @if (in_array($homework->type, ['python_code', 'php_code', 'java_code', 'csharp_code']))
        <div class="form-group">
            <label for="codeAnswer">
                @if ($homework->type == 'python_code') Python kod
                @elseif ($homework->type == 'php_code') PHP kod
                @elseif ($homework->type == 'java_code') Java kod
                @elseif ($homework->type == 'csharp_code') C# kod
                @endif
            </label>
            <div id="codeMirror_{{ $homework->id }}" style="height: 400px; border: 1px solid #ccc; border-radius: 4px;"></div>
            <textarea id="codeAnswer_{{ $homework->id }}" name="answer" style="display: none;">{{ $userAnswer->answer ?? '' }}</textarea>
        </div>
    @elseif ($homework->type == 'file_upload')
        <div class="custom-file">
            <input type="file" name="files[]" id="files" class="custom-file-input" multiple>
            <label class="custom-file-label" for="files">Fayl yoki fayllar jamlanmasini tanlang:</label>
        </div>
    @endif

    <button type="submit" class="btn btn-primary">Saqlash</button>
</form>
@else
<p class="text-center">Topshiriqni bajarish uchun sizda vaqt qolmadi!!!</p>
@endif

                  </div>
                
              
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
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/clike/clike.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/csharp/csharp.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const codeMirrorElements = document.querySelectorAll('[id^="codeMirror_"]');
      
      codeMirrorElements.forEach(function(el) {
        const homeworkId = el.id.split('_')[1]; // homework id ni ajratib olamiz
        const codeMirrorInstance = CodeMirror(document.getElementById("codeMirror_" + homeworkId), {
          lineNumbers: true,
          mode: "{{ $homework->type === 'python_code' ? 'python' : ($homework->type === 'php_code' ? 'application/x-httpd-php' : ($homework->type === 'java_code' ? 'text/x-java' : 'text/x-csharp')) }}",
          value: document.getElementById("codeAnswer_" + homeworkId).value,
          theme: "default", 
          extraKeys: {"Ctrl-Space": "autocomplete"},
          lineWrapping: true
        });

        codeMirrorInstance.on("change", function() {
          document.getElementById("codeAnswer_" + homeworkId).value = codeMirrorInstance.getValue();
        });
      });
    });
  </script>
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

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">

<style>
  
.CodeMirror {
    border: 1px solid #ccc;
    height: 400px;
    font}  
</style>


@endsection