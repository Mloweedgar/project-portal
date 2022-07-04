@if(Auth::user()->isAdmin() || (Auth::user()->isIT() && $sectionAddress == 'logo'))

    <div class="fine-uploader"
         data-project="{{$projectAddress}}"
         data-section="{{$sectionAddress}}"
         data-position="{{$positionAddress}}"
    ></div>

@elseif(Auth::user()->isProjectCoordinator() || Auth::user()->isDataEntry())

    @php
        $uploadedFiles = \App\Models\Media::where('project', $projectAddress)
                ->where('section', $sectionAddress)
                ->where('position', $positionAddress)
                ->get();
    @endphp

    <div class="row">
        @foreach($uploadedFiles as $file)
            <div class="col-md-3">
                <div class="info-box custom-info-box">
                    <div class="icon bg-blue">
                        <a href="{{route("application.media", ["id" => $file->id])}}" target="_blank"><i class="material-icons">file_download</i></a>
                    </div>
                    <div class="icon">
                        <span class="input-group-addon">
                            <input name="files_to_delete[]" value="{{$file->id}}" type="checkbox" class="filled-in chk-col-red" id="ig_checkbox{{$file->id}}">
                            <label for="ig_checkbox{{$file->id}}"></label>
                        </span>
                    </div>
                    <div class="content">
                        <div class="text">{{$file->created_at}}</div>
                        <div class="number">{{$file->old_name}}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="fine-uploader"
         data-project="{{$projectAddress}}"
         data-section="{{$sectionAddress}}"
         data-position="{{$positionAddress}}"
    ></div>

@endif

@if (isset($hidden))

    <div class="fake-uploader hidden">
        <div class="qq-drop-text ">

            <i class="material-icons">file_upload</i>
            <p>Click or drop picture here</p>
        </div>
    </div>

@endif