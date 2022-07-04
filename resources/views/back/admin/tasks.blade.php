@extends('layouts.back')

@section('styles')
  <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 class="content-title">{{ trans("task.header") }}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#request_for_modification' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="row content-row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered" id="tasks-table" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>{{ trans('task.task_name') }}</th>
                      <th>{{ trans('task.project_name') }}</th>
                      <th>{{ trans('task.section') }}</th>
                      @if (Auth::user()->isAdmin())
                          <th>{{ trans('task.user_id') }}</th>
                      @endif
                      <th>{{ trans('task.reason') }}</th>
                      <th>{{ trans('task.proposal') }}</th>
                      <th>{{ trans('task.status') }}</th>
                      @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
                          <th><i class="material-icons">create</i></th>
                      @endif
                      @if(Auth::user()->isAdmin()) <th><i class="material-icons">delete</i></th> @endif
                  </tr>
              </thead>
          </table>
        </div>
      </div>
    </div>
    @if ( Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator() )
        <!-- Modal Edit Task ====================================================================================================================== -->
        <div class="modal fade " id="modalEditTask" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">{{ trans('task.edit_task') }}</h4>
                </div>
                <div class="modal-body" style="overflow: visible;">
                    <form id="frmEditTask">
                        @if(Auth::user()->isAdmin())
                        <div class="form-group form-float">
                            <b>{{ trans("task.task_name") }}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                        @endif
                        <input type="hidden" value="" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect text-uppercase" id="btnEditTask">{{ trans('task.save_changes') }}</button>
                    <button type="button" class="btn btn-link waves-effect text-uppercase" data-dismiss="modal">{{ trans('task.close') }}</button>
                </div>
            </div>
        </div>
        <!--  Modal Edit Task ====================================================================================================================== -->
    @endif
@endsection

@section('scripts')
  <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>
  <script src="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
  <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
  <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
  <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

  <script>
    $(document).ready(function(){

    @if (Auth::user()->isAdmin())
        // Green color (materialize) if selectpicker state is valid
        $(".selectpicker").on('change', function(){
            if ($(this).find("option:selected").val()) {
                $(this).parent().parent().addClass('focused success');
            } else {
                $(this).parent().parent().removeClass('focused success');
            }
        });

    @endif

      // Initialize jQuery data-table
      var tasksTable = $('#tasks-table').DataTable({
        // order: [[ 6, "asc" ], [ 5, "desc" ]],
        columnDefs: [
            { className: "text-center", "targets": [ @if(Auth::user()->isAdmin())6, 7, 8, 9 @elseif(Auth::user()->isProjectCoordinator()) 5, 6, 7 @else 5, 6 @endif] }
        ],
        processing: true,
        serverSide: true,
        ajax: {
          url : '{!! route('tasks.tableTasks') !!}',
          method : 'POST'
        },
        columns: [
          {
              data: 'id',
              name: 'id'
          },
          {
              data: null,
              name: 'name',
              render: function(data) {
                  return '<a href="'+ data.task_url +'">'+data.name+'</a>';
              }
          },
          { data: 'project_name', name: 'projects.name' },
          { data: 'section_name', name: 'section_name' },
          @if (Auth::user()->isAdmin())
            {
                name: 'user_name',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var user = data.user_name + ' ('+data.user_email+')';
                    return user;
                }
              },
          @endif
          {
            name: 'reason',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                if (data.reason == null) {
                    return '<i style="color:#999;">No reason.</i>';
                } else {
                    return data.reason;
                }
            }
          },
          {
            name: 'proposal',
            data: null,
            sortable: false,
            searchable: false,
            render: function () {
                var actions = '<button type="button" class="btn btn-info btn-circle waves-effect waves-circle waves-float btnProposal">\
                                  <i class="material-icons">search</i> \
                              </button>';
                return actions;
            }
          },
          {
            name: 'status',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                // Accepted
                if (data.status == null) {
                    @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
                            return '<div class="text-center d-flex flex-nowrap"> <button type="button" class="btn btn-danger btn-circle waves-effect waves-circle waves-float btnDecline">\
                                          <i class="material-icons">close</i> \
                                      </button> \
                                      <button type="button" class="btn btn-success btn-circle waves-effect waves-circle waves-float btnAccept"> \
                                          <i class="material-icons">check</i> \
                                      </button></div>';
                    @else
                        return '<span class="label label-warning" style="font-size:0.9em">{{trans('task.request_modification_pending')}}</span>';
                    @endif

                } else if (data.status == 1) {
                    return '<span class="label label-success" style="font-size:0.9em">{{trans('task.request_modification_accepted')}}</span>';
                } else if (data.status == 2) {
                    @if (Auth::user()->isAdmin())
                        return '<div class="text-center"> <button type="button" class="btn btn-danger btn-circle waves-effect waves-circle waves-float btnDecline">\
                                      <i class="material-icons">close</i> \
                                  </button> \
                                  <button type="button" class="btn btn-success btn-circle waves-effect waves-circle waves-float btnAccept"> \
                                      <i class="material-icons">check</i> \
                                  </button></div>';
                    @else
                      return '<span class="label label-warning" style="font-size:0.9em">{{trans('task.request_modification_confirmed')}}</span>';
                    @endif
                } else {
                    if (data.reason_declined == null) {
                        return '<span class="label label-danger" style="font-size:0.9em">{{trans('task.request_modification_declined')}}</span>';
                    } else {
                        return '<button type="button" class="btn btn-danger waves-effect btnDeclineReason" style="font-size:0.8em;font-weight:bold;">{{trans('task.request_modification_declined')}} <i class="material-icons" style="font-size:1.3em;">search</i></span>';
                    }
                }
            }
          },
          @if (Auth::user()->isAdmin() ||  Auth::user()->isProjectCoordinator() )
              {
                name: 'edit',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                  var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float btnEditTask">\
                                    <i class="material-icons">create</i> \
                                </button>'
                  return actions;
                }
              },
           @endif

          @if(Auth::user()->isAdmin())
              {
                  name: 'delete',
                  data: null,
                  sortable: false,
                  searchable: false,
                  render: function (data) {
                    var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float btnDeleteTask">\
                                      <i class="material-icons">delete</i>\
                                  </button>'
                    return actions;
                  }
              }
          @endif
        ],
        oLanguage: {
          sLengthMenu: "{{trans('task.show')}} _MENU_ {{trans('task.tasks')}}",
          sInfo: "{{trans('task.showing')}} _START_ {{trans('task.to')}} _END_ {{trans('task.of')}} _TOTAL_ {{trans('task.tasks')}}",
          sEmptyTable : "{{trans('task.no_tasks')}}"
        }
      });
      //Datatable end

    // Set defaults for jQuery validator and initialize it to be able to perform client-side validation for new Tasks.
    $.validator.setDefaults({
        ignore: ":hidden:not(.selectpicker)",

        errorPlacement: function (error, element) {
            if (element.hasClass('bs-select')) {
                error.insertAfter('.bootstrap-select');
            } else {
                error.insertAfter(element);
            }
        }
    });

    var validatorEditTask = $('#frmEditTask').validate({
      rules: {
            @if(Auth::user()->isAdmin())
                'name': {   required: true  }
            @endif
      },
      highlight: function (input) {
          $(input).parents('.form-line').addClass('error');
      },
      unhighlight: function (input) {
          $(input).parents('.form-line').removeClass('error');
      },
      errorPlacement: function (error, element) {
          $(element).parents('.form-group').append(error);
      },
      success: function (msg, element) {
          $(element).parents('.form-line').addClass('success');
      }
    });

    // See proposal
    $('#tasks-table tbody').on('click', '.btnProposal', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var task = tasksTable.row($(this).parent().parent()).data();
        var files_json = JSON.parse(task.files_json.replace(/&quot;/g, '"'));
        var files_html = '';
        $.each(files_json, function (index, value) {

            files_html += '<tr><th>File #' + (index+1) + '</th><td><a href="'+ value.url +'" target="_blank"> '+value.old_name+' </a></td></tr>';

        });

        var files_to_delete_json = JSON.parse(task.files_to_delete.replace(/&quot;/g, '"'));
        var files_to_delete_html = '';
        $.each(files_to_delete_json, function (index, value) {

            files_to_delete_html += '<tr><th>File to delete #' + (index+1) + '</th><td><a href="'+ value.url +'" target="_blank"> '+value.old_name+' </a></td></tr>';

        });

        var data_json = task.proposal.replace(/&quot;/g, '"');
        var data = JSON.parse(data_json);

        var message_html = '<div style="margin-bottom:10px; border:1px solid #CCC;padding:5px;text-align:left;">';

        if (task.position == 0) {
            message_html += '<p>The user <strong>'+task.user_name+'</strong> proposed to add the data displayed in the table below to the section <strong>'+task.section_name+'</strong> of the project <strong>'+task.project_name+'</strong>.</p>';
        } else {
            message_html += 'The user <strong>'+task.user_name+'</strong> proposed to modify the section <strong>'+task.section_name+'</strong> of the project <strong>'+task.project_name+'</strong>.</p>';
        }

        var section_url = '<p><a href="'+task.task_url+'" target="_blank"> \
            {{ trans('task.request_modification_go_section') }} <i style="font-size:0.9em" class="material-icons">open_in_new</i> \
            </a></p>';

        message_html += section_url+'</div>';

        if (task.reason != null) {
            var reason_html = '<p style="margin-bottom:10px; border:1px solid #CCC;padding:5px;text-align:left;">The user specified the following reason: <i>'+task.reason+'</i></p>';
        } else {
            var reason_html = "";
        }

        var data_html = message_html+reason_html+'<table class="rfm-proposal-table">';
        $.each(data, function(field, values) {
            data_html += '<tr><th>'+values.label+'</th><td>'+values.value+'</td></tr>';
        });

        data_html += files_html + files_to_delete_html + '</table>';

        if (task.position == 0) {
            var title_html = '<i class="material-icons" style="font-size:1em;">add_circle_outline</i> Request for creation proposal';
        } else {
            var title_html = '<i class="material-icons" style="font-size:1em;">mode_edit</i> Request for modification proposal';
        }

        swal({
            title: title_html,
            text: data_html,
            html: true,
            type: "info"
        });
    });


    // Accept task
    $('#tasks-table tbody').on('click', '.btnAccept', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var task = tasksTable.row($(this).parent().parent().parent()).data();

        swal({
                title: "{{trans('task.request_modification_accept')}}",
                type: "warning",
                text: "{{trans('task.request_modification_accept_confirmation')}}",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(){
                $.ajax({
                    url: '{{ route('tasks.accept') }}',
                    type: 'POST',
                    data: { id: task.id },
                    dataType: "json",
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    success: function(data){
                        swal({
                            title: '{{trans('task.request_modification')}} {{trans('task.request_modification_accepted')}}',
                            type: "success",
                            html: true
                        });

                        tasksTable.ajax.reload();
                    },
                    error: function(errors){
                        laravelErrors(errors);
                    },
                    complete: function() {
                        $('.page-loader-wrapper').fadeOut();
                    }
                });
            });
    });

    // Decline task
    $('#tasks-table tbody').on('click', '.btnDecline', function (event) {
        event.preventDefault();
        event.stopPropagation();

        var task = tasksTable.row($(this).parent().parent().parent()).data();

        // Do you confirm that you want to decline this Request for modification?
        swal({
            title: "{{trans('task.request_modification_decline')}}",
            type: "warning",
            text: '<textarea rows="3" id="decline_reason" class="textarea form-control no-resize" placeholder="{{trans('task.request_modification_decline_reason_placeholder')}}"></textarea>',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel",
            closeOnConfirm: true,
            closeOnCancel: true,
            html: true
        },
        function(){
            var decline_reason = $('#decline_reason').val();
            $.ajax({
                url: '{{ route('tasks.decline') }}',
                type: 'POST',
                data: { id: task.id, reason: decline_reason },
                dataType: "json",
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                success: function(data){
                    swal({
                        title: '{{trans('task.request_modification')}} {{trans('task.request_modification_declined')}}',
                        type: "success",
                        html: true
                    });
                    tasksTable.ajax.reload();
                },
                error: function(errors){
                    laravelErrors(errors);
                },
                complete: function() {
                    $('.page-loader-wrapper').fadeOut();
                }
            });
        });
    });


    // Waiting task
    $('#tasks-table tbody').on('click', '.btnWaiting', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var task = tasksTable.row($(this).parent().parent()).data();

        swal({
            title: "{{trans('task.request_modification_confirm')}}",
            type: "warning",
            text: "{{trans('task.request_modification_confirm_confirmation')}}",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(){
            $.ajax({
                url: '{{ route('tasks.confirm') }}',
                type: 'POST',
                data: { id: task.id },
                dataType: "json",
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                success: function(data){
                    swal({
                        title: '{{trans('task.request_modification')}} {{trans('task.request_modification_sent_approval')}}',
                        type: "success",
                        html: true
                    });

                    tasksTable.ajax.reload();
                },
                error: function(errors){
                    laravelErrors(errors);
                },
                complete: function() {
                    $('.page-loader-wrapper').fadeOut();
                }
            });
        });
    });

    // Show declined reason
    $('#tasks-table tbody').on('click', '.btnDeclineReason', function (event) {
        event.preventDefault();
        event.stopPropagation();

        var task = tasksTable.row($(this).parent().parent()).data();

        swal({
            title: "{{ trans('task.request_modification_decline_reason') }}:",
            type: "info",
            text: "<span style='font-size:1.1em'>" + task.reason_declined + "</span>",
            html: true,
        });
    });

    // Open edit Task modal
    $('#tasks-table tbody').on('click', '.btnEditTask', function () {
        var form = $("#frmEditTask");
        var modal = $("#modalEditTask");

        var task = tasksTable.row( $(this).parent().parent() ).data();

        modal.find('.success').removeClass('success');
        modal.find('.error').removeClass('error');
        form.find('.form-line').siblings('label').remove();

        modal.modal('toggle');

        form.find("[name=id]").val(task.id);

        @if( Auth::user()->isAdmin() )
        form.find("[name=name]").parent().addClass('focused');
        form.find("[name=name]").val(task.name);
        @endif

        

    });


    // Edit task button.
    $("#btnEditTask").click(function(){
      var frmEdit = $('#frmEditTask');

      if(frmEdit.valid()){
          task.id =  frmEdit.find("[name=id]").val();

          @if( Auth::user()->isAdmin())
          task.name =  frmEdit.find("[name=name]").val();
          @endif

          $.ajax({
              url: '{{ route('tasks.edit') }}',
              type: 'POST',
              data: task,
              beforeSend: function() {
                  $('.page-loader-wrapper').show();
              },
              success: function(data){
                  if(data.status){
                      $("#modalEditTask").modal('toggle');
                      swal({
                          title: "{{ trans('task.task_updated') }}",
                          type: "success",
                          html: true
                      });
                      tasksTable.ajax.reload();
                  } else {
                      laravelErrors(data);
                  }
              },
              error: function(data){
                  laravelErrors(data);
              },
              complete: function() {
                  $('.page-loader-wrapper').fadeOut();
              }
          });
      } else {
          console.log("invalid")
      }
    });

    // Remove task button.
    $('#tasks-table tbody').on('click', '.btnDeleteTask', function () {
    var task = tasksTable.row( $(this).parent().parent() ).data();

    swal({
        title: '{{ trans('task.task_delete_confirmation') }}',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "{{ trans('task.task_delete_confirmation_yes') }}",
        cancelButtonText: "{{ trans('task.task_delete_confirmation_no') }}",
        closeOnConfirm: true
    },
    function(){
        $.ajax({
            url: '{{ route('tasks.delete') }}',
            type: 'POST',
            data: { id: task.id },
            beforeSend: function() {
                $('.page-loader-wrapper').show();
            },
            success: function(data){
                if (data.status) {
                    swal({
                        title: '{{ trans('task.task_deleted') }}',
                        type: "success",
                        html: true
                    });
                    tasksTable.ajax.reload();
                } else {
                    swal({
                        title: "{{ trans('task.task_not_deleted') }}",
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

    function laravelErrors(errors){
    var li = "" , element;
    $.each(errors.responseJSON, function(index, field){
      $.each(field, function(index2, error){
        li += '<li>' + error + '</li>';
      });
    });

    element = '<div class="alert alert-danger">\
        <ul>' + li +'</ul>\
    </div>';
    $(".errors").html(element);
  }

    /*
    * Task object.
    * Properties must be the same as the validator request of Laravel.
    */
    var task = {
        name: "",
    };


    });

  </script>

@endsection
