<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
        	{{ __('joesama/project::dashboard.subsidiary.task') }}
        </h3>
    </div>
    <div class="panel-body">
        <div id="project-task" class="morris-donut" style="height: 250px"></div>
    </div>
</div>
@push('content.script')
<script type="text/javascript">
$(document).on('nifty.ready', function () {

    Morris.Donut({
        element: 'project-task',
        data: @json($pertask),
        colors: [
            '#03a9f4',
            '#476a25',
            '#26256a',
            '#48256a',
            '#256a6a',
            '#ec407a',
            '#6a4825',
            '#d8dfe2'
        ],
        resize:true
    });

});
</script>
@endpush