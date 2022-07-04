@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/evaluation-ppp.title")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $projectDetail->evaluation_ppp_active])
    @endcomponent

    @component('back.components.request-modification-new', ["section" => "e","project" => $project->id])
    @endcomponent

    @if (Auth::user()->canCreate($project->id,'e'))
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/evaluation-ppp.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                    </div>
                    <div id="card-body" class="body @if (count($errors) > 0 || (isset($flag))) is-visible @else not-visible @endif">
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
                        <form method="post" id="dynamic-form-validation" action="{{route("project-details-evaluation-ppp/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/evaluation-ppp.group")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{old("name")}}" name="name" placeholder="{{__("project/project-details/evaluation-ppp.placeholder")}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/evaluation-ppp.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/evaluation-ppp.description-placeholder")}}" required></textarea>
                                </div>
                            </div>
                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'e',
                                'positionAddress' => -1
                            ])@endcomponent
                            <a id="upload-button" class="btn btn-large btn-primary waves-effect">{{__("project/project-details/evaluation-ppp.add-group")}}</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if(count($evaluations) > 0)
        @foreach($evaluations as $evaluation)
            <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$evaluation->draft])
                                @endcomponent
                                <span>{{$evaluation->name}}</span> <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$evaluation->id}}"></i></h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" class="frmEditEvaluation" action="{{route("project-details-evaluation-ppp/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$evaluation->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/evaluation-ppp.group")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/evaluation-ppp.placeholder")}}" value="{{$evaluation->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/evaluation-ppp.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/evaluation-ppp.description-placeholder")}}">{{$evaluation->description}}</textarea>
                                    </div>
                                </div>
                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 'e',
                                    'positionAddress' => $evaluation->id
                                ])@endcomponent
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons',['position'=>$evaluation->id,'section'=>'e','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                                @endcomponent
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

    @if(count($evaluations) > 0)
        <h1 class="content-title-project">{{__("project/project-details/evaluation-ppp.section-summary")}}</h1>
        <div class="row content-row">
            <div class="col-md-12">
                <div class="body table-responsive">
                    <table class="table table-bordered" id="summary_table">
                        <thead>
                            <tr>
                                <th>{{__("project/project-details/evaluation-ppp.table_title")}}</th>
                                <th>{{__("project/project-details/evaluation-ppp.table_description")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($evaluations as $evaluation)
                            <tr data-id="{{$evaluation->id}}">
                                <td>{{$evaluation->name}}</td>
                                <td>{{$evaluation->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "pd","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "e","project_id" => $projectDetail->id])
    @endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script>
    @if (!Auth::user()->isAdmin() && !Auth::user()->isProjectCoordinator())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
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

        @if(Auth::user()->canDelete())
            $('.delete-group').click(function(){
                var id = $(this).data('id');

                var card = $(this).parent().parent().parent().parent();
                var summary_row = $('#summary_table tbody').find('tr[data-id="'+id+'"]');

                swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/evaluation-ppp.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-evaluation-ppp/delete') }}',
                        type: 'DELETE',
                        data: { id: id },
                        dataType: "json",
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {
                                swal({
                                    title: '{{trans('messages.success')}}',
                                    text: '{{ trans('project/project-details/evaluation-ppp.deleted') }}',
                                    type: "success",
                                    html: true
                                });

                                card.remove();
                                summary_row.remove();
                            } else {
                                laravelErrors(data);
                            }
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
        @else
            $('i.delete-group').remove();
        @endif

        $("#frmCreateEvaluation").validate({
          ignore: ":hidden:not(.selectpicker)",
          /* Onkeyup
           * For not sending an ajax request to validate the email each time till the typing is done.
           */
          /*onkeyup: false,*/
          rules: {
            name:{
              required: true
            },
            description:{
              required: true
            },
          },
          submitHandler: function (form) {
              form.submit();
          }
        }); //Validation end

        $(".frmEditEvaluation").each(function(){
            var form = $(this);
            var validator = form.validate({
              ignore: ":hidden:not(.selectpicker)",
              /* Onkeyup
               * For not sending an ajax request to validate the email each time till the typing is done.
               */
              /*onkeyup: false,*/
              rules: {
                name:{
                  required: true
                },
                description:{
                  required: true
                },
              },
              submitHandler: function (form) {
                  form.submit();
              }
            }); //Validation end
        });

        @if (session('status') == true)
              swal({
                  title: "{{trans('messages.success')}}",
                  text: "{{trans('project/project-details/evaluation-ppp.success')}}",
                  type: "success",
                  html: true
              }, function(){
              });
          @elseif (session('error') == true)
            swal({
                title: "{{trans('messages.error')}}",
                text: "{{session('error')}}",
                type: "error",
                html: true
            }, function(){
            });
        @endif
    </script>
    @component('components.uploader-assets')
    @endcomponent
@endsection
