@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row" id="group-dashboard">
    <div class="col-md-2">
    	@include('joesama/project::dashboard.portfolio.panel-project',['summary' => true])
    </div>
    <div class="col-md-2">
    	@include('joesama/project::dashboard.portfolio.panel-task',['summary' => true])
    </div>
    <div class="col-md-2">
    	@include('joesama/project::dashboard.portfolio.panel-issue',['summary' => true])
    </div>
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-contract',['summary' => true])
    </div>
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-overspent',['summary' => true])
    </div>
</div>
<div class="row pad-no">
    @include('joesama/project::dashboard.portfolio.panel-summary',[
    		'title' => __('joesama/project::dashboard.portfolio.master'),
    		'panelId' => 'psummary',
    		'summary' => $summary,
    		'nextLevel' => handles('joesama/project::dashboard/portfolio/group/'.$corporateId),
    	])
</div>
@endsection
@push('content.script')
<script type="text/javascript">
$(document).on('nifty.ready', function () {
    $('#group-dashboard').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
});
</script>
@endpush