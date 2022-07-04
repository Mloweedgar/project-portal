@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')


    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#project_announcements' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project/project-details/announcements.title'),"visible" => $project->announcements_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "a","project" => $project->id])
    @endcomponent --}}


    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/announcements.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        <form method="post" id="dynamic-form-validation" action="{{route("project-details-announcements/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/announcements.group")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/announcements.group-placeholder")}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/announcements.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize richEditor" name="description" placeholder="{{__("project/project-details/announcements.description-placeholder")}}" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/announcements.publication_date")}}</b>
                                <div class="form-line">
                                    <input type="text" id="announcement-default-date" class="form-control datepicker" name="updated_at" required>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'a',
                                'positionAddress' => -1
                            ])@endcomponent

                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'description'],
                                'position'=>0,
                                'section'=>'a',
                                'project'=>$project->id,
                                'hasCoordinators'=>$hasCoordinators
                            ])
                            @endcomponent
                        </form>
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if(count($announcements) > 0)

        @foreach($announcements as $announcement)

            <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$announcement->draft])
                                @endcomponent
                                <span>{{$announcement->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $announcement->id,
                                    'status' => $announcement->published,
                                    'route' => route('project-details-announcements/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$announcement->id}}"></i>
                            </h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" action="{{route("project-details-announcements/edit")}}" class="frmEditAnnouncement">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$announcement->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/announcements.group")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/announcements.group-placeholder")}}" value="{{$announcement->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/announcements.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize richEditor" name="description" placeholder="{{__("project/project-details/announcements.description-placeholder")}}">{{$announcement->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/announcements.publication_date")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="updated_at" value="{{$announcement->getPreviewCreatedAt()}}" required>
                                    </div>
                                </div>

                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 'a',
                                    'positionAddress' => $announcement->id
                                ])@endcomponent

                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description'],
                                    'position'=>$announcement->id,
                                    'section'=>'a',
                                    'project'=>$project->id,
                                    'hasCoordinators'=>$hasCoordinators
                                ])
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

@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "a","project_id" => $project->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>


    <script>
    $('.datepicker').datetimepicker({
        sideBySide: true
    });
    $("#announcements-default-date").val(Date());

    function generateUniqueID() {
        randomNumber = Math.round(new Date().getTime() + (Math.random() * 100));
        return randomNumber;
    }

    // Rich Editor
    $('.richEditor').each(function(){
        $(this).attr('id', generateUniqueID());
        CKEDITOR.replace(this.id);
    });

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

                swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/announcements.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-announcements/delete') }}',
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
                                    text: '{{ trans('project/project-details/announcements.deleted') }}',
                                    type: "success",
                                    html: true
                                });

                                card.remove();
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

        $(".frmEditAnnouncement").each(function(){
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
                  text: "{{trans('project/project-details/announcements.success')}}",
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
