<div class="card sticky-top">
  <div class="card-header p-1 pl-4 pr-4">
     <div class="row">
         <div class="col-sm-5">
             <h4 class="card-title pt-3 pb-2">Progress</h4>
         </div>
         <div class="col-sm-7 text-right">
             <h3 class="card-title text-lb-yellow pt-3 mb-0 h3-important"><b>{{$leftSections}}</b></h3> 
             <p>STEPS LEFT</p>
         </div>
     </div>
    <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
          <small class="pl-2 pr-2">{{ $completedSections }} of {{ $totalSections }} Complete</small>
      </div>
    </div>
  </div>
  <div class="card-body pt-3 pb-2">
    <div class="lead--small">
      <div class="pl-4">
        <p class="mb-2 @if(!is_null($prototype) and !is_null($prototype->tracking_number)) @else text-black-25 @endif
        "><i class=" pr-2 fa fa-check-circle 
          @if(!is_null($prototype) and !is_null($prototype->tracking_number))
            text-success
          @else
            text-black-25
          @endif "></i>
          1. Prototype
        </p>
        <p class="mb-2  @if(!is_null($assets) and $assets->is_finished) @else text-black-25 @endif 
          "><i class=" pr-2 fa fa-check-circle 
          @if(!is_null($assets) and $assets->is_finished)
            text-success
          @else
            text-black-25
          @endif "></i>
            2. Assets
        </p>

        @foreach($surveys as $key => $survey)
        <p class="mb-2 @if($surveyProgress[$key]['is_completed']) @else text-black-25 @endif
        ">
          <i class=" pr-2 fa fa-check-circle @if($surveyProgress[$key]['is_completed'])
             text-success
          @else
             text-black-25
          @endif"></i> {{ $i++ }}. {{ $survey->first()->survey->survey_name}}
          
        </p>
        
        @endforeach
                                   
        @foreach(config('onboard.services') as $service)
          @include('partials._sidebar-service-status', ['answer' => $services->where('type', $service['name'])->first(), 'i' => $i++])
        @endforeach
      </div>
    </div>
    <div class="sidebar-contact-wrap">
      <hr>
      <div class="row pt-2">
        <div class="col-md-3">
          <img src="{{asset('img/mike.jpeg')}}" class="img-fluid bdras-100">
          <p class="text-center smaller pt-2"><em>Mike</em></p>
        </div>
        <div class="col-md-9">
          <p class="mb-0"><b>Need help? </b></p>
          <p class="smaller mt-0">I am here to answer your questions.</p>
          <a href="{{url('support')}}" class="btn btn-outline-primary">Ask a Question</a>
        </div>
      </div>
    </div>
  </div>