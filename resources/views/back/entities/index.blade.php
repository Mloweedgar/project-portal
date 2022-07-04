@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/website-management/general.css') }}" rel="stylesheet">

    @component('back/components.fine-upload-template-1')
    @endcomponent
@endsection

@section('content')

    <h1 class="content-title"> {{ __('entity.entities') }}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#add_new_entity' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
@if(Auth::user()->canCreate())
<div class="row content-row">

    <div class="col-md-12">
        <div class="card card-shadow">
            <div id="card-header" class="card-header header" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                <h2><i class="material-icons">add_box</i> <span>{{__("entity.new_entity")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        Message: {{$flag["message"]}}
                    </div>
                @endif
                <form id="dynamic-form-validation" method="POST" action="{{route("store-entity")}}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.name')}}</b>
                                <div class="form-line">
                                    <input name="name" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.name-representative')}}</b>
                                <div class="form-line">
                                    <input name="name_representative" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.address')}}</b>
                                <div class="form-line">
                                    <input name="address" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.tel')}}</b>
                                <div class="form-line">
                                    <input name="tel" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.fax')}}</b>
                                <div class="form-line">
                                    <input name="fax" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>{{ __('entity.email')}}</b>
                                <div class="form-line">
                                    <input name="email" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <b>{{ __('entity.description')}}</b>
                                <div class="form-line">
                                    <textarea name="description" rows="3" class="form-control no-resize" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        @component('components.uploader', [
                            'projectAddress' => 0,
                            'sectionAddress' => 'par',
                            'positionAddress' => -1
                        ])@endcomponent
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <b>{{ __('entity.website')}}</b>
                                <div class="form-line">
                                    <input name="website" type="url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <b>{{ __('entity.facebook')}}</b>
                                <div class="form-line">
                                    <input name="facebook" type="url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="label-container"><label >{{ __('entity.twitter')}}</label></div>
                                <div class="form-line">
                                    <input name="twitter" type="url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <b>{{ __('entity.instagram')}}</b>
                                <div class="form-line">
                                    <input name="instagram" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a id="upload-button" class="btn btn-large btn-primary waves-effect">{{__("entity.add_entity")}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if(count($entities) > 0)
    @foreach($entities as $entity)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ route('uploader.par', array('position' => $entity->id)) }}" class="img-responsive preview-image">
                            </div>
                            <div class="col-md-7">
                                <h2>{{$entity->name}} </h2>
                            </div>
                            <div class="col-md-2 align-right p-r-0 font-18">
                                <a class="delete-group" href="#"
                                   data-id="{{$entity->id}}">
                                    <i class="fa fa-trash-o del-btn x2" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="body not-visible">
                        <form action="/entities/update" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $entity->id }}" required>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.name')}}</b>
                                        <div class="form-line">
                                            <input name="name" type="text" class="form-control" value="{{ $entity->name}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.name-representative')}}</b>
                                        <div class="form-line">
                                            <input name="name_representative" type="text" class="form-control" value="{{ $entity->name_representative}}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.address')}}</b>
                                        <div class="form-line">
                                            <input name="address" type="text" class="form-control" value="{{ $entity->address}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.tel')}}</b>
                                        <div class="form-line">
                                            <input name="tel" type="text" class="form-control" value="{{ $entity->tel}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.fax')}}</b>
                                        <div class="form-line">
                                            <input name="fax" type="text" class="form-control" value="{{ $entity->fax}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <b>{{ __('entity.email')}}</b>
                                        <div class="form-line">
                                            <input name="email" type="email" class="form-control" value="{{ $entity->email}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>{{ __('entity.description')}}</b>
                                        <div class="form-line">
                                            <textarea name="description" rows="3" class="form-control" placeholder="{{ __('messages.description_placeholder') }}">{{ $entity->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                @component('components.uploader', [
                                    'projectAddress' => 0,
                                    'sectionAddress' => 'par',
                                    'positionAddress' => $entity->id,
                                ])@endcomponent
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>{{ __('entity.website')}}</b>
                                        <div class="form-line">
                                            <input name="website" type="url" class="form-control" value="{{ $entity->url }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>{{ __('entity.facebook')}}</b>
                                        <div class="form-line">
                                            <input name="facebook" type="url" class="form-control" value="{{ $entity->facebook }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="label-container"><label >{{ __('entity.twitter')}}</label></div>
                                        <div class="form-line">
                                            <input name="twitter" type="url" class="form-control" value="{{ $entity->twitter }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>{{ __('entity.instagram')}}</b>
                                        <div class="form-line">
                                            <input name="instagram" type="text" class="form-control" value="{{ $entity->instagram }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="submit-type">
                                    @component('back.components.project-buttons', [
                                        'position'=>$entity->id,
                                        'section'=>'ent',
                                        'project'=>0,
                                        'fileUploader_required' => true,
                                        'required_message' => trans('entity.required')
                                    ])
                                    @endcomponent
                                </div>
                            </div>
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



    <script>
        $(document).ready(function() {

            $(".card").find(".preview-image").error(function () {
                $(this).hide();
            });


            @if (!Auth::user()->isAdmin())
                $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
            @endif

            @if (Auth::user()->canDelete())
                $('.delete-group').click(function(e){
                    e.preventDefault();
                    var that = $(this);

                    swal({
                            title: "{{ __('messages.confirm_question') }}",
                            text: "{{ __('entity.delete_entity_text')}}",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "{{ __('messages.delete') }}",
                            closeOnConfirm: true
                        },
                        function(){
                            $.ajax({
                                url: '/entities/delete',
                                type: 'DELETE',
                                data: { 'id': that.data('id'),
                                    'active': that.parents('.card').find('input[name="active"]').prop("checked")},
                                success: function(result) {

                                    if(!result.status){
                                        swal("{{__('messages.error_oops')}}", result.message, "error");
                                    }else{
                                        swal({
                                            title: "{{trans('messages.success')}}",
                                            text: "{{ trans('entity.deleted') }}",
                                            type: "success",
                                            html: true
                                    });

                                        that.parents('.card').remove();
                                    }
                                }
                            });
                        });

            });
        @else
            $('a.delete-group').remove();
        @endif



            /**
             * Card Behaviour
             */
            $('.toggleable-card').each(function(){

                $(this).click(function (e) {

                    if(!$(e.target).is('.delete-group')){

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

        @if(Session::has('status'))

            swal({
            @if (session('status'))
            title: "Success!",
            type: "success",
            text: "{{ __('entity.save-success') }}",
            @else
            title: "Error!",
            type: "error",
            text: "{{ __('entity.save-error') }}",
            @endif
            html: true
        });
        @endif
    </script>

    @component('components.uploader-assets-entities', ['notMultiple' => true, 'required' => true, 'required_message' => trans('entity.required')])
    @endcomponent
@endsection
