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
        <a href="{{ route('documentation').'#procurement_documents' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.procurement'), "visible" => $project->procurement_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/procurement.title")}}</h1>
    </div>

    {{-- @component('back.components.request-modification-new', ["section" => "pri","project" => $project->id])
    @endcomponent --}}

    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/procurement.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        <form method="post" id="dynamic-form-validation" action="{{route("procurement/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="form-group">
                                <b>{{__("project/project-details/procurement.group")}}</b>
                                <div class="form-line">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" value="{{old("name")}}" placeholder="{{__("project/project-details/procurement.group-placeholder")}}" required>
                                        </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/procurement.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/procurement.description-placeholder")}}" required>{{old("description")}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                        'projectAddress' => $project->id,
                                        'sectionAddress' => 'pri',
                                        'positionAddress' => -1
                            ])@endcomponent

                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'description' ],
                                'position'=>0,
                                'section'=>'pri',
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

    @if(count($procurements) > 0)

        <ul id="sortable">
        @foreach($procurements as $procurement)
            <li class="ui-state-default" data-order="{{$procurement->position}}">
            <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$procurement->draft])
                                @endcomponent
                                <span>{{$procurement->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $procurement->id,
                                    'status' => $procurement->published,
                                    'route' => route('procurement/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$procurement->id}}"></i>
                            </h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" class="frmEditProcurement" action="{{route("procurement/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$procurement->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/procurement.group")}}</b>
                                    <div class="form-line">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/procurement.group-placeholder")}}" value="{{$procurement->name}}">
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/procurement.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/procurement.description-placeholder")}}">{{$procurement->description}}</textarea>
                                    </div>
                                </div>

                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 'pri',
                                    'positionAddress' => $procurement->id
                                ])@endcomponent

                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description' ],
                                    'position'=>$procurement->id,
                                    'section'=>'pri',
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
            <button type="button" id="order-save-button" class="btn btn-large btn-primary waves-effect m-t-20 m-l-30">{{__('order.save')}}</button>
        @endif
    @else

        @component('back.components.no-results')
        @endcomponent

    @endif

@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    @component('back.components.enable-section-js', ["section" => "pri","project_id" => $project->id])
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
                url: '{{ route('procurement/order') }}',
                type: 'POST',
                data: { order: order, project_id: {{$project->id}} },
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

        @if(Auth::user()->canDelete())
            $('.delete-group').click(function(){
            var id = $(this).data('id');

            var card = $(this).parent().parent().parent().parent();

            swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/procurement.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('procurement/delete') }}',
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
                                    text: '{{ trans('project/project-details/procurement.deleted') }}',
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

        $("#frmCreateProcurement").validate({
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

        $(".frmEditProcurement").each(function(){
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
            text: "{{trans('project/project-details/procurement.success')}}",
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

        /**
         * Selectpicker for milestones names
         */

        var content = "<span class='glyphicon glyphicon-plus addnewicon' onClick='addSelectItem(this,event,1);'></span> <input class='select-add-option' type=text onKeyDown='event.stopPropagation();' onKeyPress='addSelectInpKeyPress(this,event)' onClick='event.stopPropagation()' placeholder='Add item'>";

        var divider = $('<option/>')
            .addClass('divider')
            .data('divider', true);


        var addoption = $('<option/>')
            .addClass('additem')
            .data('content', content);


            $('select.doc-name').prepend(divider).prepend(addoption).selectpicker("refresh");


        function addSelectItem(t,ev)
        {
            ev.stopPropagation();

            var txt=$(t).next().val();

            if ($.trim(txt)=='') return;
            var p=$(t).closest('.bootstrap-select').find(".selectpicker");

            var o=$('option', p).eq(2);
            o.before( $("<option>", { "value": txt, "text": txt}) );
            //p.prepend(divider).prepend(addoption);
            p.selectpicker('refresh');
        }

        function addSelectInpKeyPress(t,ev) {
            ev.stopPropagation();

            // do not allow pipe character
            if (ev.which == 124) ev.preventDefault();

            // enter character adds the option
            if (ev.which == 13) {
                ev.preventDefault();
                addSelectItem($(t).prev(), ev);
            }
        }

    </script>
    @component('components.uploader-assets')
    @endcomponent
@endsection
