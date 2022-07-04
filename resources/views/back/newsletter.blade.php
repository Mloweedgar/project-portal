@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("newsletter.title") }}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#notifications_management' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="row content-row errors"></div>

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
            <h2 class="content-second-title">{{ trans('newsletter.notifications_management') }} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{{ __('newsletter.tooltip') }}"></i></h2>
        </div>

        <form id="frmNotification" action="{{ route('newsletter.send') }}" method="post">
            {{ csrf_field() }}
            <div class="col-md-3" id="role-row">
                <div class="form-group">
                    <label for="role-picker" class="label-margin-bottom">{{__('newsletter.search_role')}}</label>
                    <div class="input-group">
                        <div class="form-line">
                            <select class="form-control show-tick selectpicker" id="role-picker" name="roles[]"  multiple title="{{__('newsletter.select_role')}}">
                                @foreach($roles as $role)
                                    <option id="role{{$role->id}}" value={{$role->id}}>{{$role->alias}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group-addon">
                            <!--
                            <button type="button" class="btn bg-green waves-effect waves-circle waves-float communications-save-button hidden">
                                <i class="material-icons">save</i>
                            </button>
                            -->
                            <button type="button" id="clean-role" class="btn btn-danger waves-effect waves-circle waves-float disabled btnCleanSelect">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="user-row">
                <div class="form-group">
                    <label for="user-picker" class="label-margin-bottom">{{__('newsletter.search_user')}}</label>
                    <div class="input-group">
                        <div class="form-line">
                            <select class="form-control show-tick selectpicker" id="user-picker" name="users_id[]" multiple data-live-search="true" title="{{__('newsletter.select_user')}}"></select>
                        </div>
                        <div class="input-group-addon">
                            <!--
                            <button type="button" class="btn bg-green waves-effect waves-circle waves-float communications-save-button hidden">
                                <i class="material-icons">save</i>
                            </button>
                            -->
                            <button type="button" id="clean-user" class="btn btn-danger waves-effect waves-circle waves-float disabled btnCleanSelect">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" id="project-row">
                <div class="form-group">
                    <label for="project-picker" class="label-margin-bottom">{{__('newsletter.search_project')}}</label>
                    <div class="input-group">
                        <div class="form-line">
                            <select class="form-control show-tick selectpicker" id="project-picker" name="project_id" data-live-search="true" title="{{__('newsletter.select_project')}}"></select>
                        </div>
                        <div class="input-group-addon">
                            <button type="button" id="clean-project" class="btn btn-danger waves-effect waves-circle waves-float disabled btnCleanSelect">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 hidden m-b-40" id="notification_body">
                <div class="form-group">
                    <b>Subject</b>
                    <div class="form-line">
                        <input type="text" class="form-control" name="subject">
                    </div>
                </div>
                <div class="form-group">
                    <b>Message</b>
                    <div class="form-line">
                        <textarea class="form-control" name="message" rows="5"></textarea>
                    </div>
                </div>
                    <button class="btn btn-large btn-primary waves-effect" id="btnSubmitNotification">Submit</button>
            </div>
        </form>
    </div>

    <div class="row content-row">
        <div class="col-md-12">
            <h2 class="content-second-title">{{trans('newsletter.subscribers')}}</h2>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="newsletter-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="adjust-text"></th>
                        <th>{{trans('newsletter.name')}}</th>
                        <th>{{trans('newsletter.email')}}</th>
                        <th class="adjust-text">{{trans('newsletter.status')}}</th>
                        <th class="adjust-text">{{__('newsletter.unsubscribe')}}</th>
                        <th class="adjust-text"></th>
                    </tr>
                    </thead>
                </table>
            </div>
            <button class="btn btn-danger" id="multipleDeleteBtn"><i class="material-icons">delete</i> {{trans('newsletter.delete')}}</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>
    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            @if (session()->has('status'))
                @if (session('status') == true)
                    swal({
                title: '{{ session('message') }}',
                type: "success",
                closeOnConfirm: true
            });
            @else
                swal({
                    title: '{{ session('message') }}',
                    type: "warning",
                    closeOnConfirm: true
                });
            @endif
        @endif


            $('[data-toggle="tooltip"]').tooltip({'container':'body'});

            $("#frmNotification").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    subject:{
                        required: true
                    },
                    message:{
                        required: true
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            }); //Validation end

            $("#clean-role").click(function () {
                $("#user-row").removeClass('hidden');
                $("#role-row").removeClass('col-md-12').addClass('col-md-4');
                $("#project-row").removeClass('hidden');
                $("#notification_body").removeClass('hidden').addClass('hidden');
            });

            $("#clean-user").click(function () {
                $("#user-row").removeClass('col-md-12').addClass('col-md-5');
                $("#role-row").removeClass('hidden');
                $("#project-row").removeClass('hidden');
                $("#notification_body").removeClass('hidden').addClass('hidden');
            });

            $('#clean-project').click(function () {
                $("#user-row").removeClass('hidden');
                $("#role-row").removeClass('hidden');
                $("#project-row").removeClass('col-md-12').addClass('col-md-6');
                $("#notification_body").removeClass('hidden').addClass('hidden');
            });

            $('#save-roles').click(function () {
                console.log("Clicked");
                $('#role-picker').selectpicker('toggle');
            });


            $("#role-picker").on('change', function(){
                var selectpickerbox = $(this).parent().parent();
                if ($(this).find("option:selected").val()) {
                    selectpickerbox.addClass('focused success');
                    $("#notification_body").removeClass('hidden');
                    $("#user-row").addClass('hidden');
                    $("#project-row").addClass('hidden');
                    $("#role-row").removeClass('col-md-4').addClass('col-md-12');
                    $("#role-picker-row").removeClass('col-md-11').addClass('col-md-10');
                    $("#role-buttons-row").removeClass('col-md-1').addClass('col-md-2');
                    $(".communications-save-button").removeClass('hidden');

                    enableResetSelect();
                } else {
                    selectpickerbox.removeClass('focused success');
                    $("#user-row").removeClass('hidden');
                    $("#project-row").removeClass('hidden');
                    $("#role-row").removeClass('col-md-12').addClass('col-md-4');
                    $(".communications-save-button").removeClass('hidden').addClass('hidden');
                    $("#notification_body").removeClass('hidden').addClass('hidden');
                    disableResetSelect();
                }
            });

            $("#user-picker").on('change', function(){
                var selectpickerbox = $(this).parent().parent();
                if ($(this).find("option:selected").val()) {
                    selectpickerbox.addClass('focused success');
                    $("#notification_body").removeClass('hidden');
                    $("#role-row").addClass('hidden');
                    $("#project-row").addClass('hidden');
                    $("#user-row").removeClass('col-md-5').addClass('col-md-12');
                    $(".communications-save-button").removeClass('hidden');
                    enableResetSelect();
                } else {
                    selectpickerbox.removeClass('focused success');
                    $("#role-row").removeClass('hidden');
                    $("#project-row").removeClass('hidden');
                    $("#user-row").removeClass('col-md-12').addClass('col-md-5');
                    $(".communications-save-button").removeClass('hidden').addClass('hidden');

                    $("#notification_body").removeClass('hidden').addClass('hidden');
                    disableResetSelect();

                }
            });

            $("#project-picker").on('change', function(){
                var selectpickerbox = $(this).parent().parent();
                if ($(this).find("option:selected").val()) {
                    selectpickerbox.addClass('focused success');
                    $("#notification_body").removeClass('hidden');
                    $("#user-row").addClass('hidden');
                    $("#role-row").addClass('hidden');
                    $("#project-row").removeClass('col-md-6').addClass('col-md-12');
                    $("#project-picker-row").removeClass('col-md-11').addClass('col-md-10');
                    $("#project-buttons-row").removeClass('col-md-1').addClass('col-md-2');
                    $(".communications-save-button").removeClass('hidden');

                    enableResetSelect();
                } else {
                    selectpickerbox.removeClass('focused success');
                    $("#user-row").removeClass('hidden');
                    $("#role-row").removeClass('hidden');
                    $("#project-row").removeClass('col-md-12').addClass('col-md-6');
                    $(".communications-save-button").removeClass('hidden').addClass('hidden');
                    $("#notification_body").removeClass('hidden').addClass('hidden');

                    disableResetSelect();
                }
            });

            function enableResetSelect()
            {
                $('.btnCleanSelect').removeClass('disabled');

            }
            function disableResetSelect()
            {
                $('.btnCleanSelect').addClass('disabled');
            }

            $('.btnCleanSelect').click(function(){
                resetSelect();
                disableResetSelect();
                $(".communications-save-button").removeClass('hidden').addClass('hidden');
            });

            $("#user-picker").ajaxSelectPicker({
                ajax: {
                    url: '{{ route('admin-find-users-by-like') }}',
                },
                locale: {
                    statusInitialized: '{{trans('newsletter.start_typing_username')}}'
                },
                preprocessData: function (users) {
                    var i, l = users.length,
                        arr = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            arr.push($.extend(true, users[i], {
                                text: users[i].name + ' (' + users[i].email + ')',
                                value: users[i].id
                            }));
                        }
                    }

                    return arr;
                }
            });

             $("#project-picker").ajaxSelectPicker({
                ajax: {
                    url: '{{ route('admin-find-projects-by-like') }}',
                },
                locale: {
                    statusInitialized: '{{trans('newsletter.start_typing_project')}}'
                },
                preprocessData: function (projects) {
                    projects = projects.projects;
                    var i, l = projects.length,
                        arr = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            arr.push($.extend(true, projects[i], {
                                text: projects[i].name,
                                value: projects[i].id
                            }));
                        }
                    }

                    return arr;
                }
            });


            function cleanSelect()
            {
                $('.selectpicker').val([]);
                $('.selectpicker').trigger('change.abs.preserveSelected');
                $('.selectpicker').selectpicker('refresh');
                $('.selectpicker').parent().parent().removeClass('focused success');
            }

            function resetSelect()
            {
                cleanSelect();
            }

            var subscribersCheckedDelete = [];
            var newsletterTable = $('#newsletter-table').DataTable({
                order: [[ 1, "asc" ]],
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{!! route('newsletter.table') !!}',
                    method : 'POST'
                },
                columns: [
                    {
                        name: 'checkDelete',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var index = subscribersCheckedDelete.indexOf(data.id);
                            var checked = '';
                            if (index > -1) {
                                checked = 'checked';
                            }
                            var actions = '<input type="checkbox" id="checkboxDelete' + data.id + '" value="' + data.id + '" class="checkDeleteSubscriber filled-in" '+checked+'/>\
                <label for="checkboxDelete' + data.id + '"></label>';
                            return actions;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        name: 'token',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            if (data.token === null) {
                                return '<span class="label label-success" style="font-size:0.8em;">{{trans('newsletter.confirmed')}}</span>';
                            } else {
                                return '<span class="label label-danger" style="font-size:0.8em;">{{trans('newsletter.not_confirmed')}}</span>';
                            }
                        }
                    },
                    {
                        name: 'unsubscribe',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            if (data.token === null) {
                                return '<button type="button" data-id="' + data.id +'" class="centered-div btn btn-default btn-circle waves-effect waves-circle waves-float btnSendUnsubscriptionEmail">\
                                  <i class="material-icons">email</i>\
                              </button>';
                            } else {
                                return '<button type="button" disabled class="centered-div btn btn-default btn-circle waves-effect waves-circle waves-float">\
                                  <i class="material-icons">email</i>\
                              </button>';
                            }
                        }
                    },
                    {
                        name: 'delete',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float btnDeleteSubscriber">\
                              <i class="material-icons">delete</i>\
                          </button>'
                            return actions;
                        }
                    }
                ],
                oLanguage: {
                    sLengthMenu: "{{trans('newsletter.show_subscribers')}}",
                    sInfo: "{{trans('newsletter.showing_subscribers')}}",
                    sEmptyTable : "{{trans('newsletter.no_subscribers')}}"
                }
            });
            //Datatable end
            //

            // Check to delete subscriber
            $('#newsletter-table tbody').on('click', '.checkDeleteSubscriber', function () {
                var subscriber = newsletterTable.row( $(this).parent().parent() ).data();

                if ($(this).is(':checked')) {
                    subscribersCheckedDelete.push(subscriber.id);
                } else {
                    var index = subscribersCheckedDelete.indexOf(subscriber.id);
                    if (index > -1) {
                        subscribersCheckedDelete.splice(index, 1);
                    }
                }

                var html = '';
                if (subscribersCheckedDelete.length > 0) {
                    html = '<i class="material-icons">delete</i> {{trans('newsletter.delete_num_subscribers1')}} ' + subscribersCheckedDelete.length + ' {{trans('newsletter.delete_num_subscribers2')}}';
                } else {
                    html = '<i class="material-icons">delete</i> {{trans('newsletter.delete_subscribers')}}';
                }
                $('#multipleDeleteBtn').html(html);
            });

            $('#multipleDeleteBtn').click(function(){
                if (subscribersCheckedDelete.length == 0) {
                    swal({
                        title: '',
                        type: "warning",
                        confirmButtonColor: "#DD6B55",
                        text: "{{__('newsletter.multiple-non-selected')}}"
                    });

                } else {
                    swal({
                        title: '{{__('newsletter.delete_title')}}',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ trans('newsletter.delete_confirmation_yes') }}",
                        cancelButtonText: "{{ trans('newsletter.delete_confirmation_no') }}",
                        closeOnConfirm: true
                    },
                    function(){
                        $.ajax({
                            url: '{{ route('newsletter.deleteMultiple') }}',
                            type: 'POST',
                            data: { data: subscribersCheckedDelete },
                            beforeSend: function() {
                                $('.page-loader-wrapper').show();
                            },
                            success: function(data){
                                if (data.status) {
                                    subscribersCheckedDelete = [];
                                    $('#multipleDeleteBtn').html('<i class="material-icons">delete</i> {{trans('newsletter.delete_subscribers')}}');

                                    swal({
                                        title: '{{ trans('newsletter.delete_success') }}',
                                        type: "success",
                                        html: true
                                    });
                                    newsletterTable.ajax.reload();
                                } else {
                                    swal({
                                        title: "{{ trans('newsletter.delete_error') }}",
                                        text: data.error,
                                        type: "error",
                                        html: true
                                    });
                                }
                            },
                            error: function(data){
                                laravelErrors(data);
                            },
                            complete: function() {
                                $('.page-loader-wrapper').fadeOut();
                            }
                        });
                    });
                }
            });

            $('#newsletter-table tbody').on('click', '.btnDeleteSubscriber', function () {
                var row = newsletterTable.row( $(this).parent().parent() ).data();

                swal({
                    title: 'Delete subscriber',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('newsletter.delete_confirmation_yes') }}",
                    cancelButtonText: "{{ trans('newsletter.delete_confirmation_no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('newsletter.delete') }}',
                        type: 'DELETE',
                        data: { id: row.id },
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {
                                var index = subscribersCheckedDelete.indexOf(row.id);
                                if (index > -1) {
                                    subscribersCheckedDelete.splice(index, 1);
                                    var html = '';
                                    if (subscribersCheckedDelete.length > 0) {
                                        html = '<i class="material-icons">delete</i> Delete ' + subscribersCheckedDelete.length + ' subscribers';
                                    } else {
                                        html = '<i class="material-icons">delete</i> Delete subscribers';
                                    }
                                    $('#multipleDeleteBtn').html(html);
                                }

                                swal({
                                    title: '{{ trans('newsletter.delete_success') }}',
                                    type: "success",
                                    html: true
                                });
                                newsletterTable.ajax.reload();
                            } else {
                                swal({
                                    title: "{{ trans('newsletter.delete_error') }}",
                                    text: data.error,
                                    type: "error",
                                    html: true
                                });
                            }
                        },
                        error: function(data){
                            laravelErrors(data);
                        },
                        complete: function() {
                            $('.page-loader-wrapper').fadeOut();
                        }
                    });
                });
            });


            $("#btnSubmitNotification").click(function(){
                var form = $('#frmNotification');
                if(form.valid()){
                    form.submit();
                }
            });

            /*
             * Task object.
             * Properties must be the same as the validator request of Laravel.
             */
            var newsletter = {
                id: "",
                name: "",
                email: ""
            }
        });

        $("body").on('click','.btnSendUnsubscriptionEmail',function () {
           var id = $(this).data('id');
            swal({
                    title: "{{__('newsletter.unsubscribe_title')}}",
                    text: "{{__('newsletter.unsubscribe_text')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{__('newsletter.send')}}",
                    closeOnConfirm: true
                },

                function(){
                    $.ajax({
                        url: '{{ route('newsletter.unsubscribe_email') }}',
                        type: 'POST',
                        data: { id: id },
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {
                                swal({
                                    title: '{{ trans('newsletter.email_sent_unsubscribe') }}',
                                    type: "success",
                                    html: true
                                });
                            } else {
                                swal({
                                    title: "{{ trans('newsletter.email_error_unsubscribe') }}",
                                    type: "error",
                                    html: true
                                });
                            }
                        },
                        error: function(data){
                            laravelErrors(data);
                        },
                        complete: function() {
                            $('.page-loader-wrapper').fadeOut();
                        }
                    });
            });

        });
    </script>
@endsection
