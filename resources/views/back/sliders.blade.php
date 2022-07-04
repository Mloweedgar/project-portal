@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/website-management/general.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/project/gallery.css') }}" rel="stylesheet">
    @component('back/components.fine-upload-template-slider')
    @endcomponent
@endsection

@section('content')


    <h1 class="content-title">{{__("menu.sliders")}}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#sliders' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="row content-row">
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {{__("sliders.recomended-size")}}
            </div>
        </div>
    </div>

    <div class="row content-row">
        <div class="col-md-12">
            <div class="card card-shadow new-slider">
                <div id="card-header" class="header toggleable-card"
                     @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                    <h2><i class="material-icons">add_box</i> <span>{{__("sliders.slider-add-new")}}</span> <i
                                id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                </div>
                <div id="card-body"
                     class="body @if (count($errors) > 0 || (isset($flag))) is-visible @else not-visible @endif">

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
                            Message: {{$flag["message"]}}
                        </div>
                    @endif

                    <form id="dynamic-form-validation" class="new-slider-form" action="{{route("sliders/store")}}" method="POST">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <b>{{__("sliders.slider-form-select-project")}}</b>
                            <div class="m-t-20">
                                <select class="selectpicker" name="slctProjects" data-live-search="true">
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <b>{{__("sliders.slider-form-title")}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group m-t-20">
                            <b>{{ __('general.active') }}</b>
                            <div class="switch m-t-20">
                                <label><input name="active" type="checkbox" id="active"><span
                                            class="lever switch-col-blue"></span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <b>{{__("sliders.slider-form-description")}}</b>
                            <div class="form-line">
                                    <textarea rows="3" class="form-control no-resize" name="description"
                                              required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <b>{{__("sliders.slider-form-url")}}</b>
                            <div class="form-line">
                                <input type="url" class="form-control" name="url" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <b>{{__("sliders.font-color")}}</b>
                            <div class="form-line">
                            <input name="white" type="radio" id="color_white" checked value="1">
                            <label for="color_white">{{__('sliders.white')}}</label>
                            <input name="white" type="radio" id="color_black" value="0">
                            <label for="color_black">{{__('sliders.black')}}</label>
                            </div>
                        </div>
                        <div class="row upload-component flex">
                            <div class="col-md-6">
                                @component('components.uploader', [
                                    'projectAddress' => 0,
                                    'sectionAddress' => 's',
                                    'positionAddress' => -1,
                                    'hidden' => 1
                                ])
                                @endcomponent
                            </div>
                            <div class="col-md-6 gallery">
                                <div class="flex js-gallery col-blue-grey text-center div-responsive enabled"><i class="material-icons font-50">collections</i><p>{{ __('project/gallery.insert_gallery') }}</p></div>
                                <div class="js-gallery-img">


                                </div>
                                <div class="js-gallery-file">
                                    <input name="img" type="hidden">
                                    <button type="button" class="js-gallery-clear btn btn-primary waves-effect">{{__('project/gallery.remove')}}</button>
                                </div>
                                <!-- Gallery -->

                                <div class="modal fade js-gallery-modal" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">{{__('project/gallery.insert_gallery')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                @if(count($samples)>0)
                                                    <div class="slimScrollDiv">
                                                        <div class="row flex">
                                                            @foreach($samples as $sample)
                                                                <div class="col-md-3">
                                                                    <img src="{{asset('/img/samples/slider/'.$sample)}}" data-img="{{ $sample }}" class="img-responsive m-b-10">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class=" modal-footer">
                                                <button type="button" class="btn btn-primary  waves-effect js-gallery-button" data-dismiss="modal">{{ __('messages.select') }}</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('project/gallery.close') }}</button>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-large btn-primary waves-effect">{{__('general.save')}}</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    @if(count($sliders) > 0)

        @foreach($sliders as $slider)

            <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ route('uploader.s', array('position' => $slider->id)) }}"
                                         class="img-responsive preview-image">
                                </div>
                                <div class="col-md-7">
                                    <h2>{{$slider->name}} </h2>
                                </div>
                                <div class="col-md-2 align-right p-r-0 font-18">
                                  <span class="switch">
                                  <label><input class="active-button" name="active" type="checkbox"
                                                id="active"
                                                {{ $slider->active ? "checked" : "" }}  data-id={{ $slider->id }}>
                                      <span class="lever switch-col-blue"></span></label>
                                  </span>
                                    <a class="delete-group" href="#"
                                       data-id="{{$slider->id}}">
                                        <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="body not-visible" data-status="0">
                            <form method="post" action="{{route("sliders/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$slider->id}}">
                                <div class="form-group">
                                    <b>{{__("sliders.slider-form-title")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name"
                                               value="{{$slider->name}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <b>{{__("sliders.slider-form-description")}}</b>
                                    <div class="form-line">
                                            <textarea class="form-control no-resize"
                                                      name="description">{{$slider->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("sliders.slider-form-url")}}</b>
                                    <div class="form-line">
                                        <input type="url" class="form-control" name="url" value="{{$slider->url}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("sliders.font-color")}}</b>
                                    <div class="form-line">
                                        <input name="white" type="radio" id="color_white_{{$slider->id}}" @if ($slider->white=="1") checked @endif value="1">
                                        <label for="color_white_{{$slider->id}}">{{__('sliders.white')}}</label>
                                        <input name="white" type="radio" id="color_black_{{$slider->id}}" @if ($slider->white=="0") checked @endif  value="0">
                                        <label for="color_black_{{$slider->id}}">{{__('sliders.black')}}</label>
                                    </div>
                                </div>
                                <div class="row upload-component flex">
                                    <div class="col-md-6">
                                        @component('components.uploader', [
                                            'projectAddress' => 0,
                                            'sectionAddress' => 's',
                                            'positionAddress' => $slider->id,
                                            'hidden' => 1
                                        ])
                                        @endcomponent
                                    </div>
                                    <div class="col-md-6 gallery">
                                        <div class="flex js-gallery col-blue-grey text-center div-responsive disabled"><i class="material-icons font-50">collections</i><p>{{ __('project/gallery.insert_gallery') }}</p></div>
                                        <div class="js-gallery-img">


                                        </div>
                                        <div class="js-gallery-file">
                                                <input name="img" type="hidden">
                                                <button type="button" class="js-gallery-clear btn btn-primary waves-effect">{{__('project/gallery.remove')}}</button>
                                        </div>
                                        <!-- Gallery -->

                                        <div class="modal fade js-gallery-modal" role="dialog">
                                            <div class="modal-dialog modal-lg">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">{{__('project/gallery.insert_gallery')}}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if(count($samples)>0)
                                                            <div class="slimScrollDiv">
                                                                <div class="row flex">
                                                                    @foreach($samples as $sample)
                                                                        <div class="col-md-3">
                                                                            <img src="{{asset('/img/samples/slider/'.$sample)}}" data-img="{{ $sample }}" class="img-responsive m-b-10">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class=" modal-footer">
                                                        <button type="button" class="btn btn-primary  waves-effect js-gallery-button" data-dismiss="modal">{{ __('messages.select') }}</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('project/gallery.close') }}</button>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <button id="upload-button" class="btn btn-large btn-primary waves-effect"
                                        type="submit">{{__("messages.save")}}</button>

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

@endsection

@section('scripts')

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script>

        /**
         *  Disabled states
         */

        // Disable on load

        $(document).ready(function () {
            $('.upload-component').each(function(i){
                $(this).closest(".card").find(".preview-image").error(function () {
                    $(this).closest(".card").find(".preview-image").hide();
                    $(this).closest(".card").find(".js-gallery").addClass("enabled").removeClass("disabled");
                });
            });

        });

        // Enable gallery when delete slider

        $("body").on('click',".qq-ok-button-selector",function () {
            $(this).closest(".card").find(".js-gallery").addClass("enabled").removeClass("disabled");
        });


        /**
         *  Open the gallery modal
         */

        $(".js-gallery").click(function () {
            if ($(this).hasClass("enabled")){
                $(this).parent().find('.js-gallery-modal').modal('show');
                console.log("open");
            }
        });

        /**
         *  Select an image
         */

        $('.modal-body .img-responsive').click(function(){

            if(!$(this).hasClass('js-gallery-selected')){
                $('.modal-body .img-responsive').removeClass('js-gallery-selected');
                $(this).addClass('js-gallery-selected');
            }else{
                $('.modal-body .img-responsive').removeClass('js-gallery-selected');
            }

        });

        /**
         *  Append the image to the gallery container and the form
         */

        $('.js-gallery-button').click(function(){

            if($('.modal-content .img-responsive').hasClass('js-gallery-selected')){
                var imgSrc="/img/samples/slider/"+$('.js-gallery-selected').data('img');
                $(this).closest('.gallery').find('.js-gallery-img').append('<img class="img-responsive" src="'+imgSrc+'">').css('display', 'flex');
                $(this).closest('.gallery').find('.js-gallery-file').show();
                $(this).closest('.gallery').find("input[name='img']").val(imgSrc);
                $(this).removeClass('js-gallery-selected');

                // Disable uploader

                $(this).closest('.upload-component').find(".qq-uploader-selector.qq-uploader.qq-gallery.enabled").addClass("hidden");
                $(this).closest('.upload-component').find(".fake-uploader").removeClass("hidden");

            }

        });

        /**
         *  Clear the gallery image
         */

        $('.js-gallery-clear').click(function(){
            $(this).closest('.gallery').find('.js-gallery-file').hide();
            $(this).closest('.gallery').find('.js-gallery-img img').remove();
            $(this).closest('.gallery').find('.js-gallery-img').hide();
            $(this).closest('.gallery').find("input[name='img']").val();

            // Enable uploader
            $(this).closest('.upload-component').find(".fake-uploader").addClass("hidden");
            $(this).closest('.upload-component').find(".qq-uploader-selector.qq-uploader.qq-gallery.enabled").removeClass("hidden");



        });

    </script>

    <script>
        $(document).ready(function () {

            $('.delete-group').click(function (e) {

                e.preventDefault();
                var that = $(this);

                swal({
                        title: "{{ __('messages.confirm_question') }}",
                        text: "{{ __('sliders.delete_slider_text')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ __('messages.delete') }}",
                        closeOnConfirm: true
                    },
                    function () {
                        $.ajax({
                            url: '/sliders/delete',
                            type: 'DELETE',
                            data: {
                                'id': that.data('id'),
                                'active': that.parents('.card').find('input[name="active"]').prop("checked")
                            },
                            success: function (result) {

                                if (!result.status) {
                                    swal("{{__('messages.error_oops')}}", result.message, "error");
                                } else {
                                    swal({
                                        title: '{{trans('messages.success')}}',
                                        text: '{{ trans('sliders.deleted') }}',
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
            $('.toggleable-card').each(function () {

                $(this).click(function (e) {

                    if (!$(e.target).is('.delete-group') || $(e.target).is('.switch-col-blue')) {

                        // Get status of the box
                        var headerElement = $(this);
                        var bodyElement = $(this).siblings('.body');
                        var status = headerElement.data("status");

                        if (!status) {

                            // Card closed, we proceed to open
                            bodyElement.removeClass("not-visible").addClass("is-visible");

                            // Update the status of the card
                            headerElement.data("status", 1);

                            // Update the keyboard_arrow of the box if any
                            if (headerElement.find("#keyboard_arrow").length > 0) {

                                $('#keyboard_arrow').html("keyboard_arrow_up");

                            }

                        } else {

                            // Card open, we proceed to close
                            bodyElement.removeClass("is-visible").addClass("not-visible");

                            // Update the status of the card
                            headerElement.data("status", 0);

                            // Update the keyboard_arrow of the box if any
                            if (headerElement.find("#keyboard_arrow").length > 0) {

                                $('#keyboard_arrow').html("keyboard_arrow_down");

                            }
                        }
                    }
                });


            });

            $('.active-button').click(function () {

                var that = $(this);


                $.ajax({
                    url: '/sliders/active',
                    type: 'POST',
                    data: {
                        'id': that.data('id'),
                        'active': that.prop('checked')
                    },
                    success: function (result) {
                        if (!result.status) {
                            that.prop('checked', true);
                            swal("{{__('messages.error_oops')}}", result.message, "error");
                        } else {
                            //Show success message
                            swal("Success!", result.message, "success");

                        }
                    }
                });

            });


            //Code for select a slider

            $("[name='slctProjects']").selectpicker().ajaxSelectPicker({
                ajax: {
                    url: '{{route('admin-find-projects-by-like')}}',
                    dataType: 'JSON',
                    jsonpCallback: 'projects',
                },
                locale: {
                    emptyTitle: 'Select and Begin Typing'
                },
                log: 3,
                preprocessData: function (data) {
                    var i, l = data.projects.length,
                        arr = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            arr.push($.extend(true, data.projects[i], {
                                text: data.projects[i].name,
                                value: data.projects[i].id,
                                data: {
                                    /*subtext: data.projects[i].name*/
                                }
                            }));
                        }
                    }
                    // You must always return a valid array when processing data. The
                    // data argument passed is a clone and cannot be modified directly.
                    return arr;
                }
            });


            var lastIndex=null;


            $('.bootstrap-select').on('click',function(){

                var length= 200;
                //lastIndex is the last id_project selected
              if(lastIndex!=$("[name='slctProjects']").val()){

                lastIndex=$("[name='slctProjects']").val();

                $.ajax({
                  data: {'project_id': lastIndex},
                  url: '{{route("get-project-info")}}',
                  type: 'post',
                  success: function(response){
                    var name = response.name;
                    var url = "{{ url('/') }}"+'/project/'+lastIndex;

                    $('.new-slider input[name="name"]').val(name);
                    $('.new-slider input[name="url"]').val(url);
                  }
                });
              }
            });


        });

        @if(Session::has('status'))

            swal({
            @if (session('status'))
            title: "Success!",
            type: "success",
            text: "{{session('status')}}",
            @endif
            html: true
        });
        @endif


    </script>

    @component('components.uploader-assets-slider')
    @endcomponent

@endsection
