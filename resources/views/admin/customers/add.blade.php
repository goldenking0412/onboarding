@extends('spark::layouts.app')

@section('content')

  <home :user="user" inline-template>
    <div class="container">
      <!-- Application Dashboard -->
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card card-default">
            <div class="card-header">
              <h2>Add Project</h2>
            </div>
            <div class="card-body">
              <form method="POST" action="{{route('admin.customer.store')}}">
                {{csrf_field()}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name">Customer Name</label>
                  <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('project_name') ? ' has-error' : '' }}">
                  <label for="name">Project Name</label>
                  <input type="text" name="project_name" class="form-control" id="project_name" value="{{old('project_name')}}">
                  @if ($errors->has('project_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('project_name') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}">
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}">
                  @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label for="password_confirmation">Password Confirmation</label>
                  <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="{{old('password_confirmation')}}">
                  @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                  @endif
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </home>
@endsection