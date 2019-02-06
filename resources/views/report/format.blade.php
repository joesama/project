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
	<div class="col-md-12 text-left text-bold bord-rgt pad-all" id="need_action">
		@php
			$type = (request()->segment(2) == 'weekly') ? 'report' : 'card';

			$record = collect(data_get($project,$type))->where('id',request()->segment(6))->first();

			$firstStep = $workflow->pluck('step')->first();

			$currentAction = $workflow->where('profile.user_id',auth()->id())
			              ->where("step", (!is_null($record)) ? data_get($record,'need_step') : $firstStep )
			              ->first();

			$action = route('api.workflow.process',[$corporateId,$projectId]);
			$sliceIndex = $workflow->pluck('step')->search(data_get($record,'need_step'));
			$next = $workflow->slice($sliceIndex+1,1)->first();
			$back = $workflow->first();

			$allTrails = data_get($record,'workflow');
			$profileRole = data_get($currentAction,'profile.pivot.role_id');

	    @endphp
	    @if(!is_null($allTrails))
	        @foreach($allTrails as $trail)
	          @include('joesama/project::report.workflow.panel-info',[
	            'status' => data_get($trail,'state'),
	            'record' => $trail,
	            'profile' => data_get($trail,'profile'),
	          ])
	        @endforeach
        @endif
	    @if( $currentAction )
			@include('joesama/project::report.workflow.panel-form',[
			'back_state' => data_get($back,'step'),
			'state' => data_get($currentAction,'step'),
			'need_action' => data_get($next,'profile.id'),
			'need_step' => data_get($next,'step'),
			'status' => data_get($currentAction,'status'),
			'profile' => data_get($currentAction,'profile'),
			'back_action' => ($firstStep != data_get($record,'need_step') && $profileRole != 2) ? data_get($back,'profile.id') : FALSE,
			'back_step' => data_get($back,'step'),
			'back_status' => 'rejected',
			])
        @endif
	</div>
</div>