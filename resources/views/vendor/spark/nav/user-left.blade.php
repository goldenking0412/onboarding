<!-- Left Side Of Navbar -->


@if(Auth::user()->type == 'admin')
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin.dashboard', ['status' => 'not_archived'])}}">Dashboard</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin.support')}}?status=Open">Support</a>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Knowledgebase</a>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="{{route('knowledgebase')}}">View Knowledgebase</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{route('new_article')}}">Add New Article</a>
      <a class="dropdown-item" href="{{route('new_category')}}">Add New Category</a>
    </div>
  </li>
@else
  <li class="nav-item">
    <a class="nav-link {{-- {{ (Route::current()->getName() == 'customer.dashboard') ? 'btn btn-outline-primary' : '' }} --}}" href="{{route('customer.dashboard')}}">Main</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('knowledgebase')}}">Knowledgebase</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('support')}}">Support</a>
  </li>
@endif
