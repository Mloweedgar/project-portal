@extends('layouts.front')

@section('styles')
    <style type="text/css">
        .navbar {box-shadow: 0 4px 13px #ccc;}
    </style>

@endsection

@section('content')
    {{ csrf_field() }}
    <div class="background-projectinfo">
        <div class="main-content container">
            <div class="top-margin bottom-margin"><!-- project-table -->
                <h2 id="title">Projects by {{$type}}</h2>
                <div class="table-responsive">
                    <table id="projects-table" cellspacing="0" class="responsive">
                        <thead>
                        <tr>
                            <th class="all">{{__("project.project_name")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>{{__("add-project.sector")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th>{{__("general.region")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th class="adjust-text">{{__("add-project.stage")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th class="adjust-text">{{__("general.contracting_authority")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th class="adjust-text not-tablet-l">{{__("add-project.value")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th class="adjust-text not-tablet-l">{{__("add-project.value")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                            <th class="adjust-text not-tablet-l">{{__("add-project.updated")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- /project-table -->
        </div> <!-- /main-content -->
    </div>

@endsection

@section('scripts')

    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/buttons.html5.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        /*
         * Filter variables
         */


        /**
         *  Initialize general variables
         */
        var environment = "{{$environment}}";
        var searchObject = {!! $search !!};
        var sectors_array, regions_array, stages_array;

        /* Load the filter using variables from the back*/
        function loadFilter(){
            if(environment == 'region'){
                regions_array = [];
                regions_array.push(searchObject.id);
            }else if(environment == 'stage'){
                stages_array = [];
                stages_array.push(searchObject.id);

            }else if(environment == 'sector'){
                sectors_array = [];
                sectors_array.push(searchObject.id);
            }
            projectTable.draw();
        }


        var _token = $('input[name="_token"]').val();

        var title = "{{env("APP_TITLE")}} - "+ $("#title").html();

        var projectTable = $('#projects-table').DataTable({
            pageLength: 10,
            dom: 'Blfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ 'Display 10', 'Display 25', 'Display 50', 'Display All' ]
            ],
            buttons: [
                {
                    extend: 'copy',
                    title: title
                },
                {
                    extend: 'csv',
                    title: title
                },
                {
                    extend: 'excel',
                    title: title
                },
                {
                    extend: 'pdf',
                    title: title
                }
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            },
            language: {
                processing: function () {
                    return "<img alt='Loading ...' src='/img/ajax-loader.gif'>";
                },
                zeroRecords: "No matching projects found.",
                lengthMenu: "_MENU_"
            },
            // processing: "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span>",
            columnDefs: [
                {
                    className: "text-center", "targets": 5 ,
                },
                {
                    "targets": 6,
                    "visible": false
                }

            ],
            searching: false,
            bLengthChange: true,
            bInfo: false,
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('front.tableProjects') !!}',
                data: function(d){
                    d._token = _token;
                    d.sectors_array = sectors_array;
                    d.stages_array = stages_array;
                    d.regions_array = regions_array;
                },
                method : 'POST'
            },
            columns: [
                { data: 'name', name: 'projects.name' },
                { data: 'sectors', name: 'projectInformation.sectors.name' },
                { data: 'regions', name: 'projectInformation.regions.name'},
                { data: 'stage', name: 'projectInformation.stage.name'},
                {
                    data: 'sponsor', name: 'projectInformation.sponsor.name',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: null,
                    name: 'projectInformation.project_value_usd',
                    searchable: false,
                    render: function (data) {
                        var text ="";
                        if(data.project_value_second != ""){
                            text += data.project_value_second+ ' {{$currency}}' + '<br class="visible-md-block visible-lg-block"><span class="visible-sm-inline visible-xs-inline"> - </span>';
                        }
                        if(data.project_value_usd != 0){
                            text += data.project_value_usd + '  US$';
                        }
                        if(data.project_value_second == 0 && data.project_value_usd == 0){
                            text += 'Not available';
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
                { data: 'updated_at', name: 'updated_at'},
            ],
            fnDrawCallback: function(oSettings) {
                if ($('#projects-table').DataTable().data().count() == 0) {
                    $('#projects-table_paginate').hide();
                } else {
                    $('#projects-table_paginate').show();
                }
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                $(nRow).click(function(){
                    nRow.setAttribute("id",aData.id)
                    document.location.href = "/project/" + aData.id + "/" + aData.slug;;
                });
            }
        });
        loadFilter();
    </script>
@endsection