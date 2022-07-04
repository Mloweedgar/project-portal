@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("roles-permissions.title") }} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{{ __('roles-permissions.tooltip') }}"></i></h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#edit_roles' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="content main-content">
        @foreach($roles as $role)
            <div class="toggleable-wrapper">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <div class="row">
                            <div class="col-md-10">
                                <h2>{{$role->alias}}</h2>
                            </div>
                            @if (!$role->default)
                                <div class="col-md-2 align-right  font-18">
                                    <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$role->id}}"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <input type="hidden" name="id" value="{{$role->id}}">
                        <div class="form-group">
                            <b>{{__("roles-permissions.role-title")}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="alias"  value="{{$role->alias}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <b>{{__("roles-permissions.alias-from")}}</b>
                            <div class="form-line">
                                @foreach($roles as $subrole)
                                    @if($subrole->name == $role->name && $subrole->default == 1)
                                        <input type="text" class="form-control" value="{{$subrole->alias}}" disabled readonly>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">

                            <b>{{__("roles-permissions.role-description")}}</b>
                            <div class="form-line">
                                <textarea rows="3" class="form-control no-resize" name="description" >{{$role->description}}</textarea>
                            </div>
                        </div>

                        <button class="btn btn-large btn-primary waves-effect save-group">{{__("messages.save")}}</button>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

@endsection

@section('scripts')
    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script>

        $('[data-toggle="tooltip"]').tooltip({'container':'body'});

        var validator = $('#frmNewRole').validate({

            ignore: ":hidden:not(.selectpicker)",
            /* Onkeyup
             * For not sending an ajax request to validate the email each time till the typing is done.
             */
            /*onkeyup: false,*/

            rules: {
                'alias': {
                    required: true,
                    remote: {
                        url: "{{route("roles-check")}}",
                        type: "post",
                        data: {
                            alias: function () {
                                return $("#alias").val();
                            }
                        }
                    }
                },
                'description': {
                    required: true
                },
                'name': {
                    required: true
                }

            },
            messages:{
                'alias': {
                    remote: "{{__('roles-permissions.role-exists')}}"
                }
            },
            submitHandler: function (form) {

                form.submit();

            }
        }); //Validation end



        $('.save-group').click(function(){
            var id = $(this).parent().find('input[name="id"]').val();
            var alias = $(this).parent().find('input[name="alias"]').val();
            var description = $(this).parent().find('textarea[name="description"]').val();


            $.ajax({
                url: '{{route('roles-save-edit')}}',
                type: 'POST',
                data: { 'id': id, 'alias':alias, 'description':description},
                success: function(result) {

                    if(!result.status){
                        swal({
                            title: '{{trans('messages.success')}}',
                            text: result.message,
                            type: "success",
                            html: true
                        });
                    }else{

                        swal({
                            title: '{{trans('messages.success')}}',
                            text: result.message,
                            type: "success",
                            html: true
                        });
                    }
                }
            });
        });


        $('.delete-group').click(function(e) {

            var card = $(this).parents('.card')
            var id = $(this).data('id');
            swal({
                    title: "{{ __('messages.confirm_question') }}",
                    text: "{{ __('roles-permissions.delete-confirm')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ __('messages.delete') }}",
                    closeOnConfirm: true
                },
                function () {
                    $.ajax({
                        url: '{{route('roles-delete')}}',
                        type: 'POST',
                        data: {'id': id},
                        success: function (result) {

                            if (!result.status) {
                                swal({
                                    title: '{{trans('messages.success')}}',
                                    text: result.message,
                                    type: "success",
                                    html: true
                                });
                            } else {

                                swal({
                                    title: '{{trans('messages.success')}}',
                                    text: result.message,
                                    type: "success",
                                    html: true
                                });
                                card.remove();

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

        @if(Session::has('status'))

        swal({
            @if (session('status'))
            title: "Success!",
            type: "success",
            text: "{{ __('roles-permissions.create-success') }}",
            @else
            title: "Error!",
            type: "error",
            text: "{{ __('roles-permissions.create-error') }}",
            @endif
            html: true
        });
        @endif

    </script>
@endsection
