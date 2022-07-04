@extends('layouts.back')

@section('styles')

  <link href="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('back/plugins/toastr/toastr.css') }}" rel="stylesheet">
  <link href="{{ asset('back/css/views/role-management/users.css') }}" rel="stylesheet">


@endsection

@section('content')
    <h1 class="content-title">{{trans("user.edit_permission_project_coordinator")}}</h1>
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
                      <th>...</th>
                  </tr>
              </thead>
          </table>
        </div>
      </div>
    </div>



    <!-- Modal Edit Permissions ====================================================================================================================== -->
    <div class="modal fade " id="modalEditUser" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <input type="hidden" name="user_id">
            <div class="row clearfix">
              <div class="col-md-12">
                <h4 class="modal-title" id="defaultModalLabel">{{trans('general.permissions')}}</h4>
                <p class="modalPermissionsMsg" hidden>{{trans('user.select-permissions')}}</p>
              </div>
              <div class="col-md-4">
                {{-- Select projects or sectors --}}
                <div class="col-md-12 projects-sectors">
                  {{-- <p>Please select bla bla</p> --}}
                  <input class="rdbPermissionTypes" name="rdbPermissionTypeEdit" type="radio" id="radioSecEdit"  value="1" disabled checked="">
                  <label for="radioSecEdit">{{trans('user.sectors')}}</label>
                  <input class="rdbPermissionTypes" name="rdbPermissionTypeEdit" type="radio" id="radioProEdit" value="2" disabled >
                  <label for="radioProEdit">{{trans('user.projects')}}</label>
                </div>
                {{-- End projects or sectors --}}
                <div class="col-md-12">
                  <div class="table-responsive tblsSectors" id="prmSectorEdit" >
                    <table class="table table-modal" style="width:100%">
                      <thead>
                        <tr>
                          <th>
                            <div>
                              <div style="display: inline-block;">
                                {{trans('user.sectors')}}
                              </div>
                              <div class="pull-right" style="display: inline-block;">
                                {{-- <label for="sectorCheckAllSector">{{trans('user.select-all')}} </label>
                                <input type="checkbox" id="sectorCheckAllSector" value="22" class="filled-in checkAll checkAllSector"/>
                                <label for="sectorCheckAllSector" style="color:white;">.</label> --}}
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
                      <table class="table table-modal" style="width:100%">
                        <thead>
                          <tr>
                            <th>
                              <div>
                                <div style="display: inline-block;">
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
                    <table class="table table-modal" style="width:100%">
                      <thead>
                        <tr>
                          <th colspan="2">
                            <div style="display: inline-block;">
                              {{trans('user.sections')}}
                              <p class="modalPermissionsMsg" hidden>At least one section is required.</p>
                            </div>
                            <div class="pull-right" style="display: inline-block;">
                              <label for="sectorCheckAllEdit">{{trans('user.select-all')}} </label>
                              <input type="checkbox" id="sectorCheckAllEdit" value="22" class="filled-in checkAll checkAllSections" name="sss[]"/>
                              <label for="sectorCheckAllEdit" style="color:white;">.</label>
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
                  <label id="" for="entity" class="error2" style="display: none;">{{trans('jquery-validation.required')}}</label>
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
@endsection
@section('scripts')
  {{-- Input mask --}}
  <script src="{{ asset('back/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
  {{-- Datetime picker --}}
  <script src="{{ asset('back/plugins/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
  {{-- International telephone input --}}
  <script src="{{ asset('back/plugins/intl-tel-input/intlTelInput.js') }}"></script>

  {{-- <script src="{{ asset('back/plugins/intl-tel-input/intlTelInput.js') }}"></script> --}}

  <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
  <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
  <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('back/plugins/datatable/dataTables.bootstrap.js') }}"></script>
  <script src="{{ asset('back/plugins/toastr/toastr.min.js') }}"></script>




  <script>

    $(document).ready(function(){

      var project_coordinator = {!! $project_coordinator !!}

      var sections = {!! $sections !!}

      inactivePermissions();
      function inactivePermissions(){

        var radio = $("input[name='rdbPermissionTypeEdit'][value=" + project_coordinator.permission + "]").prop('checked', true);
        $(radio).click();
        $("input[name='sectionsEdit[]']").prop("checked", false);
        if(project_coordinator.permission == 1){

          $('#modalEditUser').find('.tblsSectors').find("input[type='checkbox']").prop('disabled', false);
          $('#modalEditUser').find('.slctProjects').prop('disabled', true);

          $("[name='slctProjectsEdit']").parent().parent().remove();
          $(".prmSectors2").remove();


          $("input[name='sectorsEdit[]']").prop("checked", false);
            $("input[name='sectorsEdit[]']").prop("disabled", true);

          $.each(project_coordinator.sectors, function(index, object){
            $("input[name='sectorsEdit[]'][value=" + object.id + "]").prop("disabled", false);
          });

        }else if(project_coordinator.permission == 2){

          $(".prmSectorEdit").remove();

          $("[name='slctProjectsEdit']").prop('disabled', false);

          $("[name='slctProjectsEdit']").empty().selectpicker('refresh');

          $("[name='sectorsEdit[]']").prop('checked', true);
          $("[name='sectorsEdit[]']").prop('disabled', true);

          $("#modalEditUser").find(".checkAllSector").prop('disabled', true);

          $.each(project_coordinator.projects_permissions, function(index, object){

            $("[name='slctProjectsEdit']").append("<option value=" + object.id + ">" + object.name +"</option>").selectpicker('refresh');
          });

          $("[name='slctProjectsEdit']").change()
        }

        //Remove the elements that are not assigned to the project coordinator.
        $("#modalEditUser").find("input[type='checkbox']:disabled").parent().remove();
        /*$("#modalEditUser").find("input[type='radio']:disabled").parent().remove();*/
      }



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
          url : '{!! route('project-coordinator.tableUsers') !!}',
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
        ]
      });
      //Datatable end

    /*
     * Open the permissions modal @PERMISSIONS
     * The modal can't be open if the user hasn't selected a role before.
     */

    var flagRoleNotAdmin;

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


    var projectsSearch = [];

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



      /*
       *Edit section user  @EDITROWCLICK
       */
      var previosAdminEdit = false;
      $('#users-table').on('click', '.edit', function(event) {


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
              $("[name=user_id]").val(row.id);

              $('select').selectpicker('refresh');

              var userObject = response.data;



              var radio = $("input[name='rdbPermissionTypeEdit'][value=" + userObject.permission + "]");

              /*$(radio).click();*/


              /**
               * Permission type @PERMISION_TYPE
               * 1 Sectors
               * 2 Projects
               * 3 Admin
               * 0 Not assigned
              */

               $.each(userObject.sections, function(index, object){
                  $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("disabled", false);
                  $("input[name='sectionsEdit[]'][value=" + object.id + "]").prop("checked", true);
                });

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
                $.each(userObject.projects_permissions, function(index, object){
                  projects.push(object.pivot.project_id)
                });
                $("[name='slctProjectsEdit']").selectpicker('val', projects);
                $("[name='slctProjectsEdit']").change()

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

        inactivePermissions();
      });


      /*
       *@EDIT
       */

      $("#btnSaveEdtiUser").click(function(ev){

        var userEdit = {
          user_id: "",
          sections: [],
          sectors: [],
          projects: [],
          permissionType: "",
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
          if($("[name='slctProjectsEdit']").val() == null || userEdit.projects.length == 0){
            toastr.error("{{trans('user.projects_required')}}");
            return;
          }else{
            proceed = true;
          }
        }
        if (proceed)
        {
          userEdit.user_id = $("[name=user_id]").val();
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
            userEdit.user_id = $("[name=user_id]").val();
            $.ajax({
              url: '{{route('project-coordinator.updateDataEntry')}}',
              type: 'POST',
              data: userEdit,
              success: function(data){


                if(data.status){
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
                  $("#modalEditUser").modal('toggle');
                  /*Reload the table data*/
                }
                $('.page-loader-wrapper').fadeOut();

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
    });
  </script>
@endsection