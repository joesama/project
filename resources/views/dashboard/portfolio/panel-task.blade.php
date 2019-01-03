<!--Sparkline pie chart -->
<div class="panel panel-danger panel-colorful clearfix">
    <div class="panel-body text-center clearfix">
    <div class="col-sm-{{($summary) ? '12' : '4'}} pad-top text-center">
        <p class="text-sm text-bold text-uppercase">
            {{ __('joesama/project::dashboard.portfolio.task') }}
        </p>
        <div class="text-lg">
            <p class="text-5x text-thin">
                {{ data_get($task,'overdue') }}
            </p>
        </div>
    </div>
    @if(!$summary)
    <div class="col-sm-8"> 
        <div class="pad-all">
            <p class="mar-no">
                <span class="pull-right text-bold">
                    {{ data_get($task,'total') }}
                </span> Total
            </p>
        </div>
        <div class="pad-all">
            <div class="pad-btm">
                @php 
                    $taskTotal = data_get($task,'total');
                    $taskOverdue = data_get($task,'overdue');
                    $taskComplete = data_get($task,'complete');
                    $overdue = ($taskTotal > 0 ) ? round(($taskOverdue/$taskTotal)*100,2) : 0;
                @endphp
                <p class="mar-no">
                    <span class="pull-right text-bold">
                        {{ $taskOverdue }}
                    </span> Overdue
                </p>
                <div class="progress progress-sm">
                    <div style="width: {{$overdue}}%;" class="progress-bar progress-bar-light">
                        <span class="sr-only">{{$overdue}}%</span>
                    </div>
                </div>
            </div>
            <div class="pad-btm">
                @php 
                    $complete = ($taskTotal > 0 ) ? round(($taskComplete/$taskTotal)*100,2) : 0;
                @endphp
                <p class="mar-no">
                    <span class="pull-right text-bold">
                        {{ $taskComplete }}
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
</div>  