<div class="row bord-all">
	<div class="col-md-2 col-xs-2 bord-rgt text-center ">
		<img class="pad-no img-lg" src="{{ asset('packages/joesama/project/img/kub.png') }}">
	</div>
	<div class="col-md-10 col-xs-10 text-center text-bold text-3x text-dark pad-all"> 
			{{ __('joesama/project::report.'.request()->segment(2).'.form') }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-2 col-xs-2 text-center text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.dept') ) }}
	</div>
	<div class="col-md-5 col-xs-5 text-center text-semibold bord-rgt pad-all"> 
		{{ __('joesama/project::report.format.mo') }}
	</div>
	<div class="col-md-5 col-xs-5 text-center"> 
		<div class="row bord-btm">
			<div class="col-md-12  col-xs-12 text-bold text-center" style="padding: 3px">
				{{ strtoupper( __('joesama/project::report.format.'.request()->segment(2)) ) }}
				{{ '#'.strtoupper( $reportDue ) }}
			</div>
		</div>
		<div class="row text-thin text-center">
			<div class="col-md-4  col-xs-4  text-bold bord-rgt"  style="padding: 3px">
				{{ $reportStart }}
			</div>
			<div class="col-md-4 col-xs-4 bord-rgt"  style="padding: 3px">
				{{ __('joesama/project::report.format.through') }}
			</div>
			<div class="col-md-4 col-xs-4  text-bold"  style="padding: 3px">
				{{ $reportEnd }}
			</div>
		</div>
	</div>
</div>
<div class="row bord-hor bord-btm bg-primary" style="page-break-after: auto;">
	<div class="col-md-2 col-xs-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.company') ) }}
	</div>
	<div class="col-md-10 col-xs-10 text-left text-bold pad-all">
		{{ ucwords( data_get($project,'corporate.name') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm bg-primary" style="page-break-after: auto;">
	<div class="col-md-2 col-xs-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.title') ) }}
	</div>
	<div class="col-md-10 col-xs-10 text-left text-bold pad-all">
		{{ ucwords( data_get($project,'name') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-10 col-xs-9  text-left text-bold pad-all text-uppercase">
		{{  __('joesama/project::report.format.update') }}
	</div>
	<div class="col-md-1 col-xs-3 text-center text-bold bord-lft pad-all  text-uppercase">
		{{ __('joesama/project::report.format.complete') }}
	</div>
	<div class="col-md-1 col-xs-3 text-center text-bold bord-lft pad-all  text-uppercase">
		{{ __('joesama/project::report.format.indicator') }}
	</div>
</div>
@php
    $task_number = 0;
    $plan_number = 0;
@endphp
@foreach(data_get($project,'task') as $id => $task)
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
        <div class="col-md-10  col-xs-9 text-left text-thin pad-all">
                {{ $task_number + 1 }}.&nbsp;
                {{ ucwords(data_get($task,'name')) }}
                <br>
                <span class="text-muted">
                        &nbsp;&nbsp;{{ ucwords(strip_tags(data_get($task,'description'))) }}
                </span>
        </div>
        <div class="col-md-1 col-xs-2 text-center text-thin bord-lft pad-all">
                {{ data_get($task,'progress.progress') }}
        </div>
        <div class="col-md-1 col-xs-2 text-center text-thin bord-lft pad-all">
                @php
                    $color = data_get($task,'indicator.description');
                    if(strtoupper($color) == strtoupper('merah') || strtoupper($color) == strtoupper('red')){
                        $bgcolor = '#cc0000';
                    }elseif(strtoupper($color) == strtoupper('kuning') || strtoupper($color) == strtoupper('yellow')){
                        $bgcolor = '#ffff00';
                    }else{
                        $bgcolor = '#00ff33';
                    }
                    $task_number = $task_number + 1;
                @endphp
                <span style="height: 25px;width: 25px;background-color: {{$bgcolor}};border-radius: 50%;display:inline-block;"></span>
        </div>
</div>
@endforeach
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-10  col-xs-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.issue') }}
	</div>
</div>
@foreach(data_get($project,'issue') as $id => $issue)
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-10 col-xs-9 text-left text-thin pad-all">
		{{ $id + 1 }}.&nbsp;
		{{ ucwords(data_get($issue,'label')) }}<br>
		<br>
		<span class="text-muted">
			&nbsp;&nbsp;{{ ucwords(strip_tags(data_get($issue,'description'))) }}
		</span>
	</div>
	<div class="col-md-1 col-xs-2 text-center text-thin bord-lft pad-all">
		{{ ucwords(data_get($issue,'progress.description')) }}
	</div>
	<div class="col-md-1 col-xs-2 text-center text-thin bord-lft pad-all">
                @php
                    $color = data_get($issue,'indicator.description');
                    if(strtoupper($color) == strtoupper('merah') || strtoupper($color) == strtoupper('red')){
                        $bgcolor = '#cc0000';
                    }elseif(strtoupper($color) == strtoupper('kuning') || strtoupper($color) == strtoupper('yellow')){
                        $bgcolor = '#ffff00';
                    }else{
                        $bgcolor = '#00ff33';
                    }
                @endphp
                <span style="height: 25px;width: 25px;background-color: {{$bgcolor}};border-radius: 50%;display:inline-block;"></span>
	</div>
</div>
@endforeach
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-10 col-sm-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.plan.'.request()->segment(2)) }}
	</div>
</div>
@php
	$pendingTask = data_get($project,'task')->filter(function($task, $key){
		return data_get($task,'progress.progress') != 100;
	});
@endphp
@foreach($pendingTask as $id => $pending)
<div class="row bord-hor bord-btm text-dark" style="page-break-after: auto;">
	<div class="col-md-10 col-xs-9 text-left text-thin pad-all">
		{{ $plan_number + 1 }}.&nbsp;
		{{ ucwords(data_get($pending,'name')) }}
		<br>
		<span class="text-muted">
			&nbsp;&nbsp;{{ ucwords(strip_tags(data_get($pending,'description'))) }}
		</span>
	</div>
	<div class="col-md-1 col-xs-2 text-center text-thin bord-lft pad-all">
		{{ data_get($pending,'progress.progress') }}
	</div>
	<div class="col-md-1 col-xs-2 pull-right text-center text-thin bord-lft pad-all">
		@php
            $color = data_get($pending,'indicator.description');
            if(strtoupper($color) == strtoupper('merah') || strtoupper($color) == strtoupper('red')){
                $bgcolor = '#cc0000';
            }elseif(strtoupper($color) == strtoupper('kuning') || strtoupper($color) == strtoupper('yellow')){
                $bgcolor = '#ffff00';
            }else{
                $bgcolor = '#00ff33';
            }
            $plan_number = $plan_number + 1;
        @endphp
        <span style="height: 25px;width: 25px;background-color: {{$bgcolor}};border-radius: 50%;display:inline-block;"></span>
	</div>
</div>
@endforeach
<div class="row bord-hor bord-btm bg-primary" style="page-break-after: auto;">
	<div class="col-md-12 col-xs-12 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.approval') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm" style="page-break-after: auto;page-break-inside: avoid;">
	<div class="col-md-12 col-xs-12 text-left text-bold bord-rgt pad-all" id="need_action">
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