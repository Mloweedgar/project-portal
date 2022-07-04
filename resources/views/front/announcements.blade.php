@extends('layouts.front')

@section('styles')
    <style type="text/css">
        .navbar {box-shadow: 0 4px 13px #ccc;}
    </style>

@endsection

@section('content')

    <div class="container content-announcements-page">
        <div class="row">
            @if (count($global_announcements)<1 && !$announcements_active)
                <div class="alert-ppp" role="alert">
                    {{__('global-announcements.no-announcements')}}
                </div>
            @endif
            @if (count($global_announcements)>0)
                <div class="@if ($announcements_active) col-lg-6 col-md-6  @else col-lg-12 col-md-12 @endif">
                    <div class="section-title container-wrapper text-center">
                        <h2 id="projectstable">{{__('menu.global-announcements')}}</h2>
                        <span></span>
                    </div>
                    <div class="announcement-container">
                        @if (count($global_announcements)<1)
                            <p class="text-center">{{__('global-announcements.no-announcements')}}</p>
                        @else

                            <ul>
                                @foreach ($global_announcements as $k => $announcement)
                                    <li>
                                        <a href="{{route('frontend.announcement-single',['slug'=>$announcement->slug])}}">
                                            <div class="announcement-date">
                                                <div class="announcement-date-container">
                                                    {{Carbon\Carbon::parse($announcement->created_at)->day}}
                                                    <span>{{date("F", mktime(0, 0, 0, Carbon\Carbon::parse($announcement->created_at)->month, 1))}}</span>
                                                </div>
                                            </div>
                                            <div class="announcement-content">
                                                <h3>{{ str_limit($announcement->name, 40) }}</h3>
                                                <p>{{ str_limit(strip_tags($announcement->description), 60, "...") }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            {{$global_announcements->appends(['project' => $global_announcements->currentPage()])->links()}}
                        @endif
                    </div>
                </div>
            @endif
            @if ($announcements_active)
                <div class="@if (count($global_announcements)<1) col-lg-12 col-md-12 @else col-lg-6 col-md-6 @endif">
                    <div class="section-title container-wrapper text-center">
                        <h2 id="projectstable">{{__('global-announcements.project-announcements')}}</h2>
                        <span></span>
                    </div>
                    <div class="announcement-container">
                        @if (count($announcements)<1)
                            <p class="text-center">{{__('global-announcements.no-announcements')}}</p>
                        @else
                            <ul>
                            @foreach ($announcements as $k => $announcement)
                                <li>
                                    <a href="{{route('front.project', ['id' => $announcement->project_id, str_slug($announcement->projectname)])}}#announcements-section">
                                        <div class="announcement-date">
                                            <div class="announcement-date-container">
                                                {{Carbon\Carbon::parse($announcement->created_at)->day}}
                                                <span>{{date("F", mktime(0, 0, 0, Carbon\Carbon::parse($announcement->created_at)->month, 1))}}</span>
                                                <p>{{Carbon\Carbon::parse($announcement->created_at)->year}}</p>
                                            </div>
                                        </div>
                                        <div class="announcement-content">
                                            <h3>{{ str_limit($announcement->projectname, 40) }}</h3>
                                            <p>{{ str_limit($announcement->name, 60, "...") }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                            {{$announcements->appends(['global' => $global_announcements->currentPage()])->links()}}
                        @endif

                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
@endsection
