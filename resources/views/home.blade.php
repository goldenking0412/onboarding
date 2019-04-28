@extends('spark::layouts.app')

@section('content')
  
  
  <div class="container">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('status'))
      @if(is_array(session('status')))
        <div class="alert alert-{{session('status')['type']}} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session('status')['text'] }}
        </div>
      @else
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session('status') }}
        </div>
      @endif
    @endif
  </div>


<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                  <div class="card-header">
                    <h4 class="pt-3">Hey {{$user->name}},</h4>
                    @if (empty($user->message))
                      <p>We are excited to start working with you! There are a few things that your Campaign Strategist needs to get going. If you have any questions feel free to chat with an Onboarding Specialist through the support channel. </p>
                    @else
                      <p class="text-info">{{ $user->message }}</p>
                    @endif
                  </div>
                  </div>
                    
                      @include('partials._prototype-card')
                      @include('partials._asset-card')
                      @foreach($surveys as $key => $survey)
                        @include('partials._survey-card', ['key' => $key, 'survey' => $survey, 'surveyProgress' => $surveyProgress])
                      @endforeach
                      
                      
                      @foreach(config('onboard.services') as $service)
                        @include('partials._service-card', ['service' => $service, 'user' => $user])
                      @endforeach
                    
                 </div>
                 <div class="col-md-4">
                    @include('partials._progress-sidebar')
                 </div>
             </div>

         </div>
     </div>
</home>
@endsection

