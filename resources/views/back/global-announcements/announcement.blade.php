@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <style>

    </style>
    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row content-row">
        <div class="col-md-12">
            <div class="card dynamic-card">
                <div class="header card-header-static">
                    <h2>
                        <span>{{__("global-announcements.announcement-info")}} @isset($announcement) - {{ $announcement->name }} @endisset</span>
                    </h2>
                </div>

                <div class="body" data-status="0">
                    <form method="post" class="frmEditDocument" id="dynamic-form-validation" action="{{route("admin.global-announcements-store")}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @isset($announcement)
                            <input type="hidden" name="id" value="{{ $announcement->id }}">
                        @endisset
                        <div class="form-group">
                            <b>{{trans('global-announcements.name')}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="name" value="@isset($announcement) {{ $announcement->name }} @endisset">
                            </div>
                        </div>
                        <div class="form-group">
                            <b>{{trans('global-announcements.description')}}</b>
                            <div class="form-line">
                                <textarea class="form-control" id="description" name="description" rows="10">@isset($announcement) {{ $announcement->description }} @endisset</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                        <label>{{trans('global-announcements.documents')}}</label>
                            @if (isset($next_id))
                                @component('components.uploader', [
                                    'projectAddress' => $next_id,
                                    'sectionAddress' => 'ga',
                                    'positionAddress' => -1
                                ])@endcomponent
                                </div>
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description' ],
                                    'position'=>-1,
                                    'section'=>'ga',
                                    'project'=>$next_id
                                ])
                                @endcomponent
                            @elseif (isset($announcement))
                                @component('components.uploader', [
                                    'projectAddress' => $announcement->id,
                                    'sectionAddress' => 'ga',
                                    'positionAddress' => 0
                                ])@endcomponent
                                </div>
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description' ],
                                    'position'=>0,
                                    'section'=>'ga',
                                    'project'=>$announcement->id
                                ])
                                @endcomponent
                            @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/ckeditor/ckeditor.js') }}"></script>

    <script>

        CKEDITOR.replace( 'description' );

        $("#dynamic-form-validation").validate({

            /*onkeyup: false,*/
            rules: {
                'name':{
                    required: true
                },
                'description':{
                    required: true
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        }); //Validation end

    </script>

    @component('components.uploader-assets')
    @endcomponent

@endsection
