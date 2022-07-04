@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <style>
    #summary_table thead tr th, #summary_table tbody tr td
    {
        border:1px solid #F8F8F8;
    }
    #summary_table thead tr th, #summary_table tbody tr td:first-child
    {
        background:#EFEFEF;
    }
    </style>

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#risks' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/risks.title")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $projectDetail->risks_active])
    @endcomponent

{{--
    @component('back.components.request-modification-new', ["section" => "ri","project" => $project->id])
    @endcomponent --}}

    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if ($errors->any() || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/risks.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
                    </div>
                    <div id="card-body" class="body @if ($errors->any() || (isset($flag))) is-visible @else not-visible @endif">
                        @if ($errors->any())
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
                        <form method="post" id="frmCreateRisk" action="{{route("project-details-risks/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/risks.type_risk")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{old("name")}}" name="name" placeholder="{{__("project/project-details/risks.group-placeholder")}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/risks.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/risks.description-placeholder")}}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/risks.category")}}</b>
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" name="risk_category_id" title="-- {{__("project/project-details/risks.category-placeholder")}} --">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/risks.allocation")}}</b>
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" name="risk_allocation_id" title="-- {{__("project/project-details/risks.allocation-placeholder")}} --">
                                        @foreach($allocations as $allocation)
                                            <option value="{{$allocation->id}}">{{$allocation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/risks.mitigation")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="mitigation" placeholder="{{__("project/project-details/risks.mitigation-placeholder")}}"></textarea>
                                </div>
                            </div>

                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'description', 'risk_allocation_id', 'mitigation' ],
                                'position'=>0,
                                'section'=>'ri',
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

    @if(count($risks) > 0)
        <ul id="sortable">
            @foreach($risks as $risk)
                <li class="ui-state-default" data-order="{{$risk->position}}">
                    <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$risk->draft])
                                @endcomponent
                                <span>{{$risk->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $risk->id,
                                    'status' => $risk->published,
                                    'route' => route('project-details-risks/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$risk->id}}"></i></h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" class="frmEditRisk" action="{{route("project-details-risks/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$risk->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/risks.type_risk")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/risks.group-placeholder")}}" value="{{$risk->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/risks.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/risks.description-placeholder")}}">{{$risk->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/risks.category")}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="risk_category_id" title="-- {{__("project/project-details/risks.category-placeholder")}} --">
                                            @foreach($categories as $category)
                                                <option @if($risk->risk_category_id == $loop->iteration) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/risks.allocation")}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="risk_allocation_id" title="{{__("project/project-details/risks.allocation-placeholder")}}">
                                            @foreach($allocations as $allocation)
                                                <option @if($risk->risk_allocation_id == $loop->iteration) selected @endif value="{{$allocation->id}}">{{$allocation->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/risks.mitigation")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="mitigation" placeholder="{{__("project/project-details/risks.mitigation-placeholder")}}">{{$risk->mitigation}}</textarea>
                                    </div>
                                </div>

                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description', 'risk_allocation_id', 'mitigation' ],
                                    'position'=>$risk->id,
                                    'section'=>'ri',
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

    @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
    <h1 class="content-title-project">{{__("project/project-details/risks.title-documents")}}</h1>
    <div class="row content-row">
        <div class="col-md-12">
            @component('components.uploader', [
                'projectAddress' => $project->id,
                'sectionAddress' => 'ri',
                'positionAddress' => 1
            ])@endcomponent
        </div>
    </div>
    @endif

    @if(count($risks) > 0)
        <h1 class="content-title-project">{{__("project/project-details/risks.section-summary")}}</h1>
        <div class="row content-row">
            <div class="col-md-12">
                <div class="body table-responsive">
                    <table class="table table-bordered" id="summary_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__("project/project-details/risks.table_description")}}</th>
                                <th>{{__("project/project-details/risks.table_allocation")}}</th>
                                <th>{{__("project/project-details/risks.table_mitigation")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($risks as $risk)
                            <tr data-id="{{$risk->id}}">
                                <td width="20%">{{$risk->name}}</td>
                                <td width="30%">{{$risk->description}}</td>
                                <td width="20%">{{$controller->translateRiskAllocations($risk->risk_allocation_id)}}</td>
                                <td width="30%">{{$risk->mitigation}}</td>
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

    @component('back.components.enable-subsection-js', ["section" => "ri","project_id" => $projectDetail->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
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
                url: '{{ route('project-details-risks/order') }}',
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

        @if(Auth::user()->canDelete())
            $('.delete-group').click(function(){
                var id = $(this).data('id');

                var card = $(this).parent().parent().parent().parent();
                var summary_row = $('#summary_table tbody').find('tr[data-id="'+id+'"]');

                swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/risks.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-risks/delete') }}',
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
                                    text: '{{ trans('project/project-details/risks.deleted') }}',
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



        $("#frmCreateRisk").validate({
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
            risk_allocation_id: {
                required: true
            },
            mitigation: {
                required: true
            }
          },
          messages: {
              'risk_allocation_id': "{{ trans('jquery-validation.required') }}",
          },
          submitHandler: function (form) {
              form.submit();
          }
        }); //Validation end

        $(".frmEditRisk").each(function(){
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
                risk_allocation_id: {
                    required: true
                },
                mitigation: {
                    required: true
                }
              },
              submitHandler: function (form) {
                  form.submit();
              }
            }); //Validation end
        });

        @if (session('status') == true)
              swal({
                  title: "{{trans('messages.success')}}",
                  text: "{{trans('project/project-details/risks.success')}}",
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
