@extends('layouts.back')

@section('styles')
    <link href="/front/plugins/chartist/chartist.css" rel="stylesheet" type="text/css">
    <link href="/back/plugins/dragula/dragula.min.css" rel="stylesheet" type="text/css">
    <link href="/back/css/views/website-management/graphs.css" rel="stylesheet" type="text/css">
    <script src="front/plugins/chartist/chartist.min.js"></script>
    <script src="back/plugins/dragula/dragula.min.js"></script>
@endsection

@section('content')

    @php
    $allpos = array();
    @endphp

    @if (count($errors) > 0)


        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!empty($flag))
        <div class="alert alert-danger">
            Message: {{$flag["message"]}}
        </div>
    @endif

    <div class="container-fluid">
        <h1 class="content-title">{{__("graphs.title")}}</h1>
        @if (!\Illuminate\Support\Facades\Auth::user()->isViewOnly())
            <div class="section-information">
                <a href="{{ route('documentation').'#graphs' }}"><i class="material-icons">help_outline</i> {{__('messages.section-info')}}</a>
            </div>
        @endif
        <div class="row content-row">

            <ul class="nav nav-tabs">
                @foreach($pos_groups as $posgroup)
                    <li {{ $loop->iteration==1 ? "class=active" : "" }}><a data-toggle="tab"
                                                                           href="#{{$posgroup->pos_group}}"> {{$posgroup->pos_group}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($pos_groups as $posgroup)

                    <div id="{{$posgroup->pos_group}}"
                         class="tab-pane fade in {{ $loop->iteration==1 ? "active" : "" }} selected-graphs">
                        @include('partials.graphs.'.strtolower($posgroup->pos_group), ['posgroup' =>$posgroup, 'links'=>false])

                    </div>
                @endforeach
            </div>

            <form action="{{ route('graphs/edit') }}" method="POST">
                {{csrf_field()}}

                <div class="col-md-12 graphs-inputs">
                    @foreach($pos_groups as $posgroup)
                        @foreach($posgroup->positions as $position)
                            <input type="hidden" name="pos[{{$position->id}}]" value="{{$position->graph_id}}">
                            @php
                            $allpos[] = $position->id;
                            @endphp
                        @endforeach
                    @endforeach
                    <button type="submit" id="graphs-save"
                            class="waves-effect btn btn-primary btn-lg m-b-30 pull-right">{{ __('messages.save') }}</button>
                </div>
            </form>
            <div class="flex graph-gallery" id="draggable">
                @foreach($graphs as $graph)

                    <div class="col-md-2 graph-card draggable" id="Graph{{$loop->iteration}}" data-id="{{$graph->id}}">
                        <div class="card">
                            <div class="header">
                                <div class="col-md-12">
                                    <h6>{{ __('graphs.project_by') }} {{__('graphs.'.$graph->section)}} </h6>
                                </div>
                            </div>
                            <div class="body">

                                <input type="hidden" name="graph" value="{{ $graph->id }}">

                                <div class="graph">
                                    <input type="hidden" value="{{ $graph->labels }}" class="graph-labels">
                                    <input type="hidden" value="{{ $graph->data }}" class="graph-data">
                                    <div class="ct-chart"></div>
                                </div>

                                <div class="ct-chart-full" style="display:none;">
                                <h2>{{ __('graphs.project_by') }} {{__('graphs.'.$graph->section)}}</h2></div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    </div>
@endsection
@section('scripts')

    <script>


        $(document).ready(function () {

            @if(Session::has('status'))
                swal({
                    title: "Success!",
                    text: "{{ session('status') }}",
                    type: "success",
                    html: true
                });
            @endif

            //Drag and drop
            var draggable = document.getElementById('draggable');
            var container = document.getElementById('drop-container');


            var drake = dragula({
                moves: function (el) {
                    return $(el).hasClass("draggable");
                },
                copy: function (el, source) {

                    return true;
                },
                accepts: function (el, target) {
                    return $(target).hasClass('graph-pos') && $(el).hasClass('draggable');
                },
                revertOnSpill: true
            }).on('drop', function (el, container) {
                var idEl = $(el).data('id');
                $('.graph-pos').not($(container)).each(function (index, otherContainer) {
                    var idContainer = $(container).data('id');
                    var idOtherContainer = $(otherContainer).data('id');

                    if (idEl == idOtherContainer) {
                        //copy the container graph to the position that already has the graph
                        $(otherContainer).html($(container).html());

                        //we put the new id's
                        $(otherContainer).data('id', idContainer);

                        //we change the value of the input hidden
                        $('.graphs-inputs input[name="pos[' + $(otherContainer).data("pos") + ']"]').val($(container).data('id'));
                    }
                });
                $(container).data('id', idEl);
                $('.graphs-inputs input[name="pos[' + $(container).data("pos") + ']"]').val($(el).data('id'));
                $(container).html($(el).find('.ct-chart-full'));
                $(container).find('.ct-chart-full').show();
            });

            drake.containers.push(draggable);
            @foreach($allpos as $pos)
              drake.containers.push(document.getElementById('graph-pos-{!! $pos !!}'));
            @endforeach


            //graphs

            //Little graphs for drag & drop
            var bars = new Chartist.Bar('#Graph1 .ct-chart', {
                labels: JSON.parse($('#Graph1 .graph-labels').val()),
                series: [JSON.parse($('#Graph1 .graph-data').val())]
            }, {width: 200, axisY: {position: 'end'}});


            bars.on('draw', function (context) {
                if (context.type === 'bar') {
                    // With the Chartist.Svg API we can easily set an attribute on our bar that just got drawn
                    context.element.attr({
                        // Now we set the style attribute on our bar to override the default color of the bar. By using a HSL colour we can easily set the hue of the colour dynamically while keeping the same saturation and lightness. From the context we can also get the current value of the bar. We use that value to calculate a hue between 0 and 100 degree. This will make our bars appear green when close to the maximum and red when close to zero.
                        style: 'stroke:{{ $primaryColor }};'
                    });
                }
            });

            var pie = new Chartist.Pie('#Graph2 .ct-chart', {
                labels: JSON.parse($('#Graph2 .graph-labels').val()),
                series: JSON.parse($('#Graph2 .graph-data').val())
            });


            var color = -0.1;
            $(window).resize(function () {
                color = -0.1;
            });

            pie.on('draw', function (context) {
                if (context.type === 'slice') {
                    // With the Chartist.Svg API we can easily set an attribute on our bar that just got drawn
                    context.element.attr({
                        // Now we set the style attribute on our bar to override the default color of the bar. By using a HSL colour we can easily set the hue of the colour dynamically while keeping the same saturation and lightness. From the context we can also get the current value of the bar. We use that value to calculate a hue between 0 and 100 degree. This will make our bars appear green when close to the maximum and red when close to zero.
                        style: 'fill:' + ColorLuminance("{!! $primaryColor !!}", color) + ';'
                    });
                    color = color + 0.1;
                }
            });

            //This graphs are hidden, are for clone to container when you drag & drop

            var fullbars = new Chartist.Bar('#Graph1 .ct-chart-full', {
                labels: JSON.parse($('#Graph1 .graph-labels').val()),
                series: [JSON.parse($('#Graph1 .graph-data').val())]
            }, {height: 300, width: 400});


            fullbars.on('draw', function (context) {
                if (context.type === 'bar') {
                    // With the Chartist.Svg API we can easily set an attribute on our bar that just got drawn
                    context.element.attr({
                        // Now we set the style attribute on our bar to override the default color of the bar. By using a HSL colour we can easily set the hue of the colour dynamically while keeping the same saturation and lightness. From the context we can also get the current value of the bar. We use that value to calculate a hue between 0 and 100 degree. This will make our bars appear green when close to the maximum and red when close to zero.
                        style: 'stroke:{{ $primaryColor }}; stroke-width: 20px;'
                    });
                }
            });

            var fullpie = Chartist.Pie('#Graph2 .ct-chart-full', {
                labels: JSON.parse($('#Graph2 .graph-labels').val()),
                series: JSON.parse($('#Graph2 .graph-data').val())
            }, {height: 300, width: 400});

            fullpie.on('draw', function (context) {
                if (context.type === 'slice') {
                    // With the Chartist.Svg API we can easily set an attribute on our bar that just got drawn
                    context.element.attr({
                        // Now we set the style attribute on our bar to override the default color of the bar. By using a HSL colour we can easily set the hue of the colour dynamically while keeping the same saturation and lightness. From the context we can also get the current value of the bar. We use that value to calculate a hue between 0 and 100 degree. This will make our bars appear green when close to the maximum and red when close to zero.
                        style: 'stroke:#FFFFFF; fill:' + ColorLuminance("{!! $primaryColor !!}", color) + ';'
                    });
                    color = color + 0.1;
                }
                if (context.type === 'label') {
                    context.element.attr({
                        style: 'fill:#FFF;'
                    })
                }

            });


        });


        function ColorLuminance(hex, lum) {

            // validate hex string
            hex = String(hex).replace(/[^0-9a-f]/gi, '');
            if (hex.length < 6) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
            }
            lum = lum || 0;

            // convert to decimal and change luminosity
            var rgb = "#", c, i;
            for (i = 0; i < 3; i++) {
                c = parseInt(hex.substr(i * 2, 2), 16);
                c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
                rgb += ("00" + c).substr(c.length);
            }

            return rgb;
        }

    </script>



@endsection
