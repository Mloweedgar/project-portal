<nav id="navbar-main" class="navbar">
    <div class="container-fluid nav-wrapper top-nav row float-right hidden-xs">
        <div id="header-date-box" class="col-md-3 navbar-header">
            <span><?=date("F j, Y")?></span>
        </div>
        <div class="col-md-9 text-right">
        <ul class="nav navbar-nav navigation" style="float:right;">
            <li><a href="https://zppp.go.tz/news">News</a>
            </li>
            <li><a href="https://zppp.go.tz/faqs">FAQs</a>
            </li>
            <li><a href="https://zppp.go.tz/sitemap/">Sitemap</a>
            </li>
            <li><a href="https://zppp.go.tz/contact/">Contact Us</a>
            </li>
        </ul>
        </div>
    </div>
    <div id="baseweb-header" class="container-fluid nav-wrapper row hidden-xs">
        <div class="navbar-header col-md-2">
            <a class="logo" href="/"><img class="logo-img" src="{{route('application.logo')}}"></a>
        </div>
        <div class="col-md-8 text-center">
        <h2 class="centered-title">Zanzibar Public Private Partnership <br/> (PPP) Department</h2>
        </div>
        <img class="logo col-md-2" src="/img/znz-flag.png" style="max-width:175px;" />

    </div>
    <div id="baseweb-menu" class="container-fluid nav-wrapper row hidden-xs">
        <ul class="nav navbar-nav navigation">
            <li><a href="https://zppp.go.tz/">{{ trans('general.home') }}</a>
            </li>
            <li><a href="https://zppp.go.tz/">About Us</a>
                <div data-submenu="about-us" class="submenu submenu-main-site">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul>
	                            <li><a href="https://zppp.go.tz/about/">OVERVIEW</a></li>
	                            <li><a href="https://zppp.go.tz/organization-structure/">Organization Structure</a></li>
	                            <li><a href="https://zppp.go.tz/team">Meet The Team</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="https://zppp.go.tz/framework/">Framework</a>
            </li>
            <li id="disclo_portal_opt"><a href="#">PPP Information Portal</a>
            </li>
            <li><a href="https://zppp.go.tz/ppp-project-cycle/">PPP Project cycle</a>
            </li>
            <li><a href="https://zppp.go.tz/elibrary/">E-Library</a>
            </li>
        </ul>
    </div>
    <!--div id="disc-portal-menu" class="container-fluid nav-wrapper row hidden-xs">
    <ul class="nav navbar-nav navigation">
            <li><a href="/">{{ trans('general.home') }}</a>
            <li><a id="projects" href="#">{{trans('general.projects')}}</a>
                <div data-submenu="projects" class="submenu">
                    <div class="row">
                        <div class="col-sm-4">
                            <a href='#'>{{__("add-project.stage")}}</a>
                            <ul>
                                @foreach($stages as $stage)
                                    <li>
                                        <a href='/project-info/stage/{{$stage->name}}'>{{$stage->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <a href='#'>{{__("add-project.sector")}}</a>
                            <ul>
                                @foreach($sectors as $sector)
                                    <li>
                                        <a href='/project-info/sector/{{$sector->name}}'>{{$sector->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <a href='#'>{{__("general.region")}}</a>
                            <ul>
                                @foreach($regions as $region)
                                    <li>
                                        <a href='/project-info/region/{{$region->name}}'>{{$region->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="{{route('frontend.announcements')}}">{{trans('menu.announcements')}}</a></li>
            @foreach ($nav_extra as $n_extra)
                <li><a href="{{ $n_extra->link }}">{{ $n_extra->name }}</a></li>
            @endforeach
        </ul>
        <div class="search-bar">
            @if ($projectInternalUrl !== null)
                <a class="login-button-f" href="{{$projectInternalUrl}}"><i class="material-icons">exit_to_app</i> Login</a>
            @else
                <a class="login-button-f" href="/login"><i class="material-icons">exit_to_app</i> Login</a>
            @endif
        </div>
    </div-->
    
</nav>



<div class="search-bar hiddenAtPrint">
    <div id="morphsearch" class="morphsearch">
        <form class="morphsearch-form">
            <input class="morphsearch-input" type="search" placeholder="Search..."/>
            <button class="morphsearch-submit" type="submit">Search</button>
        </form>
        <div class="morphsearch-content">
            <div class="dummy-column">
                <div id="search-dropper-container">
                    <div class="no-results-container">
                        <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 200 200">
                            <style>
                                .st0{fill:#BABABA;} .st1{clip-path:url(#XMLID_198_);} .st2{fill:#FFFFFF;} .st3{fill:#E6E7E8;} .st4{fill:#CCCCCC;} .st5{fill:#C1C1C1;} .st6{fill:#929292;} .st7{fill:#0E303F;} .st8{fill:#FCC69D;} .st9{fill:#666666;} .st10{fill:#A0A0A0;}
                            </style>
                            <g id="XMLID_235_">
                                <circle id="XMLID_1093_" class="st0" cx="100" cy="100" r="100"/>
                                <g id="XMLID_35_">
                                    <defs>
                                        <circle id="XMLID_433_" cx="100" cy="100" r="100"/>
                                    </defs>
                                    <clipPath id="XMLID_198_">
                                        <use xlink:href="#XMLID_433_" overflow="visible"/>
                                    </clipPath>
                                    <g id="XMLID_434_" class="st1">
                                        <g id="mouse_computer_3_">
                                            <g id="XMLID_1091_">
                                                <path id="XMLID_1092_" class="st2" d="M112.2 113.2h48.4c1.4 0 2.6 1.2 2.6 2.6v20.3h1.1V121v-5.2c0-2.1-1.7-3.8-3.8-3.8h-48.4"/>
                                            </g>
                                            <g id="XMLID_1086_">
                                                <path id="XMLID_1090_" class="st2" d="M165.1 129.2c2.9 0 5.2 2.3 5.2 5.2v12.5c0 2.9-2.3 5.2-5.2 5.2h-1.4v-22.9h1.4z"/>
                                                <path id="XMLID_1087_" class="st3" d="M162.3 129.2h1.4v22.9h-1.4c-2.9 0-5.2-2.3-5.2-5.2v-12.5c0-2.9 2.3-5.2 5.2-5.2z"/>
                                            </g>
                                            <g id="XMLID_1083_">
                                                <path id="XMLID_1085_" class="st4" d="M165.4 134.7v1.1c0 1-.8 1.7-1.7 1.7V133c1 0 1.7.8 1.7 1.7z"/>
                                                <path id="XMLID_1084_" class="st5" d="M163.7 133v4.6c-1 0-1.7-.8-1.7-1.7v-1.1c0-1 .7-1.8 1.7-1.8z"/>
                                            </g>
                                        </g>
                                        <g id="screen_3_">
                                            <g id="XMLID_1031_">
                                                <path id="XMLID_1080_" class="st6" d="M88.7 97.3c-1.1 4.6-2.2 9.2-3.4 13.8h31.5c-1.1-4.6-2.2-9.2-3.4-13.8H88.7z"/>
                                                <path id="XMLID_1079_" class="st2" d="M118.7 110.8H83.3c-.9 0-1.6.9-1.6 1.9v.7h38.6v-.7c0-1-.7-1.9-1.6-1.9z"/>
                                                <path id="XMLID_1078_" class="st2" d="M47.9 91.9v7.6c0 1.5 1.2 2.6 2.6 2.6h101c1.5 0 2.6-1.2 2.6-2.6v-7.6H47.9z"/>
                                                <path id="XMLID_1077_" class="st7" d="M154.2 91.9V27.6c0-1.5-1.2-2.6-2.6-2.6h-101c-1.5 0-2.6 1.2-2.6 2.6v64.3h106.2z"/>
                                                <path id="XMLID_1076_" class="st2" d="M52.2 29.1h97.6v58.4H52.2z"/>
                                                <g id="XMLID_1032_">
                                                    <path id="XMLID_1075_" class="st3" d="M52.2 29.1h15.2v58.4H52.2z"/>
                                                    <g id="XMLID_1036_">
                                                        <g id="XMLID_1151_">
                                                            <g id="XMLID_1164_">
                                                                <path id="XMLID_1169_" class="st3" d="M71.2 40.4h22.3v13.4H71.2z"/>
                                                                <path id="XMLID_1168_" class="st3" d="M71.2 55.2h22.3v1.1H71.2z"/>
                                                                <path id="XMLID_1167_" class="st3" d="M71.2 57.3h22.3v1.1H71.2z"/>
                                                                <path id="XMLID_1166_" class="st3" d="M71.2 59.5h22.3v1.1H71.2z"/>
                                                                <path id="XMLID_1165_" class="st3" d="M71.2 61.6h15.3v1.1H71.2z"/>
                                                            </g>
                                                            <g id="XMLID_1158_">
                                                                <path id="XMLID_1163_" class="st3" d="M97.6 40.4h22.3v13.4H97.6z"/>
                                                                <path id="XMLID_1162_" class="st3" d="M97.6 55.2H120v1.1H97.6z"/>
                                                                <path id="XMLID_1161_" class="st3" d="M97.6 57.3H120v1.1H97.6z"/>
                                                                <path id="XMLID_1160_" class="st3" d="M97.6 59.5H120v1.1H97.6z"/>
                                                                <path id="XMLID_1159_" class="st3" d="M97.6 61.6H120v1.1H97.6z"/>
                                                            </g>
                                                            <g id="XMLID_1152_">
                                                                <path id="XMLID_1157_" class="st3" d="M123.9 40.4h22.3v13.4h-22.3z"/>
                                                                <path id="XMLID_1156_" class="st3" d="M123.9 55.2h22.3v1.1h-22.3z"/>
                                                                <path id="XMLID_1155_" class="st3" d="M123.9 57.3h22.3v1.1h-22.3z"/>
                                                                <path id="XMLID_1154_" class="st3" d="M123.9 59.5h22.3v1.1h-22.3z"/>
                                                                <path id="XMLID_1153_" class="st3" d="M123.9 61.6h6.4v1.1h-6.4z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <g id="XMLID_1033_">
                                                        <path id="XMLID_1035_" class="st3" d="M136.9 31.6h9.4v3.6h-9.4z"/>
                                                        <path id="XMLID_1034_" class="st3" d="M125.6 31.6h9.4v3.6h-9.4z"/>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <g id="keyboard_4_">
                                            <path id="XMLID_1030_" class="st2" d="M151 123.7c0-.7-.6-1.2-1.3-1.2H52.3c-.7 0-1.3.5-1.3 1.2v35.8c0 .7.6 1.2 1.3 1.2h97.4c.7 0 1.3-.5 1.3-1.2v-35.8z"/>
                                            <g id="XMLID_963_">
                                                <path id="XMLID_1029_" class="st4" d="M59 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1028_" class="st4" d="M68.9 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1027_" class="st4" d="M70.5 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1026_" class="st4" d="M67.3 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3H67c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1025_" class="st4" d="M59 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1024_" class="st4" d="M65.6 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1023_" class="st4" d="M72.2 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1022_" class="st4" d="M128.6 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1021_" class="st4" d="M135.3 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/>
                                                <path id="XMLID_1020_" class="st4" d="M148.5 158.1c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-2.5c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v2.5z"/>
                                                <path id="XMLID_1019_" class="st4" d="M80.5 158.1c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1018_" class="st4" d="M122 158.1c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1017_" class="st4" d="M113.7 158.1c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3v-5.6c0-.2.1-.3.3-.3h31.3c.2 0 .3.1.3.3v5.6z"/>
                                                <path id="XMLID_1016_" class="st4" d="M73.9 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1015_" class="st4" d="M80.5 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1014_" class="st4" d="M87.1 150.6c0 .2-.1.3-.3.3H82c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1013_" class="st4" d="M93.8 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1012_" class="st4" d="M100.4 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1011_" class="st4" d="M107 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1010_" class="st4" d="M113.7 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1009_" class="st4" d="M120.3 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1008_" class="st4" d="M126.9 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1007_" class="st4" d="M133.5 150.6c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1006_" class="st4" d="M148.5 150.6c0 .2-.1.3-.3.3H135c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h13.1c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1005_" class="st4" d="M77.1 144c0 .2-.1.3-.3.3H72c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1004_" class="st4" d="M83.8 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1003_" class="st4" d="M90.4 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1002_" class="st4" d="M97 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1001_" class="st4" d="M103.6 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_1000_" class="st4" d="M110.3 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_999_" class="st4" d="M116.9 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_998_" class="st4" d="M123.5 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_997_" class="st4" d="M130.1 144c0 .2-.1.3-.3.3H125c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_996_" class="st4" d="M136.8 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_995_" class="st4" d="M143.4 144c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_994_" class="st4" d="M75.6 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_993_" class="st4" d="M82.2 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_992_" class="st4" d="M88.8 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_991_" class="st4" d="M95.4 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_990_" class="st4" d="M102.1 137.4c0 .2-.1.3-.3.3H97c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_989_" class="st4" d="M108.7 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_988_" class="st4" d="M115.3 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_987_" class="st4" d="M122 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_986_" class="st4" d="M128.6 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_985_" class="st4" d="M135.2 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_984_" class="st4" d="M141.8 137.4c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_983_" class="st4" d="M62.3 137.4c0 .2-.1.3-.3.3h-8.2c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3H62c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_982_" class="st4" d="M148.5 130.7c0 .2-.1.3-.3.3H140c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_981_" class="st4" d="M63.9 144c0 .2-.1.3-.3.3h-9.7c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h9.7c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_980_" class="st4" d="M60.6 150.6c0 .2-.1.3-.3.3h-6.5c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h6.5c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_979_" class="st4" d="M65.6 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_978_" class="st4" d="M72.2 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_977_" class="st4" d="M78.8 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_976_" class="st4" d="M85.5 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_975_" class="st4" d="M92.1 130.7c0 .2-.1.3-.3.3H87c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_974_" class="st4" d="M98.7 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_973_" class="st4" d="M105.3 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_972_" class="st4" d="M112 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_971_" class="st4" d="M118.6 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_970_" class="st4" d="M125.2 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_969_" class="st4" d="M131.9 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <path id="XMLID_968_" class="st4" d="M138.5 130.7c0 .2-.1.3-.3.3h-4.8c-.2 0-.3-.1-.3-.3v-4.8c0-.2.1-.3.3-.3h4.8c.2 0 .3.1.3.3v4.8z"/>
                                                <g id="XMLID_965_">
                                                    <path id="XMLID_967_" class="st4" d="M136.4 155.4v2.6c0 .1 0 .2.1.2.1.1.1.1.2.1h4.8c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-2.6h-5.4z"/>
                                                    <path id="XMLID_966_" class="st4" d="M141.9 155.1v-2.6c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v2.6h5.4z"/>
                                                </g>
                                                <path id="XMLID_964_" class="st4" d="M143.3 132.2c-.1 0-.2 0-.2.1-.1.1-.1.1-.1.2v4.8c0 .1 0 .2.1.2.1.1.1.1.2.1h1.3v6.3c0 .1 0 .2.1.2.1.1.1.1.2.1h3.2c.1 0 .2 0 .2-.1.1-.1.1-.1.1-.2v-11.4c0-.1 0-.2-.1-.2-.1-.1-.1-.1-.2-.1h-4.8z"/>
                                            </g>
                                        </g>
                                        <g id="hand_4_">
                                            <g id="XMLID_938_">
                                                <path id="XMLID_960_" class="st8" d="M84.9 141.1c-1.1-.5-2.4-.1-2.9 1l-6.9 14.2c-.5 1.1-.1 2.4 1 2.9s2.4.1 2.9-1l6.9-14.2c.5-1.1.1-2.4-1-2.9z"/>
                                                <path id="XMLID_957_" class="st8" d="M79 170.4c-1.3 2.8-4.7 3.9-7.5 2.6l-8.2-4c-2.8-1.3-3.9-4.7-2.6-7.5l4-8.2c1.3-2.8 4.7-3.9 7.5-2.6l8.2 4c2.8 1.3 3.9 4.7 2.6 7.5l-4 8.2z"/>
                                                <path id="XMLID_954_" class="st8" d="M72.3 142.8c-1.1-.5-2.4-.1-2.9 1l-4.4 9.1c-.5 1.1-.1 2.4 1 2.9s2.4.1 2.9-1l4.4-9.1c.5-1.1.1-2.4-1-2.9z"/>
                                                <path id="XMLID_951_" class="st8" d="M78.9 141.3c-1.1-.5-2.4-.1-2.9 1l-6.9 14.2c-.5 1.1-.1 2.4 1 2.9s2.4.1 2.9-1l6.9-14.2c.5-1.1 0-2.4-1-2.9z"/>
                                                <path id="XMLID_948_" class="st8" d="M88.8 145.3c-1.1-.5-2.4-.1-2.9 1L79 160.5c-.5 1.1-.1 2.4 1 2.9s2.4.1 2.9-1l6.9-14.2c.5-1.1.1-2.4-1-2.9z"/>
                                                <path id="XMLID_945_" class="st8" d="M54.6 179.6l9-18.6c.9-1.9 3.2-2.7 5.1-1.8l5.5 2.7c1.9.9 2.7 3.2 1.8 5.1l-9 18.6-12.4-6z"/>
                                                <path id="XMLID_942_" class="st8" d="M80.3 170.1l3.6-7.4c.8-1.6 2.7-2.2 4.2-1.5l1 .5s.1 0 .1.1l-3.1 6.3-5.8 2z"/>
                                                <path id="XMLID_939_" class="st8" d="M78.3 167.8l7.1-2.5c.7-.2 1.4-.2 2 0l-2.3 4.7-9.5 3.3 2.7-5.5z"/>
                                            </g>
                                            <path id="XMLID_937_" class="st2" d="M58.744 169.928l12.773 6.203-3.1 6.387-12.774-6.202z"/>
                                            <path id="XMLID_934_" class="st9" d="M54.002 178.46l14.212 6.902-8.867 18.26-14.212-6.9z"/>
                                            <path id="XMLID_931_" class="st10" d="M56.73 171.79l14.932 7.25-4.587 9.445-14.93-7.25z"/>
                                            <circle id="XMLID_928_" class="st9" cx="68.7" cy="180.4" r=".7"/>
                                        </g>
                                        <g id="hand_1_">
                                            <g id="XMLID_903_">
                                                <path id="XMLID_925_" class="st8" d="M117.1 141.7c1.1-.5 2.4-.1 2.9 1l7 14.2c.5 1.1.1 2.4-1 2.9s-2.4.1-2.9-1l-7-14.2c-.5-1.1 0-2.4 1-2.9z"/>
                                                <path id="XMLID_922_" class="st8" d="M123.1 171c1.4 2.8 4.7 3.9 7.5 2.6l8.1-4c2.8-1.4 3.9-4.7 2.6-7.5l-4-8.1c-1.4-2.8-4.7-3.9-7.5-2.6l-8.1 4c-2.8 1.4-3.9 4.7-2.6 7.5l4 8.1z"/>
                                                <path id="XMLID_919_" class="st8" d="M129.8 143.4c1.1-.5 2.4-.1 2.9 1l4.5 9.1c.5 1.1.1 2.4-1 2.9s-2.4.1-2.9-1l-4.5-9.1c-.5-1.1-.1-2.4 1-2.9z"/>
                                                <path id="XMLID_916_" class="st8" d="M123.2 141.9c1.1-.5 2.4-.1 2.9 1l7 14.2c.5 1.1.1 2.4-1 2.9s-2.4.1-2.9-1l-7-14.2c-.5-1.1-.1-2.3 1-2.9z"/>
                                                <path id="XMLID_913_" class="st8" d="M113.3 145.9c1.1-.5 2.4-.1 2.9 1l7 14.2c.5 1.1.1 2.4-1 2.9s-2.4.1-2.9-1l-7-14.2c-.5-1.1-.1-2.4 1-2.9z"/>
                                                <path id="XMLID_910_" class="st8" d="M147.6 180.1l-9.1-18.5c-.9-1.9-3.2-2.7-5.1-1.7l-5.5 2.7c-1.9.9-2.7 3.2-1.7 5.1l9.1 18.5 12.3-6.1z"/>
                                                <path id="XMLID_907_" class="st8" d="M121.9 170.7l-3.6-7.4c-.8-1.6-2.7-2.2-4.2-1.5l-.9.5s-.1 0-.1.1l3.1 6.3 5.7 2z"/>
                                                <path id="XMLID_904_" class="st8" d="M123.8 168.5l-7.1-2.4c-.7-.2-1.4-.2-2 0l2.3 4.7 9.5 3.3-2.7-5.6z"/>
                                            </g>
                                            <path id="XMLID_902_" class="st2" d="M146.51 176.788l-12.747 6.26-3.13-6.372 12.746-6.26z"/>
                                            <path id="XMLID_899_" class="st9" d="M156.865 196.593l-14.182 6.966-8.686-17.683 14.182-6.967z"/>
                                            <path id="XMLID_896_" class="st10" d="M150.128 181.758l-14.9 7.32-4.63-9.426 14.9-7.32z"/>
                                            <circle id="XMLID_435_" class="st9" cx="133.6" cy="180.9" r=".7"/>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <div class="no-results-header">Write something to start searching</div>
                        <div class="no-results-subheader">We will look into all the projects for you.</div>
                    </div>
                </div>
            </div>
        </div><!-- /morphsearch-content -->
        <span class="morphsearch-close"></span>
    </div><!-- /morphsearch -->
    <div class="overlay"></div>
</div>


<nav id="navbar-m" class="navbar navbar-default visible-xs-block">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img id="printLogo" src="{{route('application.logo')}}"></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav hiddenAtPrint">
                <li><a href="/">{{ trans('general.home') }} <span class="sr-only"></span></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{trans('general.projects')}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="trigger right-caret">{{__("add-project.stage")}} <span class="caret"></span></a>
                            <ul class="dropdown-menu sub-menu" aria-labelledby="stageMenu">
                                @foreach($stages as $stage)
                                    <li>
                                        <a href='/project-info/stage/{{$stage->name}}'>{{$stage->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="#" class="trigger right-caret">{{__("add-project.sector")}} <span class="caret"></span></a>
                            <ul class="dropdown-menu sub-menu" aria-labelledby="sectorMenu">
                                @foreach($sectors as $sector)
                                    <li>
                                        <a href='/project-info/sector/{{$sector->name}}'>{{$sector->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="#" class="trigger right-caret">{{__("general.region")}} <span class="caret"></span></a>
                            <ul class="dropdown-menu sub-menu" aria-labelledby="regionMenu">
                                @foreach($regions as $region)
                                    <li>
                                        <a href='/project-info/region/{{$region->name}}'>{{$region->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="{{route('frontend.announcements')}}">{{trans('menu.announcements')}}</a></li>
                <li><a href="/contact">{{trans('general.contact')}}</a></li>
                @foreach ($nav_extra as $n_extra)
                    <li><a href="{{ $n_extra->link }}">{{ $n_extra->name }}</a></li>
                @endforeach
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
    