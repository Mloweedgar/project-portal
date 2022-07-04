@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-gallery.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/fineuploader-core/fine-uploader-new.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <style>

    </style>

    @component('back/components.fine-upload-template-1')
    @endcomponent

@endsection

@section('content')

    @component('components.project-menu', ["project" => $project, "project_name" => $project->name, "updated_at" => $project->updated_at])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#tariffs' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.project_details_title'),"visible" => $project->project_details_active])
    @endcomponent

    <div class="inline-block">
        <h1 class="content-title-project-subsection">{{__("project/project-details/tariffs.title")}}</h1>
    </div>

    @component('back.components.enable-subsection', ["visible" => $projectDetail->tariffs_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "t","project" => $project->id])
    @endcomponent --}}

    @if (!Auth::user()->isViewOnly())
        <div class="row content-row">
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if (count($errors) > 0 || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{__("project/project-details/tariffs.add-group")}}</span> <i id="keyboard_arrow" class="material-icons">keyboard_arrow_down</i></h2>
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
                        <form method="post" id="dynamic-form-validation" action="{{route("project-details-tariffs/store")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_details_id" value="{{$projectDetail->id}}">
                            <div class="form-group">
                                <b>{{__("project/project-details/tariffs.group")}}</b>
                                <div class="form-line">
                                    <input type="text" class="form-control" value="{{old("name")}}" name="name" placeholder="{{__("project/project-details/tariffs.placeholder")}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/tariffs.tariff-paid-by")}}</b>
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" name="paidBy" title="-- Choose paid by --">
                                                <option value="government">Government</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{__("project/project-details/tariffs.tariff-value")}}</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control decimal" name="value">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                {{-- Col --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{trans('project/project-details/tariffs.tariff-start-date')}}</b>
                                        <div class="form-line">
                                            <input type="text"
                                                   class="form-control datepicker"
                                                   name="startDate"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>{{trans('project/project-details/tariffs.tariff-end-date')}}</b>
                                        <div class="form-line">
                                            <input type="text"
                                                   class="form-control datepicker"
                                                   name="endDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>{{__("project/project-details/tariffs.description")}}</b>
                                <div class="form-line">
                                    <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/tariffs.description-placeholder")}}" required></textarea>
                                </div>
                            </div>
                            @component('components.uploader', [
                                        'projectAddress' => $project->id,
                                        'sectionAddress' => 't',
                                        'positionAddress' => -1
                                    ])@endcomponent

                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'description'],
                                'position'=>0,
                                'section'=>'t',
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

    @if(count($tariffs) > 0)
        <ul id="sortable">
            @foreach($tariffs as $tariff)
                <li class="ui-state-default" data-order="{{$tariff->position}}">
                    <div class="row content-row toggleable-wrapper">
                <div class="col-md-12">
                    <div class="card dynamic-card toggleable-container">
                        <div class="header card-header-static toggleable-card">
                            <h2>
                                @component('back.components.draft-chip',['draft'=>$tariff->draft])
                                @endcomponent
                                <span>{{$tariff->name}}</span>
                                @component('back.components.individual-visibility', [
                                    'project' => $project->id,
                                    'position' => $tariff->id,
                                    'status' => $tariff->published,
                                    'route' => route('project-details-tariffs/visibility')
                                ])@endcomponent
                                <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$tariff->id}}"></i> </h2>
                        </div>
                        <div class="body not-visible" data-status="0">
                            <form method="post" id="frmEditTariff" action="{{route("project-details-tariffs/edit")}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$tariff->id}}">
                                <div class="form-group">
                                    <b>{{__("project/project-details/tariffs.group")}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="name" placeholder="{{__("project/project-details/tariffs.placeholder")}}" value="{{$tariff->name}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>{{__("project/project-details/tariffs.tariff-paid-by")}}</b>
                                            <div class="form-line">
                                                <select class="form-control show-tick selectpicker" name="paidBy" title="-- Choose paid by --">
                                                    <option @if($tariff->paidBy == "government") selected @endif value="government">Government</option>
                                                    <option @if($tariff->paidBy == "user") selected @endif value="user">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>{{__("project/project-details/tariffs.tariff-value")}}</b>
                                            <div class="form-line">
                                                <input type="text" class="form-control decimal" name="value" value="{{$tariff->value or ''}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    {{-- Col --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>{{trans('project/project-details/tariffs.tariff-start-date')}}</b>
                                            <div class="form-line">
                                                <input type="text"
                                                       class="form-control datepicker"
                                                       name="startDate"
                                                       value="{{$tariff->startDate ? $tariff->startDate->format('d-m-Y') : null}}"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b>{{trans('project/project-details/tariffs.tariff-end-date')}}</b>
                                            <div class="form-line">
                                                <input type="text"
                                                       class="form-control datepicker"
                                                       name="endDate"
                                                       value="{{$tariff->endDate ? $tariff->endDate->format('d-m-Y') : null}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>{{__("project/project-details/tariffs.description")}}</b>
                                    <div class="form-line">
                                        <textarea class="form-control no-resize" name="description" placeholder="{{__("project/project-details/tariffs.description-placeholder")}}" required>{{$tariff->description}}</textarea>
                                    </div>
                                </div>
                                @component('components.uploader', [
                                    'projectAddress' => $project->id,
                                    'sectionAddress' => 't',
                                    'positionAddress' => $tariff->id
                                ])@endcomponent
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'description'],
                                    'position'=>$tariff->id,
                                    'section'=>'t',
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

    @component('back.components.enable-subsection-js', ["section" => "t","project_id" => $projectDetail->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent


    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('back/plugins/jquery-ui-1.12.1/jquery-ui.js') }}"></script>

    <script>

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            // inline: true,
            sideBySide: true
        });

        // The good old decimal validation
        $('.decimal').keypress(function(evt){
            return (/^[0-9]*\.?[0-9]*$/).test($(this).val()+evt.key);
        });

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
                url: '{{ route('project-details-tariffs/order') }}',
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
                   text: '{{ trans('project/project-details/tariffs.delete_confirm') }}',
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonColor: "#DD6B55",
                   confirmButtonText: "{{ trans('messages.yes_delete') }}",
                   cancelButtonText: "{{ trans('general.no') }}",
                   closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project-details-tariffs/delete') }}',
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
                                    text: '{{ trans('project/project-details/tariffs.deleted') }}',
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

        $("#frmCreateTariff").validate({
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

        $(".frmEditTariff").each(function(){
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
                  text: "{{trans('project/project-details/tariffs.success')}}",
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
