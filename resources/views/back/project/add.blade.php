@extends('back/layouts/projects')
    @section('form')
        @if (Auth::user()->isAdmin() || Auth::user()->isProjectCoordinator())
            <div class="row">
                <div class="col-md-4">
                    <label>{{__("add-project.add-new")}}</label>
                    <div class="form-group">
                         <button type="button" id="add-project-button" class="btn btn-primary waves-effect">{{trans('add-project.add-project')}}</button>
                         <a href="{{ route('import-project') }}" class="btn btn-primary waves-effect">{{trans('add-project.import_project')}}</a>
                    </div>
                </div>
            </div>
        @endif
    @endsection
