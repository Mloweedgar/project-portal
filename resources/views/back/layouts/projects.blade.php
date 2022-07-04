@extends('layouts.back')

@section('styles')
    <!--<link href="{{ asset('back/plugins/bootstrap-table/bootstrap-table.css') }}" rel="stylesheet">-->

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 class="content-title">{{__("menu.projects")}}</h1>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
        <a href="{{ route('documentation').'#project_main_page' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
    </div>
        @endif

    <div class="row content-row">
        <div class="col-md-12">
           @yield('form')
            <label>{{__('project.filter')}}</label>
            <div class="row">
                <div class="col-md-4 m-b-20">
                    <div class="project-filter-box">
                        <ul>
                        <li>{{__("general.phase")}}</li>
                        @foreach($stages as $stage)
                            <li><input type="checkbox" class="filled-in" id="stage{{$stage->id}}" value={{$stage->id}} name="stages[]" /><label for="stage{{$stage->id}}"> {{$stage->name}}</label></li>
                        @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 m-b-20">
                    <div class="project-filter-box">
                        <ul>
                            <li>{{__("general.region")}}</li>
                            @foreach ($regions as $region)
                                <li><input type="checkbox" class="filled-in" id="region{{$region->id}}" value={{$region->id}} name="regions[]" /><label for="region{{$region->id}}">{{$region->name}}</label></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 m-b-20">
                    <div class="project-filter-box">
                        <ul>
                            <li>{{__("add-project.sector")}}</li>
                            @foreach ($sectors as $sector)
                                <li><input type="checkbox" class="filled-in" id="sector{{$sector->id}}" value={{$sector->id}} name="sectors[]" /><label for="sector{{$sector->id}}">{{$sector->name}}</label></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="projects-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{__("add-project.add-placeholder")}}</th>
                        <th>{{__("add-project.sector")}}</th>
                        <th>{{__("general.region")}}</th>
                        <th>{{__("general.phase")}}</th>
                        <th>{{__("general.contracting_authority")}}</th>
                        <th>{{__("add-project.value")}}</th>
                        <th>{{__("add-project.value")}}</th>
                        <th>{{__("add-project.updated")}}</th>
                        @if (Auth::user()->isAdmin())
                            <th>{{__("add-project.visible")}}</th>
                        @endif
                        <th class="align-center"><i class="material-icons">create</i></th>
                        @if(Auth::user()->canDelete()) <th class="align-center"><i class="material-icons">delete</i></th> @endif
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade " id="modalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="frmProject" method="post" action={{route("add-project/store")}}>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <b>{{trans('project.project_name')}}</b>
                            <div class="form-line">
                                <input type="text" class="form-control" name="project_name" id="project_name">
                            </div>
                        </div>
                            <div class="row clearfix">
                                {{-- Col --}}
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <label>{{trans('general.sector')}}</label>
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="sectors[]" id="sectors" multiple title="-- {{trans('general.choose-option-multiple')}} --">
                                                @foreach($sectors as $sector)
                                                    <option value="{{$sector->id}}"> {{$sector->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <label>{{trans('general.region')}}</label>
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" id="regions" name="regions[]" multiple title="-- {{trans('general.choose-option-multiple')}} --">
                                                @foreach($regions as $region)
                                                    <option value="{{$region->id}}"> {{$region->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>{{trans('project/project-information.project_value_usd')}}</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="project_value_usd" name="project_value_usd">
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
                                        <label>{{trans('general.phase')}}</label>
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="stage" name="stage" title="-- {{trans('general.choose-option')}} --">
                                                @foreach($stages as $stage)
                                                    <option value="{{$stage->id}}">{{$stage->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form-float">
                                        <label id="sponsor_label">
                                                {{trans('general.contracting_authority')}}
                                        </label>
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" id="sponsor" name="sponsor" title="-- {{trans('general.choose-option')}} --">
                                                @foreach($sponsors as $sponsor)
                                                    <option value="{{$sponsor->id}}"> {{$sponsor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{trans('project/project-information.project_value_second',['currency'=>$currency])}}</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="project_value_second" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="submit-type">
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-link waves-effect" id="">{{trans('user.save')}}</button> --}}
                            <button type="submit" class="btn btn-link waves-effect" id="btnAddNewProject">{{trans('general.save')}}</button>
                        </div>

                    </form>
                </div>{{-- Body --}}
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>

    <script>

    @if (Auth::user()->isAdmin() || Auth::user()->hasRole('role_data_entry_project_coordinator'))
        /*
        *   Open a delete modal
        */
        $(document).on('click', '.delete-button', function(){
            //Get the project id
            var id = this.id;
                swal({
                    title: "Delete a project",
                    text: "Are you sure you want to delete the project with id: "+id+"?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    $.ajax({
                        type: "POST",
                        url: "{{route("add-project/delete")}}",
                        data: {id: id},
                        success: function( data ) {
                            swal({
                                title: "Success!",
                                text: data.msg,
                                type: "success",
                                html: true
                            });
                            projectTable.draw();
                        },
                        error: function () {
                            swal({
                                title: "Oops!",
                                text: "There was an error deleting the project, please try again later",
                                type: "error",
                                html: true
                            });
                        }

                    });
                });

        });

        // Active button
        $(document).on('click', '.btnActive', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var project = projectTable.row($(this).closest('[role="row"]')).data();

            var confirm_message = '';
            if (project.active) {
                confirm_message = "{{trans('add-project.confirm_hide')}}";
            } else {
                confirm_message = "{{trans('add-project.confirm_visible')}}";
            }

            swal({
                title: "{{trans('add-project.visibility')}}",
                type: "warning",
                text: confirm_message,
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(){
                $.ajax({
                    url: '{{ route('project.active') }}',
                    type: 'POST',
                    data: { id: project.id },
                    dataType: "json",
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    success: function(data){
                        swal({
                            title: '{{trans('add-project.action_completed')}}',
                            type: "success",
                            html: true
                        });

                        projectTable.ajax.reload();
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
    @endif

        /*
         * Initialize the jQuery data-table.
         * Besides the data table plugin of jQuery, a php plugin is used to manage the server-side table.
         */

        /**
         *  Initialize the sectors array to send via AJAX to the controller
         */
        var sectors_array;

        $("input[name='sectors[]']").change(function () {
            sectors_array=[];

            $.each($("input[name='sectors[]']:checked"), function() {
                sectors_array.push($(this).val());

            });
            projectTable.draw();

        });

        /**
         *  Initialize the regions array to send via AJAX to the controller
         */
        var regions_array;

        $("input[name='regions[]']").change(function () {
            regions_array=[];
            $.each($("input[name='regions[]']:checked"), function() {
                regions_array.push($(this).val());

            });
            projectTable.draw();

        });

        /**
         *  Initialize the stages array to send via AJAX to the controller
         */
        var stages_array;

        $("input[name='stages[]']").change(function () {
            stages_array=[];
            $.each($("input[name='stages[]']:checked"), function() {
                stages_array.push($(this).val());

            });
            projectTable.draw();

        });

        // jQuery.fn.dataTableExt.aTypes.unshift(
        //     function ( sData )
        //     {
        //         if ( sData.match(/ocds-[0-9a-z]+-[0-9]+/g,'') !== null) {
        //             return 'ocds';
        //         }
        //         return null;
        //     }
        // );
        // jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        //     "ocds-pre": function ( a ) {
        //         a = a.replace( /ocds-[0-9a-z]+-/g, "" );
        //         console.log(parseFloat( a ));
        //         return parseFloat( a );
        //     },
         
        //     "ocds-asc": function ( a, b ) {
        //         console.log(a - b);
        //         return a - b;
        //     },
         
        //     "ocds-desc": function ( a, b ) {
        //         console.log(a - b);
        //         return b - a;
        //     }
        // } );


        var projectTable = $('#projects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('add-projects.tableProjects') !!}',
                data: function(d){
                    d.sectors_array = sectors_array;
                    d.stages_array = stages_array;
                    d.regions_array = regions_array;
                },
                method : 'POST'
            },
            columns: [
                // {
                //     data: 'id',
                //     name: 'projects.id',
                //     visible: false
                // },
                //{ data: 'project_information.ocid', name: 'projectInformation.ocid' },
                { data: 'project_information.id', name: 'projectInformation.id' },
                {
                    data: 'name',
                    name: 'projects.name',
                },
                { data: 'sectors', name: 'projectInformation.sectors.name'},
                { data: 'regions', name: 'projectInformation.regions.name'},
                { data: 'stage', name: 'projectInformation.stage.name'},
                { data: 'sponsor', name: 'projectInformation.sponsor.name'},
                {
                    data: null,
                    name: 'projectInformation.project_value_usd',
                    searchable: false,
                    render: function (data) {
                        var text = "";
                        if(data.project_value_second){
                            text += data.project_value_second + ' {{$currency}}' + ' - '
                        }
                        if(data.project_value_usd){
                            text += data.project_value_usd + '  US$';
                        }

                        return text;

                    }
                },
                {
                    data: 'project_value_second',
                    name: 'projectInformation.project_value_second',
                    visible: false,
                    searchable: false,

                },
                { data: 'updated_at', name: 'projects.updated_at'},
                @if (Auth::user()->isAdmin())
                    {
                        data: null,
                        name: 'projects.active',
                        render: function (data) {
                            var checked = '';
                            if (data.active) {
                                checked = 'checked';
                            }
                            return '<div class="switch inline-block"><label><input class="btnActive" type="checkbox" '+checked+'><span class="lever"></span></label> </div>';
                        }
                    },
                @endif
                {
                    name: 'projects.project_url',
                    data: null,
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        if (data.project_url == false) {
                            var actions = '<button disabled class="btn btn-default btn-circle waves-effect waves-circle waves-float">\
                                    <i class="material-icons">create</i>\
                                </button>';
                        } else {
                            var actions = '<a href="'+data.project_url+'" class="btn btn-default btn-circle waves-effect waves-circle waves-float">\
                                    <i class="material-icons">create</i>\
                                </a>';
                        }

                        return actions;
                    }
                },
                @if(Auth::user()->canDelete())
                    {
                        name: 'delete',
                        data: 'id',
                        sortable: false,
                        searchable: false,
                        render: function (data) {
                            var actions = '<button type="button" id='+data+' class="btn btn-default btn-circle waves-effect waves-circle waves-float delete-button">\
                                      <i class="material-icons">delete</i>\
                                  </button>'
                            return actions;
                        }
                    }
                @endif
            ]
        });

        $("#add-project-button").click(function () {

            $("#modalAdd").modal('show');

        });

        $("#btnAddNewProject").closest('form').validate({
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
                'type':{
                    required: true,
                },
                'project_value_second':{
                    number: true,
                    required: true,
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        }); //Validation end


        @if (session('project'))
            swal({
                title: "Success!",
                text: "{{trans('add-project.success-message')}}",
                type: "success",
                html: true
            }, function(){
            });
        @endif
        
    </script>

@endsection
