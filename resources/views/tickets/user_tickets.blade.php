@extends('spark::layouts.app')

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
			@include('includes.flash')
	        <div class="card card-default">
	        	<div class="card-header">
	        		<div class="row justify-content-center">
	        			<h2 class="col-md-8">Conversations</h2>
	        			<div class="col-md-4 text-right">
	        				<a href="{{route('new-conversation')}}" class="btn btn-success">Start a Conversation</a>
	        			</div>
	        		</div>
	        	</div>

	        	<div class="card-body">
	        		@if ($tickets->isEmpty())
						<p>You don't have any conversations yet. <a href="{{route('new-conversation')}}">Start One!</a></p>
	        		@else
		        		<table class="table">
		        			<thead>
		        				<tr>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Last Updated</th>
		        				</tr>
		        			</thead>
		        			<tbody>
		        			@foreach ($tickets as $ticket)
								<tr>
		        					<td>
		        						<a href="{{ url('support/'. $ticket->ticket_id) }}">
		        							{{ $ticket->title }}
		        						</a>
		        					</td>
		        					<td>
		        					@if ($ticket->status === 'Open')
		        						<span class="badge badge-success">{{ $ticket->status }}</span>
		        					@else
		        						<span class="badge badge-danger">{{ $ticket->status }}</span>
		        					@endif
		        					</td>
		        					<td>
		        						@if(!empty($ticket->lastComment))
		        							{{$ticket->lastComment->created_at->diffForHumans() }}
		        						@else
		        							{{ $ticket->updated_at->diffForHumans() }}
		        						@endif
		        					</td>
		        				</tr>
		        			@endforeach
		        			</tbody>
		        		</table>

		        		{{ $tickets->render() }}
	        		@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection