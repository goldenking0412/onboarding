@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header text-center">
                      <h1>Knowledgebase</h1>
                    </div>
                    <div class="card-body">
                      @foreach ($articles as $article)
                            <h4><a href="/knowledgebase/{{$article->id}}/">{{$article->title}}</a></h4>
                            <p>{{ strip_tags(Str::words($article->body,10)) }}</p>
                      @endforeach
                    </div>
                 </div>
             </div>
         </div>
     </div>
</home>
@endsection