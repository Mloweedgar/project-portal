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

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#government_support' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection"> {{__("project/project-details/government-support.title")}} </h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $projectDetail->government_support_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "gs","project" => $project->id])
    @endcomponent --}}

    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/government-support.add-group")}} </span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        <form method="post" id="dynamic-form-validation" action="{{route("project-details-government-support/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b> {{__("project/project-details/government-support.group")}} </b>
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{old("name")}}" name="name" placeholder="{{__("project/project-details/government-support.placeholder")}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/government-support.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/government-support.description-placeholder")}}" required></textarea>
                                </div>
                            </div>
                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'gs',
                                'positionAddress' => -1
                            ])@endcomponent
                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'description', 'help' ],
                                'position'=>0,
                                'section'=>'gs',
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

    @if(count($government_supports) > 0)
        <ul id="sortable">
        @foreach($government_supports as $government_support)
                <li class="ui-state-default" data-order="{{$government_support->position}}">

            <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$government_support->draft])
                                @endcomponent
                                <span>{{$government_support->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $government_support->id,
                                    'status' => $government_support->published,
                                    'route' => route('project-details-government-support/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$government_support->id}}"></i></h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" class="frmEditGovernmentSupport" action="{{route("project-details-government-support/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$government_support->id}}">
                                <div class="form-group">
                                    <b> {{__("project/project-details/government-support.group")}} </b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/government-support.placeholder")}}" value="{{$government_support->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/government-support.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/government-support.description-placeholder")}}">{{$government_support->description}}</textarea>
                                    </div>
                                </div>
                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 'gs',
                                    'positionAddress' => $government_support->id
                                ])@endcomponent
                                <input type="hidden" name="submit-type">

                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description', 'help' ],
                                    'position'=>$government_support->id,
                                    'section'=>'gs',
                                    'project'=>$project->id,
                                    'hasCoordinators'=>$hasCoordinators
                                ])
                                @endcomponent
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                </li>
            @endforeach
        </ul>
        @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
            <button type="button" id="order-save-button" class="btn btn-large btn-primary waves-effect m-t-20 m-l-30" disabled>{{__('order.save')}}</button>
        @endif
    @else
        @component('back.components.no-results')
        @endcomponent
    @endif

@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "pd","project_id" => $project->id])
    @endcomponent

    @component('back.components.enable-subsection-js', ["section" => "gs","project_id" => $projectDetail->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script src="{{ asset('back/plugins/jquery-ui-1.12.1/jquery-ui.js') }}"></script>

    <script>
        @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())

        /**
         * Drag and drop
         */
        var order;

        $(function() {
            $( "#sortable" ).sortable({
                update: function(event, ui) {
                    order = [];
                    $('#sortable li').each( function(e) {
                        order.push( $(this).data('order'));
                    });
                    order = order.filter(function(n){ return n != undefined });
                    $("#order-save-button").prop('disabled',false);

                }
            });
        });

        $("#order-save-button").click(function () {
            $.ajax({
                url: '{{ route('project-details-government-support/order') }}',
                type: 'POST',
                data: { order: order, project_id: {{$projectDetail->id}} },
                beforeSend: function() {
                },
                success: function(data){
                    swal({
                            title: '{{ trans('messages.success') }}',
                            text: "{{trans('order.success')}}",
                            type: "success",
                        },function () {
                            location.reload();
                        }
                    );
                },
                error: function(data){
                },
                complete: function() {
                }
            });
        });

        @endif

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

        @if(Auth::user()->canCreate())
            $('.delete-group').click(function(){
            var id = $(this).data('id');

            var box = $(this).parent().parent().parent();
            var summary_row = $('#summary_table tbody').find('tr[data-id="'+id+'"]');

            swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: ' {{ trans('project/project-details/government-support.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-government-support/delete') }}',
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
                                    text: '{{ trans('project/project-details/government-support.deleted') }}',
                                    type: "success",
                                    html: true
                                });

                                box.remove();
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

        $("#frmCreateGovernmentSupport").validate({
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

        $(".frmEditGovernmentSupport").each(function(){
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
            text: "{{ trans('project/project-details/government-support.success') }}",
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
