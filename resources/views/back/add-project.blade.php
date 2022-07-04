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
    <div class="row content-row">
        <div class="col-md-12">
            <div class="row">
                <form id="frmProject" method="post" action={{route("add-project/store")}}>
                    {{ csrf_field() }}
                <div class="col-md-4">
                    <label>{{__("add-project.add-new")}}</label>

                    <div class="input-group">

                        <div class="form-line">
                            <input type="text" name="project-name" class="form-control" placeholder="{{__("add-project.add-placeholder")}}">
                        </div>
                        <span class="input-group-addon">
                            <button type="submit" class="btn btn-primary waves-effect">+</button>
                        </span>
                    </div>
                </div>
                </form>
            </div>


            <div class="row">

                <div class="col-md-4 m-b-20">

                    <div class="project-filter-box">
                        <ul>
                        <li>{{__("add-project.stage")}}</li>
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
                        <th></th>
                        <th>{{__("add-project.sector")}}</th>
                        <th>{{__("general.region")}}</th>
                        <th>{{__("add-project.stage")}}</th>
                        <th>{{__("add-project.sponsor")}}</th>
                        <th>{{__("add-project.value")}}</th>
                        <th>{{__("add-project.updated")}}</th>
                        <th class="align-center"><i class="material-icons">create</i></th>
                        <th class="align-center"><i class="material-icons">delete</i></th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('scripts')

    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back/plugins/datatable/dataTables.bootstrap.js') }}"></script>

    <script>

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


        var projectTable = $('#projects-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('add-projects.tableProjects') !!}',
                "data": function(d){
                    d.sectors_array = sectors_array;
                    d.stages_array = stages_array;
                    d.regions_array = regions_array;
                },
                method : 'POST'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'project_name', name: 'project_name' },
                { data: 'sector_name', name: 'sector_name' },
                { data: 'region_name', name: 'region_name'},
                { data: 'stage_name', name: 'stage_name'},
                { data: 'entity_name', name: 'entity_name'},
                { data: 'project_value', name: 'project_value'},
                { data: 'updated_at', name: 'updated_at'},
                {
                    name: 'edit',
                    data: 'id',
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        var actions = '<a href="/project/'+data+'/project-information" class="btn btn-default btn-circle waves-effect waves-circle waves-float">\
                                <i class="material-icons">create</i>\
                            </a>'
                        return actions;
                    }
                },
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
            ]
        });



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
