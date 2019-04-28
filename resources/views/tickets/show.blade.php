@extends('spark::layouts.app')

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
      <div class="card card-default">
      	<div class="card-header">
      		<div class="row justify-content-center">
            <div class="col-md-9">
              @if(Auth::user()->type == 'admin')
                <p class="mb-0"><a class="text-secondary" href="/admin/customers/{{ $ticket->user->id }}/show">{{ $ticket->user->project_name }}</a></p>
              @endif
              <h3><span class="text-primary">{{ $ticket->title }}</span></h3>
              <p>
              @if ($ticket->status === 'Open')
                Status: <span class="badge badge-success">{{ $ticket->status }}</span>
              @else
                Status: <span class="badge badge-danger">{{ $ticket->status }}</span>
              @endif
             </p>
            </div>
            <p class="col-md-3 text-right">Created: {{ $ticket->created_at->diffForHumans() }}</p>
          </div>
      	</div>
      	<div class="card-body">
      		@include('includes.flash')
      		<div class="ticket-info">
      			<p class="white-space">{{ $ticket->message }}</p>
      		</div>
      		<hr>
      		<div class="row justify-content-center">
            <div class="col-md-10 comments">
              @foreach ($comments as $comment)
                <div class="card @if($comment->user->type == 'admin') border border-success @endif">
                  <div class="card-header">
                    <div class="row justify-content-center">
                      <div class="col-md-9 @if($comment->user->type == 'admin') text-success @endif">
                        @if($comment->user->type == 'admin')
                        <img src="/img/mike.jpeg" class="img-fluid bdras-100 maw-50 mr-2">
                        @endif
                        {{ $comment->user->name }} - {{ $comment->user->project_name }}
                      </div>
                      <div class="col-md-3 text-right">{{ $comment->created_at->diffForHumans() }}</div>
                    </div>
                  </div>
            
                  <div class="card-body">
                    <div class="white-space">{{ $comment->comment }}</div>    
                  </div>
                </div>
              @endforeach
            

          		<div class="comment-form">
            		<form action="{{ url('comment') }}" method="POST" class="form">
            			{!! csrf_field() !!}

            			<input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            			<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                    <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>
                    @if ($errors->has('comment'))
                        <span class="help-block">
                            <strong>{{ $errors->first('comment') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Reply</button>
                  </div>
            		</form>
          	  </div>
            </div>
          </div>
      </div>
    </div>
	</div>
@endsection