@extends('spark::layouts.app')

@section('title', 'Open Ticket')

@section('content')
	<div class="row justify-content-center">
		<div class="col-md-8">
	        <div class="card card-default">
	            <div class="card-header">
                    <h2>Open New Ticket</h2>
                </div>

	            <div class="card-body">
                    @include('includes.flash')

	                <div class="row justify-content-center">
                        <form class="form-horizontal col-md-6" role="form" method="POST" action="{{ url('/new-conversation') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="control-label">Title</label>

                                <div class="">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="control-label">Message</label>

                                <div class="">
                                    <textarea rows="10" id="message" class="form-control" name="message"></textarea>

                                    @if ($errors->has('message'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-ticket fa-commment"></i> Start Conversation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection