@extends('layouts.front')

@section('styles')
    <style type="text/css">
        .navbar {box-shadow: 0 4px 13px #ccc;}
    </style>

@endsection

@section('content')

    <div class="container content-announcements-page">
        <div class="section-title container-wrapper text-center">
            <h2 id="projectstable">{{ $announcement->name }}</h2>
            <span></span>
        </div>
        <div class="panel panel-cus">
            <div class="panel-body panel-body-cus">
                {!! $announcement->description !!}
                <div class="documents-block">
                    @foreach($media as $file)
                        <a href="{{route('application.media',["id"=>$file->id])}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect project-button" target="_blank"><i class="material-icons">file_download</i>{{trans('general.download_document')}}</a>
                    @endforeach
                </div>
            </div>
            <div class="panel-footer panel-footer-cus"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$announcement->created_at)->toDayDateTimeString() }}</div>
        </div>

    </div>

@endsection

@section('scripts')
@endsection
