@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/role-management/users.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("sectionstodisclose.title") }} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{{ __('sectionstodisclose.tooltip') }}"></i></h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#sections_to_disclose' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
    <div class="row content-row errors"></div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row content-slim">
        <div class="card">
            <form id="sectionform">
                <div class="body body-nopadding">
                    {{ csrf_field() }}
                    <div class="table-responsive">
                        <table class="table table-slim">
                            <thead>
                            <tr>
                                <th colspan="2">
                                    <div class="pull-right" style="display: inline-block;">
                                        <label class="label-slim" for="sectorCheckAll">Select all </label>
                                        <input type="checkbox" id="sectorCheckAll" class="filled-in checkAll checkAllSections">
                                        <label class="label-slim" for="sectorCheckAll" style="color:white;">.</label>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                                <tr>
                                    <td>
                                      <input type="checkbox" id="sectorid1" class="filled-in " value="1" name="sections[]" disabled checked>
                                      <label for="sectorid1">{{trans('project.section.project_basic_information')}}</label>
                                    </td>
                                    <td>
                                      <input type="checkbox" id="sectorid4" class="filled-in   parentSection " value="4" name="sections[]">
                                      <label for="sectorid4">{{trans('project.section.performance_information_title')}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="sectorid2" class="filled-in" value="2" name="sections[]">
                                        <label for="sectorid2">{{trans('project.section.contract_milestones')}}</label>
                                    </td>
                                    <td class="td-projects-section-gray" data-parent="4">
                                      <input type="checkbox" id="sectorid8" class="filled-in subSection" value="8" name="sections[]" data-parent="4">
                                      <label for="sectorid8">{{trans('project.section.performance_information.key_performance_indicators')}}</label>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="sectorEdit15" class="filled-in" value="15" name="sections[]">
                                        <label for="sectorEdit15">{{trans('project.section.procurement')}}</label>
                                    </td>
                                    <td class="td-projects-section-gray" data-parent="4">
                                        <input type="checkbox" id="sectorEdit9" class="filled-in subSection" value="9" name="sections[]" data-parent="4">
                                        <label for="sectorEdit9">{{trans('project.section.performance_information.performance_failures')}}</label>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="sectorid3" class="filled-in " value="3" name="sections[]">
                                        <label for="sectorid3">{{trans('project.section.parties')}}</label>
                                    </td>

                                    <td class="td-projects-section-gray" data-parent="4">
                                      <input type="checkbox" id="sectorid10" class="filled-in subSection" value="10" name="sections[]" data-parent="4">
                                      <label for="sectorid10">{{trans('project.section.performance_information.performance-assessments')}}</label>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" id="sectorid12" class="filled-in parentSection " value="12" name="sections[]">
                                        <label for="sectorid12">{{trans('project.section.project_details_title')}}</label>
                                    </td>

                                    <td>
                                      <input type="checkbox" id="sectorid11" class="filled-in  " value="11" name="sections[]">
                                      <label for="sectorid11">{{trans('project.section.gallery')}}</label>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid13" class="filled-in subSection" value="13" name="sections[]" data-parent="12">
                                        <label for="sectorid13">{{trans('project.section.project_details.documents')}}</label>
                                    </td>

                                    <td>
                                      <input type="checkbox" id="sectorid14" class="filled-in" value="14" name="sections[]">
                                      <label for="sectorid14">{{trans('project.section.project_details.announcements')}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid18" class="filled-in subSection" value="18" name="sections[]" data-parent="12">
                                        <label for="sectorid18">{{trans('project.section.project_details.financial')}}</label>
                                    </td>


                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid16" class="filled-in subSection" value="16" name="sections[]" data-parent="12">
                                        <label for="sectorid16">{{trans('project.section.project_details.risks')}}</label>
                                    </td>


                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid19" class="filled-in subSection" value="19" name="sections[]" data-parent="12">
                                        <label for="sectorid19">{{trans('project.section.project_details.government-support')}}</label>
                                    </td>


                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid20" class="filled-in subSection" value="20" name="sections[]" data-parent="12">
                                        <label for="sectorid20">{{trans('project.section.project_details.tariffs')}}</label>
                                    </td>


                                </tr>
                                <tr>
                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid21" class="filled-in subSection" value="21" name="sections[]" data-parent="12">
                                        <label for="sectorid21">{{trans('project.section.project_details.contract-termination')}}</label>
                                    </td>


                                </tr>

                                <tr>

                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid22" class="filled-in subSection" value="22" name="sections[]" data-parent="12">
                                        <label for="sectorid22">{{trans('project.section.project_details.renegotiations')}}</label>
                                    </td>

                                </tr>
                                <tr>

                                    <td class="td-projects-section-gray" data-parent="12">
                                        <input type="checkbox" id="sectorid23" class="filled-in subSection" value="23" name="sections[]" data-parent="12">
                                        <label for="sectorid23">{{trans('project.section.project_details.award')}}</label>
                                    </td>

                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="body body-footer">
                    <a id="submitdata" class="btn btn-primary btn-lg">{{ __('sectionstodisclose.submit') }}</a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>
    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){

            var sections = {!! $sections !!}

            loadSections();
            function loadSections(){

                var flag;
                $.each(sections, function(index, object){

                    console.log(object.id)
                    if(object.active == 1){

                        $("input[name='sections[]'][value=" + object.id + "]").not('#sectorid1').prop("checked", true);
                    }
                    else{

                        $("input[name='sections[]'][value=" + object.id + "]").not('#sectorid1').prop("checked", false);
                    }


                });


            }

            $('[data-toggle="tooltip"]').tooltip({'container':'body'});

            /*
             * Checking and un-checking all the checkboxes sectors/projects
             */
            $(".checkAll").click(function(){
                $($(this).parents('table').find('tbody').find("input[type='checkbox']")).not('#sectorid1').prop('checked', this.checked)
            });

            $('#sectorid1').click(function () {

                swal({
                    title: "{{trans('sectionstodisclose.warning-title')}}",
                    text: "{{trans('sectionstodisclose.warning-desc')}}",
                    type: "warning",
                    html: true
                }, function(){
                });

            });

            /**
              * Checks if the section that have sub sections have at least one child selected.
              */
             $(".parentSection").click(function(){
               var tbody = $(this).parent().parent().parent();

               var checkboxesChekeced = tbody.find("input[type='checkbox'][data-parent=" + $(this).val() +"]:checked");
               var checkboxes = tbody.find("input[type='checkbox'][data-parent=" + $(this).val() +"]");

               if(this.checked){
                 if(checkboxesChekeced.length == 0){
                   $(checkboxes).prop('checked', true);
                 }
               }else{

                 $(checkboxes).prop('checked', false)
               }
             });

             /*
             *
              */
             $(".subSection").click(function(){

               var parent = $(this).data('parent');
               var tbody = $(this).parent().parent().parent();


               var checkboxesChekeced = tbody.find("input[type='checkbox'][data-parent=" + parent +"]:checked");
               var mainCheckbox = tbody.find("input[type='checkbox'][value=" + parent +"]");

               if(checkboxesChekeced.length > 0){
                 mainCheckbox.prop('checked', true)
               }else{
                 mainCheckbox.prop('checked', false)
               }

             });

            /**
             *
             */
            $(".subSection").click(function(){

                var parent = $(this).data('parent');
                var tbody = $(this).parent().parent().parent();

                var checkboxesChekeced = tbody.find("input[type='checkbox'][data-parent=" + parent +"]:checked");
                var mainCheckbox = tbody.find("input[type='checkbox'][data-value=" + parent +"]");

                if(checkboxesChekeced.length > 0){
                    mainCheckbox.prop('checked', true)
                }else{
                    mainCheckbox.prop('checked', false)
                }

            });

        });

        function checkboxValues(element){
            var types = [];
            element.each(function (i) {
                var active = 0;
                if($(this).prop('checked')){
                    active = 1;
                }
                types.push({id: $(this).val(), active:active });
            });
            return types;
        }

        $('#submitdata').click( function() {

            var sections = checkboxValues($("input[name='sections[]']").not('#sectorid1'));


            $.ajax({
                url: '{{route('sectionstodisclose.update')}}',
                type: 'POST',
                data: {sections: sections},
                success: function(response){

                    if(response){

                        swal({
                            title: "{{trans('sectionstodisclose.success-title')}}",
                            text: "{{trans('sectionstodisclose.success-desc')}}",
                            type: "success",
                            html: true
                        });

                    } else {

                        swal({
                            title: "{{trans('sectionstodisclose.error-title')}}",
                            text: "{{trans('sectionstodisclose.error-desc')}}",
                            type: "error",
                            html: true
                        }, function(){
                        });

                    }

                },
                error: function(){

                    swal({
                        title: "{{trans('sectionstodisclose.error-title')}}",
                        text: "{{trans('sectionstodisclose.error-desc')}}",
                        type: "error",
                        html: true
                    }, function(){
                    });

                }
            });

        });

    </script>
@endsection
