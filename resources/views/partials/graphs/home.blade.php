<div class="row align-center" id="drop-container">

    <?php


    if (isset($posgroup->positions)) {

        $graphs = $posgroup->positions;
    } else {
        $graphs = $posgroup;
    }

    ?>

    @foreach($graphs as $pos)
        <?php $graph = $pos->graph()->first() ?>
        <?php
            $sColumnClass="col-lg-6";
            if(count(json_decode($pos->graph->labels))>12)
            {
                $sColumnClass="col-lg-12";
            }
        ?>
        <!--div class="col-lg-6 graph-pos" id="graph-pos-{{ $pos->id }}" data-pos="{{ $pos->id }}"
             data-id="{{ $graph->id }}"-->
         <div class="{{ $sColumnClass }} graph-pos" id="graph-pos-{{ $pos->id }}" data-pos="{{ $pos->id }}"
                 data-id="{{ $graph->id }}">
            
                <h2 class="graph-tittle">{{ __('graphs.project_by') }}  {{__('graphs.'.$graph->section)}}</h2>
                <div id="pos{{$pos->id}}" class="text-center"></div>
        </div>
    @endforeach
</div>



@section('scripts')
    <script src="front/plugins/chartist/chartist.min.js"></script>
    <script src="front/plugins/chartist/chartist-plugin-tooltip.min.js"></script>
    <script>

    @foreach($graphs as $pos)

        var labels_{{$pos->graph->label_suffix}} = JSON.parse('{!! $pos->graph->labels !!}');
        var data_{{$pos->graph->label_suffix}} = JSON.parse('{!!  $pos->graph->data !!}');
        var bars;
        var j = 0;
        var i = 0;
        var k = 0;

        var color = -0.1;
        $(window).resize(function () {
            color = -0.1;
        });

        switch ("{{ $pos->graph->graph_type }}") {
            case 'bar':
                var labelsbar = labels_{{$pos->graph->label_suffix}};
                var defaultWitdth = 400;
                if (labelsbar.length>12)
                {
                    defaultWitdth = 1200;
                }
                bars = new Chartist.Bar('#pos{!! $pos->id !!}', {
                    labels: labels_{{$pos->graph->label_suffix}},
                    series: [data_{{$pos->graph->label_suffix}}]
                }, {
                    plugins: [
                        Chartist.plugins.tooltip({
                            transformTooltipTextFnc: function(value) {
                                return false;
                            }
                        })
                    ], height: 300, width: defaultWitdth, axisY: {onlyInteger: true}});

                bars.on('draw', function (context) {

                    if (context.type === 'bar') {
                        context.element.attr({
                            style: 'stroke:' + ColorLuminance("{!! $primaryColor !!}", 0) + '; stroke-width: 20px;',
                            href: '/project-info/sector/' + labelsbar[i],
                        });

                        i++;
                    }
                });

                break;
            case 'pie':
                var sum = function(a, b) { return a + b };
                var labelspie = labels_{{$pos->graph->label_suffix}};
                var chart = new Chartist.Pie('#pos{!! $pos->id !!}', {
                    series: data_{{$pos->graph->label_suffix}},
                }, {
                    plugins: [
                        Chartist.plugins.tooltip({
                            transformTooltipTextFnc: function(value) {
                                return false;
                            }
                        })
                    ],
                    height: 300,
                    labelInterpolationFnc: function(value, index) {
                        return labelspie[index] + ' ' + Math.round(value / data_{{$pos->graph->label_suffix}}[index].total * 100) + '%';
                    }
                });


                chart.on('draw', function (context) {

                    if (context.type === 'label') {
                        context.element.attr({
                            href: '/project-info/stage/' + labelspie[j],
                            style: 'fill:#FFF;'
                        });
                        j++;
                    }
                    if (context.type === 'slice') {
                        context.element.attr({
                            href: '/project-info/stage/' + labelspie[k],
                            style: 'stroke:#FFFFFF; fill:' + ColorLuminance("{!! $primaryColor !!}", color) + ';'
                        });
                        k++;

                        color = color + 0.1;
                    }
                });

                break;
        }
        @endforeach

        @if(isset($links))
            $(document).ready(function () {
                $(document).on('click', '.ct-bar', function () {
                    if (typeof $(this).attr('href') != "undefined") {
                        redirect($(this).attr('href'));
                    }
                });

                $(document).on('click', '.ct-label', function () {
                    redirect($(this).attr('href'));
                });

                $(document).on('click', '.ct-series path', function () {
                    if (typeof $(this).attr('href') != "undefined") {
                        redirect($(this).attr('href'));
                    }
                });

            });

            function redirect(href) {
                location.href = href;
            }
        @endif



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

    @parent
@endsection
