@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row" id="group-dashboard">
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-project',['summary' => true])
    </div>
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-contract',['summary' => true])
    </div>
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-task',['summary' => true])
    </div>
    <div class="col-md-3">
    	@include('joesama/project::dashboard.portfolio.panel-issue',['summary' => true])
    </div>
</div>
<div class="row">
	@foreach($corporate as $subs)
	    @include('joesama/project::dashboard.portfolio.panel-summary',[
	    		'title' => data_get($subs,'corporate.name'),
	    		'logo' => data_get($subs,'corporate.logo'),
	    		'panelId' => 'subs'.data_get($subs,'corporate.id'),
	    		'width' => 'col-md-12',
	    		'nextLevel' => handles('joesama/project::dashboard/portfolio/subsidiaries/'.data_get($subs,'corporate.id')),
	    		'summary' => data_get($subs,'summary')
	    	])

	@endforeach
</div>
@endsection
@push('content.script')
<script type="text/javascript">
    $('#group-dashboard').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
</script>
@endpush