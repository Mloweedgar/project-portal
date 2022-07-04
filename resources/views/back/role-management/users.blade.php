@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('back/plugins/intl-tel-input/intlTelInput.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/toastr/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/views/role-management/users.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/multi-select/multi-select.css') }}" rel="stylesheet">

    <style>
        .select.select-block .btn {
            width: 100%;
        }
    </style>


@endsection

@section('content')
    <h1 class="content-title">{{trans("user.edit-users-title")}}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#edit_users_section' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
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

    <div class="row content-row">
        <div class="col-md-12">
            {{-- <h3 class="content-form-title">Add user</h3> --}}
            <form id="frmUser">
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <b>{{trans('user.name')}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <b>{{trans('user.email')}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <b>{{trans('user.entity')}}</b>
                            <div class="form-line">
                                <select class="form-control show-tick slctFrmUser" name="entity" title="-- {{trans('user.choose-option')}} --">
                                    @foreach($entities as $entity)
                                        <option value="{{$entity->id}}">{{$entity->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <label id="" for="entity" class="error2 display_none">{{trans('jquery-validation.required')}}</label> --}}
                        </div>
                    </div>
                </div> {{-- Row --}}
                <div class="row clearfix">
                    <div class="col-sm-4">
                        <div class="form-group form-float">
                            <b>{{trans('user.role')}}</b>
                            <div class="form-line">
                                <select class="form-control show-tick selectpicker slctFrmUser" name="role" title="-- {{trans('user.choose-option')}} --">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->alias}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <label id="" for="entity" class="error2 display_none">{{trans('jquery-validation.required')}}</label> --}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>{{trans('user.telephone')}}</b>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input class="form-control telephones" type="tel" id="phone" name="telephone">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <b>{{trans('user.date')}}</b>
                        <div class="form-group">
                            <div class="form-line disabled">
                                <input type="text" class="form-control" value="{{ Carbon\Carbon::today()->format('Y-m-d')}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">

            <button class="btn btn-large btn-primary waves-effect" id="btnPermissions"
                    data-trigger="focus" data-container="body" data-toggle="popover" data-placement="right" title=""
                    data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                    data-original-title="Popover Title">{{trans('user.permissions')}}</button>
            <button class="btn btn-large btn-primary waves-effect pull-right" id="btnAddUser">{{trans('user.add')}}</button>
        </div>
    </div>
    <div class="row content-row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{trans('user.name')}}</th>
                        <th>{{trans('user.email')}}</th>
                        <th>{{trans('user.entity')}}</th>
                        <th>{{trans('user.telephone')}}</th>
                        <th>{{trans('user.role')}}</th>
                        <th>{{trans('user.date')}}</th>
                        <th>{{trans('user.inactive')}}</th>
                        <th>...</th>
                        <th>...</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Permissions ====================================================================================================================== -->
    <div class="modal fade " id="modalPermissions" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h4 class="modal-title" id="defaultModalLabel">{{trans('general.permissions')}}</h4>
                            <p class="modalPermissionsMsg" hidden>{{trans('user.select-permissions')}}</p>
                        </div>
                        <div class="col-md-4 m-t-10">
                            {{-- End --}}
                            <label for="slctProjects">{{trans('user.choose_projects')}}</label>
                            <select class="slctProjects" id="slctProjects" name="slctProjects" data-live-search="true" multiple >
                            </select>
                            <div class="table-responsive m-t-10" id="tblProjects">
                                <table class="table table-modal w-100">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div>
                                                <div class="display_inline_block">
                                                    {{trans('user.projects')}}
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbodyProjects" id="tbodyProjects">
                                    </tbody>
                                </table>
                            </div> {{-- Table responsive --}}
                            {{-- End col --}}
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-modal w-100">
                                    <thead>
                                    <tr>
                                        <th colspan="2">
                                            <div class="display_inline_block">
                                                {{trans('user.sections')}}

                                            </div>
                                            <div class="pull-right display_inline_block">
                                                <label for="sectorCheckAll">{{trans('user.select-all')}} </label>
                                                <input type="checkbox" id="sectorCheckAll" value="22" class="filled-in checkAll checkAllSections" name="sss[]"/>
                                                <label for="sectorCheckAll" class="color_white">.</label>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectorid1" class="filled-in " value="1" name="sections[]">
                                            <label for="sectorid1">{{trans('project.section.project_basic_information')}}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="sectorid4" class="filled-in   parentSection " value="4" name="sections[]">
                                            <label for="sectorid4">{{trans('project.section.performance_information_title')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectorid2" class="filled-in " value="2" name="sections[]">
                                            <label for="sectorid2">{{trans('project.section.contract_milestones')}}</label>
                                        </td>
                                        <td class="td-projects-section-gray" data-parent="4">
                                            <input type="checkbox" id="sectorid8" class="filled-in subSection" value="8" name="sections[]" data-parent="4">
                                            <label for="sectorid8">{{trans('project.section.performance_information.key_performance_indicators')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-parent="12">
                                            <input type="checkbox" id="sectoridEdit15" class="filled-in" value="15" name="sections[]">
                                            <label for="sectoridEdit15">{{trans('project.section.procurement')}}</label>
                                        </td>
                                        <td class="td-projects-section-gray" data-parent="4">
                                            <input type="checkbox" id="sectoridEdit9" class="filled-in subSection" value="9" name="sections[]" data-parent="4">
                                            <label for="sectoridEdit9">{{trans('project.section.performance_information.performance_failures')}}</label>
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
                                    <!-- AWARD TODO -->
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectorid23" class="filled-in subSection" value="23" name="sections[]" data-parent="12">
                                            <label for="sectorid23">{{trans('project.section.project_details.award')}}</label>
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

                                    </tbody>
                                    {{-- @if($i % 2 == 1 )
                                      {!! "</tr>" !!}
                                    @endif --}}

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>{{-- Body --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('general.cancel')}}</button>
                    {{-- <button type="button" class="btn btn-link waves-effect" id="">{{trans('user.save')}}</button> --}}
                    <button type="button" class="btn btn-link waves-effect" id="btnSavePermissions">{{trans('general.save')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Permissions ====================================================================================================================== -->

    <!-- Modal Edit Permissions ====================================================================================================================== -->
    <div class="modal fade " id="modalEditUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="row clearfix" id="rowUserEdit">
                        <div class="col-md-12">
                            <form id="frmUserEdit">
                                <input type="hidden" name="user_id">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <b>{{trans('user.name')}}</b>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="nameEdit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <b>{{trans('user.email')}}</b>
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="emailEdit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <b>{{trans('user.entity')}}</b>
                                            <div class="form-line">
                                                <select class="form-control show-tick" name="entityEdit" title="-- {{trans('general.choose-option')}} --">
                                                    @foreach($entities as $entity)
                                                        <option value="{{$entity->id}}">{{$entity->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label id="" for="entity" class="error2 display_none">{{trans('jquery-validation.required')}}</label>
                                        </div>
                                    </div>
                                </div> {{-- Row --}}
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <b>{{trans('user.role')}}</b>
                                            <div class="form-line">
                                                <select class="form-control show-tick selectpicker" name="roleEdit" title="-- {{trans('general.choose-option')}} --">
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->name}}">{{$role->alias}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label id="" for="entity" class="error2 display_none">{{trans('jquery-validation.required')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <b>{{trans('user.telephone')}}</b>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input class="form-control" class="telephones" type="tel" id="phone" name="telephoneEdit">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>{{trans('user.date')}}</b>
                                        <div class="form-group">
                                            <div class="form-line disabled">
                                                <input type="text" class="form-control" name="dateEdit" value="" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        {{-- <button class="btn btn-large btn-primary waves-effect m-b-10 pull-right" id="btnModalEditDataEntries" hidden >{{trans('user.edit_project_coordinator')}}</button> --}}
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div id="rowUserPermissions" class="row clearfix">
                        <div class="col-md-12">
                            <h4 class="modal-title" id="defaultModalLabel">{{trans('general.permissions')}}</h4>
                            <p class="modalPermissionsMsg" hidden>{{trans('user.select-permissions')}}</p>
                        </div>
                        <div class="col-md-4 m-t-10">
                            {{-- End --}}
                            <label for="slctProjects">{{trans('user.choose_projects')}}</label>
                            <select class="slctProjects" name="slctProjectsEdit" data-live-search="true" multiple >
                            </select>
                            <div class="table-responsive m-t-10" id="prmSectors2">
                                <table class="table table-modal w-100">
                                    <thead>
                                    <tr>
                                        <th>
                                            <div>
                                                <div class="display_inline_block">
                                                    {{trans('user.projects')}}
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbodyProjects" id="tbodyProjectsEdit">
                                    </tbody>
                                </table>
                            </div> {{-- Table responsive --}}
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-modal w-100">
                                    <thead>
                                    <tr>
                                        <th colspan="2">
                                            <div class="display_inline_block">
                                                {{trans('user.sections')}}
                                                <p class="modalPermissionsMsg" hidden>At least one section is required.</p>
                                            </div>
                                            <div class="pull-right display_inline_block">
                                                <label for="sectorCheckAllEdit">{{trans('user.select-all')}} </label>
                                                <input type="checkbox" id="sectorCheckAllEdit" value="22" class="filled-in checkAll checkAllSections" name="sss[]"/>
                                                <label for="sectorCheckAllEdit"  class="color_white" >.</label>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit1" class="filled-in " value="1" name="sectionsEdit[]">
                                            <label for="sectoridEdit1">{{trans('project.section.project_basic_information')}}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit4" class="filled-in   parentSection " value="4" name="sectionsEdit[]">
                                            <label for="sectoridEdit4">{{trans('project.section.performance_information_title')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectorEdit2" class="filled-in " value="2" name="sectionsEdit[]">
                                            <label for="sectorEdit2">{{trans('project.section.contract_milestones')}}</label>
                                        </td>
                                        <td class="td-projects-section-gray" data-parent="4">
                                            <input type="checkbox" id="sectoridEdit8" class="filled-in subSection" value="8" name="sectionsEdit[]" data-parent="4">
                                            <label for="sectoridEdit8">{{trans('project.section.performance_information.key_performance_indicators')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectorEdit15" class="filled-in" value="15" name="sectionsEdit[]">
                                            <label for="sectorEdit15">{{trans('project.section.procurement')}}</label>
                                        </td>
                                        <td class="td-projects-section-gray" data-parent="4">
                                            <input type="checkbox" id="sectorEdit9" class="filled-in subSection" value="9" name="sectionsEdit[]" data-parent="4">
                                            <label for="sectorEdit9">{{trans('project.section.performance_information.performance_failures')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit3" class="filled-in " value="3" name="sectionsEdit[]">
                                            <label for="sectoridEdit3">{{trans('project.section.parties')}}</label>
                                        </td>
                                        <td class="td-projects-section-gray" data-parent="4">
                                            <input type="checkbox" id="sectoridEdit10" class="filled-in subSection" value="10" name="sectionsEdit[]" data-parent="4">
                                            <label for="sectoridEdit10">{{trans('project.section.performance_information.performance-assessments')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit12" class="filled-in parentSection " value="12" name="sectionsEdit[]">
                                            <label for="sectoridEdit12">{{trans('project.section.project_details_title')}}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit11" class="filled-in  " value="11" name="sectionsEdit[]">
                                            <label for="sectoridEdit11">{{trans('project.section.gallery')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit18" class="filled-in subSection" value="18" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit18">{{trans('project.section.project_details.financial')}}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="sectoridEdit14" class="filled-in" value="14" name="sectionsEdit[]">
                                            <label for="sectoridEdit14">{{trans('project.section.project_details.announcements')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit23" class="filled-in subSection" value="23" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit23">{{trans('project.section.project_details.award')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit13" class="filled-in subSection" value="13" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit13">{{trans('project.section.project_details.documents')}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit16" class="filled-in subSection" value="16" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit16">{{trans('project.section.project_details.risks')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit19" class="filled-in subSection" value="19" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit19">{{trans('project.section.project_details.government-support')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit20" class="filled-in subSection" value="20" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit20">{{trans('project.section.project_details.tariffs')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit21" class="filled-in subSection" value="21" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit21">{{trans('project.section.project_details.contract-termination')}}</label>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="td-projects-section-gray" data-parent="12">
                                            <input type="checkbox" id="sectoridEdit22" class="filled-in subSection" value="22" name="sectionsEdit[]" data-parent="12">
                                            <label for="sectoridEdit22">{{trans('project.section.project_details.renegotiations')}}</label>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>{{-- Body --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" id="btnSaveEdtiUser">{{trans('general.save')}}</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('general.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Permissions ====================================================================================================================== -->

    <!-- Modal Delete ====================================================================================================================== -->
    <div class="modal fade " id="modalDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">{{trans('user.delete_title')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <p>{{trans('user.delete_description')}}</p>
                        </div>
                        <form id="frmDelete">
                            <input type="hidden" name="user_edit_id">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="5" id="" name="description" class="textarea form-control no-resize" placeholder="{{trans('user.delete_description_placeholder')}}">{{old('penalty-abatement-contract')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                              <input type="checkbox" id="checkDeleteAll" value="1" name="checkDelete" class="filled-in checkDelete" checked />
                              <label for="checkDeleteAll">{{trans('user.delete_all')}}</label>
                            </div>
                            <div class="col-md-12">
                              <input type="checkbox" id="checkDeleteAssign" value="2" name="checkDelete" class="filled-in checkDelete"/>
                              <label for="checkDeleteAssign">{{trans('user.delete_assign')}}</label>
                            </div> --}}

                            <div class="col-sm-12" id="frmGroupUserAssign">
                                <div class="form-group form-float">
                                    <b>{{ trans("task.assigned_to") }}</b>
                                    <div class="form-line">
                                        <select class="form-control show-tick selectpicker ignore" name="user_assign" data-live-search="true" title="{{ trans("task.search_user") }}"></select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>{{-- Body --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" id="btnDeleteUser">{{trans('user.delete_user')}}</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('general.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Project coordinator ====================================================================================================================== -->

    <!-- Modal Edit Project Coordinator Data Entries ====================================================================================================================== -->
    <div class="modal fade " id="modalEditDataEntries" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">{{trans('user.project-coordinator-title')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <label for="">Not Assigned</label>
                        </div>
                        <div class="col-md-6">
                            <label for="">Assigned</label>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <select id="slctDataEntriesGeneric" class="ms" multiple="multiple">
                            </select>
                        </div>
                    </div>

                </div>{{-- Body --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="saveProjectCoordinator" >{{trans('general.save')}}</button>
                    {{-- <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('user.cancel')}}</button> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Project Coordinator Data Entries ====================================================================================================================== -->
@endsection
@section('scripts')
    {{-- Input mask --}}
    <script src="{{ asset('back/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
    {{-- Datetime picker --}}
    <script src="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
    {{-- International telephone input --}}
    <script src="{{ asset('back/plugins/intl-tel-input/intlTelInput.js') }}"></script>

    {{-- <script src="{{ asset('back/plugins/intl-tel-input/intlTelInput.js') }}"></script> --}}

    <script src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/multi-select/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back/plugins/datatable/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('back/plugins/toastr/toastr.min.js') }}"></script>





    <script>

        $(document).ready(function(){




            /*
             * Get the country list and use them in the int input
             */

            var countryData = $.fn.intlTelInput.getCountryData();
            var hashCountryDataTranslation = {!! $countries !!};
            $.each(countryData, function(i, country) {
                country.name = hashCountryDataTranslation[country.iso2];
            });

            /*
             * Initialize the international input for telephones
             */
            initializeIntTelInput($("[name='telephone']"));
            initializeIntTelInput($("[name='telephoneEdit']"));
            function initializeIntTelInput(element){
                element.intlTelInput({
                    initialCountry: "auto",
                    preferredCountries: ['tz'],
                    geoIpLookup: function(callback) {
                        $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "";
                            callback(countryCode);
                        });
                    },
                    utilsScript: "back/plugins/intl-tel-input/utils.js" // just for formatting/placeholders etc
                });
            }

            /*
             * Custom validator created for the international input for telephones.
             */

            $.validator.addMethod(
                "validIntInputTelephone",
                function(value, element) {
                    /* Types of international input errors
                     "IS_POSSIBLE": 0,
                     "INVALID_COUNTRY_CODE": 1,
                     "TOO_SHORT": 2,
                     "TOO_LONG": 3,
                     "NOT_A_NUMBER": 4
                     */
                    var errorMSG = $(element).intlTelInput("getValidationError");
                    //If the error MSG is 0, it's means that the number it's possible right, so the validator passes.
                    if(errorMSG == 0 || $(element).val() == "")
                        return true;
                    else
                        return false;

                },
                "{{trans('jquery-validation.int-input-lenght')}}"
            );

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "15000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            /*
             * Initialize the jQuery data-table.      @DATATABLE
            * Besides the data table plugin of jQuery, a php plugin is used to manage the server-side table.
             */

            var userTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : '{!! route('users.tableUsers') !!}',
                    method : 'POST'
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'entity', name: 'entities.name'},
                    { data: 'telephone', name: 'telephone'},
                    { data: 'role', name: 'roles.alias'},
                    { data: 'created_at', name: 'created_at'},
                    {
                        name: 'inactive',
                        data: null,
                        sortable: true,
                        searchable: false,
                        render: function (data) {
                            if(data.id == 1){
                                return "";
                            }

                            var actions = '<input type="checkbox" id="inactive' + data.id + '" value="" class="checkInactive filled-in" name="" '+ ((data.inactive == 1) ? 'checked' : '') +' />\
              <label for="inactive' + data.id + '"></label>';
                            /*actions += '<a href="">Edit</a>';
                             actions += '<a href="">Delete</a>';*/
                            return actions;
                        }
                    },
                    {
                        name: 'edit',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float edit">\
                                <i class="material-icons">create</i>\
                            </button>'
                            return actions;
                        }
                    },
                    {
                        name: 'delete',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            if(data.id == 1){
                                return "";
                            }
                            var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float delete">\
                                <i class="material-icons">delete</i>\
                            </button>'
                            return actions;
                        }
                    },
                    /*{
                     name: 'password',
                     data: null,
                     sortable: false,
                     searchable: false,
                     render: function (data) {
                     if(data.id == 1){
                     return "";
                     }
                     var actions = '<button type="button" class="btn btn-default btn-circle waves-effect waves-circle waves-float delete" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.table_editable') }}">\
                     <i class="material-icons">cached</i>\
                     </button>'
                     return actions;
                     }
                     },*/
                ]
            });
            //Datatable end
            $('[data-toggle="tooltip"]').tooltip({'container':'body'});

            /*
             * Open the permissions modal @PERMISSIONS
            * The modal can't be open if the user hasn't selected a role before.
             */

            var flagRoleNotAdmin;
            $("#btnPermissions").click(function(){
                var role = $("[name=role]").val();

                if(role == ""){
                    swal({
                        title: "{{trans('user.oops')}}",
                        text: "{{trans('user.msg_no_role_selected')}}",
                        type: "info",
                        html: true
                    });
                    return;
                }
                /*
                 * If the role is admin  all the check-boxes are checked in the permissions modal.
                 */

                /**
                 *    ADMIN1
                 */
                if(role == 'role_admin'){

                    activeUnactivePermissions(true);
                    flagRoleNotAdmin = true;

                }else{

                    if(flagRoleNotAdmin){
                        activeUnactivePermissions(false);
                        flagRoleNotAdmin = false;
                    }

                }

                $("#modalPermissions").modal('toggle');
            })
            function activeUnactivePermissions(flag){

                $("[name='sections[]']").prop('checked', flag);
                $("[name='sections[]']").prop('disabled', flag);
                $("[name='slctProjects']").prop('disabled', flag)
                $("[name='slctProjects']").selectpicker('refresh');
                $("#modalPermissions").find(".checkAll").prop('checked', flag);
                $("#modalPermissions").find(".checkAll").prop('disabled', flag);

            }

            function activeUnactivePermissionsEdit(flag){
                $("[name='sectionsEdit[]']").prop('checked', flag);
                $("#modalEditUser").find(".checkAll").prop('checked', flag);
                $("#modalEditUser").find(".checkAll").prop('disabled', flag);
                $("[name='sectionsEdit[]']").prop('disabled', flag);
                $("[name='slctProjectsEdit']").prop('disabled', flag)
                $("[name='slctProjectsEdit']").selectpicker('refresh');

            }

            /*
             * Initialize the jQuery validation for adding a user.
             */
            var validator = $('#frmUser').validate({

                ignore: ":hidden:not(.selectpicker)",
                /* Onkeyup
                 * For not sending an ajax request to validate the email each time till the typing is done.
                 */
                /*onkeyup: false,*/
                rules: {
                    'name': {
                        required: true
                    },
                    'telephone': {
                        required: false,
                        validIntInputTelephone: true,
                    },
                    'email': {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{route('admin-validate-new-user-email')}}",
                            type: "post",
                            data: {
                                email: function() {
                                    return $("[name='email']").val();
                                }
                            }
                        }
                    },
                    'entity': {
                        required: true
                    },
                    'role': {
                        required: true
                    }
                },
            }); //Validation end

            $(".slctFrmUser[name='role']").change(function(){

                var role = $(this).find("option:selected").val();
                if (role == 'role_it' || role == 'role_auditor' || role == 'role_admin') {
                    $('#btnPermissions').addClass('hidden');
                } else {
                    $('#btnPermissions').removeClass('hidden');
                }

                /*validator.element($(this));*/
            });

            function initializeFormEditValidate(){
                var validatorEdit = $('#frmUserEdit').validate({

                    ignore: ":hidden:not(.selectpicker)",
                    /* Onkeyup
                     * For not sending an ajax request to validate the email each time till the typing is done.
                     */
                    /*onkeyup: false,*/
                    rules: {
                        'nameEdit': {
                            required: true
                        },
                        'telephoneEdit': {
                            required: false,
                            validIntInputTelephone: true,
                        },
                        'entityEdit': {
                            required: true
                        },
                        'emailEdit': {
                            required: true,
                            email: true,
                            remote: {
                                url: "{{route('users.validate.email.edit')}}",
                                type: "post",
                                data: {
                                    email: function() {
                                        return $("[name='emailEdit']").val();
                                    },
                                    user_id: function(){
                                        return $("[name=user_id]").val();
                                    }
                                }
                            }
                        },
                    }
                }); //Validation end
            }

            /*
             * Manually validate select picker.
             */
            $("select").on('change', function () {
                /*validateSelect($(this));*/
            });

            // The default value for $('#frm_editCategory').validate().settings.ignore

            /*$('#frmUser').validate().settings.ignore =
             ':not(select:hidden, input:visible, textarea:visible)';*/




            /*
             * Initialize the ajax select picker plugins      @SELECTPROJECTS
            * The plugin is an extension of the selectpicker.
             * Is used for searching the projects in the permissions modal.
             */

            var projectsSearch = [];

            inatializeAjaxSlctProjects($("[name=slctProjects]"));


            function inatializeAjaxSlctProjects(object, data2){


                return object.selectpicker().ajaxSelectPicker({
                    ajax: {
                        url: '{{route('admin-find-projects-by-like')}}',
                        dataType: 'JSON',
                        jsonpCallback: 'projects',
                    },
                    locale: {
                        emptyTitle: '{{trans('general.begin_typing')}}'
                    },
                    log: 3,
                    cache: true,
                    clearOnEmpty: true,
                    preserveSelected: true,
                    preprocessData: function (data) {


                        projectsSearch = data;
                        var i, l = data.projects.length,
                            arr = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                arr.push($.extend(true, data.projects[i], {
                                    text: data.projects[i].name,
                                    value: data.projects[i].id,
                                    data: {
                                        /*'icon': 'icon-person',*/
                                    }
                                }));
                            }
                        }
                        // You must always return a valid array when processing data. The
                        // data argument passed is a clone and cannot be modified directly.
                        return arr;
                    }
                });
            }

            /**
             * Initialize Projects Table
             */

            loadProjectsTable($("[name='slctProjects']"))
            loadProjectsTable($("[name='slctProjectsEdit']"))
            /**
             * [loadProjectsTable loads the selected projects into rows into the table]
             * @param  {[ jQuery object]} select [select object]
             * @return {[type]}        [description]
             */
            function loadProjectsTable( select )
            {
                select.on('changed.bs.select', function(){

                    var name = $(this).prop('name');
                    var selected = $(this).val()
                    var tbody = $($(this).parent().parent().find('.tbodyProjects'));
                    $(tbody).html("");
                    tbody.empty();

                    var tr = '';
                    $.each(selected, function(index, object){
                        tr += '\
          <tr>\
            <td>\
              <input type="checkbox" id="project' + object + '" value="' + object + '" class="filled-in" name="projects[]" checked disabled/>\
              <label for="project' + object + '">' + $("[name='" + name +"'] option[value="+object+"]").html() + ' </label>\
            </td>\
          </tr>';
                    });
                    tbody.append(tr);
                });
            }


            $("[name='role']").on('change', function () {

            });

            /*
             * Add user button click @STORE
            */
            $("#btnAddUser").click(function(){

                var proceed = false;


                if($('#frmUser').valid()){
                    /* The saved user has to have at least 1 permission selected */

                    /* Empty projects and sections */
                    user.sections = checkboxValues($("input[name='sections[]']:checked"));
                    user.role = $("[name=role]").val();

                    /*If the user is admin proceed*/
                    if(user.role == ""){
                        swal({
                            title: "{{trans('user.oops')}}",
                            text: "{{trans('user.select_permissions_save')}}",
                            type: "info",
                            html: true
                        });
                        return;
                    }
                    else if(user.role == 'role_admin' || user.role == 'role_it' || user.role == 'role_auditor'){
                        proceed = true;
                    }
                    /*If the user has the data entry generic role*/


                    if(user.sections.length == 0 && !proceed){
                        $("#modalPermissions").modal('toggle');
                        toastr.error("{{trans('user.select-permissions')}}");
                        return;
                    }

                    if(!proceed){
                        user.projects = $("[name='slctProjects']").val();

                        if($("[name='slctProjects']").val() == null ||user.projects.length == 0){
                            $("#modalPermissions").modal('toggle');
                            toastr.error("{{trans('user.projects_required')}}");
                            return;
                        }else{
                            proceed = true;
                        }
                    }

                    if(proceed){
                        swal({
                                title: '{{ trans('messages.confirm') }}',
                                text: "{{trans('user.save_confirm')}}",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "{{ trans('messages.yes_proceed') }}",
                                cancelButtonText: "{{ trans('general.no') }}",
                                closeOnConfirm: true
                            },
                            function(){
                                $('.page-loader-wrapper').show();
                                user.name = $("[name=name]").val();
                                user.email = $("[name=email]").val();
                                user.entity = $("[name=entity]").val();
                                user.role = $("[name=role]").val();


                                if($("[name='telephone']").val() != ""){

                                    var countryData = $("[name='telephone']").intlTelInput("getSelectedCountryData");
                                    user.country = countryData.iso2;
                                    user.telephone = $("[name='telephone']").intlTelInput("getNumber", intlTelInputUtils.numberFormat.NATIONAL);

                                }


                                $.ajax({
                                    url: '{{route('users.store')}}',
                                    type: 'POST',
                                    data: user,
                                    success: function(data){
                                        if(data.status){

                                            swal({
                                                title: "{{trans('messages.success')}}",
                                                text: "{{trans('user.success')}}",
                                                type: "success",
                                                html: true
                                            }, function(){
                                                location.reload();
                                            });
                                            /*Reload the table data*/
                                            /*Unselect fields*/
                                            activeUnactivePermissions(false);
                                            userTable.ajax.reload();
                                            $('#frmUser')[0].reset();

                                            $("select").val('');
                                            $("select").selectpicker("refresh");
                                            $('#frmUser').validate().resetForm();
                                            $('#frmUser').find(".success").removeClass("success");



                                        }
                                        $('.page-loader-wrapper').fadeOut();
                                        /*Reload the table data*/
                                        /*userTable.ajax.reload();*/

                                    },
                                    error: function(data){
                                        if(!data.errors){
                                            laravelErrors(data);
                                        }

                                        $('.page-loader-wrapper').fadeOut();

                                    }
                                });
                            });

                    }
                } //Valid true*/
                else{
                    validator.focusInvalid();

                }

            });
            $("#btnSavePermissions").click(function(){
                var proceed, sectors, projects;
                sections = checkboxValues($("input[name='sections[]']:checked"));
                proceed = false;
                if($("[name=role]").val() == 'role_admin'){
                    proceed = true;
                }
                if(sections.length == 0 && !proceed){
                    toastr.error("{{trans('user.select-permissions')}}");
                    return;
                }

                if(!proceed){
                    projects = $("[name='slctProjects']").val();
                    if($("[name='slctProjects']").val() == null || projects.length == 0){
                        toastr.error("{{trans('user.projects_required')}}");
                        return;
                    }else{
                        proceed = true;
                    }
                }
                if(proceed){
                    $("#modalPermissions").modal('toggle');
                    $("#btnAddUser").click();

                }
            });

            /*
             * Inactive the selected user  @INACTIVE
            */

            $('#users-table').on('click', '.checkInactive', function(event) {

                //Prevent to un-check/check the check-box until the request has been success-full.
                event.preventDefault();
                event.stopPropagation();

                /*Get the user object of the selected row*/
                var row = userTable.row( $(this).parent().parent() ).data();

                swal({
                        title: '{{ trans('messages.confirm') }}',
                        text: "{{trans('user.inactivate_confirm')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        /*The confirm modal appears*/
                        if (isConfirm) {
                            $('.page-loader-wrapper').show();

                            $.ajax({
                                url: '{{route('users.inactive')}}',
                                type: 'POST',
                                data: {id: row.id, inactive: row.inactive },
                                success: function(){
                                    $('.page-loader-wrapper').fadeOut();

                                    /*Reload the table data*/
                                    userTable.ajax.reload();

                                },
                                error: function(){

                                }
                            });

                            /*swal("Deleted!", "Your imaginary file has been deleted.", "success");*/
                        } else {
                            /*swal("Cancelled", "Your imaginary file is safe :)", "error");*/
                        }
                    });

                /*$('.page-loader-wrapper').show();
                 $('.page-loader-wrapper').fadeOut();*/
            });

            /*
             *Edit section user  @EDITROWCLICK
            */
            var previosAdminEdit = false;
            $('#users-table').on('click', '.edit', function(event) {
                inatializeAjaxSlctProjects($("[name=slctProjectsEdit]"), []);

                /*Get the user object of the selected row*/
                var row = userTable.row( $(this).parent().parent() ).data();

                $('.page-loader-wrapper').show();

                // Search user permissions
                $.ajax({
                    url: '{{route('user.findPermissions')}}',
                    type: 'POST',
                    data: {user_id: row.id},
                    success: function(response){
                        if(response.status){

                            $("#modalEditUser").modal('toggle');
                            $('#modalEditUser').find('.tbodyProjects').html("");
                            initializeIntTelInput($("[name='telephoneEdit']"));
                            $("[name=user_id]").val(row.id);
                            $("[name=nameEdit]").val(row.name);
                            $("[name=emailEdit]").val(row.email);
                            $("[name=entityEdit]").val(row.entity_id);
                            $("[name=roleEdit]").val(row.role_name);
                            $("[name=dateEdit]").val(row.created_at);

                            //Telephone exists
                            if(row.telephone != null && row.dial_code != null){
                                var telephone = "+" + row.dial_code + row.telephone;
                                $("[name='telephoneEdit']").intlTelInput("setNumber", telephone);
                            }

                            if(row.role_name == 'role_admin'){
                                previosAdminEdit = true;
                                activeUnactivePermissionsEdit(true);
                            } else if (row.role_name == 'role_it' || row.role_name == 'role_auditor') {
                                $('#rowUserPermissions').addClass('hidden');
                            } else{
                                activeUnactivePermissions(false);
                            }

                            $('select').selectpicker('refresh');


                            var userObject = response.data;



                            var radio = $("input[name='rdbPermissionTypeEdit'][value=" + userObject.permission + "]")


                            $(radio).click();


                            /**
                             * Permission type @PERMISION_TYPE
                             * 1 Sectors
                             * 2 Projects
                             * 3 Admin
                             * 0 Not assigned
                             */
                            if(row.role_name != 'role_admin'){
                                $.each(userObject.sections, function(index, object){

                                    $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("disabled", false);

                                    $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("checked", true);

                                });
                                var projects = [];

                                $("[name='slctProjectsEdit']").html("");
                                $.each(userObject.projects_permissions, function(index, object){
                                    $("[name='slctProjectsEdit']").append("<option value=" + object.id + ">" + object.name +"</option>").selectpicker('refresh');
                                    projects.push(object.id)

                                });

                                $("[name='slctProjectsEdit']").selectpicker('val', 'default');
                                $("[name='slctProjectsEdit']").selectpicker('refresh');
                                $("[name='slctProjectsEdit']").selectpicker('val', projects);
                                $("[name='slctProjectsEdit']").change();
                            }



                            $('.page-loader-wrapper').fadeOut();
                        }
                    },
                    error: function(data){
                        if(!data.errors){
                            laravelErrors(data);
                        }

                        $('.page-loader-wrapper').fadeOut();

                    }
                });

            });

            $('#modalEditUser').on('hide.bs.modal', function (e) {

                activeUnactivePermissionsEdit(false);


                $('#frmUserEdit').validate().resetForm();
                $('#frmUserEdit').find(".success").removeClass("success");
                $('#frmUserEdit').find(".error").removeClass("error");
                $("[name='telephoneEdit']").val("");

            });
            $('#modalEditUser').on('shown.bs.modal', function (e) {

                initializeFormEditValidate();
                $('#frmUserEdit').valid();

            });

            /*
             *@EDIT
            */

            $("#btnSaveEdtiUser").click(function(ev){
                var userEdit = {
                    user_id: "",
                    name: "",
                    entity: "",
                    country: "",
                    telephone: "",
                    sections: [],
                    projects: [],
                    role: [],
                    email: "",
                }

                var proceed = false;

                var role = $("[name=roleEdit]").val();

                if (role === 'role_it' || role === 'role_auditor') {
                    proceed = true;
                }

                userEdit.sections = checkboxValues($("input[name='sectionsEdit[]']:checked"));

                /*
                 CHECK LENGTHS
                 */

                if(userEdit.sections.length == 0 && !proceed){
                    toastr.error("{{trans('user.select-permissions')}}");
                    return;
                }

                if(!proceed){

                    var permissionsEdit_projectArray = $("[name='slctProjectsEdit']");

                    if(permissionsEdit_projectArray.val()){

                        userEdit.projects = permissionsEdit_projectArray.val();

                    } else {

                        userEdit.projects = [];

                    }

                    if(permissionsEdit_projectArray.val() == null && userEdit.projects.length == 0){

                        if(role){

                            if(role == 'role_admin'){

                                proceed = true;
                            } else {
                                toastr.error("{{trans('user.projects_required')}}");
                                return;
                            }
                        } else {
                            toastr.error("{{trans('user.projects_required')}}");
                            return;
                        }
                    }else{
                        proceed = true;
                    }
                }

                if ($('#frmUserEdit').valid() && proceed)
                {
                    swal({
                            title: '{{ trans('messages.confirm') }}',
                            text: "{{trans('user.update_confirm')}}",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "{{ trans('messages.yes_proceed') }}",
                            cancelButtonText: "{{ trans('general.no') }}",
                            closeOnConfirm: true
                        },
                        function(){
                            $('.page-loader-wrapper').show();
                            userEdit.name = $("[name=nameEdit]").val();
                            userEdit.user_id = $("[name=user_id]").val();
                            userEdit.role = $("[name=roleEdit]").val();
                            userEdit.email = $("[name=emailEdit]").val();


                            userEdit.entity = $("[name=entityEdit]").val();

                            if($("[name='telephoneEdit']").val() != ""){
                                var countryData = $("[name='telephoneEdit']").intlTelInput("getSelectedCountryData");
                                userEdit.country = countryData.iso2;
                                userEdit.telephone = $("[name='telephoneEdit']").intlTelInput("getNumber", intlTelInputUtils.numberFormat.NATIONAL)
                            }

                            $.ajax({
                                url: '{{route('users.update')}}',
                                type: 'POST',
                                data: userEdit,
                                success: function(data){

                                    if(data.status){

                                        $("#modalEditUser").modal('toggle');
                                        setTimeout(function(){
                                            swal({
                                                title: "{{trans('messages.success')}}",
                                                text: "{{trans('user.updated')}}",
                                                type: "success",
                                                html: true
                                            }, function(){
                                                location.reload();
                                            });

                                        }, 800);


                                        userTable.ajax.reload();
                                        $('#frmUserEdit')[0].reset();
                                        $("select").val('default');
                                        $("select").selectpicker("refresh");
                                        $('#frmUserEdit').validate().resetForm();

                                        /*Reload the table data*/
                                        userTable.ajax.reload();
                                    }
                                    $('.page-loader-wrapper').fadeOut();


                                    /*Reload the table data*/
                                    /*userTable.ajax.reload();*/

                                },
                                error: function(data){
                                    if(!data.errors){
                                        laravelErrors(data);
                                    }

                                    $('.page-loader-wrapper').fadeOut();

                                }
                            });
                        });

                }
                else
                {

                }
            });

            $("[name='roleEdit']").change(function(){

                var role = $(this).val();

                if (role == 'role_it' || role == 'role_auditor') {
                    $('#rowUserPermissions').addClass('hidden');
                } else {
                    $('#rowUserPermissions').removeClass('hidden');
                }


                if(role == 'role_admin'){

                    activeUnactivePermissionsEdit(true);

                } else{
                    activeUnactivePermissionsEdit(false);
                }


            });
            /*
             * End Edit section
             */

            /*
             * User object
             * The properties has to be as same as the validator request of laravel.
             */
            var user = {
                name: "",
                email: "",
                entity: "",
                role: "",
                prefix: "",
                country: "",
                telephone: "",
                date: "",
                sectors: [],
                sections: [],
                projects: [],
                coordinator: "",
            }





            /**
             * @CHECKBOX_RADIOS_FUNCTIONS
             *
             */

            /*
             * Checking and un-checking all the checkboxes sectors/projects
             */
            $(".checkAll").click(function(){
                $($(this).parents('table').find('tbody').find("input[type='checkbox']")).prop('checked', this.checked)
            });

            /*
             * Radio projects/sectors click @PERMISION_TYPE
             * This option is for disabled and enabled depending on whats selected
             * 1 Sectors
             * 2 Projects
             */



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
             * @DELETEROWCLICK
            */

            $('#users-table').on('click', '.delete', function(event) {


                /*Get the user object of the selected row*/
                var row = userTable.row( $(this).parent().parent() ).data();
                $("[name=user_edit_id]").val(row.id);

                $('.page-loader-wrapper').show();
                $.ajax({
                    url: '{{route('user.findByRoleAndAdmin')}}',
                    type: 'POST',
                    data: {role_id: row.role_name},
                    success: function(response){
                        if(response.status){
                            $("#modalDelete").modal('toggle');
                            initializeDeleteValidator();
                            $("[name='user_assign']").empty().selectpicker('refresh');

                            /*
                             * Load the users into the select
                             */
                            $.each(response.data, function(index, object) {

                                $.each(object.users, function(index2, object2){
                                    if(row.id != object2.id){
                                        $("[name='user_assign']").append('<option value="' + object2.id + '">'+ object2.name +' ('+ object2.email + ')</option>');
                                    }
                                });

                            });
                            $("[name='user_assign']").selectpicker('refresh');
                        }
                        $('.page-loader-wrapper').fadeOut();
                        /*Reload the table data*/
                        /*userTable.ajax.reload();*/
                    },
                    error: function(data){
                        if(!data.errors){
                            laravelErrors(data);
                        }
                        $('.page-loader-wrapper').fadeOut();
                        swal({
                            title: "{{trans('messages.error')}}",
                            text: "{{trans('messages.general_error')}}",
                            type: "error",
                            html: true
                        }, function(){
                        });
                    }
                });




            });

            /*Checkbox*/
            $(".checkDelete").click(function(ev){
                /*ev.preventDefault()*/

                var parent = $(this).parent().parent();
                var checkboxesChekeced = parent.find("input[type='checkbox']:checked");
                var checkboxes = parent.find("input[type='checkbox']");

                if(checkboxesChekeced.length < 1){
                    $(this).prop('checked', true);
                }



                if($(this).val() == 1 && checkboxesChekeced.length > 0){
                    parent.find("input[type='checkbox'][value=1]").prop('checked', true);
                    parent.find("input[type='checkbox'][value=2]").prop('checked', false);
                }else if($(this).val() == 2 && checkboxesChekeced.length > 0){
                    parent.find("input[type='checkbox'][value=2]").prop('checked', true);
                    parent.find("input[type='checkbox'][value=1]").prop('checked', false);
                }

                if($(this).val() == 1){

                    $("#frmGroupUserAssign").hide();

                }else{

                    $("#frmGroupUserAssign").show();

                }

                delete_role_id = 2;


            });

            var delete_role_id = 1;


            /*@DELETE*/
            $("#btnDeleteUser").click(function(){

                if( $('#frmDelete').valid() ){
                    /*var deleteType = $(".checkDelete:checked").val();*/
                    deleteType = 2;
                    var msg;
                    if(deleteType == 1){
                        msg = "{{trans('user.delete_confirm_all')}}"
                    }
                    else{
                        msg = "{{trans('user.delete_confirm_assign')}}"
                    }

                    swal({
                            title: '{{ trans('messages.confirm') }}',
                            text: msg,
                            type: "warning",
                            html: true,
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "{{ trans('messages.yes_proceed') }}",
                            cancelButtonText: "{{ trans('general.no') }}",
                            closeOnConfirm: true
                        },
                        function(){
                            $('.page-loader-wrapper').show();

                            var userDelete = {
                                user_id: $("[name='user_edit_id']").val(),
                                user_assign: $("[name='user_assign']").val(),
                                description: $("[name=description]").val(),
                                deleteType: deleteType
                            }
                            $.ajax({
                                url: '{{route('users.delete')}}',
                                type: 'POST',
                                data: userDelete,
                                success: function(data){
                                    if(data.status){
                                        swal({
                                            title: "{{trans('messages.success')}}",
                                            text: "{{trans('user.deleted')}}",
                                            type: "success",
                                            html: true
                                        }, function(){
                                            location.reload();
                                        });
                                        $("#modalDelete").modal('toggle');
                                        /*Reload the table data*/
                                        userTable.ajax.reload();
                                    }
                                    $('.page-loader-wrapper').fadeOut();

                                    /*Reload the table data*/
                                    /*userTable.ajax.reload();*/

                                },
                                error: function(data){
                                    if(!data.errors){
                                        laravelErrors(data);
                                    }

                                    $('.page-loader-wrapper').fadeOut();

                                }
                            });
                        });
                }else{
                    validatorDelete.focusInvalid();
                }
            });
            var validatorDelete;
            function initializeDeleteValidator(){
                validatorDelete = $('#frmDelete').validate({
                    ignore: ":hidden",
                    /* Onkeyup
                     * For not sending an ajax request to validate the email each time till the typing is done.
                     */
                    /*onkeyup: false,*/
                    rules: {
                        'description': {
                            required: true,
                            minlength: 10,
                        },
                        'user_assign': {
                            required: true,
                        }
                    }
                }); //Validation end
            }

            /**
             * End DELETE
             */
            /*
             * @FUNCTIONS
            */
            /*
             * Validate select picker manually
             *
             */
            function validateSelect(element){

                if(element.val() == ""){
                    element.parents('.form-line').removeClass('success');

                    element.parents('.form-line').addClass('error');
                    element.parents('.form-group').find('.error2').show();
                    return false;
                }else{
                    element.parents('.form-line').removeClass('error');
                    element.parents('.form-line').addClass('success');
                    element.parents('.form-group').find('.error2').hide();
                    return true;
                }
            }

            function laravelErrors(errors){

                var li ="" , element;
                $.each(errors.responseJSON, function(index, field){
                    $.each(field, function(index2, error){
                        li += '<li>' + error + '</li>';
                    });
                });

                element = '<div class="alert alert-danger">\
            <ul>' + li +'</ul>\
        </div>';
                $(".errors").html(element);

            }
            function checkboxValues(element){
                var types = [];
                element.each(function (i) {
                    types.push($(this).val());
                });
                return types;
            }


            var procurementSectionsIds = [1, 2, 3, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
            var performanceSectionsIds = [2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 21, 22];

            /**
             * [defaultCheckBoxes check the default ]
             * @param  {[type]} inputName [input name]
             * @param  {[array]} ids       [arra]
             */

            function defaultCheckBoxes(inputName, ids, flag){

                $(".checkAllSections").prop('disabled', true);
                $("input[name='"+ inputName +"']").prop("disabled", true);
                if(flag){
                    $("input[name='"+ inputName +"']").prop("checked", false);
                }

                $.each(ids, function(index, object){

                    $("input[name='"+ inputName +"'][value=" + object + "]").prop("checked", true);

                });
            }





        }); //End Document
    </script>
@endsection