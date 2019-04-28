@extends('spark::layouts.app')

@section('content')
	<div class="row  justify-content-center">
		<div class="col-md-10">
	        <div class="card card-default">
	        	<div class="card-header">
	        		<div class="row">
	        			<div class="col-md-8">
	        				<h2>Conversations</h2>
	        			</div>
	        			<div class="col-md-4 text-right">
	        				<div class="dropdown">
	        				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        				    Filter Status
	        				  </button>
	        				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	        				    <a class="dropdown-item" href="{{route('admin.support')}}/">All</a>
	        				    <a class="dropdown-item" href="{{route('admin.support')}}/?status=Open">Open</a>
	        				    <a class="dropdown-item" href="{{route('admin.support')}}/?status=Closed">Closed</a>
	        				  </div>
	        				</div>
	        			</div>
	        		</div>
	        	</div>

	        	<div class="card-body">
	        		@if ($tickets->isEmpty())
						<p>There are currently no conversations.</p>
	        		@else
		        		<table class="table">
		        			<thead>
		        				<tr>
		        					<th>Project</th>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Last Updated</th>
									<th>Last Comment</th>
		        					<th style="text-align:center" colspan="2">Actions</th>
		        				</tr>
		        			</thead>
		        			<tbody>
		        			@foreach ($tickets as $ticket)
								<tr>
											<td>
												{{-- <a href="/admin/customers/{{ $ticket->user->id }}/show/">{{ $ticket->user->project_name }}</a> --}}
												<b><u><a href="/admin/customers/{{ $ticket->user_id }}/show/">{{ $ticket->user->project_name }}</a></u></b>
											</td>
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
		        					<td>{{ $ticket->updated_at->diffForHumans() }}</td>
									<td>
										@if(!empty($ticket->lastComment))
											{{$ticket->lastComment->created_at->diffForHumans() }}
										@else
											<span class="badge badge-secondary">No comments</span>
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

		        		{{ $tickets->render() }}
		        	@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection