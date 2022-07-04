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
            <a href="{{ route('documentation').'#project_basic_info' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif

    @component('back.components.enable-section', ["section" => trans('project.section.project_basic_information'),"visible" => $project->project_information_active])
    @endcomponent

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
            <div class="card dynamic-card">
                <div class="header card-header-static">
                    <h2>
                        <span>{{__("project.section.project_basic_information")}}</span>
                    </h2>
                </div>

                <div class="body" data-status="0">
                    <form method="post" class="frmEditDocument" id="formCoreInfo" action="{{route("project.project-information.editCore")}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="project_id" value="{{$project->id}}">
                        <div class="row clearfix">
                            {{-- Col --}}
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <label>{{trans('general.sector')}}</label>
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="sectors[]" multiple title="-- {{trans('general.choose-option-multiple')}} --">
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}"
                                                        {{ (old("sector") == $sector->id ? "selected":"") }}
                                                        @foreach(json_decode($project_information)->sectors as $prSector)
                                                        @if($prSector->id == $sector->id)
                                                        selected
                                                        @endif
                                                        @endforeach
                                                > {{$sector->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <b>{{trans('general.region')}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="regions[]" multiple title="-- {{trans('general.choose-option-multiple')}} --">
                                            @foreach($regions as $region)
                                                <option value="{{$region->id}}"
                                                        {{ (old("region") == $region->id ? "selected":"") }}
                                                        @foreach(json_decode($project_information)->regions as $prRegion)
                                                        @if($prRegion->id == $region->id)
                                                        selected
                                                        @endif
                                                        @endforeach
                                                > {{$region->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-information.project_value_usd')}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="project_value_usd" value="{{json_decode($project_information)->project_value_usd}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- end row --}}
                        {{-- row start --}}
                        <div class="row clearfix">
                            {{-- Col --}}
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <b>{{trans('general.phase')}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick" name="stage" title="-- {{trans('general.choose-option')}} --">
                                            @foreach($stages as $stage)
                                                <option value="{{$stage->id}}"
                                                        {{ (old("stage") == $stage->id ? "selected":"") }}
                                                        @if(json_decode($project_information)->stage_id == $stage->id)
                                                        selected
                                                        @endif
                                                > {{$stage->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <b>{{trans('general.contracting_authority')}}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="sponsor" title="-- {{trans('general.choose-option')}} --">
                                            @foreach($sponsors as $sponsor)
                                                <option value="{{$sponsor->id}}"
                                                        {{ (old("sponsor") == $sponsor->id ? "selected":"") }}
                                                        @if(json_decode($project_information)->sponsor_id == $sponsor->id)
                                                        selected
                                                        @endif
                                                > {{$sponsor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-information.project_value_second',['currency'=>$currency])}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="project_value_second" value="{{json_decode($project_information)->project_value_second}}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-information.ocid')}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" disabled value="{{$ocid}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>{{trans('project/project-information.local_government')}}</b>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="local_government" value="{{ json_decode($project_information)->local_government }}" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-float">
                                    <b>{{trans('general.cofog')}} <a href="http://standard.open-contracting.org/profiles/ppp/latest/en/framework/#i-1-2-project-sector" target="_blank"><i class="small-help-icon material-icons">help_outline</i></a></b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker" name="cofog" title="-- {{trans('general.choose-option')}} --">
                                            @foreach($cofog as $sector_cofog)
                                                <option value="{{$sector_cofog->id}}"
                                                        {{ (old("sector_cofog") == $sector_cofog->id ? "selected":"") }}
                                                        @if(json_decode($project_information)->cofog_sector_id == $sector_cofog->id)
                                                        selected
                                                        @endif
                                                > {{$sector_cofog->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                          <div class="col-sm-3">
                              <div class="form-group form-float">
                                  <b>{{trans('general.timing_invest')}}</b>
                                  <div class="form-line">
                                    <input type="text" class="form-control datepicker" name="indicative_timing_invest" value="{{json_decode($project_information)->indicative_timing_invest ? json_decode($project_information)->indicative_timing_invest : null}}">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <input type="hidden" name="submit-type">
                        @component(
                            'back.components.project-buttons', [
                                'section_fields' => ['sectors', 'regions', 'project_value_usd', 'stage', 'sponsor', 'project_value_second', 'ocid','cofog','indicative_timing_invest_unit','indicative_timing_invest_unit'],
                                'position'=>1,
                                'section'=>'i',
                                'project'=>$project->id,
                                'hasCoordinators'=>$hasCoordinators
                            ])
                        @endcomponent
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--
        PROJECT NEED
    -->
    @if (Auth::user()->isAdmin() || json_decode($project_information)->project_need_private)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2>
                            {{trans('project/project-information.project-need')}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'section' => 'i',
                                'position' => 'project_need_private',
                                'status' => json_decode($project_information)->project_need_private,
                                'route' => route('project.project-informationIndividualVisibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project.project-information.edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="position_table" value="project_need">

                            <div class="form-group">
                                <b>{{__("project/project-details/documents.description")}}</b>
                                <div class="form-line">
                                    <textarea rows="5" class="form-control no-resize rich-editor" name="description" placeholder="{{trans('project/project-information.project-need-placeholder')}}">{{json_decode($project_information)->project_need}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'i',
                                'positionAddress' => 2
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons',['section_fields' => ['project_id','position_table','description'],'position'=>2,'section'=>'i','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!--
        DESCRIPTION OF ASSET
    -->
    @if (Auth::user()->isAdmin() || json_decode($project_information)->description_asset)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2>
                            {{trans('project/project-information.description-asset')}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'section' => 'i',
                                'position' => 'description_asset_private',
                                'status' => json_decode($project_information)->description_asset_private,
                                'route' => route('project.project-informationIndividualVisibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project.project-information.edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="position_table" value="description_asset">

                            <div class="form-group">
                                <b>{{__("project/project-details/documents.description")}}</b>
                                <div class="form-line">
                                    <textarea rows="5" class="form-control no-resize rich-editor" name="description" placeholder="{{trans('project/project-information.description-asset-placeholder')}}">{{json_decode($project_information)->description_asset}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'i',
                                'positionAddress' => 3
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons',['section_fields' => ['project_id','position_table','description'],'position'=>3,'section'=>'i','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!--
        DESCRIPTION OF SERVICES
    -->
    @if (Auth::user()->isAdmin() || json_decode($project_information)->description_services_private)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2>
                            {{trans('project/project-information.description-services')}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'section' => 'i',
                                'position' => 'description_services_private',
                                'status' => json_decode($project_information)->description_services_private,
                                'route' => route('project.project-informationIndividualVisibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project.project-information.edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="position_table" value="description_services">

                            <div class="form-group">
                                <b>{{__("project/project-details/documents.description")}}</b>
                                <div class="form-line">
                                    <textarea rows="5" class="form-control no-resize rich-editor" name="description" placeholder="{{trans('project/project-information.description-services-placeholder')}}">{{json_decode($project_information)->description_services}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'i',
                                'positionAddress' => 4
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons',['section_fields' => ['project_id','position_table','description'],'position'=>4,'section'=>'i','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--
        RATIONALE FOR SELECTION OF PPP MODE
    -->
    @if (Auth::user()->isAdmin() || json_decode($project_information)->reasons_ppp_private)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2>
                            {{trans('project/project-information.reasons-ppp')}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'section' => 'i',
                                'position' => 'reasons_ppp_private',
                                'status' => json_decode($project_information)->reasons_ppp_private,
                                'route' => route('project.project-informationIndividualVisibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project.project-information.edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="position_table" value="reasons_ppp">

                            <div class="form-group">
                                <b>{{__("project/project-details/documents.description")}}</b>
                                <div class="form-line">
                                    <textarea rows="5" class="form-control no-resize rich-editor" name="description" placeholder="{{trans('project/project-information.reasons-ppp-placeholder')}}">{{json_decode($project_information)->reasons_ppp}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'i',
                                'positionAddress' => 5
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons',['section_fields' => ['project_id','position_table','description'],'position'=>5,'section'=>'i','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!--
        STAKEHOLDER CONSULTATION
    -->
    @if (Auth::user()->isAdmin() || json_decode($project_information)->stakeholder_consultation_private)
        <div class="row content-row toggleable-wrapper">
            <div class="col-md-12">
                <div class="card dynamic-card toggleable-container">
                    <div class="header card-header-static toggleable-card">
                        <h2>
                            {{trans('project/project-information.stakeholder-consultation')}}
                            @component('back.components.individual-visibility', [
                                'project' => $project->id,
                                'section' => 'i',
                                'position' => 'stakeholder_consultation_private',
                                'status' => json_decode($project_information)->stakeholder_consultation_private,
                                'route' => route('project.project-informationIndividualVisibility')
                            ])@endcomponent
                        </h2>
                    </div>
                    <div class="body not-visible" data-status="0">
                        <form method="post" class="frmEditDocument" action="{{route("project.project-information.edit")}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="project_id" value="{{$project->id}}">
                            <input type="hidden" name="position_table" value="stakeholder_consultation">

                            <div class="form-group">
                                <b>{{__("project/project-details/documents.description")}}</b>
                                <div class="form-line">
                                    <textarea rows="5" class="form-control no-resize rich-editor" name="description" placeholder="{{trans('project/project-information.stakeholder-consultation-placeholder')}}">{{json_decode($project_information)->stakeholder_consultation}}</textarea>
                                </div>
                            </div>

                            @component('components.uploader', [
                                'projectAddress' => $project->id,
                                'sectionAddress' => 'i',
                                'positionAddress' => 6
                            ])@endcomponent

                            <input type="hidden" name="submit-type">
                            @component('back.components.project-buttons',['section_fields' => ['project_id','position_table','description'],'position'=>6,'section'=>'i','project'=>$project->id,'hasCoordinators'=>$hasCoordinators])
                            @endcomponent
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @component('components.request-modification-modal')
    @endcomponent

@endsection

@section('scripts')

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    @component('back.components.enable-section-js', ["section" => "i","project_id" => $project->id])
    @endcomponent

    @component('back.components.individual-visibility-js', [
    ])@endcomponent

    <script>

        @if (!Auth::user()->isAdmin())
        $('textarea, input, select').not('.morphsearch-input').prop('disabled', true);
        @endif

        @if (!Auth::user()->isViewOnly())
            // Rich Editor
            tinymce.init({
                selector: '.rich-editor'
            });
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

        $("#formCoreInfo").validate({
            /* Onkeyup
             * For not sending an ajax request to validate the email each time till the typing is done.
             */
            ignore: ":hidden:not(.selectpicker)",

            /*onkeyup: false,*/
            rules: {
                'project_name':{
                    required: true
                },
                'sectors[]':{
                    required: true
                },
                'regions[]':{
                    required: true,
                },
                'project_value_usd':{
                    required: true,
                    number: true
                },
                'stage':{
                    required: true,
                },
                'sponsor':{
                    required: true,
                },
                'project_value_second':{
                    number: true,
                    required: true
                },
                'ocid':{
                    remote: {
                        url: "{{route('project-check-ocid')}}",
                        type: "post",
                        data: {
                            ocid: function() {
                                return $("[name='ocid']").val();
                            },
                            projectInfo: {{json_decode($project_information)->id}}
                        }
                    }
                }
            },
            messages: {
                "ocid": {
                    remote: "{{__('jquery-validation.ocid')}}",
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        }); //Validation end


        @if (session('status') == true)
        swal({
            title: "{{trans('messages.success')}}",
            text: "{{trans('project/project-information.new-project-information-success')}}",
            type: "success",
            html: true
        }, function(){});
        @elseif (session('error') == true)
        swal({
            title: "{{trans('messages.error')}}",
            text: "{{session('error')}}",
            type: "error",
            html: true
        }, function(){});
        @endif

        $('.datepicker').datetimepicker({
            format: 'MM-YYYY',
            sideBySide: true
        });
    </script>

    @component('components.uploader-assets')
    @endcomponent

@endsection
