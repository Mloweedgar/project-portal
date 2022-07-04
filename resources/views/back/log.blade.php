@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("menu.activity_log") }}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#activity_log' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
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
            <h2 class="content-second-title">{{__('log.log_filter')}}</h2>
            <p class="log_information"><i class="material-icons">help</i> {{__('log.log_help')}}</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('log.display')}}</label>
                        <select class="selectpicker form-control" id="lines-display">
                            <option value="100">{{__('log.100_lines')}}</option>
                            <option value="0">{{__('log.all_lines')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('log.users')}}</label>
                        <select class="form-control show-tick selectpicker" id="user-picker" name="user_id" data-live-search="true" title="{{__('log.select_users')}}"></select>

                    </div>

                </div>
            </div>
            <button type="button" id="filters-activate" class="btn btn-primary waves-effect">{{__('log.filter')}}</button>
            <button type="button" id="filters-reset" class="btn btn-default waves-effect">{{__('log.reset')}}</button>
            <hr/>

            <h2 class="content-second-title">{{__('log.table_title')}}</h2>
            <div class="table-responsive">
                <table class="table table-bordered" id="logTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>{{__('log.time')}}</th>
                        <th>{{__('log.user')}}</th>
                        <th>{{__('log.action')}}</th>
                        <th>{{__('log.section_type')}}</th>
                        <th>{{__('log.properties')}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>
    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/buttons.html5.min.js')}}" type="text/javascript"></script>

    <script>

        var lines_select = $("#lines-display");
        var users_select = $("#user-picker");
        var lines = null;
        var users = null;

        $("#filters-reset").click(function () {
            lines_select.val("100").selectpicker('refresh');
            users_select.val("").selectpicker('refresh');
            lines = null;
            users = null;
            logsTable.draw();

        });

        var title = "{{env("APP_TITLE")}} - Log";

        var logsTable = $('#logTable').DataTable({
            order: [[ 0, "desc" ]],
            bSort : false,
            paging:false,
            searching: false,
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    title: title,

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
            ajax: {
                url : '{!! route('activity_log_table') !!}',
                method : 'POST',
                data: function ( d ) {
                    d.lines = lines;
                    d.users = users;
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'email', name: 'email' },
                { data: 'description', name: 'description' },
                { data: 'subject_type', name: 'subject_type' },
                { data: 'properties', name: 'properties',
                    "render": function(data, type, row){
                        return data.split("\n").join("\n<br/>");
                    }
                },
            ],
            });

        $("#filters-activate").click(function () {
            lines = lines_select.val();
            users = users_select.val();
            logsTable.draw();
        });


        $(document).ready(function() {

            $("#user-picker").ajaxSelectPicker({
                ajax: {
                    url: '{{ route('admin-find-users-by-like') }}',
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
                                text: users[i].name + ' (' + users[i].email + ')',
                                value: users[i].id
                            }));
                        }
                    }

                    return arr;
                }
            });

        });



    </script>

@endsection