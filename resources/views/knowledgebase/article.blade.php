@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                      <div class="row justify-content-center">
                        <div class="col-md-10">
                          <h1>{{$article->title}}</h1>
                          <p>Last Updated: {{ Carbon\Carbon::parse($article->updated_at)->format('F d, Y') }}</p>
                        </div>
                        @if(Auth::user()->type == 'admin')
                        <p class="col-md-2">
                          <a href="/admin/knowledgebase/{{$article->id}}/edit">Edit</a>
                        </p>
                        @endif
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row justify-content-center">
                        <div class="col-md-8 normal-page">
                          {!! $article->body !!}
                        </div>
                      </div>
                      @if (!empty($associated_categories))
                        <p class="mb-0"><strong>Categories:</strong>
                          @foreach ($associated_categories as $category)
                            <a href="/knowledgebase/category/{{$category->id}}" class="btn btn-sm btn-outline-secondary ml-2 mr-2">{{$category->name}}</a>
                          @endforeach
                        </p>
                      @endif
                    </div>
                 </div>
             </div>
         </div>
     </div>
</home>
@endsection