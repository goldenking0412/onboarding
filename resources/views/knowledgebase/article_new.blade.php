@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header text-center"><h1>Add New Article</h1></div>
                    <div class="card-body">
                      <form method="POST" action="/admin/knowledgebase/new">
                      {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                          <label for="title">Title</label>
                          <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}">
                          @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                          <label for="body">Body</label>
                          <textarea name="body" id="messageArea" class="form-control description" name="konten" rows="10" cols="50">{{old('body')}}</textarea>
                          @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                          @endif
                        </div>
                        <div class="form-group">
                          <label>Categories:</label>
                          <div class="row">
                            @forelse ($categories->sortBy('name') as $categories)
                            <div class="col-md-4">
                              <label for="{{$categories->id}}"><input type="checkbox" name="categories[]" value="{{$categories->id}}" id="{{$categories->id}}"> {{$categories->name}}</label>
                            </div>
                            @empty
                              <div class="col-md-6">
                                <p>You have no categories. <a href="{{url('admin/knowledgebase/category/new')}}" class="primary"> Add some here</a>.</p>
                              </div>
                            @endforelse
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                      </form>
                    </div>
                 </div>
             </div>
         </div>
     </div>
</home>
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