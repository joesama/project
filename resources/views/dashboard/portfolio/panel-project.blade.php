<div class="panel">
    <div class="panel-body text-center clearfix pad-no">
        <div class="col-sm-{{($summary) ? '12' : '4'}} pad-top text-center">
            <p class="text-sm text-semibold text-uppercase">
            	{{ __('joesama/project::dashboard.portfolio.project') }}
            </p>
            <div class="text-lg">
                <p class="text-lg text-thin text-main">
                    {{ data_get($project,'total') }}
                </p>
            </div>
        </div>
        @if(!$summary)
        <div class="col-sm-8">  
            <ul class="list-unstyled text-center pad-ver row">
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-primary">
                        {{ data_get($project,'active') }}
                    </span>
                    <p class="text-sm text-primary mar-no">Active</p>
                </li>
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-mint">
                        {{ data_get($project,'closed') }}
                    </span>
                    <p class="text-sm text-mint mar-no">Close</p>
                </li>
            </ul>
            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                <li class="col-xs-6">
                    <span class="text-lg text-semibold text-success">
                        {{ data_get($project,'ontrack') }}
                    </span>
                    <p class="text-sm text-success mar-no">On Schedule</p>
                </li>
                <li class="col-xs-6">
                    <span class="text-lg text-danger text-semibold">
                        {{ data_get($project,'delayed') }}
                    </span>
                    <p class="text-sm text-danger mar-no">Delayed</p>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>