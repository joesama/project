@extends('joesama/entree::layouts.content')
@push('content.style')
<link href="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.css" rel="stylesheet">
@endpush
@section('content')
@section('content')
<div class="row mb-3">
	<div class="col-md-12">
	    <div class="panel" >
	        <div class="panel-body">
		        <div class="col-md-4 text-center pull-right mar-btm"> 
	                <div class="row bord-all">
	                    <div class="col-md-12 text-bold text-center" style="padding: 3px">
	                        {{ strtoupper( __('joesama/project::report.format.monthly') ) }}
	                        {{ strtoupper( '#'.$reportDue ) }}
	                    </div>
	                </div>
	                <div class="row text-thin text-center">
	                    <div class="col-md-4 text-bold bord-hor bord-btm"  style="padding: 3px">
	                        {{ $reportStart->format('j M Y') }}
	                    </div>
	                    <div class="col-md-4 bord-rgt bord-btm"  style="padding: 3px">
	                        {{ __('joesama/project::report.format.through') }}
	                    </div>
	                    <div class="col-md-4 text-bold bord-rgt bord-btm"  style="padding: 3px">
	                        {{ $reportEnd->format('j M Y') }}
	                    </div>
	                </div>
	            </div>
	        	@includeIf('joesama/project::manager.project.part.projectInfo')
	        </div>
			<div class="panel-footer text-right">
		  		@php
		  			$projectUrl = 'manager/project/view/'.$project->corporate_id.'/'.$project->id;
		  			$printUrl = 'report/monthly/form/'.$corporateId.'/'.$projectId.'/'.$reportId.'?print=true';
		  		@endphp
		        @if($printed)
		        <a class="btn btn-info" href="{{ handles($printUrl) }}">
		        	<i class="psi-printer icon-fw"></i>
		        	{{ __('joesama/project::report.print') }}
		        </a>
		        @endif
		        <a class="btn btn-dark" href="{{ handles($projectUrl) }}">
		        	<i class="psi-folder-with-document icon-fw"></i>
		        	{{ __('joesama/project::manager.project.view') }}
		        </a>
		    </div>
	    </div>

		@includeIf('joesama/project::manager.project.part.physical-curve')

    	@includeIf('joesama/project::manager.project.part.financial-curve')

        @foreach($policies as $policyId => $policy)
            @php
                $currentView = 'joesama/project::manager.project.part.'.$policyId;

                $view = 'joesama/project::manager.project.part.table';
            @endphp

            @includeFirst([$currentView,$view],[
                    'table' => ${$policyId.'Table'},
                    'title' => 'joesama/project::manager.'.$policyId.'.list',
                    'tableId' => $policyId
                ])
        @endforeach

        @includeIf('joesama/project::manager.project.part.financial')

		@includeIf('joesama/project::manager.project.part.hse')

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
	</div>
</div>
@endsection
@prepend('content.script')
<script src="https://naver.github.io/billboard.js/release/latest/dist/billboard.pkgd.min.js"></script>
<script type="text/javascript">
    $('.mh-byrow').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
</script>
@stack('datagrid')
@endprepend

