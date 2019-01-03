<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
        	{{ __('joesama/project::dashboard.subsidiary.variance') }}
        </h3>
    </div>
    <div class="panel-body">
        <div id="project-variance" style="height: 250px"></div>
    </div>
</div>
@push('content.script')
<script type="text/javascript">
$(document).on('nifty.ready', function () {

    Morris.Bar({
        element: 'project-variance',
        data: @json($variance),
        xkey: 'project',
        ykeys: ['variance'],
        labels: ['Variance'],
        gridEnabled: true,
        gridLineColor: 'rgba(0,0,0,.1)',
        gridTextColor: '#8f9ea6',
        gridTextSize: '8px',
        barColors: ['#f44336'],
        resize:true,
        hideHover: 'auto'
    });

});
</script>
@endpush