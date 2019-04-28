@extends('spark::layouts.app')

@section('content')

  
  {{-- <home :user="user" inline-template> --}}
    <div class="container" id="app">
      {{-- frontent --}}
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card card-default">
              
            <div class="card-body">

                <table-draggable></table-draggable>

            </div>
          </div>
        </div>
      </div>
      {{-- backend --}}
      {{-- <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card card-default">
              
            <div class="card-body">

                @foreach($sections as $section)
                 <div class="card bg-white">
                   <div class="card-body">
                    @foreach($section->questions as $question)
                      <div class="card bg-white">
                        <div class="card-body">
                          {!! $question->question !!}
                        </div>
                      </div>
                    @endforeach
                   </div>
                 </div>
                @endforeach

            </div>
          </div>
        </div>
      </div> --}}
    </div>
  {{-- </home> --}}
@endsection