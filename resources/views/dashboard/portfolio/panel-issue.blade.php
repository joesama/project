<!--Sparkline pie chart -->
<div class="panel panel-mint panel-colorful clearfix">
    <div class="col-sm-{{($summary) ? '12' : '4'}} pad-top text-center">
        <div class="text-lg">
            <p class="text-5x text-thin">
                {{ data_get($issue,'open') }}
            </p>
        </div>
        <p class="text-sm text-bold text-uppercase">
            {{ __('joesama/project::dashboard.portfolio.issue') }}
        </p>
    </div>
    @if(!$summary)
    <div class="col-sm-8"> 
        <div class="pad-all">
            <p class="mar-no">
                <span class="pull-right text-bold">
                    {{ data_get($issue,'total') }}
                </span> Total
            </p>
        </div>
        <div class="pad-all">
            <div class="pad-btm">
                @php 
                    $issueTotal = data_get($issue,'total');
                    $issueOpen = data_get($issue,'open');
                    $issueCompleted = data_get($issue,'complete');
                    $open = ($issueTotal > 0 ) ? round(($issueOpen/$issueTotal)*100,2) : 0;
                @endphp
                <p class="mar-no">
                    <span class="pull-right text-bold">
                        {{ $issueOpen }}
                    </span> Open
                </p>
                <div class="progress progress-sm">
                    <div style="width: {{$open}}%;" class="progress-bar progress-bar-warning">
                        <span class="sr-only">{{$open}}%</span>
                    </div>
                </div>
            </div>
            <div class="pad-btm">
                @php 
                    $complete = ($issueTotal > 0 ) ? round(($issueCompleted/$issueTotal)*100,2) : 0;
                @endphp
                <p class="mar-no">
                    <span class="pull-right text-bold">
                        {{ $issueCompleted }}
                    </span> Completed
                </p>
                <div class="progress progress-sm">
                    <div style="width: {{$complete}}%;" class="progress-bar progress-bar-success">
                        <span class="sr-only">{{$complete}}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>  