@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header border-secondary border-bottom" style="border-radius: 0.25rem 0.25rem 0 0;">
                      <div class="row justify-content-center">
                        <h1 class="col-md-10">{{$category->name}}</h1>
                        <p class="col-md-2">
                          <a href="/admin/knowledgebase/category/{{$category->id}}/edit">Edit</a>
                        </p>
                      </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($category->articles as $article)
                            <li class="list-group-item pb-4 pt-4">
                                <a href="/knowledgebase/{{ $article->id }}">{{ $article->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                 </div>
             </div>
         </div>
     </div>
</home>
@endsection