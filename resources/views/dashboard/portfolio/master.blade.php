@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3" id="group-dashboard">
    <div class="col-md-4">
    	@include('joesama/project::dashboard.portfolio.panel-project',['summary' => false])
    </div>
    <div class="col-md-4">
    	@include('joesama/project::dashboard.portfolio.panel-task',['summary' => false])
    </div>
    <div class="col-md-4">
    	@include('joesama/project::dashboard.portfolio.panel-issue',['summary' => false])
    </div>
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-contract',['summary' => false])
    </div>
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-overspent',['summary' => false])
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