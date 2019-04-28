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
                        <div class="row justify-content-center">
                            <div class="col-md-8 ">
                                <form action="{{url('search')}}" method="POST" role="search" class="form-inline justify-content-center mb-4">
                                    {{ csrf_field() }}
                                    <div class="input-group col-md-6">
                                        <input type="text" class="form-control mb-2 mr-sm-2" name="q" placeholder="Search...">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Search Articles</button>
                                </form>
                            </div>
                        </div>
                        @if(isset($details))
                            <div class="row justify-content-center">
                                <div class="col-md-8 ">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h4> The Search results for <b> {{ $query }} </b>:</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                @foreach($details as $article)
                                                    <li><a href="/knowledgebase/{{$article->id}}"><u>{{$article->title}}</u></a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(isset($message))
                            <p>{{ $message }}</p>
                        @else
                            <div class="row">
                                @foreach ($allCategories as $category)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-header border-secondary border-bottom" style="border-radius: 0.25rem 0.25rem 0 0;">
                                                <h4 class="mt-2">{{$category->name}}</h4>
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
                                @endforeach
                            </div>
                        @endif
                    </div>
                 </div>
             </div>
         </div>
     </div>
</home>
@endsection
