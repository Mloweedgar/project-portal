@extends('layouts.app')


@section('content')


    <div class="mdl-grid themes">

        <div class="mdl-cell mdl-cell--12-col">
            <a href="/themes/new">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                    {{ __('themes.new_theme') }}
                </button>
            </a>
        </div>

        @foreach ($themes as $theme)



            <div class="mdl-cell mdl-cell--4-col ">
                <div class="demo-card-image mdl-card mdl-shadow--2dp" style="background-color: {{ $theme->schema()->where('name', 'primary_color' )->get()->first()->css_rule }};">
                    <div class="mdl-card__title mdl-card--expand text-center" style="color: {{  $theme->schema()->where('name', 'secondary_color' )->get()->first()->css_rule }}">
                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                    </div>
                    <div class="mdl-card__actions text-center">
                        <span class="demo-card-image__filename" >{{ $theme->name }} - {{ $theme->created_at->formatLocalized('%A %d %B %Y') }}</span>
                    </div>
                </div>
                    <div>
                            @if(!$theme->active)
                                <a href="/themes/{{ $theme->id }}/active">
                                   <button class="mdl-button mdl-js-button mdl-button--raised  mdl-js-ripple-effect">
                                        {{ __('themes.active') }}
                                    </button>
                                </a>
                            @endif
                                @if($theme->custom)
                                    <a href="/themes/{{ $theme->id }}/edit">
                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                          {{ __('themes.edit') }}
                                        </button>
                                    </a>
                                    <a href="/themes/{{ $theme->id }}/delete">
                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                            {{ __('themes.delete') }}
                                        </button>
                                    </a>
                                @endif

                        </p>
                    </div>
                </div>


        @endforeach
    </div>
@endsection