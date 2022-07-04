@extends('layouts.app')


@section('content')

    @if(count($errors))
    <div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </div>
    @endif


    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--12-col"><h2>Create Theme</h2></div>

        <form method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" name="name" type="text" id="name">
                <label class="mdl-textfield__label" for="name">{{ __("themes.name") }}</label>
            </div>



            @if($theme_schema_fields)
                @foreach ($theme_schema_fields as $schema)
                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" name="{{ $schema->name }}" type="text" id="{{ $schema->name }}">
                        <label class="mdl-textfield__label" for="{{ $schema->name }}">{{ __("themes.".$schema->name) }}</label>
                    </div>
                @endforeach
            @endif
            <div>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection


