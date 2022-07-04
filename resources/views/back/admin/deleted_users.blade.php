@extends('layouts.back')

@section('styles')
    <!--<link href="{{ asset('back/plugins/bootstrap-table/bootstrap-table.css') }}" rel="stylesheet">-->

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h1 class="content-title">{{__("menu.deleted_users")}}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#deleted_users' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
        </div>
    @endif
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
                <table class="table table-bordered" id="deletedUsersTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{__("user.email")}}</th>
                        <th>{{__("general.description")}}</th>
                        <th>{{__("user.deleted_date")}}</th>
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
    <script src="{{ asset('back//plugins/datatable/dataTables.bootstrap.js') }}"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.responsive.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/buttons.html5.min.js')}}" type="text/javascript"></script>

    <script>

        var title = "{{env("APP_TITLE")}} - {{__('menu.deleted_users')}}";

        var projectTable = $('#deletedUsersTable').DataTable({
            lengthMenu: [
                [10,25, 50, 100, -1],
                [10,25, 50, 100, "All"]
            ],
            "dom": "B<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-md-6'><'col-md-6'>>" +
            "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
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
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('users.deleted.table') !!}',
                method : 'POST'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'email', name: 'email' },
                { data: 'description', name: 'description' },
                { data: 'created_at', name: 'created_at' },

            ]
        });




    </script>

@endsection
