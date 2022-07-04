@extends('layouts.app')


@section('content')
    <div class="mdl-grid">

        <form action="/langs/store"  method="POST">
            {{ csrf_field() }}

            <div class="mdl-cell mdl-cell--8-col">

            <select id="lang" name="lang">
            @foreach($langs as $l)
                <option value="{{ $l->id }}">{{ $l->iso }} - {{ $l->name }}</option>
            @endforeach
            </select>
                <label for="lang">{{ __('langs.select_language') }}</label>
            </div>


            @foreach($default_lang as $df)

                <?php $file = $df->file ?>

                    <div>

                        <h3>{{ $file }}</h3>

                        @foreach(json_decode($df->value, true) as $field=>$value)

                            @if( is_array($value) && !empty($value))

                                <?php $values=$value ?>
                                @include('langs.partials.form', [$values, $file])
                            @else
                                <div class="form-line">

                                    <label for="{{ $file }}-{{ $field  }}">{{ $file.".".$field }}</label> =>
                                    <input  class="input-field" type="text" name="{{ $file }}-{{ $field }}" id="{{ $file }}.{{ $field }}" placeholder="{{ __($file.".".$field) }}" >

                                </div>


                            @endif
                        @endforeach

                    </div>
                    <div>



                </div>

            @endforeach


            <button type="submit" class="waves-effect waves-light btn">
                {{ __('messages.save') }}
            </button>

        </form>
    </div>
@endsection