<div class="card">
    <div class="card-header">
          <span class="card-title">
           <h4 class="pt-3"><i class="fa fa-check-circle  @if(!is_null($assets) and $assets->is_finished) text-success @else text-black-25 @endif"></i> Assets</h4>
              @if(!is_null($assets))
                  @if(!$assets->is_reviewed)
                      <p>Your assets have been uploaded! Feel free to upload more, the assests you previously uploaded will not be overwritten.</p>
                  @else
                      @if($assets->is_complete)
                          <p>Your assets look great!</p>
                      @else
                          <p>Your assets are pending review. Feel free to upload more, the assests you previously uploaded will not be overwritten.</p>
                      @endif
                  @endif
              @else
                  <p class="mb-0"><small><i>We'll need your creative assets (photos, videos, graphics, etc.) to move forward with the campaign. </i></small></p> <p><small><i>If you already have a folder of all of all your assets on Dropbox or Google Drive you can share that URL in the Brand Messaging Questionarre <a href="/surveys/2/32/show"><u>here</u></a>.</i></small></p>
              @endif
          </span>
        <p>Please upload any product photos, logos, videos that you have. </p>
        <p>You may provide your own photo, video, creative and media assets to be used in the TestBoom program instead of sending a prototype and having LaunchBoom create them. Understand the quality and content of the assets may affect the TestBoom results. If you are creating your own assets, please provide professional-grade photos in high resolution JPEG or PNG with a horizontal orientation and allow room around the edges for cropping.</p>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                @if(!is_null($assets))
                    @if(!$assets->is_reviewed)
                        <p><span class="fa fa-check text-success"></span>Assets Uploaded</p>
                    @else
                        @if($assets->is_complete)
                            <h5>
                                      <span class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-check"></i> Assets Accepted
                                      </span>
                            </h5>
                        @else
                            <h5>
                                      <span class="btn btn-sm btn-outline-warning">
                                        <i class="fa fa-times"></i> Assets Need Review
                                      </span>
                            </h5>
                        @endif
                        <p><b>Feedback</b>: {{$assets->feedback}}</p>
                    @endif
                @endif

                <form method="POST" enctype="multipart/form-data" action="{{route('assets.upload')}}" class="">
                    @if(is_null($assets))
                        <div>
                            <b>Choose type of assets you want to provide</b>
                            <br>
                            <input type="radio" id="assettype1" v-model="user.assettype" value="file">
                            <label for="assettype1">Upload Files</label>
                            <input type="radio" id="assettype2" v-model="user.assettype" value="link">
                            <label for="assettype2">Link</label>
                        </div>
                    @endif
                    <br>
                    {{csrf_field()}}
                    <div class="" v-if="user.assettype == 'file'">
                        <div class="custom-file col-md-4">
                            <input type="file" class="custom-file-input"  name="files[]" type="file" multiple id="customFile">
                            <label class="custom-file-label" for="customFile">Choose files</label>
                        </div>
                    </div>
                    <div class="" v-if="user.assettype == 'link'">
                        <label for="link">Alternative link <small>(you can add a link to images instead of uploading images)</small></label>
                        <input class="form-control" type="text" name="link" value="{{$assets->value or ''}}">
                    </div>
                    <input v-if="user.assettype" type="submit" class="btn btn-primary btn-sm mt-2 mb-4" value="Upload Assets">
                </form>
            </div>
        </div>
    </div>
</div>