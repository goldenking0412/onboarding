@extends('spark::layouts.app')

@section('content')

    <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <div class="text-center">
                <h3>{{$survey->survey_name}}</h3>
              </div>
            </div>
            <div class="card-body">
              <p>
              <div class="progress">
                <div class="progress-bar" style="width: {{$progress}}%; min-width: 7%;" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">{{$progress}}%</div>
              </div>
              </p>
               <div class="row">
                  <div class="col-md-4">
                    <div class="card card-default">
                      @foreach($sections as $sectionName => $section)
                          <div class="card-header">
                            <h5 class="mb-0">{{$sectionName}}</h5>
                          </div>
                          <div class="card-body">
                            <ul class="mb-0 mt-2">
                              @foreach($section as $question)
                                @if(!empty($question->user_answer->value) and $question->user_answer->is_finished)
                                  <li class="mb-2">
                                    <s>
                                      <a href="{{route('surveys.showQuestion', [$survey, $question])}}">{{ str_limit(strip_tags($question->question), 35) }}</a>
                                    </s>
                                  </li>
                                @else
                                  <li class="mb-2">
                                    <a href="{{route('surveys.showQuestion', [$survey, $question])}}">{{ str_limit(strip_tags($question->question), 35) }}</a>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                          </div>
                      @endforeach
                    </div>
                  </div>
                 <div class="col-md-8">
                    @if(is_null($currentQuestion))
                      Thanks for answering all the questions, head back to  <a href="{{url('home')}}"><u>the dashboard</u></a>!
                    @else
                      @if(!is_null($currentQuestion->user_answer))
                        @if($currentQuestion->user_answer->feedback)
                          <div class="card bg-warning">
                            <div class="card-body">
                              <h4 class="card-title">Feedback</h4>
                              <hr>
                              <p class="">{{$currentQuestion->user_answer->feedback}}</p>
                            </div>
                          </div>
                        @endif
                      @endif
                      <form action="{{route('surveys.answer', ['survey' => $survey->id, 'question' => $currentQuestion->id])}}">
                        <div class="card card-default">
                          <div class="card-header">
                            <h4 class="card-title lh-15">{!! $currentQuestion->question !!}</h4>
                          </div>
                          <div class="card-body">
                           {{csrf_field()}}
                           <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                              @if($question->type == 'textarea')
                                <textarea name="value" id="value" cols="30" rows="10" class="form-control">{{old('value', isset($currentQuestion->user_answer) ? $currentQuestion->user_answer->value : '')}}</textarea>
                              @elseif($currentQuestion->type == 'text')
                                <input class="form-control" type="text" name="value" value="{{old('value', isset($currentQuestion->user_answer) ? $currentQuestion->user_answer->value : '')}}">
                              @endif
                              @if ($errors->has('value'))
                                <span class="help-block">
                                  <strong>{{ $errors->first('value') }}</strong>
                              </span>
                              @endif
                            </div>
                            <div class="text-right">
                              <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                            </div>
                          </div>
                        </div>
                     </form>
                     
                   @endif
                 </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection