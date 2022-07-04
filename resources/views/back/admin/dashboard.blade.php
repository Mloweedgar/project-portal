@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/morris/morris.css') }}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("dashboard.title") }}</h1>
    @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
        <div class="section-information">
            <a href="{{ route('documentation').'#dashboard' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
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

    <div class="row content-row dashboard-info-boxes">
        <div class="@if (!Auth::user()->isViewOnly()) col-md-3 col-lg-3 @else col-md-6 col-lg-6 @endif col-sm-6 col-xs-12">
            <a href="{{route('add-project')}}" class="no-underline">
                <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="content">
                    <div class="text text-uppercase">{{ trans('general.projects') }}</div>
                    <div class="number count-to" data-from="0" data-to="{{ $count }}" data-speed="1000" data-fresh-interval="20">{{ $count }}</div>
                </div>
            </div>
            </a>
        </div>

        @if (!Auth::user()->isViewOnly())
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <a href="{{route('tasks-management')}}" class="no-underline">
                <div class="info-box bg-blue-grey hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text text-uppercase">{{ trans('dashboard.uncompleted-tasks') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{ count($tasks) }}" data-speed="15" data-fresh-interval="20">{{ count($tasks) }}</div>
                    </div>
                </div>
                </a>
            </div>
        @endif

        <div class="@if (!Auth::user()->isViewOnly()) col-md-3 col-lg-3 @else col-md-6 col-lg-6 @endif col-sm-6 col-xs-12">
            <a href="{{route('edit-users')}}" class="no-underline">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text text-uppercase">{{ trans('dashboard.total-users') }}</div>
                    <div class="number count-to" data-from="0" data-to="{{ $users_total->count }}" data-speed="1000" data-fresh-interval="20">{{ $users_total->count }}</div>
                </div>
            </div>
            </a>
        </div>

        @if (!Auth::user()->isViewOnly())
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <a href="{{route('newsletter')}}" class="no-underline">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">send</i>
                    </div>
                    <div class="content">
                        <div class="text text-uppercase">{{ trans('dashboard.newsletter-users') }}</div>
                        <div class="number count-to" data-from="0" data-to="{{ $newsletter->count }}" data-speed="1000" data-fresh-interval="20">{{ $newsletter->count }}</div>
                    </div>
                </div>
                </a>
            </div>
        @endif
    </div>

    <div class="row content-row row-eq-height">
        <!-- LATEST PROJECTS -->
        <div class="col-xs-12 col-sm-12 @if (!Auth::user()->isViewOnly()) col-md-4 col-lg-4 @else col-md-12 col-lg-12 @endif">
            <div class="card project-box dashboard-box">
                <div class="body bg-green height-100">
                    <div class="m-b--35 font-bold text-uppercase">{{ trans('dashboard.latest-projects') }}
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="{{route('add-project')}}" class=" waves-effect waves-block text-transform-none">{{ trans('dashboard.to-projects') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <ul class="dashboard-stat-list">
                        @foreach($projects as $project)
                        <li>
                            <a href="/project/{{ $project->id }}/project-information">
                                <i class="material-icons">mode_edit</i> {{ $project->name }}
                            </a>
                            <span class="dashboard-updated-at">{{ $project->updated }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        @if (!Auth::user()->isViewOnly())
            <!-- PENDING TASKS -->
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="dashboard-box card bg-blue-grey">

                    <div class="body ">
                        <div class="m-b--35 font-bold text-uppercase">{{ trans('dashboard.pending_tasks') }}
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{route('tasks-management')}}" class=" waves-effect waves-block text-transform-none">{{ trans('dashboard.to-task') }}</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </div>

                        <div class="table-responsive m-t-48">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ trans('task.task_name') }}</th>
                                    <th class="md-hide">{{ trans('task.project_name') }}</th>
                                    <th class="md-hide">{{ trans('task.section') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (count($tasks))
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td><a href="/tasks">{{ $task->name }}</a></td>
                                            <td class="md-hide">{{ $task->project_name }}</td>
                                            <td class="md-hide">{{ $task->section_name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ trans('dashboard.no_pending_tasks') }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/countTo/jquery.countTo.js') }}"></script>
    <script>

        $('.count-to').countTo();

    </script>
@endsection
