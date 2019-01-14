<div class="row bord-all">
	<div class="col-md-2 bord-rgt">
		<img class="pad-no" width="100%" height="100%" src="{{ asset('packages/joesama/project/img/kub.png') }}">
	</div>
	<div class="col-md-10 text-center text-bold text-3x text-dark pad-all"> 
			{{ __('joesama/project::report.'.request()->segment(2).'.form') }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark">
	<div class="col-md-2 text-center text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.dept') ) }}
	</div>
	<div class="col-md-5 text-center text-semibold bord-rgt pad-all"> 
		{{ __('joesama/project::report.format.mo') }}
	</div>
	<div class="col-md-5 text-center"> 
		<div class="row bord-btm">
			<div class="col-md-12 text-bold text-center" style="padding: 3px">
				{{ strtoupper( __('joesama/project::report.format.'.request()->segment(2)) ) }}
				{{ strtoupper( $reportDue ) }}
			</div>
		</div>
		<div class="row text-thin text-center">
			<div class="col-md-4 text-bold bord-rgt"  style="padding: 3px">
				{{ $reportStart }}
			</div>
			<div class="col-md-4 bord-rgt"  style="padding: 3px">
				{{ __('joesama/project::report.format.through') }}
			</div>
			<div class="col-md-4 text-bold"  style="padding: 3px">
				{{ $reportEnd }}
			</div>
		</div>
	</div>
</div>
<div class="row bord-hor bord-btm bg-primary">
	<div class="col-md-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.company') ) }}
	</div>
	<div class="col-md-10 text-left text-bold pad-all">
		{{ data_get($project,'corporate.name') }}
	</div>
</div>
<div class="row bord-hor bord-btm bg-primary">
	<div class="col-md-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.title') ) }}
	</div>
	<div class="col-md-10 text-left text-bold pad-all">
		{{ data_get($project,'name') }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark">
	<div class="col-md-10 text-left text-bold pad-all text-uppercase">
		{{  __('joesama/project::report.format.update') }}
	</div>
	<div class="col-md-2 text-center text-bold bord-hor pad-all  text-uppercase">
		{{ __('joesama/project::report.format.complete') }}
	</div>
</div>
@foreach(data_get($project,'task') as $id => $task)
<div class="row bord-hor bord-btm text-dark">
	<div style="width: 40px" class="col-md-1 text-center text-bold bord-rgt pad-all">
		{{ $id + 1 }}
	</div>
	<div class="col-md-9 text-left text-thin pad-all">
		{{ ucwords(data_get($task,'name')) }}
	</div>
	<div class="col-md-2 pull-right text-center text-thin bord-hor pad-all">
		{{ data_get($task,'progress.progress') }}
	</div>
</div>
@endforeach
<div class="row bord-hor bord-btm text-dark">
	<div class="col-md-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.issue') }}
	</div>
</div>
@foreach(data_get($project,'issue') as $id => $issue)

<div class="row bord-hor bord-btm text-dark">
	<div style="width: 40px" class="col-md-1 text-center text-bold bord-rgt pad-all">
		{{ $id + 1 }}
	</div>
	<div class="col-md-9 text-left text-thin pad-all">
		{{ ucwords(data_get($issue,'description')) }}
	</div>
	<div class="col-md-2 pull-right text-center text-thin bord-hor pad-all">
		{{ ucwords(data_get($issue,'progress.description')) }}
	</div>
</div>
@endforeach
<div class="row bord-hor bord-btm text-dark">
	<div class="col-md-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.plan.'.request()->segment(2)) }}
	</div>
</div>
@php
	$pendingTask = data_get($project,'task')->filter(function($task, $key){
		return data_get($task,'progress.progress') != 100;
	});
@endphp
@foreach($pendingTask as $id => $pending)
<div class="row bord-hor bord-btm text-dark">
	<div style="width: 40px" class="col-md-1 text-center text-bold bord-rgt pad-all">
		{{ $id + 1 }}
	</div>
	<div class="col-md-9 text-left text-thin pad-all">
		{{ ucwords(data_get($pending,'name')) }}
	</div>
	<div class="col-md-2 pull-right text-center text-thin bord-hor pad-all">
		{{ data_get($pending,'progress.progress') }}
	</div>
</div>
@endforeach
<div class="row bord-hor bord-btm bg-primary">
	<div class="col-md-12 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.approval') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm">
	<div class="col-md-12 text-left text-bold bord-rgt pad-all">
		@foreach($workflow as $state => $workflow)
			@if( ( is_null( data_get($workflow,'weekly') ) || is_null( data_get($workflow,'monthly') ) )  && $state == "pm")
			  @include('joesama/project::report.workflow.panel-form',[
			      'state' => $state,
			      'status' => data_get($workflow,'status'),
			      'profile' => data_get($workflow,'profile'),
			    ])
			@elseif( !is_null( data_get($workflow,'weekly') ) || !is_null( data_get($workflow,'monthly') ) )
			  @include('joesama/project::report.workflow.panel-info',[
			      'state' => $state,
			      'status' => data_get($workflow,'status'),
			      'profile' => data_get($workflow,'profile'),
			    ])
			@endif
		@endforeach
	</div>
</div>