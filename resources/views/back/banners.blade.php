@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/website-management/general.css') }}" rel="stylesheet">

@endsection

@section('content')

    @component('back/components.fine-upload-template-1')
    @endcomponent


    <div class="container-fluid">
        <h1 class="content-title">{{__("menu.banners")}}</h1>

        @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
            <div class="section-information">
                <a href="{{ route('documentation').'#banners' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
            </div>
        @endif

        <div class="row content-row">
            <div class="col-md-12">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    {{__("banners.recomended-size")}}
                </div>
            </div>
        </div>

        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("banners.banner-add-new")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                    </div>
                    <div id="card-body" class="body @if (count($errors) > 0 || (isset($flag))) is-visible @else not-visible @endif card-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (!empty($flag))
                            <div class="alert alert-danger">
                                Message: {{ $flag["message"] }}
                            </div>
                        @endif

                        <form id="dynamic-form-validation" action="{{route("banners/store")}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <b>{{__("banners.banner-form-title")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="switch m-t-20">
                              <b>{{ __('general.active') }}</b>
                              <div class="m-t-20">
                            <label><input name="active" type="checkbox" value="1">
                                <span class="lever switch-col-blue"></span></label>
                              </div>
                            </div>

                            <div class="form-group">

                                <b>{{__("banners.banner-form-description")}}</b>
                                <div class="form-line">
                                    <textarea rows="3" class="form-control no-resize" name="description" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("banners.banner-form-url")}}</b>
                                <div class="form-line">
                                    <input type="url" class="form-control" name="url" required>
                                </div>
                            </div>
                            @component('components.uploader', [
                                'projectAddress' => 0,
                                'sectionAddress' => 'b',
                                'positionAddress' => -1
                            ])@endcomponent
                            <a id="upload-button" class="btn btn-large btn-primary waves-effect">{{__('general.save')}}</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        @if(count($banners) > 0)

        @foreach($banners as $banner)

        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <div class="row">
                      <div class="col-md-3">
                        <img src="{{ route('uploader.b', array('position' => $banner->id)) }}" class="img-responsive preview-image">
                      </div>
                      <div class="col-md-7">
                        <h2>{{$banner->name}}</h2>
                        </div>
                        <div class="col-md-2 align-right  font-18">
                          <span class="switch">
                          <label><input class="active-button" name="active" type="checkbox" value="1"
                                        {{ $banner->active ? "checked" : "" }}  data-id={{ $banner->id }}>
                              <span class="lever switch-col-blue"></span></label>
                            </span>
                          <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$banner->id}}"></i>
                    </div>
                        </div>
                  </div>
                    <!-- TODO : put requires -->
                    <div class="body not-visible" data-status="0">
                        <form method="post" action="{{route("banners/edit")}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$banner->id}}">
                        <div class="form-group">
                            <b>{{__("banners.banner-form-title")}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="name"  value="{{$banner->name}}">
                            </div>
                        </div>

                        <div class="form-group">

                            <b>{{__("banners.banner-form-description")}}</b>
                            <div class="form-line">
                                <textarea rows="3" class="form-control no-resize" name="description" >{{$banner->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <b>{{__("banners.banner-form-url")}}</b>
                            <div class="form-line">
                                <input type="url" class="form-control" name="url"  value="{{$banner->url}}">
                            </div>
                        </div>

                        @component('components.uploader', [
                            'projectAddress' => 0,
                            'sectionAddress' => 'b',
                            'positionAddress' => $banner->id
                        ])@endcomponent

                        <button class="btn btn-large btn-primary waves-effect" type="submit">{{__("messages.save")}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach


        @else

        @component('back.components.no-results')
        @endcomponent

        @endif
    </div>
@endsection

@section('scripts')



<script>
        $(document).ready(function(){

            $('.active-button').click(function(){

                $('.active-button').not($(this)).prop("checked", false);

                var that = $(this);

                $.ajax({
                    url: '/banners/active',
                    type: 'POST',
                    data: {
                        'id': that.data('id'),
                        'active': that.prop('checked')
                    },
                    success: function (result) {

                        if(!result.status){

                            swal("{{__('messages.error_oops')}}", result.message, "error");

                        } else {

                            swal({
                                title: '{{trans('messages.success')}}',
                                text: '{{ trans('banners.active-status') }}',
                                type: "success",
                                html: true
                            });

                        }

                    }
                });
            });

            $('.delete-group').click(function(e){
                e.preventDefault();
                var that = $(this);

                swal({
                        title: "{{ __('messages.confirm_question') }}",
                        text: "{{ __('banners.delete_banner_text')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ __('messages.delete') }}",
                        closeOnConfirm: false
                    },
                    function(){
                        $.ajax({
                            url: '/banners/delete',
                            type: 'DELETE',
                            data: { 'id': that.data('id'),
                                'active': that.parents('.card').find('input[name="active"]').prop("checked")},
                            success: function(result) {

                                if(!result.status){
                                    swal("{{__('messages.error_oops')}}", result.message, "error");
                                }else{

                                    swal({
                                        title: '{{trans('messages.success')}}',
                                        text: '{{ trans('banners.deleted') }}',
                                        type: "success",
                                        html: true
                                    });

                                    that.parents('.card').remove();
                                }
                            }
                        });
                    });
            });

            /**
             * Card Behaviour
             */
            $('.toggleable-card').each(function(){

                $(this).click(function (e) {

                    if(!$(e.target).is('.delete-group') || $(e.target).is('.switch-col-blue')){

                        // Get status of the box
                        var headerElement = $(this);
                        var bodyElement = $(this).siblings('.body');
                        var status = headerElement.data("status");

                        if(!status){

                            // Card closed, we proceed to open
                            bodyElement.removeClass("not-visible").addClass("is-visible");

                            // Update the status of the card
                            headerElement.data("status", 1);

                            // Update the keyboard_arrow of the box if any
                            if(headerElement.find("#keyboard_arrow").length > 0){

                                $('#keyboard_arrow').html("keyboard_arrow_up");

                            }

                        } else {

                            // Card open, we proceed to close
                            bodyElement.removeClass("is-visible").addClass("not-visible");

                            // Update the status of the card
                            headerElement.data("status", 0);

                            // Update the keyboard_arrow of the box if any
                            if(headerElement.find("#keyboard_arrow").length > 0){

                                $('#keyboard_arrow').html("keyboard_arrow_down");

                            }
                        }
                    }
                });
            });
        });

    </script>
    @component('components.uploader-assets', ['notMultiple' => true])
    @endcomponent
@endsection
