<div id="demo-panel-network" class="panel clearfix">
    <!--Chart information-->
    <div class="panel-body text-center clearfix pad-no">
        <div class="row">
			<div class="col-sm-{{($summary) ? '12' : '4'}} pad-top">
                <p class="text-sm text-semibold text-uppercase text-danger">
                    {{ __('joesama/project::dashboard.portfolio.overspent') }}
                </p>
                <div class="text-lg">
                    <div class="media">
                        <div class="media-left" style="width: 95%">
                            <span class="text-2x text-thin text-right  text-danger">
                            	{{ data_get($contract,'total.value') }}
                            </span>
                        </div>
                        <div class="media-body" style="width: 5%">
                            <p class="mar-no text-left text-danger">
                            {{ data_get($contract,'total.unit') }}
                        	</p>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$summary)
            <div class="col-sm-8">
			    <!--chart placeholder-->
			    <div class="pad-top pad-lft">
			        <div id="chart-overspent" style="height: 100px"></div>
			    </div>
            </div>
            @endif
        </div>
    </div>
</div>
@php
	$chart = data_get($contract,'chartData')
@endphp
@if(!$summary)
@push('content.script')
<script type="text/javascript">
	
    var upData = @json($chart);

    var plot = $.plot('#chart-overspent', [
        {
            label: '{{ __('joesama/project::dashboard.portfolio.overspent') }}',
            data: upData,
            lines: {
                show: true,
                lineWidth: 1,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.3
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
                show: false
            },
            shadowSize: 0 // Drawing is faster without shadows
        },
        colors: ['#f44336'],
        legend: {
            show: true,
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
            show: false,
            ticks: 20,
            tickColor: 'transparent'
        },
        tooltip: {
            show: true,
            content: "<div class='flot-tooltip text-center'><h5 class='text-main'>%s</h5>%y.0</div>"
        }
    });

</script>
@endpush
@endif