<div class="card">
    <div class="card-header">
        <span class="card-title">
         <h4 class="pt-3 pb-2"><i class="fa fa-check-circle @if($surveyProgress[$key]['is_completed']) text-success @else text-black-25 @endif "></i> {{$survey->first()->survey->survey_name}}</h4>
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="progress">
                    <div class="progress-bar" style="width: {{$surveyProgress[$key]['progress']}}%; min-width: 7%;" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                        {{$surveyProgress[$key]['progress']}}%
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                @if(!$surveyProgress[$key]['is_completed'] or !$surveyProgress[$key]['is_reviewed'] )
                    <a href="{{route('surveys.next', ['id' => $survey->first()->survey_id])}}" class="btn btn-primary">Go to questionnaire</a>
                @else
                    <span class="btn btn-sm btn-outline-success">Survey accepted <i class="fa fa-check"></i></span>
                @endif
            </div>
        </div>
    </div>
</div>