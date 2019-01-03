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
<div class="row">
	<div class="col-md-8">
		@include('joesama/project::dashboard.portfolio.panel-costing')
	</div>
	<div class="col-md-4">		
    	@include('joesama/project::dashboard.portfolio.panel-variance')
	</div>
	<div class="col-md-4">
		@include('joesama/project::dashboard.portfolio.panel-health')
	</div>
	<div class="col-md-4">
		@include('joesama/project::dashboard.portfolio.panel-subtask')
	</div>
	<div class="col-md-4">
		@include('joesama/project::dashboard.portfolio.panel-subissue')
	</div>
</div>
@endsection
@push('content.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
@endpush