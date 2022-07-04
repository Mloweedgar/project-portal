@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <style>

    </style>

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')
    <h1 class="content-title">{{__("menu.change-password")}}</h1>
    <div class="row content-row">
        <div class="col-md-12">
            {{-- <h3 class="content-form-title">Add user</h3> --}}
            <div class="card">
                <div class="header card-header-static">
                    <h2><i class="material-icons">security</i> <span>{{__("user.change-password")}}</span></h2>
                </div>
                <div class="body">
                    <form  id="frmChangePassword" method="post" action={{route("change-password.store")}}>
                        {{ csrf_field() }}
                        {{-- row start --}}
                        <div class="form-group">
                            <label for="current_password">{{trans('user.old-password')}}</label>
                            <div class="form-line">
                                <input type="password" id="current_password" class="form-control" name="current_password" value="" placeholder="{{trans('user.old-password-placeholder')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">{{trans('user.new-password')}}</label>
                            <div class="form-line">
                                <input type="password" id="password" data-toggle="tooltip" data-placement="left" title="Length min 8 and at least one of: <b>a-z</b>, <b>A-Z</b>, <b>0-9</b>, special char (<b>!@#$%^&*()_-=+?</b>)" data-html="true" class="form-control" name="password" value="" placeholder="{{trans('user.new-password-placeholder')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{trans('user.new-password-confirm')}}</label>
                            <div class="form-line">
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" value="" placeholder="{{trans('user.new-password-confirm-placeholder')}}">
                            </div>
                        </div>

                        <button type="submit" id="save-button" class="type btn btn-large btn-primary waves-effect" data-type="save_draft">{{__("general.save")}}</button>

                    </form>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            // tooltip initialization
            $('[data-toggle="tooltip"]').tooltip();

            $("#frmChangePassword").validate({
                /* Onkeyup
                 * For not sending an ajax request to validate the email each time till the typing is done.
                 */
                /*onkeyup: false,*/
                debug: true,
                rules: {
                    current_password:{
                        required: true
                    },
                    password:{
                        required: true,
                        pattern: /(?=.*[a-z]).*(?=.*[A-Z]).*(?=.*\d).*(?=.*[-!@#$%^&*()_=+?]).{8,}/
                    },
                    password_confirmation:{
                        required: true,
                        equalTo:"#password"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            }); //Validation end

            @if (session('changed')=='success')
                swal({
                title: "Success!",
                text: "{{trans('user.password-change-success')}}",
                type: "success",
                html: true
            }, function(){
            });

            @elseif (session('changed')=='password-mismatch')
                swal({
                title: "Error!",
                text: "{{trans('user.password-change-mismatch')}}",
                type: "error",
                html: true
            }, function(){
            });

            @elseif (session('changed')=='password-insecure')
                swal({
                title: "Error!",
                text: "{{trans('user.password-change-insecure')}}",
                type: "error",
                html: true
            }, function(){
            });

            @endif            
        });
    </script>
    @endsection
