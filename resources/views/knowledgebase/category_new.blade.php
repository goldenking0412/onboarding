@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header text-center"><h1>Add New Category</h1></div>
                    <div class="card-body">
                      <form method="POST" action="/admin/knowledgebase/category/new">
                      {{ csrf_field() }}
                        <div class="form-group">
                          <label for="title">Name:</label>
                          <input type="text" class="form-control" name="name">
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