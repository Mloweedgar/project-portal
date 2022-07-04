@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">


@endsection

@section('content')

    @component('components.project-menu', ["project" => $project])
    @endcomponent

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#project_milestones' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    @component('back.components.enable-section', ["section" => trans('project.section.contract_milestones'),"visible" => $project->contract_milestones_active])
    @endcomponent

    {{-- @component('back.components.request-modification-new', ["section" => "cm","project" => $project->id])
    @endcomponent --}}

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="row content-row">

            {{-- Category failure type --}}
            <div class="col-md-12">

                <div class="card card-shadow">
                    <div id="card-header" class="header toggleable-card" @if ($errors->any() || (isset($flag))) data-status="1" @else data-status="0" @endif>
                        <h2><i class="material-icons">add_box</i> <span>{{trans('project/contract-milestones.add_group')}}</span> <i class="keyboard_arrow material-icons">keyboard_arrow_down</i></h2>
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

                        <form id="frm-new-contract" method="post" action="{{route("project.contract-milestones.store")}}" class="frmContractMilestones" hidden>
                            {{ csrf_field() }}
                            <input type="hidden" name="contract_milestone_id">
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">
                                    <label for="milestone-name">{{trans('project/contract-milestones.milestone')}} {{trans('project/contract-milestones.milestone-name')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="milestone-name" class="form-control"  name="name" placeholder="" required>
                                            </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}

                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">

                                    <label for="milestone_category">{{trans('project/contract-milestones.milestone_category')}}</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control milestone_types show-tick" name="milestone_category" title="-- {{trans('general.choose-option')}} --">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}"> {{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}

                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">

                                    <label for="milestone-name">{{trans('project/contract-milestones.milestone-type')}}</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control milestone_types show-tick" name="milestone_type">
                                                @foreach($milestones as $milestone)
                                                    <option value="{{$milestone->id}}"> {{$milestone->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}

                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">
                                    <label for="milestone-name" class="lblDate">{{trans('project/contract-milestones.milestone-date')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="date">
                                        </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}

                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">
                                    <label for="milestone-name" class="lblDate">{{trans('project/contract-milestones.milestone-deadline')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="deadline">
                                        </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}

                            <div class="row"> {{-- Row --}}
                                {{-- Group --}}
                                <div class="col-md-3">
                                    <label for="milestone-name">{{trans('project/contract-milestones.milestone-responsible')}}</label>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="3" name="description" class="textarea form-control no-resize" placeholder="{{trans('project/contract-milestones.milestone-responsible-placeholder')}}" required></textarea>
                                        </div>
                                    </div>
                                </div> {{-- End group --}}
                            </div>  {{-- Row end --}}
                            @component('back.components.project-buttons', [
                                'section_fields' => [ 'name', 'milestone_type', 'date', 'description' ],
                                'position'=>0,
                                'section'=>'cm',
                                'project'=>$project->id,
                                'hasCoordinators'=>$hasCoordinators
                            ])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
            {{-- End category failure type --}}
        </div>
    @endif

    @if(count($contract_milestones) > 0)

        @foreach($contract_milestones as $contract_milestone)

            <div class="row content-row toggleable-wrapper">
                <form class="frmContractMilestones" method="post" action={{route("project.contract-milestones.update")}}>
                    {{ csrf_field() }}
                    <input type="hidden" name="contract_milestone_id" value="{{$contract_milestone->id}}">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <div class="col-md-12">
                        <div class="card dynamic-card toggleable-container">
                            <div class="header card-header-static toggleable-card">
                                <h2>
                                    @component('back.components.draft-chip',['draft'=>$contract_milestone->draft])
                                    @endcomponent
                                    <span>{{$contract_milestone->name}}</span>
                                    @component('back.components.individual-visibility', [
                                        'project' => $project->id,
                                        'position' => $contract_milestone->id,
                                        'status' => $contract_milestone->published,
                                        'route' => route('project.contract-milestones.visibility')
                                    ])@endcomponent
                                    <i class="fa fa-trash-o del-btn x2 delete-group" aria-hidden="true" data-id="{{$contract_milestone->id}}"></i>
                                </h2>
                            </div>
                            <div class="body not-visible" data-status="0">
                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-name">{{trans('project/contract-milestones.milestone')}} {{trans('project/contract-milestones.milestone-name')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="milestone-name" class="form-control" name="name" placeholder="" value="{{$contract_milestone->name}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>  {{-- Row end --}}
                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-category">{{trans('project/contract-milestones.milestone_category')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control milestone_types show-tick" name="milestone_category" title="-- {{trans('general.choose-option')}} --">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" @if($category->id == $contract_milestone->milestone_category_id) selected @endif> {{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> {{-- End group --}}
                                </div>  {{-- Row end --}}
                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-name">{{trans('project/contract-milestones.milestone-type')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control milestone_types show-tick" name="milestone_type">
                                                    @foreach($milestones as $milestone)
                                                        <option value="{{$milestone->id}}" @if($milestone->id == $contract_milestone->milestone_type_id) selected @endif> {{$milestone->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> {{-- End group --}}
                                </div>  {{-- Row end --}}

                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-name" class="lblDate">{{trans('project/contract-milestones.milestone-date')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="date" value="{{$contract_milestone->date ? $contract_milestone->date->format('d-m-Y') : null}}">
                                            </div>
                                        </div>
                                    </div> {{-- End group --}}
                                </div>  {{-- Row end --}}

                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-name" class="lblDate">{{trans('project/contract-milestones.milestone-deadline')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="deadline" value="{{$contract_milestone->deadline ? $contract_milestone->deadline->format('d-m-Y') : null}}">
                                            </div>
                                        </div>
                                    </div> {{-- End group --}}
                                </div>  {{-- Row end --}}

                                <div class="row"> {{-- Row --}}
                                    {{-- Group --}}
                                    <div class="col-md-3">
                                        <label for="milestone-name">{{trans('project/contract-milestones.milestone-responsible')}}</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="3" name="description" class="textarea form-control no-resize" placeholder="{{trans('project/contract-milestones.milestone-responsible-placeholder')}}">{{$contract_milestone->description}}</textarea>
                                            </div>
                                        </div>
                                    </div> {{-- End group --}}
                                </div>  {{-- Row end --}}
                                <input type="hidden" name="submit-type">
                                @component('back.components.project-buttons', [
                                    'section_fields' => [ 'name', 'milestone_type', 'date', 'description' ],
                                    'position'=>$contract_milestone->id,
                                    'section'=>'cm',
                                    'project'=>$project->id,
                                    'hasCoordinators'=>$hasCoordinators
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        @endforeach

    @else
        @component('back.components.no-results')
        @endcomponent
    @endif

@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->
    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    @component('back.components.enable-section-js', ["section" => "cm","project_id" => $project->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script>
        @if (!Auth::user()->isAdmin() &&  !Auth::user()->isProjectCoordinator())
$('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
        @endif

        $('select').selectpicker('refresh');
        /*picker.$root.appendTo('.card');*/
        /*
         * Validatior
         */

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            // inline: true,
            sideBySide: true
        });

        @if (Auth::user()->canDelete())
        /*
         Delete group
         */
        $('.delete-group').click(function(ev){
            ev.preventDefault();

            var id = $(this).data('id');

            var card = $(this).closest('.card');

            swal({
                    title: '{{ trans('messages.confirm') }}',
                    text: "{{trans('project/contract-milestones.milestone_delete_confirm')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('messages.yes_delete') }}",
                    cancelButtonText: "{{ trans('general.no') }}",
                    closeOnConfirm: true
                },
                function(){
                    $.ajax({
                        url: '{{ route('project.contract-milestones.delete') }}',
                        type: 'DELETE',
                        data: { id: id },
                        dataType: "json",
                        beforeSend: function() {
                            $('.page-loader-wrapper').show();
                        },
                        success: function(data){
                            if (data.status) {

                                swal({
                                    title: "{{trans('messages.success')}}",
                                    text: "{{ trans('project/contract-milestones.milestone-delete') }}",
                                    type: "success",
                                    html: true
                                }, function(){

                                });

                                card.parent().remove();
                            } else {
                                swal({
                                    title: "{{trans('messages.error')}}",
                                    text: info,
                                    type: "error",
                                    html: true
                                }, function(){
                                });
                            }
                        },
                        error: function(errors){
                            $('.page-loader-wrapper').fadeOut();
                            var info = laravelErrors(data)
                            swal({
                                title: "{{trans('messages.error')}}",
                                text: info,
                                type: "error",
                                html: true
                            }, function(){
                            });
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



        /*
         * Fine Uploader initialization
         */

        var validators = [];
        $('.frmContractMilestones').each(function(){
            var form = $(this)
            var validator = $(form).validate({
                ignore: ":hidden:not(.selectpicker)",
                /* Onkeyup
                 * For not sending an ajax request to validate the email each time till the typing is done.
                 */
                /*onkeyup: false,*/
                rules: {
                    'name': {
                        required: true
                    },
                    'milestone_type':{
                        required: true
                    },
                    'description':{
                        required: true,
                        maxlength: 120
                    }
                },
            }); //Validation end
            validators.push(validator);
        });


        /*
         * Change the label name date
         */
        /* NOT NEEDED ANYMORE - 21/01/2019
        $(".milestone_types").change(function(){

            if($(this).val() != ""){
                var lbl = $($(this).closest('.card').find('.lblDate'))
                if($(this).val() == 1){
                    lbl.html("{{trans('project/contract-milestones.milestone-date')}}");
                }else{
                    lbl.html("{{trans('project/contract-milestones.milestone-deadline')}}");

                }
            }
        });
        */

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

                        //Show form
                        bodyElement.find('form').show();

                        // Update the keyboard_arrow of the box if any
                        if(headerElement.find("#keyboard_arrow").length > 0){
                            $('#keyboard_arrow').html("keyboard_arrow_up");
                        }

                    } else {

                        // Card open, we proceed to close
                        bodyElement.removeClass("is-visible").addClass("not-visible");

                        // Update the status of the card
                        headerElement.data("status", 0);

                        bodyElement.find('form').hide();

                        // Update the keyboard_arrow of the box if any
                        if(headerElement.find("#keyboard_arrow").length > 0){

                            $('#keyboard_arrow').html("keyboard_arrow_down");

                        }

                    }

                }

            });

        });

        $("#new-contract").click(function () {
            $(this).closest("form").submit();
        });

        /**
         * Selectpicker for milestones names
         */

        var content = "<span class='glyphicon glyphicon-plus addnewicon' onClick='addSelectItem(this,event,1);'></span> <input class='select-add-option' type=text onKeyDown='event.stopPropagation();' onKeyPress='addSelectInpKeyPress(this,event)' onClick='event.stopPropagation()' placeholder='Add item'>";

        var divider = $('<option/>')
            .addClass('divider')
            .data('divider', true);


        var addoption = $('<option/>')
            .addClass('additem')
            .data('content', content)


            $('select.milestone-name').prepend(divider).prepend(addoption).selectpicker('refresh');


        function addSelectItem(t,ev)
        {
            ev.stopPropagation();

            console.log(t);

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

    @if (session('status') == true)
        <script>
            swal({
                title: "{{trans('messages.success')}}",
                text: "{{trans('project/contract-milestones.milestone-success')}}",
                type: "success",
                html: true
            }, function(){

            });
        </script>
    @endif

@endsection
