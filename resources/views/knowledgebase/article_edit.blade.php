@extends('spark::layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header text-center">
                      <h1>Edit Article</h1>
                    </div>
                    <div class="card-body">
                      <form method="POST" action="/admin/knowledgebase/{{ $article->id }}/edit">
                      {{ csrf_field() }}
                        <div class="form-group">
                          <label for="title">Title:</label>
                          <input type="text" class="form-control" name="title" value={{ $article->title }}>
                        </div>
                        <div class="form-group">
                          <textarea name="body" id="messageArea" class="form-control description" rows="10" cols="50">{{ $article->body }}</textarea>
                        </div>
                        <div class="form-group">
                          <label>Categories:</label>
                          <div class="row">
                            @foreach ($categories as $category)
                              <div class="col-md-4">
                                <label for="{{$category->id}}"><input type="checkbox" name="categories[]" value="{{$category->id}}" id="{{$category->id}}"
                                  @if (in_array($category->id, $category_ids))
                                  checked
                                  @endif 
                                > {{$category->name}}</label>
                              </div>
                              @endforeach
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
                    </div>
                 </div>
             </div>
         </div>
     </div>

@endsection
<script src="/vendor/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({ 
  selector:'textarea.description',
  statusbar: false,
  plugins: "code",
  theme_advanced_buttons1 : "code",
});

</script>