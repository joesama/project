<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
        	{{ __('joesama/project::dashboard.subsidiary.cost') }}
        </h3>
    </div>
    <div class="panel-body">
        <div id="demo-morris-bar" style="height: 250px"></div>
    </div>
</div>
@push('content.script')
<script type="text/javascript">
$(document).on('nifty.ready', function () {
    $('#group-dashboard').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });

    Morris.Bar({
        element: 'demo-morris-bar',
        data: @json($costingName),
        xkey: 'project',
        ykeys: ['planned', 'actual'],
        labels: ['Planned', 'Actual'],
        gridEnabled: true,
        gridLineColor: 'rgba(0,0,0,.1)',
        gridTextColor: '#8f9ea6',
        gridTextSize: '11px',
        barColors: ['#25476a', '#f44336'],
        resize:true,
        hideHover: 'auto'
    });

});
</script>
@endpush