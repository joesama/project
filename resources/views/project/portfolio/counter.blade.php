<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-6">
		<div class="card text-center">
		  <div class="card-body font-weight-bold" style="font-size: 50px">
		  	@if(request()->segment(1) == 'subsidiaries')
		  		{{ collect($project)->count()}}
		  	@else
		  	{{ config('joesama/project::data.portfolio.project.group') }}
		  	@endif
		  </div>
		  <div class="card-footer font-weight-bold text-light bg-dark">
		    {{ __('joesama/project::portfolio.portfolio.project') }}
		  </div>
		</div>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-6">
		<div class="card text-center">
		  <div class="card-body font-weight-bold" style="font-size: 50px">
		  	@if(request()->segment(1) == 'subsidiaries')
		  		{{ collect($project)->sum('planned')}}&nbsp;K
		  	@else
		  	{{ config('joesama/project::data.portfolio.contract.group') }}&nbsp;M
		  	@endif
		  </div>
		  <div class="card-footer font-weight-bold text-light bg-dark">
		    {{ __('joesama/project::portfolio.portfolio.contract') }}
		  </div>
		</div>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-6">
		<div class="card text-center">
		  <div class="card-body font-weight-bold" style="font-size: 50px">
		  	@if(request()->segment(1) == 'subsidiaries')
		  	{{ collect($project)->sum('planned') - collect($project)->sum('actual') }}&nbsp;K
		  	@else
		  	{{ config('joesama/project::data.portfolio.budget.group') }}&nbsp;K
		  	@endif
		  </div>
		  <div class="card-footer font-weight-bold text-light bg-dark">
		    {{ __('joesama/project::portfolio.portfolio.over') }}
		  </div>
		</div>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-6">
		<div class="card text-center">
		  <div class="card-body font-weight-bold" style="font-size: 50px">
		  	@if(request()->segment(1) == 'subsidiaries')
		  		{{ collect($project)->sum('issue')}}
		  	@else
		  	{{ config('joesama/project::data.portfolio.issue.group') }}
		  	@endif
		  </div>
		  <div class="card-footer font-weight-bold text-light bg-dark">
		    {{ __('joesama/project::portfolio.portfolio.issue') }}
		  </div>
		</div>
	</div>
	<div class="col-lg-2 col-md-2 col-sm-6">
		<div class="card text-center">
		  <div class="card-body font-weight-bold" style="font-size: 50px">
		  	@if(request()->segment(1) == 'subsidiaries')
		  		{{ collect($project)->sum('task')}}
		  	@else
		  	{{ config('joesama/project::data.portfolio.task.group') }}
		  	@endif
		  </div>
		  <div class="card-footer font-weight-bold text-light bg-dark">
		    {{ __('joesama/project::portfolio.portfolio.task') }}
		  </div>
		</div>
	</div>
</div>