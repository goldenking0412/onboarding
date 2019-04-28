<div class="card">
    <div class="card-header">
      <span class="card-title">
       <h4 class="pt-3"><i class="fa fa-check-circle @if(is_null($services->where('type', $service['name'])->where('user_id', $user->id)->first())) text-black-25 @else text-success @endif"></i> {{ucfirst($service['name'])}} Account Setup</h4>

       <p class=""><small><i>{{ucfirst($service['description'])}}</i></small></p>
      </span>
    </div>
    <div class="card-body">
        <div class="row mt-3 mb-4">
            <div class="col-md-4 text-center">
                <p>Follow these steps to setup {{ucfirst($service['name'])}}</p>
                <a target="_blank" href="{{ucfirst($service['link'])}}" class="btn btn-primary btn-outline-primary">View {{ucfirst($service['name'])}} Account Instructions</a>
            </div>
            <div class="col-md-4 text-center">
                <p>Go to {{ucfirst($service['name'])}} to login or create an account.</p>
                <a target="_blank" href="{{ucfirst($service['register-url'])}}" class="btn btn-primary btn-outline-primary">Go to {{ucfirst($service['name'])}}</a>
            </div>
            <div class="col-md-4 text-center">
                <p>Invite LaunchBoom to manage your account</p>
                @if(is_null($services->where('type', $service['name'])->first()) or !$services->where('type', $service['name'])->first()->is_finished)
                    <form method="POST" action="{{route('services.mark-connected')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="service" value="{{$service['name']}}">
                        <button type="submit" class="btn btn-primary btn-outline-primary">
                            Mark as Connected
                        </button>
                    </form>
                @elseif(!$services->where('type', $service['name'])->first()->is_reviewed)
                    <span class="btn btn-outline-primary">
                        <i class="fa fa-check"></i> Pending Review
                      </span>
                @else
                    <span class="btn btn-outline-primary">
                        <i class="fa fa-check"></i> Approved
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>