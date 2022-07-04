<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link href="{{ asset('back/css/libs.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('back/css/all-themes.css') }}" rel="stylesheet"> --}}
    @yield('styles')
    <link href="{{ asset('back/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('back/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="padding-20">
            <a href="/dashboard">
                <img src="{{route('application.logo')}}" alt="" class="img-responsive img-center back-logo">
            </a>
        </div>
        <div class="menu-separator"></div>
        <!-- User Info -->
        <!--<div class="user-info" style="background: none;">
            <div class="row flex">
                <div class="col-md-4">
                    <div class="user-avatar">
                        <img src="{{ asset('img/user.png') }}">
                    </div>
                </div>
                <div class="col-md-8 p-l-0 self-vertical-center">
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                        <div class="email">{{Auth::user()->email}}</div>
                        <div class="role">{{Auth::user()->role()->first()->alias}}</div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right user-options">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"><i class="material-icons">person</i>{{__("menu.profile")}}</a></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"><i class="material-icons">security</i>{{__("menu.change-password")}}</a></li>
                                <li><a href="{{route('logout')}}" class=" waves-effect waves-block"><i class="material-icons">input</i>{{__("menu.log-out")}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    {{-- <li class="header">NAVIGATION</li> --}}

                    @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())
                        <li class="{{active('dashboard')}}">
                            <a href="{{route('dashboard')}}">
                                <i class="material-icons">home</i>
                                <span>{{ __('menu.dashboard') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->isAdmin() || Auth::user()->isIT())
                        <li class="{{active(['sliders','banners', 'footer', 'graphs'])}}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">web_asset</i>
                                <span>{{ __('menu.website-management') }}</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{{active('banners')}}">
                                    <a href="{{route('banners')}}">{{ __('menu.banners') }}</a>
                                </li>
                                <li class="{{active('sliders')}}">
                                    <a href="{{route('sliders')}}">{{ __('menu.sliders') }}</a>
                                </li>
                                <li class="{{active('graphs')}}">
                                    <a href="{{route('graphs')}}">{{ __('menu.graphs') }}</a>
                                </li>
                                <li class="{{active('footer')}}">
                                    <a href="{{route('footer')}}">{{ __('menu.footer') }}</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (!Auth::user()->isIT() && !Auth::user()->isAuditor())
                        <li class="{{active('add-project')}}">
                            <a href="{{route('add-project')}}">
                                <i class="material-icons">assignment</i>
                                <span>{{ __('menu.projects') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->isAdmin())
                        <li class="{{active(['edit-users', 'roles','roles.roles-permissions', 'users.deleted'])}}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">card_membership</i>
                                <span>{{ __('menu.role-management') }}</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{{active('edit-users')}}">
                                    <a href="{{route('edit-users')}}">{{ __('menu.edit-users') }}</a>
                                </li>
                                <li class="{{active('roles.roles-permissions')}}">
                                    <a href="{{route('roles.roles-permissions')}}">{{ __('menu.roles-permissions') }}</a>
                                </li>
                                <li class="{{active('users.deleted')}}">
                                    <a href="{{route('users.deleted')}}">{{ __('menu.deleted_users') }}</a>
                                </li>
                            </ul>

                        </li>

                        <li class="{{active(['newsletter','admin.global-announcements','admin.global-announcements-new','admin.global-announcements-edit'])}}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">web_asset</i>
                                <span>{{ __('menu.communications-management-menutop') }}</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="{{active(['newsletter'])}}">
                                    <a href="{{route('newsletter')}}">{{ __('menu.communications-management') }}</a>
                                </li>
                                <li class="{{active(['admin.global-announcements','admin.global-announcements-edit','admin.global-announcements-new'])}}">
                                    <a href="{{route('admin.global-announcements')}}">{{ __('menu.global-announcements') }}</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                     @if (Auth::user()->isAdmin() || Auth::user()->isIT())
                        <li class="{{active(['general-settings', 'roles', 'sectionstodisclose.index'])}}">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">settings</i>
                                <span>{{ __('menu.system-configuration') }}</span>
                            </a>
                            <ul class="ml-menu">
                                @if (!Auth::user()->isAuditor())
                                <li class="{{active('general-settings')}}">
                                    <a href="{{route('general-settings')}}">{{ __('menu.general-settings') }}</a>
                                </li>
                                @endif
                                <!--
                                <li class="{{active('select-fields')}}">
                                    <a href="#">{{ __('menu.select-fields') }}</a>
                                </li>-->
                                @if (Auth::user()->isAdmin())
                                    <li class="{{active('sectionstodisclose.index')}}">
                                        <a href="{{route('sectionstodisclose.index')}}">{{ __('menu.fields-disclose') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if (Auth::user()->isAdmin() || Auth::user()->isIT())
                        <li class="{{active('analytics.dashboard')}}">
                            <a href="{{route('analytics.dashboard')}}">
                                <i class="material-icons">timeline</i>
                                <span>{{ __('menu.analytics') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->isAuditor() || Auth::user()->isAdmin())
                        <li class="{{active('activity_log')}}">
                            <a href="{{route('activity_log')}}">
                                <i class="material-icons">cloud</i>
                                <span>{{ __('menu.activity_log') }}</span>
                            </a>
                        </li>
                    @endif


                @if (Auth::user()->canAccessTasks())
                        <li class="{{active('tasks-management')}}">
                            <a href="{{route('tasks-management')}}">
                                <i class="material-icons">event</i>
                                <span>{{ __('menu.tasks-management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->canCreate())
                        <li class="{{active('entities')}}">
                            <a href="{{route('entities')}}">
                                <i class="material-icons">account_balance</i>
                                <span>{{ __('menu.entities') }}</span>
                            </a>
                        </li>
                    @endif

                    <!--
                   @if (Auth::user()->isAdmin())
                        <li class="{{active('langs')}}">
                            <a href="{{route('langs')}}">
                                <i class="material-icons">language</i>
                                <span>{{ __('langs.title') }}</span>
                            </a>
                        </li>
                    @endif
                    -->
                    @if (!Auth::user()->isViewOnly())

                    <li class="{{active('documentation')}}">
                        <a href="{{route('documentation')}}">
                            <i class="material-icons">code</i>
                            <span>{{ __('menu.documentation') }}</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{route('front.home')}}">
                            <i class="material-icons">reply</i>
                            <span>{{ __('menu.homepage') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->

    <!-- #END# Right Sidebar -->
</section>

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
        </div>

        <div id="navbar-collapse">
            {!! Breadcrumbs::render() !!}
            @component('components.back-search')
            @endcomponent
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <!-- #END# Call Search -->
                <!-- Notifications -->
                <!--
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count">7</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>12 new members joined</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 14 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-cyan">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>4 sales made</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 22 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-red">
                                            <i class="material-icons">delete_forever</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy Doe</b> deleted account</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">mode_edit</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy</b> changed name</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 2 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-blue-grey">
                                            <i class="material-icons">comment</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> commented your post</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 4 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">cached</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> updated status</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-purple">
                                            <i class="material-icons">settings</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>Settings updated</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> Yesterday
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Notifications</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Notifications -->
                <!-- Tasks -->
                <!--
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">flag</i>
                        <span class="label-count">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">TASKS</li>
                        <li class="body">
                            <ul class="menu tasks">
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Footer display issue
                                            <small>32%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Make new buttons
                                            <small>45%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Create new dashboard
                                            <small>54%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Solve transition issue
                                            <small>65%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Answer GitHub questions
                                            <small>92%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Tasks</a>
                        </li>
                    </ul>
                </li>
                -->
                <li class="">
                    <div class="user-info" style="background: none;">
                        <div class="info-container">
                            <div class="btn-group user-helper-dropdown">
                                <img src="{{ asset('img/user.svg') }}" data-toggle="dropdown">
                                <ul class="dropdown-menu pull-right user-options">
                                    <li><a><i class="material-icons">person</i>{{__('general.hi')}} {{Auth::user()->name}}</a></li>
                                    <li><a href="{{route('change-password')}}" class=" waves-effect waves-block"><i class="material-icons">security</i>{{__("menu.change-password")}}</a></li>
                                    <li><a href="{{route('logout')}}" class=" waves-effect waves-block"><i class="material-icons">input</i>{{__("menu.log-out")}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <!--<li class="hidden-on-close"><a href="{{route('logout')}}" data-close="true"><i class="material-icons">input</i></a></li>-->
                <!-- #END# Tasks -->
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->

<section class="content">
    <div class="container-master">
        @yield('content')
    </div>
    <!-- #Footer -->
</section>
<script src="{{ asset('back/js/libs.js') }}"></script>
<script src="{{ asset('back/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('back/plugins/ckeditor/styles.js') }}"></script>
<script src="{{ asset('back/js/custom.js') }}"></script>
<script>

    /*
     * General AJAX setup
     * This setup is used for adding in every ajax request the x-csrf token that
     * is required for laravel.
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     * General jQuery validation setup
     * This setup is used for adding the validation messages from the langs files.
     */
    jQuery.extend(jQuery.validator.messages, {
        required: "{{trans('jquery-validation.required')}}",
        remote: "{{trans('jquery-validation.remote')}}",
        email: "{{trans('jquery-validation.email')}}",
        url: "{{trans('jquery-validation.url')}}",
        date: "{{trans('jquery-validation.date')}}",
        dateISO: "{{trans('jquery-validation.dateISO')}}",
        number: "{{trans('jquery-validation.number')}}",
        digits: "{{trans('jquery-validation.digits')}}",
        creditcard: "{{trans('jquery-validation.creditcard')}}",
        equalTo: "{{trans('jquery-validation.equalTo')}}",
        accept: "{{trans('jquery-validation.accept')}}",
        maxlength: jQuery.validator.format("{{trans('jquery-validation.maxlength')}}"),
        minlength: jQuery.validator.format("{{trans('jquery-validation.minlength')}}"),
        rangelength: jQuery.validator.format("{{trans('jquery-validation.rangelength')}}"),
        range: jQuery.validator.format("{{trans('jquery-validation.range')}}"),
        max: jQuery.validator.format("{{trans('jquery-validation.max')}}"),
        min: jQuery.validator.format("{{trans('jquery-validation.min')}}")
    });
    /*
     * General jQuery validation setup
     * This setup is used for adding messages placement
     */
    $.validator.setDefaults({
        /*OBSERVATION: note how the ignore option is placed in here*/
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        /*...other options omitted to focus on the OP...*/
        highlight: function (input) {
          $(input).parents('.form-line').removeClass('success');
          $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.form-group').append(error);
        },
        success: function (msg, element) {
            $(element).parents('.form-line').addClass('success');
        }
    });
</script>

@component('components.back-navigation-assets')
@endcomponent

@if (session('rfm_complete')==true)
    <script>
        swal({
            title: "{{__('task.request_modification-success-title')}}",
            text: "{{__('task.request_modification-success-info')}}",
            type: "success",
            html: true
        });
    </script>
@endif



@yield('scripts')
</body>

</html>
