<div class="row">
	<div class="col-md-1">&nbsp;</div>
    <div class="col-md-2">
        <div class="panel panel-warning panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-project icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
				  	@if(request()->segment(1) == 'subsidiaries')
				  		{{ collect($project)->count()}}
				  	@else
				  	{{ config('joesama/project::data.portfolio.project.group') }}
				  	@endif
                </p>
                <p class="mar-no">{{ __('joesama/project::portfolio.portfolio.project') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-info panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-money icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
                @if(request()->segment(1) == 'subsidiaries')
		  		{{ collect($project)->sum('planned')}}&nbsp;K
			  	@else
			  	{{ config('joesama/project::data.portfolio.contract.group') }}&nbsp;M
			  	@endif
			  </p>
                <p class="mar-no">
                	{{ __('joesama/project::portfolio.portfolio.contract') }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-mint panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-dollar-sign icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
	                @if(request()->segment(1) == 'subsidiaries')
				  	{{ collect($project)->sum('planned') - collect($project)->sum('actual') }}&nbsp;K
				  	@else
				  	{{ config('joesama/project::data.portfolio.budget.group') }}&nbsp;K
				  	@endif
				  </p>
                <p class="mar-no">
					{{ __('joesama/project::portfolio.portfolio.over') }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-danger panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-list-view icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
			  	@if(request()->segment(1) == 'subsidiaries')
			  		{{ collect($project)->sum('issue')}}
			  	@else
			  	{{ config('joesama/project::data.portfolio.issue.group') }}
			  	@endif
            	</p>
                <p class="mar-no">
					{{ __('joesama/project::portfolio.portfolio.issue') }}
                </p>
            </div>
        </div>
    </div>
	<div class="col-md-2">
        <div class="panel panel-pink panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-overtime icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold">
		        	@if(request()->segment(1) == 'subsidiaries')
				  		{{ collect($project)->sum('task')}}
				  	@else
				  	{{ config('joesama/project::data.portfolio.task.group') }}
				  	@endif
			  	</p>
                <p class="mar-no">
				{{ __('joesama/project::portfolio.portfolio.task') }}
                </p>
            </div>
        </div>
    </div>
	<div class="col-md-1"></div>
</div>