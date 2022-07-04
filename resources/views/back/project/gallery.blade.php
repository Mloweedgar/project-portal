@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/project/gallery.css') }}" rel="stylesheet">
    @component('back/components.fine-upload-template-2')
    @endcomponent
@endsection

@section('content')
    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#project_gallery' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
    @endif

    @component('back.components.enable-section', ["section" => trans('project.section.gallery'),"visible" => $project->gallery_active])
    @endcomponent




    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content main-content">

        <div class="gallery">

            @if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())

            <div class="row ">
                <div class="col-md-4">
                    @component('components.uploader', [
                            'projectAddress' => $project->id,
                            'sectionAddress' => 'g',
                            'positionAddress' => -1
                    ])@endcomponent

                </div>
                <div class="col-md-4">
                    <div class="flex js-gallery col-blue-grey text-center div-responsive"  data-toggle="modal" data-target="#js-gallery"><i class="material-icons font-50">collections</i><p>{{ __('project/gallery.insert_gallery') }}</p></div>
                    <div class="js-gallery-img">


                    </div>
                    <div class="js-gallery-file">
                        <form action="{{ route('project.gallery.add') }}" method="POST">
                            {{ csrf_field() }}
                            <input name="project_id" type="hidden" value="{{ $project->id }}">
                            <input name="img" type="hidden">
                            <input name="sector" type="hidden">
                            <button type="button" class="js-gallery-clear btn btn-primary waves-effect">{{__('project/gallery.remove')}}</button>
                            <button type="submit" class="btn btn-primary waves-effect">{{__('project/gallery.add_to_project')}}</button>
                        </form>

                    </div>
                </div>
            </div>
            @else
                <p class="m-b-35">{{__('project/gallery.unauthorized')}}</p>
            @endif


            @foreach($images as $image)
                @if($loop->iteration % 3 == 1)
                    <div class="row flex">
                        @endif
                        <div class="col-md-4 js-gallery-container">
                            @if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator())

                            <div class="relative">
                                <i class="material-icons js-gallery-delete" data-id="{{$image->id}}">close</i>
                            </div>
                            @endif
                            <img class="img-responsive m-b-10" id="image-sizes" src="{{route('uploader.g', array('image_id' => $image->id))}}">

                        </div>
                        @if($loop->iteration % 3 == 0)
                    </div>
                @endif

            @endforeach


        </div>
    </div>

    <div id="js-gallery" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{__('project/gallery.insert_gallery')}}</h4>
                </div>
                <div class="modal-body">
                    @foreach($samples as $sector => $images)
                        @if(count($images)>0)
                            <div class="slimScrollDiv">
                                <h5>{{__('catalogs/sectors.sector_'.explode(' ',$sector)[0])}}</h5>
                                <div class="row flex">

                                    @foreach($images as $image)
                                        <div class="col-md-3">
                                            <img class="img-responsive m-b-10" data-img="{{ $image }}" data-sector="{{ $sector }}" src="{{asset("/img/samples/gallery/".$sector.'/'.$image)}}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-primary  waves-effect js-gallery-button" data-dismiss="modal">{{ __('messages.select') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('project/gallery.close') }}</button>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')

    @component('back.components.enable-section-js', ["section" => "g","project_id" => $project->id])
    @endcomponent

    <script src="{{ asset('back/plugins/fineuploader-core/all.fine-uploader.js') }}"></script>
    <script>


        $(document).ready(function(){

            $('.modal-body .img-responsive').click(function(){

                if(!$(this).hasClass('js-gallery-selected')){
                    $('.modal-body .img-responsive').removeClass('js-gallery-selected');
                    $(this).addClass('js-gallery-selected');
                }else{
                    $('.modal-body .img-responsive').removeClass('js-gallery-selected');
                }



            });

            $('.js-gallery-button').click(function(){

                if($('.modal-content .img-responsive').hasClass('js-gallery-selected')){
                    var imgSrc="/img/samples/gallery/"+$('.js-gallery-selected').data('sector')+'/'+$('.js-gallery-selected').data('img');
                    $('.js-gallery-img').append('<img class="img-responsive" src="'+imgSrc+'">');
                    $('.js-gallery-file input[name="img"]').val($('.js-gallery-selected').data('img'));
                    $('.js-gallery-file input[name="sector"]').val($('.js-gallery-selected').data('sector'));
                    $('.js-gallery-img').css('display', 'flex');
                    $('.js-gallery-file').show();
                    $('.modal-content .img-responsive').removeClass('js-gallery-selected');
                }

            });

            $('.js-gallery-clear').click(function(){
                $('.js-gallery-file').hide();
                $('.js-gallery-img img').remove();
                $('.js-gallery-img').hide();
                $('.js-gallery-file input[name="img"]').val();
                $('.js-gallery-file input[name="sector"]').val();
            });


            //delete
            $('.js-gallery-delete').click(function() {
                console.log("Hey");

                var that = $(this);

                swal({
                        title: "{{ __('messages.confirm_question') }}",
                        text: "{{ __('project/gallery.delete_confirm_text') }}!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ __('project/gallery.delete_confirm_button') }}",
                        closeOnConfirm: true
                    },
                    function () {
                        $.ajax({
                            url: '{{route('project.gallery.remove')}}',
                            type: 'DELETE',
                            data: {
                                'id': that.data('id'),
                                'project_id': "{!! $project->id !!}"
                            },
                            success: function (result) {
                                console.log(result.status);
                                if (result.status) {
                                    location.reload();

                                }else{
                                    swal("{{__('messages.error_oops')}}", result.message, "error");
                                }
                            }

                        });
                    });
            });
        });


    </script>

    @component('components.uploader-assets-gallery')
    @endcomponent
@endsection
