@extends('layouts.back')

@section('styles')
    <link href="{{ asset('back/plugins/morrisjs/morris.css') }}" rel="stylesheet">
    <link href="{{asset('back/plugins/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection

@section('content')

    <h1 class="content-title">{{ trans("dashboard.analytics_title") }}</h1>

    <div class="row content-row errors"></div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row content-row clearfix">
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-purple hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text">UNIQUE USERS</div>
                    <div class="number count-to" data-from="0" data-to="{{$totalUsers}}" data-speed="1000" data-fresh-interval="1">{{$totalUsers}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-brown hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">desktop_mac</i>
                </div>
                <div class="content">
                    <div class="text">USER SESSIONS</div>
                    <div class="number count-to" data-from="0" data-to="{{$totalSessions}}" data-speed="1000" data-fresh-interval="1">{{$totalSessions}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">pageview</i>
                </div>
                <div class="content">
                    <div class="text">PAGE VIEWS</div>
                    <div class="number count-to" data-from="0" data-to="{{$totalPages}}" data-speed="1000" data-fresh-interval="1">{{$totalPages}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">toll</i>
                </div>
                <div class="content">
                    <div class="text">BOUNCES</div>
                    <div class="number count-to" data-from="0" data-to="{{$totalBounces}}" data-speed="1000" data-fresh-interval="1">{{$totalBounces}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row content-row clearfix">
        <!-- Area Chart -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Website analytics</h2><span>(Last 30 days)</span>
                </div>
                <div class="body">
                    <div id="area_chart" class="graph"></div>
                </div>
            </div>
        </div>
        <!-- #END# Area Chart -->
    </div>

    <div class="row content-row clearfix">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h2>Unique users per country</h2><span>(Last 30 days)</span>
                </div>
                <div class="body scrollbox-sm table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Country</th>
                            <th>Users</th>
                            <th>%</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countries as $country)
                            <tr>
                                <td>
                                    <i class="flag-icon flag-icon-{{strtolower($country[0])}}"></i>
                                    <span class="country-name">{{$country[1]}}</span>
                                </td>
                                <td>{{$country[2]}}</td>
                                <td>{{round(($country[2]/$totalUsers)*100,2)}}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h2>List of browsers</h2><span>(Last 30 days)</span>
                </div>
                <div class="body scrollbox-sm table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Browser</th>
                            <th>Name</th>
                            <th>Sessions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($browsers as $browser)
                            <tr>
                                <td><img src="{{asset('/back/images/browser/'.str_slug($browser['browser']).'.png')}}" alt='{{$browser['browser']}}' /></td>
                                <td>{{$browser['browser']}}</td>
                                <td>{{$browser['sessions']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row content-row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Top visited pages</h2><span>(Top 20 in the last 30 days)</span>
                </div>
                <div class="body scrollbox-lg table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Link</th>
                            <th>Visits</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($processedPages as $page)
                            <tr>
                                <td><a href="{{url($page['url'])}}">{{$page['url']}}</a></td>
                                <td>{{$page['pageViews']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script src="{{asset('back/plugins/raphael/raphael.js')}}"></script>
    <script src="{{asset('back/plugins/morrisjs/morris.js')}}"></script>
    <script src="{{ asset('back/plugins/countTo/jquery.countTo.js') }}"></script>
    <script>

        $('.count-to').countTo();

        $('.scrollbox-sm').slimScroll({
            height: '300px'
        });
        $('.scrollbox-lg').slimScroll({
            height: '500px'
        });

    </script>
    <script>

        $(function () {
            getMorris('area', 'area_chart');
        });

        function getMorris(type, element) {
            if (type === 'area') {

                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                Morris.Line({
                    element: element,
                    data: {!! $jsonArray !!},
                    xkey: 'day',
                    xlabels: 'day',
                    xLabelFormat: function (x) {
                        return x.getDate() + ' ' + months[x.getMonth()];
                    },
                    ykeys: ['uniqueUsers', 'sessions', 'pageViews', 'bounces'],
                    labels: ['Unique Users', 'User Sessions', 'Page Views', 'Bounces'],
                    pointSize: 2,
                    hideHover: 'auto',
                    lineColors: ['rgb(156, 39, 176)', 'rgb(121, 85, 72)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)'],
                    xLabelAngle: 50,
                    dateFormat: function (d) {
                        var ds = new Date(d);
                        return ds.getDate() + ' ' + months[ds.getMonth()];
                    },
                    behaveLikeLine: true
                });
            }
        }

    </script>
@endsection
