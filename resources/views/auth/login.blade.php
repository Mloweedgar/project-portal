@extends('layouts.auth')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}


    <link href="{{ asset('back/css/libs.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('content')

    <body class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <form  method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="E-mail" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 p-t-5">
                            <input type="checkbox" name="remember" id="remember" class="filled-in chk-col-light-blue" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember Me</label>
                        </div>
                        <div class="col-xs-5">
                            <button class="btn btn-block btn-primary waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                        <div class="m-t-15 m-b-15 align-right">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

    @section('scripts')
        <script src="{{ asset('back/js/libs.js') }}"></script>
        <script src="{{ asset('back/js/custom.js') }}"></script>
        <script src="{{ asset('back/plugins/sweetalert/sweetalert.min.js') }}"></script>
        @if ($errors->has('email'))
            <script>
                swal({
                    title: "Oops!",
                    text: "{{ $errors->first('email') }}",
                    type: "error",
                    html: true
                });
            </script>
        @endif
        @if ($errors->has('password'))
            <script>
                swal({
                    title: "{{ __('messages.error_oops') }}",
                    text: "{{ $errors->first('password') }}",
                    type: "error",
                    html: true
                });
            </script>
        @endif
        @if ($errors->first() == "Your session expired. Please login to continue.")
            <script>
                swal({
                    title: "{{ __('messages.error_oops') }}",
                    text: "{{ $errors->first() }}",
                    type: "error",
                    html: true
                });
            </script>
        @endif




@endsection
