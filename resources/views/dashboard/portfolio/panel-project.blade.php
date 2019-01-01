<div class="panel">
    <div class="panel-body text-center clearfix">
        <div class="col-sm-4 pad-top">
            <div class="text-lg">
                <p class="text-5x text-thin text-main">
                    {{ data_get($project,'project.total') }}
                </p>
            </div>
            <p class="text-sm text-bold text-uppercase">
            	{{ __('joesama/project::dashboard.portfolio.project') }}
            </p>
        </div>
        <div class="col-sm-8">  
            <ul class="list-unstyled text-center pad-ver row">
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-main">
                        {{ data_get($project,'project.active') }}
                    </span>
                    <p class="text-sm text-muted mar-no">Active</p>
                </li>
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-main">
                        {{ data_get($project,'project.closed') }}
                    </span>
                    <p class="text-sm text-muted mar-no">Close</p>
                </li>
            </ul>
            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-main">
                        {{ data_get($project,'project.ontrack') }}
                    </span>
                    <p class="text-sm text-muted mar-no">On Schedule</p>
                </li>
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-main">
                        {{ data_get($project,'project.delayed') }}
                    </span>
                    <p class="text-sm text-muted mar-no">Delayed</p>
                </li>
            </ul>
        </div>
    </div>
</div>