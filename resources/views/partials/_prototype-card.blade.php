<div class="card">
    <div class="card-header">
          <span class="card-title">
            <h4 class="pt-3"><i class="fa fa-check-circle @if(!is_null($prototype) and !is_null($prototype->tracking_number)) text-success @else text-black-25 @endif"></i> Prototype</h4>
              @if(is_null($prototype) or !$prototype->is_complete)
                  <p class=""><small><i>Please upload photos or videos of your prototype so we can review it before you send it.</i></small></p>
              @endif
          </span>
        <p class="card-text">In order for LaunchBoom to take photos for the TestBoom program, we will need you to send us a photo-ready prototype and any additional assets needed for the full representation of the product and it's capabilities (app screen renders, monitor UI, etc). </p>
        <p class="card-text">Please understand that the prototype and assets you send us will be what we use to represent the product you wish to launch in our ads. We will not "adjust", "correct" or "tweak" your product digitally or physically to look anymore or less than what is provided to us.</p>
    </div>
    <div class="card-body">
        <p>
        <div class="progress" style="height: 23px;">
            <div class="progress-bar @if(is_null($prototype) or !$prototype->is_finished) bg-white text-black-25 @endif"
                 role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                 aria-valuemax="100">
                Uploaded Images
            </div>
            <div class="progress-bar @if(is_null($prototype) or !$prototype->is_complete) bg-white text-black-25 @endif"
                 role="progressbar" style="width: 25%" aria-valuenow="" aria-valuemin="0"
                 aria-valuemax="100">Prototype Accepted
            </div>
            <div class="progress-bar @if(is_null($prototype) or is_null($prototype->tracking_number)) bg-white text-black-25 @endif"
                 role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                 aria-valuemax="100">Prototype Shipped
            </div>
            <div class="progress-bar @if(is_null($prototype) or !$prototype->is_received) bg-white text-black-25 @endif"
                 role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                 aria-valuemax="100">Prototype Received
            </div>
        </div>
        </p>


        <div class="">
            @if(!is_null($prototype))
                @if($prototype->is_reviewed and !$prototype->is_complete)
                    <span class="btn btn-sm btn-outline-danger mb-4">
                      <i class="fa fa-times"></i> Prototype Needs Review or Changing on Your Side
                    </span>
                @endif
            @endif
            <div class="row">
                @if(is_null($prototype) or !$prototype->is_complete)
                    <div class="row col-md-6">
                        <form method="POST" enctype="multipart/form-data"
                              action="{{route('prototype.upload')}}" class="col-md-12">
                            {{csrf_field()}}

                            @if(is_null($prototype))
                                <div>
                                    <b>Choose type of assets you want to provide</b>
                                    <br>
                                    <input type="radio" id="prototypetype1" v-model="user.prototypetype" value="file">
                                    <label for="prototypetype1">Upload Files</label>
                                    <input type="radio" id="prototypetype2" v-model="user.prototypetype" value="link">
                                    <label for="prototypetype2">Link</label>
                                </div>
                            @endif
                            <div class="" v-if="user.prototypetype == 'file'">
                                <div class="custom-file col-md-9">

                                    <input type="file" class="custom-file-input" name="files[]"
                                           type="file" multiple id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose
                                        files</label>
                                </div>
                            </div>
                            <div v-if="user.prototypetype == 'link'">
                                <label for="link">Alternative link
                                    <small>(you can add a link to images instead of uploading
                                        images)
                                    </small>
                                </label>
                                <input class="form-control" type="text" name="link" value="{{$prototype->value or ''}}">
                            </div>
                            <input type="submit" v-if="user.prototypetype" class="btn btn-primary btn-sm mt-2 mb-4"
                                   value="Upload Prototype">

                        </form>
                    </div>
                    <div class="col-md-6">
                        @if(!empty($prototype->feedback))
                            <b>Feedback</b>: <span
                                    class="text-info">{{$prototype->feedback}}</span>
                        @endif

                    </div>
                @endif
                @if(!is_null($prototype))
                    @if($prototype->is_complete and is_null($prototype->tracking_number))
                        <div class="col-md-6">
                            <h5><span class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Prototype accepted!</span>
                            </h5>
                            <p><b>Please ship your prototype to:</b> <br>
                                @foreach(config('app.address') as $line)
                                    {{$line}}<br>
                                @endforeach
                            </p>
                        </div>
                        <div class="col-md-6">
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route('prototype.post-tracking')}}">
                                {{csrf_field()}}
                                <div class="form-group{{ $errors->has('tracking_number') ? ' has-error' : '' }}">
                                    <label for="tracking_number">Once you have shipped your
                                        package, please enter the tracking code.</label>
                                    <input type="text" name="tracking_number"
                                           placeholder="Tracking number" class="form-control"
                                           id="tracking_number"
                                           value="{{old('tracking_number', $prototype->tracking_number)}}">
                                    @if ($errors->has('tracking_number'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('tracking_number') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm"
                                       value="Submit">
                            </form>
                        </div>
                    @elseif(!is_null($prototype->tracking_number) and !$prototype->is_received)
                        <div>
                            <p>
                                Waiting for the prototype to arrive.
                            </p>
                            <p>
                                <a target="_blank" class="btn btn-success btn-sm"
                                   href="https://www.packagemapping.com/track/auto/{{$prototype->tracking_number}}">
                                    <i class="fa fa-truck"></i> Track package
                                </a>
                            </p>
                        </div>
                    @elseif($prototype->is_received)
                        <span class="btn btn-sm btn-outline-success"><i class="fa fa-check"></i> Prototype Received!</span>

                    @endif
                @endif
            </div>
        </div>
    </div>
</div>