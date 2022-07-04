@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">

    <link href="{{ asset('back/plugins/datatable/dataTables.bootstrap.css') }}" rel="stylesheet">

@endsection

@section('content')
    <h1 class="content-title">{{__("menu.global-announcements")}}</h1>

    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#general_announcements' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
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
            <div class="row">
                <div class="col-md-4">
                    <label>{{__("global-announcements.add-new")}}</label>
                    <div class="form-group">
                        <a href="{{route("admin.global-announcements-new")}}" class="btn btn-primary waves-effect">{{trans('global-announcements.add-new-button')}}</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="announcements-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{__("global-announcements.name")}}</th>
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
            //Get the announcement id
            var id = this.id;
            swal({
                    title: "{{__("global-announcements.delete-title")}}",
                    text: "{{__("global-announcements.delete-body")}}",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    $.ajax({
                        type: "DELETE",
                        url: "{{route("admin.global-announcements-delete")}}",
                        data: {id: id},
                        success: function( data ) {
                            console.log(data);
                            swal({
                                title: "Success!",
                                text: data.message,
                                type: "success",
                                html: true
                            });
                            announcementsTable.draw();
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

        var announcementsTable = $('#announcements-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('admin.global-announcements.tableAnnouncements') !!}',
                method : 'POST'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'updated_at', name: 'updated_at'},
                {
                    name: 'edit',
                    data: 'id',
                    sortable: false,
                    searchable: false,
                    render: function (data) {
                        var actions = '<a href="/website-management/global-announcements/edit/'+data+'" class="btn btn-default btn-circle waves-effect waves-circle waves-float centered-div">\
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
                        var actions = '<button type="button" id='+data+' class="btn btn-default btn-circle waves-effect waves-circle waves-float delete-button centered-div">\
                                  <i class="material-icons">delete</i>\
                              </button>'
                        return actions;
                    }
                }
            ]
        });





            @if (session('status')==true)
                swal({
                title: "{{trans('messages.success')}}",
                text: "{{session("message")}}",
                type: "success",
                html: true
            }, function(){});
            @elseif (session(['error']))
                swal({
                title: "{{trans('messages.error')}}",
                text: "{{session('error')}}",
                type: "error",
                html: true
            }, function(){});
            @endif


    </script>

@endsection
