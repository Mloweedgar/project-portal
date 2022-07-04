@extends('layouts.app')


@section('content')


    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--12-col"><h2>Edit Theme</h2></div>
        @if($theme->custom)

        <form method="POST">
            {{ csrf_field() }}

            @foreach ($theme->schema as $schema)
                <div class="mdl-textfield mdl-js-textfield">
                    <input class="mdl-textfield__input" name="{{ $schema->id }}" type="text" id="{{ $schema->name }}" value="{{ $schema->css_rule }}">
                    <label class="mdl-textfield__label" for="{{ $schema->name }}">{{ __("messages.themes.edit.".$schema->name) }}</label>
                </div>


            @endforeach
            <div>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                    {{ 'messages_save' }}
                </button>
            </div>
        </form>
            @else

            <div class="col-md-12 alert alert-danger">
                <p>{{__('themes.cant_edit_default')}}</p>
            </div>
            @endif
    </div>
@endsection