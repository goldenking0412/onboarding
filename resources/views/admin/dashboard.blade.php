@extends('spark::layouts.app')

@section('content')
  <home :user="user" inline-template>
    <div class="container container-wide">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <div class="row">
                <div class="col-md-8">
                  <h2>Dashboard</h2>
                </div>
                <div class="col-md-4 text-right">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Filter Status
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('admin.dashboard')}}/">All</a>
                      <a class="dropdown-item" href="{{route('admin.dashboard', ['status' => 'not_archived'])}}">In Progress</a>
                      <a class="dropdown-item" href="{{route('admin.dashboard', ['status' => 'archived'])}}">Complete</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <table class="table table-striped table-responsive">
                <tr>
                  <th scope="col">Project</th>
                  {{-- @foreach($surveys as $survey) --}}
                    <th scope="col">Key Info</th>
                    <th scope="col">Branding</th>
                  {{-- @endforeach --}}
                  <th scope="col">Assets</th>
                  <th scope="col">Prototype</th>
                  @foreach(config('onboard.services') as $service)
                    <th scope="col">{{ucfirst($service['name'])}}</th>
                  @endforeach
                  <th>Onboarded</th>
                </tr>
                @foreach($users as $user)
                  <tr>
                    <td scope="row">
                      <a href="{{route('admin.customer.show', $user)}}">
                        {{$user->project_name}}
                      </a>
                    </td>
                    @foreach($surveys as $survey)
                      <td>
                        <i class="fa fa-{{$surveyResults[$user->id][$survey->id] ? 'check text-success' : 'times text-danger'}}"></i>
                      </td>
                    @endforeach
                    <td>
                      <p>
                        @if(!is_null($user->assets))
                          @if($user->assets->is_reviewed)
                            @if($user->assets->is_complete)
                              <span class="btn btn-sm btn-outline-success">Approved</span>
                            @else
                              <span class="btn btn-sm btn-outline-danger">Declined</span>
                            @endif
                          @else
                            <span class="btn btn-sm btn-outline-info">Needs Review</span>
                          @endif
                        @else
                          <span class="btn btn-sm btn-outline-secondary">Not Uploaded</span>
                        @endif
                      </p>
                    </td>
                    <td>
                      <p>
                        @if(!is_null($user->prototype))
                          @if(!$user->prototype->is_reviewed)
                            <span class="btn btn-sm btn-outline-info">Needs Review</span>

                            @elseif($user->prototype->is_reviewed and !$user->prototype->is_complete)
                            <span class="btn btn-sm btn-outline-danger">Declined</span>
                            @elseif($user->prototype->is_reviewed and is_null($user->prototype->tracking_number))
                            <span class="btn btn-sm btn-outline-primary">Waiting shipment</span>
                            @elseif(!is_null($user->prototype->tracking_number) and !$user->prototype->is_received)
                            <span class="btn btn-sm btn-outline-success">Shipped</span>
                            @elseif($user->prototype->is_received)
                            <span class="btn btn-sm btn-outline-success">Received</span>
                            @endif
                        @else
                          <span class="btn btn-sm btn-outline-secondary">Not Uploaded</span>
                        @endif
                      </p>
                    </td>
                    @foreach(config('onboard.services') as $service)
                      <td>
                        @if(is_null($services->where('type', $service['name'])->where('user_id', $user->id)->first()))
                          <span class="btn btn-sm btn-outline-secondary">Not Connected</span>
                        @elseif(!$services->where('type', $service['name'])->where('user_id', $user->id)->first()->is_reviewed)
                          <span class="btn btn-sm btn-outline-info">Needs Review</span>
                        @elseif(!$services->where('type', $service['name'])->where('user_id', $user->id)->first()->is_complete)
                          <span class="btn btn-sm btn-outline-danger">Declined</span>
                        @else
                          <span class="btn btn-sm btn-outline-success">Approved</span>
                        @endif
                      </td>
                    @endforeach
                      <td>{{ date('M j', strtotime($user->created_at)) }}</td>
                  </tr>
                @endforeach
              </table>
              {{ $users->render() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </home>
@endsection
