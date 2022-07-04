@extends('layouts.back')

@section('styles')

  <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">

  <link href="{{ asset('back/plugins/intl-tel-input/intlTelInput.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/toastr/toastr.css') }}" rel="stylesheet">
  <link href="{{ asset('back/css/views/role-management/users.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/multi-select/multi-select.css') }}" rel="stylesheet">


@endsection

@section('content')
    <h1 class="content-title">{{trans("user.edit-users-title")}}</h1>
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
                    <select class="form-control show-tick selectpicker slctFrmUser" name="role" title="-- {{trans('user.choose-option')}} --"">
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
                      <th>Id</th>
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
              <div class="col-md-4">
                {{-- Select projects or sectors --}}
                <div class="col-md-12 projects-sectors">
                  {{-- <p>Please select bla bla</p> --}}
                  <input class="rdbPermissionTypes" name="rdbPermissionType" type="radio" id="radio_1"  value="1" checked="">
                  <label for="radio_1">{{trans('user.sectors')}}</label>
                  <input class="rdbPermissionTypes" name="rdbPermissionType" type="radio" id="radio_2" value="2">
                  <label for="radio_2">{{trans('user.projects')}}</label>
                </div>
                {{-- End projects or sectors --}}
                <div class="col-md-12">
                  <div class="table-responsive tblsSectors" id="prmSectors">
                    <table class="table table-modal w-100">
                      <thead>
                        <tr>
                          <th>
                            <div>
                              <div class="display_inline_block" >
                                {{trans('user.sectors')}}
                              </div>
                              <div class="pull-right display_inline_block" >
                                <label for="sectorCheck222">{{trans('user.select-all')}} </label>
                                <input type="checkbox" id="sectorCheck222" value="22" class="filled-in checkAll"/>
                                <label for="sectorCheck222" class="color_white">.</label>
                              </div>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($sectors as $index => $sector)
                          <tr>
                            <td>
                              <input type="checkbox" id="sectorCheck{{$sector->id}}" value="{{$sector->id}}" class="filled-in sectors" name="sectors[]"/>
                              <label for="sectorCheck{{$sector->id}}">{{ trans('catalogs/sectors.'.$sector->code_lang) }}</label>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                {{-- End --}}
                <div class="col-md-12">
                    <select class="slctProjects" name="slctProjects" data-live-search="true" multiple disabled >
                    </select>
                    <div class="table-responsive" id="tblProjects">
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
                </div>
                {{-- End col --}}
              </div>
              <div class="col-md-8">
                <div class="col-md-12">
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

                        <tr>
                          @for($i = 0; $i < count($sectionsPart1); $i++ )
                            {{-- @if($i % 2 == 0 )
                              {!! "<tr>" !!}
                            @endif --}}
                            <tr>
                              <td @if($sectionsPart1[$i]['parent']) class="td-projects-section-gray" data-parent="{{$sectionsPart1[$i]['parent']}}" @endif>
                                <input type="checkbox" id="sectorid{{$sectionsPart1[$i]['id']}}" class="filled-in @if($sectionsPart1[$i]['parent']) subSection @endif @if(in_array($sectionsPart1[$i]['id'], [4,12])) parentSection @endif" value="{{$sectionsPart1[$i]['id']}}" name="sections[]" @if($sectionsPart1[$i]['parent']) data-parent="{{$sectionsPart1[$i]['parent']}}" @endif/>
                                <label for="sectorid{{$sectionsPart1[$i]['id']}}">{{ trans('catalogs/sections.'.$sectionsPart1[$i]['code_lang']) }}</label>
                              </td>
                              <td @if($sectionsPart2[$i]['parent']) class="td-projects-section-gray" data-parent="{{$sectionsPart2[$i]['parent']}}" @endif>
                                <input type="checkbox" id="sectorid{{$sectionsPart2[$i]['id']}}" class="filled-in @if($sectionsPart2[$i]['parent']) subSection @endif @if(in_array($sectionsPart2[$i]['id'], [4,12])) parentSection @endif" value="{{$sectionsPart2[$i]['id']}}" name="sections[]" @if($sectionsPart2[$i]['parent']) data-parent="{{$sectionsPart2[$i]['parent']}}" @endif/>
                                <label for="sectorid{{$sectionsPart2[$i]['id']}}">{{ trans('catalogs/sections.'.$sectionsPart2[$i]['code_lang']) }}</label>
                              </td>
                            </tr>
                            {{-- @if($i % 2 == 1 )
                              {!! "</tr>" !!}
                            @endif --}}
                          @endfor
                          {{-- @if($i % 2 == 1 )
                            {!! "</tr>" !!}
                          @endif --}}


                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
          </div>{{-- Body --}}
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-link waves-effect" id="">{{trans('user.save')}}</button> --}}
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('general.save')}}</button>
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
                            <input type="text" class="form-control" name="emailEdit" disabled>
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
                          <select class="form-control show-tick selectpicker" name="roleEdit" disabled title="-- {{trans('general.choose-option')}} --">
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
            <div class="row clearfix">
              <div class="col-md-12">
                <h4 class="modal-title" id="defaultModalLabel">{{trans('general.permissions')}}</h4>
                <p class="modalPermissionsMsg" hidden>{{trans('user.select-permissions')}}</p>
              </div>
              <div class="col-md-4">
                {{-- Select projects or sectors --}}
                <div class="col-md-12 projects-sectors">
                  {{-- <p>Please select bla bla</p> --}}
                  <input class="rdbPermissionTypes" name="rdbPermissionTypeEdit" type="radio" id="radioSecEdit"  value="1" checked="">
                  <label for="radioSecEdit">{{trans('user.sectors')}}</label>
                  <input class="rdbPermissionTypes" name="rdbPermissionTypeEdit" type="radio" id="radioProEdit" value="2">
                  <label for="radioProEdit">{{trans('user.projects')}}</label>
                </div>
                {{-- End projects or sectors --}}
                <div class="col-md-12">
                  <div class="table-responsive tblsSectors" id="prmSectorEdit" >
                    <table class="table table-modal w-100">
                      <thead>
                        <tr>
                          <th>
                            <div>
                              <div class="display_inline_block">
                                {{trans('user.sectors')}}
                              </div>
                              <div class="pull-right display_inline_block">
                                <label for="sectorCheckAllSector">{{trans('user.select-all')}} </label>
                                <input type="checkbox" id="sectorCheckAllSector" value="22" class="filled-in checkAll"/>
                                <label class="color_white" for="sectorCheckAllSector">.</label>
                              </div>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($sectors as $index => $sector)
                          <tr>
                            <td>
                              <input type="checkbox" id="sectorCheckEdit{{$sector->id}}" value="{{$sector->id}}" class="filled-in sectors" name="sectorsEdit[]"/>
                              <label for="sectorCheckEdit{{$sector->id}}">{{ trans('catalogs/sectors.'.$sector->code_lang) }}</label>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                {{-- End --}}
                <div class="col-md-12">
                    <select class="slctProjects" name="slctProjectsEdit" data-live-search="true" multiple disabled >
                    </select>
                    <div class="table-responsive" id="prmSectors2">
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
                {{-- End col --}}
              </div>
              <div class="col-md-8">
                <div class="col-md-12">
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
                        <tr>
                          @for($i = 0; $i < count($sectionsPart1); $i++ )
                            {{-- @if($i % 2 == 0 )
                              {!! "<tr>" !!}
                            @endif --}}
                            <tr>
                              <td @if($sectionsPart1[$i]['parent']) class="td-projects-section-gray" data-parent="{{$sectionsPart1[$i]['parent']}}" @endif>
                                <input type="checkbox" id="sectoridEdit{{$sectionsPart1[$i]['id']}}" class="filled-in @if($sectionsPart1[$i]['parent']) subSection @endif @if(in_array($sectionsPart1[$i]['id'], [4,12])) parentSection @endif" value="{{$sectionsPart1[$i]['id']}}" name="sectionsEdit[]" @if($sectionsPart1[$i]['parent']) data-parent="{{$sectionsPart1[$i]['parent']}}" @endif/>
                                <label for="sectoridEdit{{$sectionsPart1[$i]['id']}}">{{ trans('catalogs/sections.'.$sectionsPart1[$i]['code_lang']) }}</label>
                              </td>
                              <td @if($sectionsPart2[$i]['parent']) class="td-projects-section-gray" data-parent="{{$sectionsPart2[$i]['parent']}}" @endif>
                                <input type="checkbox" id="sectoridEdit{{$sectionsPart2[$i]['id']}}" class="filled-in @if($sectionsPart2[$i]['parent']) subSection @endif @if(in_array($sectionsPart2[$i]['id'], [4,12])) parentSection @endif" value="{{$sectionsPart2[$i]['id']}}" name="sectionsEdit[]" @if($sectionsPart2[$i]['parent']) data-parent="{{$sectionsPart2[$i]['parent']}}" @endif/>
                                <label for="sectoridEdit{{$sectionsPart2[$i]['id']}}">{{ trans('catalogs/sections.'.$sectionsPart2[$i]['code_lang']) }}</label>
                              </td>
                            </tr>
                            {{-- @if($i % 2 == 1 )
                              {!! "</tr>" !!}
                            @endif --}}
                          @endfor
                          {{-- @if($i % 2 == 1 )
                            {!! "</tr>" !!}
                          @endif --}}


                        </tr>
                      </tbody>
                    </table>
                  </div>
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

    <!-- Modal Project coordinator ====================================================================================================================== -->
    <div class="modal fade " id="modalGenericDataEntry" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="largeModalLabel">{{trans('user.project-coordinator-title')}}</h4>
          </div>
          <div class="modal-body">

            <div class="row clearfix">
              <div class="col-md-12">
                <p>{{trans('user.project-coordinator-details')}}</p>
              </div>
            </div>
            <div class="row clearfix">
              <div class="col-sm-4">
                <div class="form-group form-float">
                  {{-- <b>{{trans('user.project-coordinator')}}</b> --}}
                  <div class="form-line">
                    <select class="form-control show-tick" name="slctProjectCoordinator" data-live-search="true" title="-- {{trans('general.choose-option')}} --">
                    </select>
                    </div>
                  <label id="" for="entity" class="error2 display_none">{{trans('jquery-validation.required')}}</label>
                </div>
              </div>
            </div>

          </div>{{-- Body --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="saveProjectCoordinator" >{{trans('user.next')}}</button>
            {{-- <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">{{trans('user.cancel')}}</button> --}}
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Project coordinator ====================================================================================================================== -->

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
        /*$("[name=role]").focus();*/
        return;
      }

      /*
       * Generic Data Entry
       * If the user is generic data entry, it has to be assign to a project coordinator.
       */
      if(role == 'role_data_entry_generic'){
        loadProjectCoordinatorModal()
        return;
      }

      /*
       * If the role is admin  all the check-boxes are checked in the permissions modal.
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
      $("[name='sectors[]']").prop('checked', flag);
      $("[name='sections[]']").prop('disabled', flag);
      $("[name='sectors[]']").prop('disabled', flag);
      $("[name='rdbPermissionType']").prop('disabled', flag);
      $("#modalPermissions").find(".checkAll").prop('checked', flag);
      $("#modalPermissions").find(".checkAll").prop('disabled', flag);

    }

    function activeUnactivePermissionsEdit(flag){
      $("[name='sectionsEdit[]']").prop('checked', flag);
      $("[name='sectorsEdit[]']").prop('checked', flag);
      $("#modalEditUser").find(".checkAll").prop('checked', flag);
      $("#modalEditUser").find(".checkAll").prop('disabled', flag);

      $("[name='rdbPermissionTypeEdit']").prop('disabled', flag);
      $("[name='sectionsEdit[]']").prop('disabled', flag);
      $("[name='sectorsEdit[]']").prop('disabled', flag);

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
      messages: {
        'entity': "{{ trans('jquery-validation.required') }}",
        'role': "{{ trans('jquery-validation.required') }}",
      },
    }); //Validation end

    $(".slctFrmUser").change(function(){


      validator.element($(this));
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
           emptyTitle: 'Select and Begin Typing'
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

      $('#modalPermissions').on('hidden.bs.modal', function (e) {



      });

      $("[name='role']").on('change', function () {
        /*Mark the defaults checkboxs*/
        /*activeUnactivePermissions(false);*/
        if($(this).val() == 'role_data_entry_procurement'){
            defaultCheckBoxes("sections[]", procurementSectionsIds, true);
        }else if($(this).val() == 'role_data_entry_progress'){
          defaultCheckBoxes("sections[]", performanceSectionsIds, true);
        }
        else if($(this).val() == 'role_data_entry_project_coordinator'){
          defaultCheckBoxes("sections[]", performanceSectionsIds, false);
          defaultCheckBoxes("sections[]", procurementSectionsIds, false);

        }else{
          activeUnactivePermissions(false);
        }

      });

      /*
       * Add user button click @STORE
       */
      $("#btnAddUser").click(function(){
        /*var vs1, vs2;*/
        var proceed = false;
        /*vs1 = validateSelect($("[name='entity']"));
        vs2 = validateSelect($("[name='role']"));*/

        if($('#frmUser').valid() /*&& vs1 && vs2*/){
          /* The saved user has to have at least 1 permission selected */

          /* Empty projects and sections */
          user.sectors = [];
          user.sectors = [];
          user.sections = checkboxValues($("input[name='sections[]']:checked"));
          user.role = $("[name=role]").val();

          user.permissionType = $("[name='rdbPermissionType']:checked").val();

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
          else if(user.role == 'role_admin'){
            user.permissionType = 3;
            proceed = true;
          }
          /*If the user has the data entry generic role*/
          else if(user.role == 'role_data_entry_generic'){
            user.coordinator = $("[name=slctProjectCoordinator]").val();
            user.permissionType = 0;
            if(user.coordinator == ""){
              loadProjectCoordinatorModal();
              toastr.error("{{trans('user.select_project_coordinator')}}");
              return;
            }else{
              proceed = true;
            }

          }

          if(user.sections.length == 0 && !proceed){
            $("#modalPermissions").modal('toggle');
            toastr.error("{{trans('user.select-permissions')}}");
            return;
          }

          if(user.permissionType == 1 && !proceed){
            user.sectors = checkboxValues($("input[name='sectors[]']:checked"));
            if(user.sectors.length == 0){
              $("#modalPermissions").modal('toggle');
              toastr.error("{{trans('user.sectors_required')}}");
              return;
            }else{
              proceed = true;
            }

          } else if(user.permissionType == 2 && !proceed){
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
              /*$("[name='slctProjects']").append('<option value="5">Test</option>').selectpicker('refresh');
              $("[name='slctProjects']").selectpicker('val', '5');*/

              //If telephone exists

              if(row.telephone != null && row.dial_code != null){

                  var telephone = "+" + row.dial_code + row.telephone;
                  $("[name='telephoneEdit']").intlTelInput("setNumber", telephone);
              }

              if(row.role_name == 'role_admin'){
                previosAdminEdit = true;
                activeUnactivePermissionsEdit(true);
              }
              else if(row.role_name == 'role_data_entry_procurement'){
                  defaultCheckBoxes('sectionsEdit[]', procurementSectionsIds, true);
              }else if(row.role_name == 'role_data_entry_progress'){
                defaultCheckBoxes('sectionsEdit[]', performanceSectionsIds, true);
              }else if(row.role_name == 'role_data_entry_project_coordinator'){
                //Show data entries project coordinator button
                /*$("#btnModalEditDataEntries").show();*/
                defaultCheckBoxes('sectionsEdit[]', performanceSectionsIds, false);
                defaultCheckBoxes('sectionsEdit[]', procurementSectionsIds, false);
              }else{
                //Hide data entries project coordinator button
                /*$("#btnModalEditDataEntries").hide();*/
                activeUnactivePermissions(false);
                /*$("#btnModalEditDataEntries").hide();*/
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
            if(row.role_name != 'role_data_entry_procurement' && row.role_name != 'role_data_entry_progress' && row.role_name != 'role_data_entry_project_coordinator'){
               $.each(userObject.sections, function(index, object){

                  $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("disabled", false);

                  $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("checked", true);

                });
             }


              if ( userObject.permission == 1 )
              {

                $.each(userObject.sectors, function(index, object){
                  $("input[name='sectorsEdit[]'][value=" + object.id + "]").prop("checked", true);

                });
              }

              else if ( userObject.permission == 2 )
              {
                var projects = [];
                /*var $elem = inatializeAjaxSlctProjects($("[name=slctProjectsEdit]"), userObject.projects);*/
                /*$elem.trigger('change').data('AjaxBootstrapSelect').list.cache = {}*/
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

              /*Reload the table data*/
              /*userTable.ajax.reload();*/
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

        /*activeUnactivePermissionsEdit(false);*/

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
          sectors: [],
          projects: [],
        }
        var proceed = false;

        userEdit.sections = checkboxValues($("input[name='sectionsEdit[]']:checked"));

        userEdit.permissionType = $("[name='rdbPermissionTypeEdit']:checked").val();



        if(userEdit.sections.length == 0 && !proceed){
          toastr.error("{{trans('user.select-permissions')}}");
          return;
        }

        if(userEdit.permissionType == 1 && !proceed){
          userEdit.sectors = checkboxValues($("input[name='sectorsEdit[]']:checked"));
          if(userEdit.sectors.length == 0){
            toastr.error("{{trans('user.sectors_required')}}");
            return;
          }else{
            proceed = true;
          }

        } else if(userEdit.permissionType == 2 && !proceed){
          userEdit.projects = $("[name='slctProjectsEdit']").val();
          if($("[name='slctProjectsEdit']").val() == null && userEdit.projects.length == 0){
            toastr.error("{{trans('user.projects_required')}}");
            return;
          }else{
            proceed = true;
          }
        }
        if ( $('#frmUserEdit').valid() && proceed)
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
        permission: "",
        permissionType: "",
        coordinator: "",
      }



       /*
       * Project coordinator function  @PROJECTCOORDINATOR
       *
       */
      /**
       * [loadProjectCoordinatorModal Used to load the modal with all the existing project coordinators]
       * @return {[type]} [description]
       */
      $("#saveProjectCoordinator").click(function(){
        $("#btnAddUser").click();
      });

      function loadProjectCoordinatorModal(){
        $('.page-loader-wrapper').show();
        $.ajax({
          url: '{{route('user.findByRole')}}',
          type: 'POST',
          data: {role_id: 'role_data_entry_project_coordinator'},
          success: function(response){
            if(response.status){
              $("[name='slctProjectCoordinator']").empty().selectpicker('refresh');
              /*
               * Load the project coordinators into the select
               */
              $.each(response.data, function(index, object) {
                $("[name='slctProjectCoordinator']").append('<option value="' + object.id + '">' + object.email + '</option>');
              });
              $("[name='slctProjectCoordinator']").selectpicker('refresh');
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

        $("#modalGenericDataEntry").modal('toggle')

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

      $(".rdbPermissionTypes").click(function(){
        var permissionType = $(this).val();

        var div = $(this).parent().parent().parent();
        if(permissionType == 1){
          $(div.find('.tblsSectors')).find("input[type='checkbox']").prop('disabled', false);
          $(div).find('.slctProjects').prop('disabled', true);
        }else if(permissionType == 2) {
          $(div.find('.tblsSectors')).find("input[type='checkbox']").prop('disabled', true);
          $(div).find('.slctProjects').prop('disabled', false);
        }

        $(".slctProjects").selectpicker('refresh');
      });

      /**
       * Checks if the section that have sub sections have at least one child selected.
       */
      $(".parentSection").click(function(){
        var tbody = $(this).parent().parent().parent();

        /*$($(this).parents('table').find('tbody').find("input[type='checkbox']")).prop('checked', this.checked)*/
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

                /*if(row.role_name != 'role_data_entry_project_coordinator' && object.name != 'role_admin'){*/
                  $.each(object.users, function(index2, object2){

                    if(row.id != object2.id){

                      if(row.role_name == 'role_data_entry_project_coordinator' && object.name == 'role_admin'){

                      }else{
                        $("[name='user_assign']").append('<option value="' + object2.id + '">'+ object2.name +' ('+ object2.email + ')</option>');
                      }

                    }
                  });
                /*}*/


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

        /*if($(this).val() == 1){
          parent.find("input[type='checkbox'][value=1]").prop('checked', true);
        }else if($(this).val() == 2){
          parent.find("input[type='checkbox'][value=2]").prop('checked', true);
        }*/

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

      /*var optionsSelectUsers = {
      $("[name=user_assign]").ajaxSelectPicker({
            ajax: {
                url: '{{ route('admin.usersListLikeRole') }}',
                data: {role_id: delete_role_id},
            },
            locale: {
                statusInitialized: 'Start typing a user name ...'
            },
            preprocessData: function (users) {
                var i, l = users.length,
                    arr = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        arr.push($.extend(true, users[i], {
                            text: users[i].name + ' ' + users[i].email,
                            value: users[i].id
                        }));
                    }
                }

                return arr;
            }
        }
        });*/

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

      /**
       * @EDIT_DATA_ENTRIES
       * Load data entries related to a project coordinator.
       */

      /*Data entries multiselect initialize */
      $('#slctDataEntriesGeneric').addClass('display_none');

      $('#slctDataEntriesGeneric').selectpicker('destroy');

      $('#slctDataEntriesGeneric').multiSelect({ selectableOptgroup: false });


      $("#btnModalEditDataEntries").click(function(event){
        event.preventDefault();


        /*Get the user object of the selected row*/

        var project_coordinator_id = $("[name=user_id]").val();


        //Hide edit user modal
        $("#modalEditUser").modal('toggle');

        //Show edit data entires modal
        $("#modalEditDataEntries").modal('toggle');

        /*$('.page-loader-wrapper').show();*/
        $.ajax({
          url: '{{route('user.findDataEntriesGeneric')}}',
          type: 'POST',
          data: {project_coordinator_id: project_coordinator_id},
          success: function(response){
            if(response.status){


              $.each(response.users, function(index, object){


                /*$('#slctDataEntriesGeneric').append("<option value=" + object.id + ">" + object.name +"</option>")*/
                var text = object.name + ' ' + object.email;
                $('#slctDataEntriesGeneric').multiSelect('addOption', { value: object.id, text: text});


              });

              $.each(response.assigned, function(index, object){


                /*$('#slctDataEntriesGeneric').append("<option value=" + object.id + ">" + object.name +"</option>")*/
                var text = object.name + ' ' + object.email;
                $('#slctDataEntriesGeneric').multiSelect('addOption', { value: object.id, text: text});
                $('#slctDataEntriesGeneric').multiSelect('select', '' +object.id + '');



              });
              /*$('#slctDataEntriesGeneric').multiSelect({ selectableOptgroup: false });*/


              /*$('#slctDataEntriesGeneric').multiSelect('refresh');*/


              };

              $('.page-loader-wrapper').fadeOut();

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
    }); //End Document
  </script>
@endsection