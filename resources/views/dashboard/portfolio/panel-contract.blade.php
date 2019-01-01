<div id="demo-panel-network" class="panel">
    <!--Chart information-->
    <div class="panel-body text-center clearfix">
        <div class="row">
            <div class="col-sm-8">
			    <!--chart placeholder-->
			    <div class="pad-top pad-lft">
			        <div id="demo-chart-network" style="height: 100px"></div>
			    </div>
            </div>
			<div class="col-sm-4 pad-top">
                <p class="text-sm text-bold text-uppercase">
                	{{ __('joesama/project::dashboard.portfolio.contract') }}
                </p>
                <div class="text-lg">
                    <div class="media">
                        <div class="media-left">
                            <span class="text-5x text-thin text-main text-right">
                            	{{ data_get($contract,'contract.total.value') }}
                            </span>
                        </div>
                        <div class="media-body">
                            <p class="mar-no text-left">{{ data_get($contract,'contract.total.unit') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('content.script')
<script type="text/javascript">
	
    var upData = [[1, 2], [2, 22], [3, 7], [4, 6], [5, 17], [6, 15], [7, 17], [8, 7], [9, 18], [10, 18], [11, 18], [12, 29], [13, 23], [14, 10], [15, 22], [16, 7], [17, 6], [18, 17], [19, 15], [20, 17], [21, 7], [22, 18], [23, 18], [24, 18], [25, 29], [26, 13], [27, 2], [28, 22], [29, 7], [30, 6], [31, 17], [32, 15], [33, 17], [34, 7], [35, 18], [36, 18], [37, 18], [38, 29], [39, 23], [40, 10], [41, 22], [42, 7], [43, 6], [44, 17], [45, 15], [46, 17], [47, 7], [48, 18], [49, 18], [50, 18], [51, 29], [52, 13], [53, 24]];

    var plot = $.plot('#demo-chart-network', [
        {
            label: 'Project',
            data: upData,
            lines: {
                show: true,
                lineWidth: 1,
                fill: false,
                fillColor: {
                    colors: [{
                        opacity: 0.9
                    }, {
                        opacity: 0.9
                    }]
                }
            },
            points: {
                show: false
            }
        }
        ], {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            },
            shadowSize: 0 // Drawing is faster without shadows
        },
        colors: ['#25476a'],
        legend: {
            show: false,
            position: 'nw',
            margin: [0, 0]
        },
        grid: {
            borderWidth: 0,
            hoverable: true,
            clickable: true
        },
        yaxis: {
            show: false,
            ticks: 5,
            tickColor: 'rgba(0,0,0,.1)'
        },
        xaxis: {
            show: true,
            ticks: 10,
            tickColor: 'transparent'
        },
        tooltip: {
            show: true,
            content: "<div class='flot-tooltip text-center'><h5 class='text-main'>%s</h5>%y.0</div>"
        }
    });

</script>
@endpush