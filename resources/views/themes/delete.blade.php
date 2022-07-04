@extends('layouts.app')


@section('content')

    @if(count($errors))
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    @if($theme->custom)

        <div class="mdl-cell mdl-cell--8-col">
            @if($theme->preview_img)
                <img class="img-responsive" src="{{ asset('/img/themes/'.$theme->preview_img) }}">
            @endif
            <div>
                <p>{{ __('themes.name') }}: {{ $theme->name }}</p>
                <p>{{ __('themes.date_creation') }}: {{ $theme->created_at->formatLocalized('%A %d %B %Y') }}</p>
                <a href="/themes/{{ $theme->id }}/destroy">
                    <button class="mdl-button mdl-js-button mdl-button--raised  mdl-js-ripple-effect">
                      {{ __('themes.confirm_delete') }}</i>
                    </button>
                </a>
            </div>
        </div>
    @else

        <div class="col-md-12 alert alert-danger">
            <p>{{__('messages.themes.cant.delete.default')}}</p>
        </div>
    @endif
@endsection
