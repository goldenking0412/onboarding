@extends('spark::layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card card-default">
        <div class="card-header">
          <div class="pull-left">
            <div style="font-size: x-large;">{{ $user->project_name }}</div>
            <p class="mb-0">Onboarded: {{ date('M j, Y', strtotime($user->created_at)) }}</p>
            @if($user->is_archived)
              <p class="mb-0">Archived: {{ date('M j, Y', strtotime($user->archived_at)) }}</p>
            @endif
          </div>
          <div class="pull-right text-right">
            @if(!$user->is_archived)
              <a href="{{route('admin.customer.archive', $user->id)}}"  class="btn btn-danger" data-method="PUT" data-token="{{ csrf_token() }}">Archive</a>
            @endif
          </div>
        </div>
      </div>  
    </div>  
  </div>  
</div>
  <home :user="user" inline-template>
    
    <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">Questionnaires</span>
            </div>
            <div class="card-body">
              <table class="table">
                <tr>
                  <th>Survey</th>
                  <th style="width:50%">Progress</th>
                  <th colspan="2">Actions</th>
                </tr>
                @foreach($surveys as $key => $survey)
                <tr>
                  <td>
                    {{$survey->first()->survey->survey_name}}
                    @if($surveyProgress[$key]['is_reviewed'])
                      <small class="text-success">(reviewed)</small>
                    @endif
                  </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar" style="width: {{$surveyProgress[$key]['progress']}}%; min-width: 10%;" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">
                        {{$surveyProgress[$key]['progress']}}%
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($surveyProgress[$key]['is_reviewed'])
                      <a href="{{route('admin.customer.show-review', ['user' => $user->id, 'survey' => $key])}}" class="btn btn-warning btn-sm">Review again</a>
                    @else
                      <a href="{{route('admin.customer.show-review', ['user' => $user->id, 'survey' => $key])}}" class="btn btn-primary btn-sm">Review</a>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('admin.customer.export', ['user' => $user->id, 'survey' => $key])}}" class="btn btn-outline-secondary btn-sm">Export</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </home>

  <div class="container">
    <!-- Application Dashboard -->
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <span class="card-title">Assets</span>
          </div>
          <div class="card-body">
            <p>
              @if(isset($assets->folder))
                {{-- @if($assets->folder == 'link') --}}
                  {{-- <a href="{{ $assets->value }}">Link to assets</a> --}}
                {{-- @else --}}
                  <a target="_blank" href="https://drive.google.com/drive/folders/{{$assets->folder}}">
                    <i class="fa fa-folder-open"></i>
                    Assets Folder
                  </a>
                {{-- @endif --}}
              @elseif(isset($assets->value))
                    Link: <a href="{{$assets->value}}">{{$assets->value}}</a>
              @endif
            </p>

            @if(!is_null($assets))
              @if(!$assets->is_reviewed)
                <button
                        data-toggle="modal" data-target="#assets-modal"
                        type="button"
                        class="btn btn-sm btn-primary">
                  Review
                </button>
              @else
                <button
                        data-toggle="modal" data-target="#assets-modal"
                        type="button"
                        class="btn btn-sm btn-warning">
                  Change Review
                </button>
              @endif
              @if($assets->is_complete)
                  <span class="btn btn-sm btn-outline-success">
                      <i class="fa fa-check"></i>
                      Assets Mark Complete
                  </span>
              @endif
            @else
              Assets not uploaded yet.
              <button
                      data-toggle="modal" data-target="#assets-modal"
                      type="button"
                      class="btn btn-sm btn-primary">
                  Review
              </button>
            @endif

              <div class="modal fade" id="assets-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <form method="POST" action="{{route('admin.review-assets', [$user, $assets])}}">
                    {{csrf_field()}}
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group{{ $errors->has('feedback') ? ' has-error' : '' }}">
                          <textarea name="feedback" id="feedback" cols="30" rows="10" class="form-control">{{old('feedback',isset($assets->feedback)?$assets->feedback:'')}}</textarea>
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
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <!-- Application Dashboard -->
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <span class="card-title">Prototype</span>
          </div>
          <div class="card-body">
            <p>
              @if(isset($prototype->folder))
                <a target="_blank" href="https://drive.google.com/drive/folders/{{$prototype->folder}}">
                  <i class="fa fa-camera"></i>
                  Prototype Folder
                </a>
                @elseif(isset($prototype->value))
                   Link: <a href="{{$prototype->value}}">{{$prototype->value}}</a>
                @endif
            </p>

            @if(!is_null($prototype))
              @if(!$prototype->is_reviewed)
                <button
                        data-toggle="modal" data-target="#prototype-modal"
                        type="button"
                        class="btn btn-sm btn-primary">
                  Review
                </button>
              @elseif(!is_null($prototype->tracking_number) and !$prototype->is_received)
                <a target="_blank" class="btn btn-success btn-sm" href="https://www.packagemapping.com/track/auto/{{$prototype->tracking_number}}">
                  <i class="fa fa-truck"></i> Track Package
                </a>
                <p>
                <form method="POST" action="{{route('admin.prototype-received', [$user, $prototype])}}">
                  {{csrf_field()}}
                  <input type="submit" value="Mark as Received" class="btn btn-primary btn-sm">
                </form>
                </p>
              @elseif($prototype->is_received)
                <h5>
                  <span class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Prototype Received</span>
                </h5>
              @endif
            @endif

            @if(!is_null($prototype) and !$prototype->is_reviewed)

            @elseif(is_null($prototype))
              Prototype not uploaded yet.
              <button
                      data-toggle="modal" data-target="#prototype-modal"
                      type="button"
                      class="btn btn-sm btn-primary">
                  Review
              </button>
            @elseif($prototype->is_reviewed and !$prototype->is_complete)
              <span class="btn btn-sm btn-outline-danger">
                <i class="fa fa-times"></i> Prototype Declined
              </span>
            @endif
              <a
                 href="{{route('admin.complete-prototype', $user->id)}}"
                 data-token="{{csrf_token()}}"
                 data-confirm="Are you sure, you want to mark prototype complete and recieved?"
                 data-method="PUT"
                 class="btn btn-sm btn-outline-dark"
              >
                  Mark Everything Complete
              </a>

              <div class="modal fade" id="prototype-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                      <form method="POST" action="{{route('admin.review-prototype', [$user, $prototype])}}">
                          {{csrf_field()}}
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group{{ $errors->has('feedback') ? ' has-error' : '' }}">
                                      <textarea name="feedback" id="feedback" cols="30" rows="10" class="form-control">{{old('feedback',isset($prototype->feedback)?$prototype->feedback:'')}}</textarea>
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
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @foreach(config('onboard.services') as $service)
    <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">{{ucfirst($service['name'])}}</span>
            </div>
            <div class="card-body">
              @if(is_null($services->where('type', $service['name'])->first()))
                <span class="btn btn-sm btn-outline-secondary">Not Connected</span>
              @elseif(!$services->where('type', $service['name'])->first()->is_reviewed)
                <form action="{{route('service.connected', [$user])}}" method="POST">
                  {{csrf_field()}}
                  <input type="hidden" name="service" value="{{$service['name']}}">
                  <input type="submit" name="is_complete" value="Mark Correct" class="btn btn-sm btn-success">
                  <input type="submit" name="is_complete" value="Mark Incorrect" class="btn btn-sm btn-danger">
                </form>
              @elseif(!$services->where('type', $service['name'])->first()->is_complete)
                <span class="btn btn-sm btn-outline-danger">Declined</span>
              @else
                <span class="btn btn-sm btn-outline-success">Approved</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">Send {{ $user->name }} a Message</span>
            </div>
            <div class="card-body">
              <form class="form-horizontal col-md-8" role="form" method="POST" action="{{ route('send.message', $user) }}">
                  {!! csrf_field() !!}
              
                  <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                      <label for="message" class="control-label">Message</label>
              
                      <div class="">
                          <textarea rows="4" id="message" class="form-control" name="message">{{ $user->message }}</textarea>
              
                          @if ($errors->has('message'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('message') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
              
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-btn fa-ticket"></i> Send Message
                    </button>
                  </div>
              </form>
            </div>
          </div>
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">Conversations</span>
            </div>

            <div class="card-body">
              @if ($tickets->isEmpty())
            <p>There are currently no conversations.</p>
              @else
                <table class="table">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Status</th>
                      <th>Last Updated</th>
                      <th style="text-align:center" colspan="2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($tickets as $ticket)
                <tr>
                      <td>
                        <a href="{{ url('support/'. $ticket->ticket_id) }}">
                          <u>{{ $ticket->title }}</u>
                        </a>
                      </td>
                      <td>
                        <h5>
                          @if ($ticket->status === 'Open')
                            <span class="btn btn-sm btn-outline-success">{{ $ticket->status }}</span>
                          @else
                            <span class="btn btn-sm btn-outline-danger">{{ $ticket->status }}</span>
                          @endif
                        </h5>
                      </td>
                      <td>
                        @if(!empty($ticket->lastComment))
                          {{$ticket->lastComment->created_at->diffForHumans() }}
                        @else
                        {{ $ticket->updated_at->diffForHumans() }}
                        @endif
                      </td>
                      <td>
                        <a href="{{ url('support/' . $ticket->ticket_id) }}" class="btn btn-primary">Comment</a>
                      </td>
                      <td>
                        <form action="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" method="POST">
                          {!! csrf_field() !!}
                          <button type="submit" class="btn btn-danger">Close</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              @endif
            </div>
          </div>
      </div>
    </div>
  </div>
  <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card card-default">
            <div class="card-header">
              <span class="card-title">Customer Info</span>
            </div>
            <div class="card-body">
              <p><strong>Name:</strong> {{ $user->name }}</p>
              <p><strong>Email:</strong> {{ $user->email }}</p>
              <p><strong>Last Active:</strong> @if(isset($user->last_login_at)) {{ $user->last_login_at->diffForHumans() }} @endif</p>
              <p><strong>Admin Notes</strong></p>
              <form class="form-horizontal col-md-8" role="form" method="POST" action="{{ route('add.admin_notes', $user) }}">
                  {!! csrf_field() !!}
              
                  <div class="form-group{{ $errors->has('admin_notes') ? ' has-error' : '' }}">              
                      <div class="">
                          <textarea rows="4" id="admin_notes" class="form-control" name="admin_notes">{{ $user->admin_notes }}</textarea>
              
                          @if ($errors->has('admin_notes'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('admin_notes') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
              
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-btn fa-note"></i> Add Note
                    </button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection