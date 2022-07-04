@extends('layouts.front')

@section('styles')
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/1.10.15/integration/font-awesome/dataTables.fontAwesome.css" type="text/css"> --}}
    <link href="/front/plugins/chartist/chartist.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    {{ csrf_field() }}

    <div class="carousel slide" data-ride="carousel" id="myCarousel">
        <div class="carousel-inner">
            @foreach ($sliders as $slider)
                <div class="item @if ($loop->first) active @endif">
                    <img src="{{route('uploader.s', ['position' => $slider->id])}}" alt="{{ $slider->name }}">
                    <div class="carousel-caption">
                        <div @if (!$slider->white) class="black-text" @endif>
                            <h1><a href="{{ $slider->url }}">{{ $slider->name }}</a></h1>
                            <p class="hidden-xs">{{ str_limit($slider->description, 370, "...") }}</p>
                            <p class="hidden-xs hidden-sm"><a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" href="{{ $slider->url }}">{{ trans('general.continue_reading') }}</a></p>
                        </div>
                    </div><!--caption -->
                </div>
            @endforeach
        </div><!-- /.carousel-inner -->

        <!-- Controls -->
        @if (count($sliders)>1)
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        @endif
    </div> <!-- carousel slide -->
    <div class="clearfix"></div>

    @if ($banner)
        <div id="banner">
            <a href="{{$banner->url}}" title="{{$banner->title}}"><img alt="{{$banner->title}}" class="img-responsive" src="{{ route('uploader.b', ['position' => $banner->id]) }}"></a>
        </div>
    @endif

    <div class="section-title container-wrapper text-center">
        <h2 id="projectstable">Projects</h2>
        <span></span>
    </div>

    <div id="searching-area" class="row">
        <div class="col-md-3">
            <div data-open-first="true" class="accordion">
                <div class="accordion-item active filter_menu_button" data-status="1">

                    <div class="accordion-title"><h4>{{__('frontpage.map')}}<span id="map-filter-counter" class="label label-primary hidden">3</span></h4></div>

                    <div class="accordion-content accordion-show-content">
                        <div id="map_wrapper">
                            <div id="map_canvas"></div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item filter_menu_button" data-status="0">
                    <div class="accordion-title"><h4>{{__('frontpage.filterstage')}}<span id="stages-filter-counter" class="label label-primary hidden">3</span></h4></div>
                    <div class="accordion-content">
                        <ul>
                            @foreach($stages as $stage)
                                <li>
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="stage{{$stage->id}}">
                                        <input type="checkbox" class="mdl-checkbox__input filled-in" id="stage{{$stage->id}}" value={{$stage->id}} name="stages[]" />
                                        <span class="mdl-checkbox__label">{{$stage->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="accordion-item filter_menu_button" data-status="0">
                    <div class="accordion-title"><h4>{{__('frontpage.filterstate')}}<span id="regions-filter-counter" class="label label-primary hidden">3</span></h4></div>
                    <div class="accordion-content">
                        <ul>
                            @foreach ($regions as $region)
                                <li>
                                    <label id="region-locator-{{$region->id -1}}" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="region{{$region->id}}">
                                        <input type="checkbox" class="mdl-checkbox__input filled-in" id="region{{$region->id}}" value={{$region->id}} name="regions[]" />
                                        <span class="mdl-checkbox__label">{{$region->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="accordion-item filter_menu_button" data-status="0">
                    <div class="accordion-title"><h4>{{__('frontpage.filtersector')}}<span id="sectors-filter-counter" class="label label-primary hidden">3</span></h4></div>
                    <div class="accordion-content">
                        <ul>
                            @foreach ($sectors as $sector)
                                <li>
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="sector{{$sector->id}}">
                                        <input type="checkbox" class="mdl-checkbox__input filled-in" id="sector{{$sector->id}}" value={{$sector->id}} name="sectors[]" />
                                        <span class="mdl-checkbox__label">{{$sector->name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--<button class="btn btn-search btn-block filters-reset-button"><i class="fa fa-filter" aria-hidden="true"></i> Reset filters</button>-->
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-2">
                    <div class="project-counter-wrapper">
                        <span id="project-counter"></span>
                        <p>Project(s)</p>
                    </div>
                </div>
                <div class="col-md-10">
                    <div id="search">
                        <div class="mdh-expandable-search mdl-cell--hide-phone">
                            <label for="search-input"><i class="material-icons search-icon">search</i></label>
                            <input id="search-input" class="form-control search-map-input" placeholder="{{trans('general.find_project')}}" autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="active-filters"></div>
            <div class="table-responsive-wrapper">
                <table id="projects-table" cellspacing="0">
                    <thead>
                    <tr>
                        <th class="project-table-sorter all">{{__("add-project.name")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter">{{__("add-project.sector")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter">{{__("general.region")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter adjust-text">{{__("add-project.stage")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter adjust-text">{{__("general.contracting_authority")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter adjust-text">{{__("add-project.value")}} <i class="fa fa-sort" aria-hidden="true"></i></th>
                        <th class="project-table-sorter adjust-text">{{__("general.last_update")}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="section-fluid-wrapper">
        <div class="graphs-container">
            <!-- Graphs -->
            @include('partials.graphs.home', $posgroup)
        </div>
    </div>

    <section class="updates-container">
        @if ($announcementActive)
            <div class="row">

                <div class="col-md-8 col-sm-12 ">
                    @endif
                    <div class="section-title-double section-title-left">
                        <h2>{{__('frontpage.latest-projects')}}</h2>

                        <span></span>
                    </div>
                    <div class="updates-container-wrapper">
                        @foreach ($latest_updates as $latest_update)
                            <div class="sk-news-container-element">
                                <a href='{{route('front.project', ['id' => $latest_update->id, str_slug($latest_update->name)])}}'>
                                    <div class="update-thumbnail">
                                        <img class="portrait" src="{{$latest_update->project_image}}">
                                    </div>
                                    <h3>
                                        <div class="submenu">{{ Carbon\Carbon::parse($latest_update->updated_at)->format('d-m-Y') }} / <a href="/project-info/sector/{{$latest_update->project_sector}}">{{$latest_update->project_sector}}</a></div>
                                        <a href="{{route('front.project', ['id' => $latest_update->id, str_slug($latest_update->name)])}}">{{ $latest_update->name }}</a>
                                    </h3>
                                </a>
                            </div>
                        @endforeach

                    </div>
                    @if ($announcementActive)

                </div>

            @endif

            <!--- END COL -->
                @if ($announcementActive)
                    <div class="col-md-4 col-sm-12">
                        <div class="section-title-double section-title-left">
                            <h2>{{__('frontpage.announcements')}}</h2>

                            <span></span>
                        </div>
                        <div class="announcement-container">
                            <ul>
                                @foreach ($announcements as $k => $announcement)
                                    <li>
                                        <a href="{{route('front.project', ['id' => $announcement->project_id, str_slug($announcement->projectname)])}}#announcements-section">
                                            <div class="announcement-date">
                                                <div class="announcement-date-container">
                                                    {{Carbon\Carbon::parse($announcement->created_at)->day}}
                                                    <span>{{date("F", mktime(0, 0, 0, Carbon\Carbon::parse($announcement->created_at)->month, 1))}}</span>
                                                    <p>{{Carbon\Carbon::parse($announcement->created_at)->year}}</p>
                                                </div>
                                            </div>
                                            <div class="announcement-content">
                                                <h3>{{ str_limit($announcement->projectname, 40) }}</h3>
                                                <p>{{ str_limit(strip_tags($announcement->name), 60, "...") }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- END SECTION TITLE -->
                    </div>
                    <!--- END COL -->
            </div>
    @endif
    <!--- END CONTAINER -->
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('back/plugins/datatable/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="https://www.google.com/jsapi?.js"></script>
    <script src="{{asset('back/plugins/datatable/plugins/dataTables.buttons.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/jszip.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/pdfmake.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/vfs_fonts.js')}}" type="text/javascript"></script>
    <script src="{{asset('back/plugins/datatable/plugins/buttons.html5.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        /**
         *  Initialize the sectors array to send via AJAX to the controller
         */

        var sectors_array;
        var sectors_counter;
        var sectors_values=[];

        $("input[name='sectors[]']").change(function () {
            sectors_array=[];
            sectors_values=[];
            sectors_counter = 0;
            $.each($("input[name='sectors[]']:checked"), function() {
                sectors_array.push($(this).val());
                sectors_values.push($(this).siblings(".mdl-checkbox__label").html());
                sectors_counter++;
            });

            refreshSectorFilterCounter(sectors_counter);

            buildActiveFilters();
            projectTable.draw();

        });

        function refreshSectorFilterCounter(sectors_counter)
        {
            var sectors_element_counter = $("#sectors-filter-counter");
            if(sectors_counter){
                sectors_element_counter.html(sectors_counter);
                sectors_element_counter.removeClass("hidden");
            } else {
                sectors_element_counter.removeClass("hidden").addClass("hidden");
            }
        }

        /**
         *  Initialize the regions array to send via AJAX to the controller
         */
        var regions_array;
        var regions_counter;
        var regions_values=[];

        $("input[name='regions[]']").change(function () {
            regions_array=[];
            regions_values=[];
            regions_counter = 0;

            $.each($("input[name='regions[]']:checked"), function() {
                regions_array.push($(this).val());
                regions_values.push($(this).siblings(".mdl-checkbox__label").html());
                regions_counter++;
            });

            refreshRegionFilterCounter(regions_counter);

            buildActiveFilters();
            projectTable.draw();
        });

        function refreshRegionFilterCounter(regions_counter)
        {
            var regions_element_counter = $("#regions-filter-counter");
            var map_element_counter = $("#map-filter-counter");
            if(regions_counter){
                regions_element_counter.html(regions_counter);
                regions_element_counter.removeClass("hidden");
                map_element_counter.html(regions_counter);
                map_element_counter.removeClass("hidden");
            } else {
                regions_element_counter.removeClass("hidden").addClass("hidden");
                map_element_counter.removeClass("hidden").addClass("hidden");
            }
        }

        /**
         *  Initialize the stages array to send via AJAX to the controller
         */
        var stages_array;
        var stages_counter;
        var stages_values=[];

        $("input[name='stages[]']").change(function () {
            stages_array=[];
            stages_values=[];
            stages_counter = 0;
            $.each($("input[name='stages[]']:checked"), function() {
                stages_array.push($(this).val());
                stages_values.push($(this).siblings(".mdl-checkbox__label").html());
                stages_counter++;
            });

            refreshStageFilterCounter(stages_counter);

            buildActiveFilters();
            projectTable.draw();

        });


        function refreshStageFilterCounter(stages_counter)
        {
            var stages_element_counter = $("#stages-filter-counter");
            if(stages_counter){
                stages_element_counter.html(stages_counter);
                stages_element_counter.removeClass("hidden");
            } else {
                stages_element_counter.removeClass("hidden").addClass("hidden");
            }
        }

        $("#search-input").on("keyup",function () {
            projectTable.draw();
        });

        function buildActiveFilters(){

            var activeFiltersContainer = $(".active-filters");
            var activeFiltersArray = [];

            if(sectors_values.length > 0){
                sectors_values.forEach(function(element){
                    activeFiltersArray.push(element);
                });
            }

            if(stages_values.length > 0){
                stages_values.forEach(function(element){
                    activeFiltersArray.push(element);
                });
            }

            if(regions_values.length > 0){
                regions_values.forEach(function(element){
                    activeFiltersArray.push(element);
                });
            }

            if(activeFiltersArray.length > 0){

                // Clean container
                activeFiltersContainer.html('<h6>Active Filters</h6>');

                // Build container
                activeFiltersArray.forEach(function(element){
                    activeFiltersContainer.append('<span class="label label-primary active-filters-element">'+element+' <i class="fa fa-times" aria-hidden="true"></i></span>');
                });

                activeFiltersContainer.append('<button class="label btn-search-xs filters-reset-button"><i class="fa fa-filter" aria-hidden="true"></i> Reset filters</button>');

            } else {
                activeFiltersContainer.html('');
            }
        }

        /**
         * Remove one filter
         */
        $("body").on("click", ".active-filters-element", function(){
            var text = $(this).text().trim();
            var label = $(".mdl-checkbox__label:contains('"+text+"')");
            var input = label.siblings('input');
            input.prop('checked', false);

            var parent = label.parent().removeClass('is-checked');

            var type = input.prop('name'); // regions[] || stages[] || sectors[]

            if (type == "stages[]") {

                var index = stages_values.indexOf(text);
                stages_values.splice(index, 1);

                var value = stages_array.indexOf(input.val());
                stages_array.splice(value, 1);

                stages_counter--;
                refreshStageFilterCounter(stages_counter);

            } else if(type == "regions[]") {

                var index = regions_values.indexOf(text);
                regions_values.splice(index, 1);

                var value = regions_array.indexOf(input.val());
                regions_array.splice(value, 1);

                regions_counter--;
                refreshRegionFilterCounter(regions_counter);

            } else {

                var index = sectors_values.indexOf(text);
                sectors_values.splice(index, 1);

                var value = sectors_array.indexOf(input.val());
                sectors_array.splice(value, 1);

                sectors_counter--;
                refreshSectorFilterCounter(sectors_counter);

            }

            buildActiveFilters();
            projectTable.draw();
        });

        /**
         *  Reset Filters
         */
        $("body").on("click", ".filters-reset-button", function(){

            // Init all filters
            sectors_array = [];
            regions_array = [];
            stages_array = [];

            // Init all values filters
            sectors_values = [];
            regions_values = [];
            stages_values = [];

            // Hide all counters
            var sectors_element_counter = $("#sectors-filter-counter");
            var regions_element_counter = $("#regions-filter-counter");
            var stages_element_counter = $("#stages-filter-counter");
            var map_element_counter = $("#map-filter-counter");

            sectors_element_counter.removeClass("hidden").addClass("hidden");
            regions_element_counter.removeClass("hidden").addClass("hidden");
            stages_element_counter.removeClass("hidden").addClass("hidden");
            map_element_counter.removeClass("hidden").addClass("hidden");

            // Uncheck all filters
            $('.mdl-checkbox').each(function (index, element) {
                element.MaterialCheckbox.uncheck();
            });

            // Clean Search Box
            $("#search-input").val('');

            // Reset active filters
            buildActiveFilters();

            // Draw the table
            projectTable.draw();
        });

        /**
         *  GOOGLE MAP - LOGIC
         */
        function drawMap() {

            var data = google.visualization.arrayToDataTable([
                ['State', 'Projects', {role: 'tooltip', p:{html:true}}],
                    @foreach ($regions as $region)
                        @if($region->name == "Nasarawa")
                            ['Nassarawa', {{$region->num_projects}}, '<b>Nasarawa</b><br/><span>Projects: {{$region->num_projects}}</span>'],
                        @elseif($region->name == "Federal Capital Territory")
                            ['Abuja Capital Territory', {{$region->num_projects}}, '<b>Federal Capital Territory</b><br/><span>Projects: {{$region->num_projects}}</span>'],
                        @else
                            ['{{$region->name}}', {{$region->num_projects}}, '<b>{{$region->name}}</b><br/><span>Projects: {{$region->num_projects}}</span>'],
                        @endif
                    @endforeach
            ]);

            var options = {
                region: 'NG',
                displayMode: 'regions',
                resolution: 'provinces',
                datalessRegionColor: 'transparent',
                defaultColor: '#ffc43e',
                colorAxis: {colors: {!! $mapColors !!}},
                height: 300,
                width: 400,
                legend: 'none',
                isHtml: true,
                tooltip: {
                    isHtml: true,
                    showTitle: false
                }
            };

            var container = document.getElementById('map_canvas');
            var chart = new google.visualization.GeoChart(container);

            function mapClickHandler(){

                var selection = chart.getSelection();
                var regionClicked = chart.regionClick

                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null) {

                        // Get element and check it
                        var correlatedElement = document.getElementById("region-locator-"+item.row);
                        var currentCheckbox = new MaterialCheckbox(correlatedElement);
                        currentCheckbox.check();

                        // Init regions data
                        regions_array  = [];
                        regions_values = [];
                        regions_counter = 0;

                        // Push checked data
                        $.each($("input[name='regions[]']:checked"), function() {
                            regions_array.push($(this).val());
                            regions_values.push($(this).siblings(".mdl-checkbox__label").html());
                            regions_counter++;
                        });

                        // Update DOM with visual stuff
                        var regions_element_counter = $("#regions-filter-counter");
                        var map_element_counter = $("#map-filter-counter");
                        if(regions_counter){
                            regions_element_counter.html(regions_counter);
                            regions_element_counter.removeClass("hidden");
                            map_element_counter.html(regions_counter);
                            map_element_counter.removeClass("hidden");
                        } else {
                            regions_element_counter.removeClass("hidden").addClass("hidden");
                            map_element_counter.removeClass("hidden").addClass("hidden");
                        }

                        // Rebuild the filters
                        buildActiveFilters();

                        // Draw the table
                        projectTable.draw();
                    }
                }

            }

            google.visualization.events.addListener(chart, 'select', mapClickHandler);
            chart.draw(data, options);

        }

        google.load('visualization', '1', {packages: ['geochart'], callback: drawMap});

        var _token = $('input[name="_token"]').val();

        var title = "{{env("APP_TITLE")}} - Projects";

        var projectTable = $('#projects-table').DataTable({
            pageLength: 10,
            dom: 'Blfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ 'Display 10', 'Display 25', 'Display 50', 'Display All' ]
            ],
            buttons: [
                {
                    extend: 'copy',
                    title: title
                },
                {
                    extend: 'csv',
                    title: title
                },
                {
                    extend: 'excel',
                    title: title
                },
                {
                    extend: 'pdf',
                    title: title
                }
            ],
            order: [[ 6, "desc" ]],
            language: {
                processing: function () {
                    return "<img alt='Loading ...' src='/img/ajax-loader.gif'>";
                },
                zeroRecords: "No matching projects found.",
                lengthMenu: "_MENU_"
            },
            // processing: "<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span>",
            columnDefs: [
                {
                    className: "text-center", "targets": [ 5 ],
                },

            ],
            searching: false,
            bLengthChange: true,
            bInfo: false,
            processing: true,
            serverSide: true,
            ajax: {
                url : '{!! route('front.tableProjects') !!}',
                data: function(d){
                    d._token = _token;
                    d.sectors_array = sectors_array;
                    d.stages_array = stages_array;
                    d.regions_array = regions_array;
                    d.name = $("#search-input").val();
                },
                method : 'POST'
            },
            columns: [
                { data: 'name', name: 'projects.name', orderable: true},
                { data: 'sectors', name: 'projectInformation.sectors.name', orderable: true},
                { data: 'regions', name: 'projectInformation.regions.name', orderable: true},
                { data: 'stage', name: 'projectInformation.stage.name', orderable: true},
                {
                    data: 'sponsor', name: 'projectInformation.sponsor.name',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: null,
                    name: 'projectInformation.project_value_usd',
                    searchable: false,
                    render: function (data) {
                        var text = '';
                        if(data.project_value_second != ""){
                            text += data.project_value_second+ ' {{$currency}}' + '<br class="visible-md-block visible-lg-block"><span class="visible-sm-inline visible-xs-inline"> - </span>';
                        }
                        if(data.project_value_usd != 0){
                            text += data.project_value_usd + '  US$';
                        }
                        if(data.project_value_second == 0 && data.project_value_usd == 0){
                            text += 'Not available';
                        }
                        return text
                    }
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    visible: false,
                },
            ],
            fnDrawCallback: function(oSettings) {
                if ($('#projects-table').DataTable().data().count() == 0) {
                    $('#projects-table_paginate').hide();
                } else {
                    $('#projects-table_paginate').show();
                }

                /**
                 *  INIT PROJECT NUMBER
                 */
                drawProjectNumber();
            },
            fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                $(nRow).click(function(){
                    nRow.setAttribute("id",aData.id)
                    document.location.href = "/project/" + aData.id + "/" + aData.slug;
                });
            }
        });

        /**
         *  Number of projects at table.
         */
        function drawProjectNumber() {

            if ( ! projectTable.page.info().recordsTotal ) {

                $("#project-counter").html(0);

            } else {

                $("#project-counter").html(projectTable.page.info().recordsTotal);

            }

        }

        $(document).ready(function() {

            /**
             * ACCORDION
             */
            $(".accordion-item").click(function () {

                var itemStatus = $(this).data("status");

                if(itemStatus === "1"){

                    $(".accordion-item").each(function (index, element) {
                        $(element).removeClass('active');
                        $(element).children(".accordion-content").removeClass("accordion-show-content");
                    });

                    $(this).data("status", 0);

                } else {

                    $(".accordion-item").each(function (index, element) {
                        $(element).removeClass('active');
                        $(element).children(".accordion-content").removeClass("accordion-show-content");
                    });

                    $(this).addClass('active');
                    $(this).children(".accordion-content").addClass("accordion-show-content");

                    $(this).data("status", 1);

                }

            });

            /**
             * Pagination Scroll Up
             */

            var tableElement = $("#projects-table");
            var elementOffset = tableElement.offset().top;
            var currentElementOffset = (elementOffset + 200);

            projectTable.on( 'page.dt', function () {
                $('html, body').animate({
                    scrollTop: currentElementOffset
                });
            } );

            /**
             * Graphs link to external resources
             */
            $('body').on("click", ".ct-slice-pie, .ct-bar", function () {

                location.href = $(this).attr("href");

            });


        });



        // Contact
        $('#btnSendContact').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            if($('#frmContact').valid()){
                var input_name = $('#frmContact input[name=name]').val();
                var input_email = $('#frmContact input[name=email]').val();
                var input_message = $('#frmContact textarea[name=message]').val();

                $.ajax({
                    url: '{{ route('contact.send') }}',
                    type: 'POST',
                    data: { name: input_name, email: input_email, message: input_message, _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                        $('.contactLoader').html("<img alt='Loading ...' src='/img/loader.gif'>");
                    },
                    success: function(data){
                        if (data.status) {
                            var success = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your message was successfully sent.</div>';
                            $('.contactState').removeClass('hidden').addClass('display');
                            $('.contactState').html(success);
                            $('#frmContact').remove();
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+data.message+'</div>';
                            $('.contactState').removeClass('hidden').addClass('display');
                            $('.contactState').html(errors);
                        }
                    },
                    error: function(data){
                        if (data.status === 422) {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><ul>';
                            $.each(data.responseJSON, function(index, value){
                                errors += "<li>" + value + "</li>";
                            });
                            errors += '</ul></div>';
                            $('.contactState').removeClass('hidden').addClass('display');
                            $('.contactState').html(errors);
                        } else {
                            var errors = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>There was an internal error. Please try soon again.</div>';
                            $('.contactState').removeClass('hidden').addClass('display');
                            $('.contactState').html(errors);
                        }
                    },
                    complete: function() {
                        $('.contactLoader').html("");
                    }
                });
            }
        });

        $(".filter_menu_button").click(function() {
            $('html, body').animate({
                scrollTop: $('#searching-area').offset().top
            }, 450);
        });
        $(".filter_menu_button li").click(function(e) {
            e.stopPropagation();
        });

    </script>
@endsection
