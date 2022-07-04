<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link href="{{ asset('back/css/libs.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('back/css/all-themes.css') }}" rel="stylesheet"> --}}
    @yield('styles')
    <link href="{{ asset('back/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body class="error-page">

<section>
    <div class="top">
        <div class="text-top">
            <div><img src="{{route('application.logo')}}"></div>
            <h1>{{__("errors.error_404")}}</h1>
        </div>
    </div>
    <div class="bottom">
        <div class="text-bottom">
            <h2>{{__("errors.page_not_found")}}</h2>

            <p>{{__("errors.error_info")}}</p>

            <button type="button" onclick="goBack()" class="error-btn type btn btn-large btn-primary waves-effect"><a href="{{ url()->previous() }}">{{__("errors.return")}}</a></button>
        </div>


    </div>
</section>

<script src="{{ asset('back/js/libs.js') }}"></script>
<script src="{{ asset('back/js/custom.js') }}"></script>

<script>
function goBack() {
    window.history.back();
}
</script>
</body>

</html>