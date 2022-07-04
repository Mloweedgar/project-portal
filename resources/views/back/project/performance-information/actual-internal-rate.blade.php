@extends('layouts.back')

@section('styles')

    <link href="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.css') }}" rel="stylesheet">

@endsection

@section('content')
    <h1 class="content-title">{{__("menu.projects")}}</h1>
    <h1 class="content-title">{{$project->name}}</h1>

    @component('components.project-menu')
    @endcomponent

    <div class="row content-row">
        <div class="col-md-12">
            <h2 class="page-subtitle">{{__("project.section.performance_information.internal_rate_of_return")}}</h2>
            <form method="post" action={{route("actual-internal-rate-return.store")}}>
                {{ csrf_field() }}

                <div class="form-group">
                    <div class="form-line">
                        <input type="hidden" value={{$project->id}} name="project_id">
                        <input type="number" step="0.01" name="rate-return" @if(isset($internal)) value="{{$internal->value}}" @endif @if (!$write) readonly @endif class="form-control" placeholder="{{__("project.rate_of_return")}}">
                    </div>
                </div>

                @if ($write)
                    <button type="submit" class="btn btn-large btn-primary waves-effect">{{__("general.save_draft")}}</button>
                @endif


                @if(isset($internal))

                    <button type="button" id="request-modification-button" class="btn btn-large btn-primary waves-effect">{{__("general.request_modification")}}</button>

                @endif

                @if(Auth::user()->role()->first()->name == "role_admin" || Auth::user()->role()->first()->name == "role_validator" )

                    @if (!$internal->published)
                        <button type="button" id="publish-button" class="btn btn-large btn-primary waves-effect">{{__("general.publish")}}</button>
                    @else
                        <button type="button" class="btn btn-large btn-success waves-effect" disabled="disabled"><i class="material-icons font-14">check</i> {{__("general.published")}}</button>
                    @endif
                @endif

            </form>
        </div>

        @component('components.request-modification-modal')
        @endcomponent


    </div>
@endsection

@section('scripts')
    <!--<script src="{{ asset('back/plugins/bootstrap-table/bootstrap-table.js') }}"></script>-->

    <script defer src="{{ asset('back/plugins/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('back/plugins/ajax-bootstrap-select/ajax-bootstrap-select.js') }}"></script>

    <script>

        var id = {!! $internal->id !!}

        $("#publish-button").click(function () {
            swal({
                    title: "Publish actual rate of return",
                    text: "Are you sure you want to publish this actual rate of return?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    $.ajax({
                        type: "POST",
                        url: "{{route("actual-internal-rate-return.publish")}}",
                        data: {id: id},
                        success: function() {
                            swal({
                                title: "Success!",
                                text: "The actual internal rate of return has been successfully published",
                                type: "success",
                                html: true
                            });
                        },
                        error: function () {
                            swal({
                                title: "Oops!",
                                text: "There was an error publishing the actual internal rate of return, please try again later",
                                type: "error",
                                html: true
                            });
                        }

                    });
                });
        });

        @if (session('new')==true)

            @if (session('internal'))

            swal({
            title: "Success!",
            text: "The actual internal rate of return has been successfully created",
            type: "success",
            html: true
        });

        @endif


    @else

        @if (session('internal'))

swal({
            title: "Success!",
            text: "The actual internal rate of return has been successfully modified",
            type: "success",
            html: true
        });

        @endif

        @endif


    </script>

@endsection