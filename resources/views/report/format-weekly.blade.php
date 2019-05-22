<div class="row bord-all">
	<div class="col-md-2 col-xs-2 bord-rgt text-center ">
		<img class="pad-no img-lg" src="{{ asset(asset(memorize('joesama.logo','packages/joesama/project/img/kub.png'))) }}">
	</div>
	<div class="col-md-10 col-xs-10 text-center text-bold text-3x text-dark pad-all"> 
			{{ __('joesama/project::report.'.request()->segment(2).'.form') }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark" style="break-after: auto;">
	<div class="col-md-2 col-xs-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.company') ) }}
	</div>
	<div class="col-md-5 col-xs-7 text-left text-semibold bord-rgt pad-all"> 
		{{ ucwords( data_get($project,'corporate.name') ) }}
	</div>
	<div class="col-md-5 col-xs-2 text-center"> 
		<div class="row bord-btm">
			<div class="col-md-12  col-xs-10 text-bold text-center" style="padding: 3px">
				{{ strtoupper( __('joesama/project::report.format.'.request()->segment(2)) ) }}
				{{ '#'.strtoupper( $reportDue ) }}
			</div>
		</div>
		<div class="row text-thin text-center">
			<div class="col-md-4  col-xs-4  text-bold bord-rgt"  style="padding: 3px">
				{{ $reportStart->format('j M Y') }}
			</div>
			<div class="col-md-4 col-xs-2 bord-rgt"  style="padding: 3px">
				{{ __('joesama/project::report.format.through') }}
			</div>
			<div class="col-md-4 col-xs-4 text-bold"  style="padding: 3px">
				{{ $reportEnd->format('j M Y') }}
			</div>
		</div>
	</div>
</div>
<div class="row bord-hor bord-btm bg-primary" style="break-after: avoid;">
	<div class="col-md-2 col-xs-2 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.title') ) }}
	</div>
	<div class="col-md-10 col-xs-10 text-left text-bold pad-all">
		{{ ucwords( data_get($project,'name') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm text-dark" style="break-after: avoid;">
	<div class="col-md-10 col-xs-8  text-left text-bold pad-all text-uppercase">
		{{  __('joesama/project::report.format.update') }}
	</div>
	<div class="col-md-1 col-xs-1 text-center text-bold bord-lft pad-all  text-uppercase">
		{{ __('joesama/project::report.format.complete') }}
	</div>
	<div class="col-md-1 col-xs-1 text-center text-bold bord-lft pad-all  text-uppercase">
		{{ __('joesama/project::report.format.indicator') }}
	</div>
</div>
@php
    $task_number = 0;
    $plan_number = 0;
@endphp
@foreach(data_get($project,'task') as $id => $task)
<div class="row bord-hor bord-btm text-dark" style="break-after: auto;">
        <div class="col-md-10  col-xs-8 text-left text-thin pad-all">
                {{ $task_number + 1 }}.&nbsp;
                {{ ucwords(strip_tags(data_get($task,'name'))) }}
                <br>
                <span class="text-muted">
                        &nbsp;&nbsp;{{ ucwords(strip_tags(data_get($task,'description'))) }}
                </span>
        </div>
        <div class="col-md-1 col-xs-1 text-center text-thin bord-lft pad-all">
                {{ data_get($task,'progress.progress') }}
        </div>
        <div class="col-md-1 col-xs-1 text-center text-thin bord-lft pad-all">
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
<div class="row bord-hor bord-btm text-dark" style="break-after: avoid;break-before: auto;">
	<div class="col-md-10  col-xs-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.issue') }}
	</div>
</div>
@foreach(data_get($project,'issue') as $id => $issue)
<div class="row bord-hor bord-btm text-dark" style="break-after: auto;">
	<div class="col-md-10 col-xs-8 text-left text-thin pad-all">
		{{ $id + 1 }}.&nbsp;
		{{ ucwords(data_get($issue,'label')) }}<br>
		<br>
		<span class="text-muted">
			&nbsp;&nbsp;{{ ucwords(strip_tags(data_get($issue,'description'))) }}
		</span>
	</div>
	<div class="col-md-1 col-xs-1 text-center text-thin bord-lft pad-all">
		{{ ucwords(data_get($issue,'progress.description')) }}
	</div>
	<div class="col-md-1 col-xs-1 text-center text-thin bord-lft pad-all">
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
@php
	$breakAfter = (collect(data_get($project,'plan'))->count() > 0) ? 'avoid':'auto';
@endphp
<div class="row bord-hor bord-btm text-dark" style="break-after:{{ $breakAfter }};break-before: auto;">
	<div class="col-md-10 col-sm-10 text-left text-bold pad-all text-uppercase">
		{{ __('joesama/project::report.format.plan.'.request()->segment(2)) }}
	</div>
</div>
@foreach(data_get($project,'plan') as $id => $pending)
<div class="row bord-hor bord-btm text-dark" style="break-after: auto;">
	<div class="col-md-10 col-xs-8 text-left text-thin pad-all">
		{{ $plan_number + 1 }}.&nbsp;
		{{ ucwords(data_get($pending,'name')) }}
		<br>
		<span class="text-muted">
			&nbsp;&nbsp;{{ ucwords(strip_tags(data_get($pending,'description'))) }}
		</span>
	</div>
	<div class="col-md-1 col-xs-1 text-center text-thin bord-lft pad-all">
		{{ data_get($pending,'progress.progress') }}
	</div>
	<div class="col-md-1 col-xs-1 pull-right text-center text-thin bord-lft pad-all">
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
<div class="row bord-hor bord-btm bg-primary" style="break-after: auto;break-before: always;">
	<div class="col-md-12 col-xs-12 text-left text-bold bord-rgt pad-all">
		{{ strtoupper( __('joesama/project::report.format.approval') ) }}
	</div>
</div>
<div class="row bord-hor bord-btm" style="break-after: auto;break-inside: avoid-page;">
	<div class="col-md-12 col-xs-12 text-left text-bold bord-rgt pad-all" id="need_action" style="break-inside: avoid;">

	@includeWhen(
	    ($project->active && (data_get($workflow,'current.profile_assign.id') == $profile->id)),
	    'joesama/project::setup.process.workflow', 
	    [
	        'workflow' => $workflow,
	        'input' => [
	        	'start' => $reportStart->format('Y-m-d'),
	        	'end' => $reportEnd->format('Y-m-d'),
	        	'cycle' => $reportDue
	        ]
	    ]
	)
	
	@includeWhen(
	    ($project->active && (data_get($workflow,'current.profile_assign.id') != $profile->id)),
	    'joesama/project::manager.project.part.flowRecord', 
	    [
	        'records' => $workflow->get('record')
	    ]
	)
	</div>
</div>