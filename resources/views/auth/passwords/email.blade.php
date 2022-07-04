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
        <div class="logo">
            <a href="javascript:void(0);"><img src="{{route("application.logo")}}"></a>
        </div>
        <div class="card">
            <div class="body">
                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg btn-primary waves-effect" type="submit">RESET MY PASSWORD</button>

                    <div class="row m-t-20 m-b--5 align-center">
                        <a href="/login">Sign In!</a>
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
        @if (session('status'))
            <script>
                swal({
                    title: "Success!",
                    text: "{{ session('status') }}",
                    type: "success",
                    html: true
                });
            </script>
        @endif

    @endsection
