
<div class="card bg-white">
  <div class="card-body">

  <h5 class="card-title">{!! $question->question !!}</h5>
  <hr>
  @if(!is_null($question->user_answer))
  <p class="card-text white-space">{{$question->user_answer->value}}</p>

  @if($question->user_answer->is_complete)
    <button
            data-toggle="modal" data-target="#{{$question->id}}-modal"
            type="button"
            class="btn btn-sm btn-warning">
      Change Review
    </button>
    @else
    <button
            data-toggle="modal" data-target="#{{$question->id}}-modal"
            type="button"
            class="btn btn-sm btn-primary">
      Review
    </button>
    @endif

    @if(!$question->user_answer->is_reviewed)
      <form class="d-inline" method="POST" action="{{route('admin.review-answer', [$user, $question->user_answer])}}">
        {{csrf_field()}}
        <textarea style="display: none;" name="answer" id="answer">{{old('answer', $question->user_answer->value)}}</textarea>
        <input type="submit" class="btn btn-sm btn-success ml-1" name="is_complete" value="Mark Complete">
      </form>
      <small class="ml-1 text-muted">(Not Reviewed)</small>
    @else
      @if($question->user_answer->is_complete)
        <small class="text-success">(Answer Accepted)</small>
      @else
        <small class="text-danger">(Answer Rejected)</small>
      @endif
    @endif
  </div>
</div>

  <div class="modal fade" id="{{$question->id}}-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form method="POST" action="{{route('admin.review-answer', [$user, $question->user_answer])}}">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Review Question</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
              <label for="answer">Answer</label>
              <textarea class="form-control" name="answer" id="answer" cols="30" rows="10">{{old('answer', $question->user_answer->value)}}</textarea>
              @if ($errors->has('answer'))
                <span class="help-block">
                    <strong>{{ $errors->first('answer') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('feedback') ? ' has-error' : '' }}">
              <label for="feedback">Feedback</label>
              <textarea name="feedback" id="feedback" cols="30" rows="10" class="form-control">{{old('feedback',$question->user_answer->feedback)}}</textarea>
              @if ($errors->has('feedback'))
                <span class="help-block">
                    <strong>{{ $errors->first('feedback') }}</strong>
                </span>
              @endif
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-warning" name="is_complete" value="Mark Incomplete">
            <input type="submit" class="btn btn-success" name="is_complete" value="Mark Complete">
          </div>
        </div>
      </form>
    @endif
  </div>
</div>
