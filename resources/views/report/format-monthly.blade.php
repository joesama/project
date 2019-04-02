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

@includeWhen(
    ($project->active && (data_get($workflow,'current.profile_assign.id') == $profile->id)),
    'joesama/project::manager.project.part.flowProcessing', 
    [
        'workflow' => $workflow
    ]
)

@includeWhen(
    ($project->active && (data_get($workflow,'current.profile_assign.id') != $profile->id )),
    'joesama/project::manager.project.part.flowHistory', 
    [
        'workflow' => $workflow
    ]
)
