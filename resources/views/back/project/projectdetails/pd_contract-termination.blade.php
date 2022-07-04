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
        <a href="{{ route('documentation').'#termination_provisions' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/contract-termination.title")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $projectDetail->contract_termination_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "ct","project" => $project->id])
    @endcomponent --}}

    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/contract-termination.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        <form method="post" id="dynamic-form-validation" action="{{route("project-details-contract-termination/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/contract-termination.party")}}</b>
                                <div class="form-line">
                                    <select class="form-control show-tick selectpicker" name="party_type" title="-- {{__("project/project-details/contract-termination.select-party")}} --" required>
                                        <option value="operator" @if(old('party_type') == 'operator') selected @endif>{{__("project/project-details/contract-termination.party_operator")}}</option>
                                        <option value="authority" @if(old('party_type') == 'authority') selected @endif>{{__("project/project-details/contract-termination.party_authority")}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/contract-termination.group")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/contract-termination.placeholder")}}" value="{{old('name')}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/contract-termination.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/contract-termination.description-placeholder")}}" required>{{old('description')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/contract-termination.termination_payment")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="termination_payment" placeholder="{{__("project/project-details/contract-termination.description-placeholder")}}" required>{{old('termination_payment')}}</textarea>
                                </div>
                            </div>
                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'ct',
                                'positionAddress' => -1
                            ])@endcomponent
                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'party_type', 'name', 'description', 'termination_payment' ],
                                'position'=>0,
                                'section'=>'ct',
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

    @if(count($contract_terminations) > 0)
        <ul id="sortable">
            @foreach($contract_terminations as $contract_termination)
                <li class="ui-state-default" data-order="{{$contract_termination->position}}">
                    <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$contract_termination->draft])
                                @endcomponent
                                <span>{{$contract_termination->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $contract_termination->id,
                                    'status' => $contract_termination->published,
                                    'route' => route('project-details-contract-termination/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$contract_termination->id}}"></i></h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" class="frmEditContractTermination" action="{{route("project-details-contract-termination/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$contract_termination->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/contract-termination.party")}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="party_type" title="-- {{__("project/project-details/contract-termination.select-party")}} --">
                                            <option value="operator" @if($contract_termination->party_type == 'operator') selected @endif>{{__("project/project-details/contract-termination.party_operator")}}</option>
                                            <option value="authority" @if($contract_termination->party_type == 'authority') selected @endif>{{__("project/project-details/contract-termination.party_authority")}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/contract-termination.group")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/contract-termination.placeholder")}}" value="{{$contract_termination->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/contract-termination.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/contract-termination.description-placeholder")}}">{{$contract_termination->description}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/contract-termination.termination_payment")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="termination_payment" placeholder="{{__("project/project-details/contract-termination.description-placeholder")}}">{{$contract_termination->termination_payment}}</textarea>
                                    </div>
                                </div>
                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 'ct',
                                    'positionAddress' => $contract_termination->id
                                ])@endcomponent
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'party_type', 'name', 'description', 'termination_payment' ],
                                    'position'=>$contract_termination->id,
                                    'section'=>'ct',
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

    @if(count($contract_terminations) > 0)
        <h1 class="content-title-project">{{__("project/project-details/contract-termination.section-summary")}}</h1>
        <div class="row content-row">
            <div class="col-md-12">
                <div class="body table-responsive">
                    <table class="table table-bordered" id="summary_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__("project/project-details/contract-termination.table_name")}}</th>
                                <th>{{__("project/project-details/contract-termination.table_description")}}</th>
                                <th>{{__("project/project-details/contract-termination.table_termination_payment")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($contract_terminations as $contract_termination)
                            <tr data-id="{{$contract_termination->id}}">
                                <td>
                                @if ($contract_termination->party_type == 'authority')
                                    {{__("project/project-details/contract-termination.party_authority")}}
                                @elseif ($contract_termination->party_type == 'operator')
                                    {{__("project/project-details/contract-termination.party_operator")}}
                                @endif
                                </td>
                                <td>{{$contract_termination->name}}</td>
                                <td>{{$contract_termination->description}}</td>
                                <td>{{$contract_termination->termination_payment}}</td>
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

    @component('back.components.enable-subsection-js', ["section" => "ct","project_id" => $projectDetail->id])
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
                url: '{{ route('project-details-contract-termination/order') }}',
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

                var card = $(this).parent().parent().parent().parent();
                var summary_row = $('#summary_table tbody').find('tr[data-id="'+id+'"]');

                swal({
                    title: '{{ trans('messages.confirm_question') }}',
                    text: '{{ trans('project/project-details/contract-termination.delete_confirm') }}',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-contract-termination/delete') }}',
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
                                    text: '{{ trans('project/project-details/contract-termination.deleted') }}',
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

        $(".frmEditContractTermination").each(function(){
            var form = $(this);
            var validator = form.validate({
              ignore: ":hidden:not(.selectpicker)",
              /* Onkeyup
               * For not sending an ajax request to validate the email each time till the typing is done.
               */
              /*onkeyup: false,*/
              rules: {
                party_type: {
                    required: true
                },
                name:{
                  required: true
                },
                description:{
                  required: true
                },
                termination_payment: {
                    required:true
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
                  text: "{{trans('project/project-details/contract-termination.success')}}",
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
