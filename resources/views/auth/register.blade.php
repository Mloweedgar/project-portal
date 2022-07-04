@extends('layouts.auth')

@section('styles')
    <link href="{{ asset('css/login-form.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="login-form">
<div class="container">

    <div class="card">
      <!--  <div class="toggle"></div> -->
        <h1 class="title">Register
            <div class="close"></div>
        </h1>
        <form  method="POST" action="/registerUser">
            {{ csrf_field() }}


            <div class="input-container {{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" id="name" name="name" required autofocus  value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <a tabindex="0" class="fa fa-times-circle error-popover" role="button" data-placement="right" data-toggle="popover" title="Error"
                       data-content="{{ $errors->first('name') }}"></a>

                @endif
                <label for="name">Name</label>
                <div class="bar"></div>

            </div>

            <div class="input-container {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" id="email" name="email" required  value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <a tabindex="0" class="fa fa-times-circle error-popover" role="button" data-placement="right" data-toggle="popover" title="Error"
                       data-content="{{ $errors->first('email') }}"></a>

                @endif
                <label for="email">E-Mail Address</label>
                <div class="bar"></div>

            </div>



            <div class="input-container {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" id="password" name="password" required  >
                @if ($errors->has('password'))
                    <a tabindex="0" class="fa fa-times-circle error-popover" role="button" data-placement="right" data-toggle="popover" title="Error"
                       data-content="{{ $errors->first('password') }}"></a>

                @endif
                <label for="password">Password</label>
                <div class="bar"></div>

            </div>
            <div class="input-container">
                <input type="password" id="password-confirm" name="password_confirmation" required/>
                <label for="password-confirm">Confirm Password</label>
                <div class="bar"></div>
            </div>
            <div class="button-container">
                <button type="submit"><span>Register</span></button>
            </div>
        </form>
    </div>
</div>
   <!-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/registerUser">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.error-popover').popover({
                container: 'body',
                trigger: 'focus, click'
            })
            $('.error-popover').popover('show');
        })
    </script>
    @endsection