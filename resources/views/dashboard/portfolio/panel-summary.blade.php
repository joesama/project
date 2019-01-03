<div class="{{ isset($width) ? 'col-md-6' : 'col-md-12' }}">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-primary" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-primary collapsed" data-panel="minmax" data-target="#{{$panelId}}" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">
          @if(isset($nextLevel))
          <a class="add-tooltip text-semibold" data-toggle="tooltip" data-container="body" data-placement="right" data-original-title="{{ $title }} {{ (isset($nextTitle)) ? $nextTitle : '' }}" href="{{ $nextLevel }}">
            {{ $title }}<i class="psi-magnifi-glass-plus icon-fw"></i>
          </a>
          @else
          {{ $title }}
          @endif
        </h3>
    </div>
    <!--Panel body-->
    <div class="collapse in" id="{{$panelId}}">
      <div class="panel-body">
        <div class="row">
          <div class="col-md-8">
          @if(isset($logo))
          <img class="bg-light mar-rgt" src="{{ asset(memorize('threef.logo',$logo)) }}" alt="logo" style="max-height: 50px;max-width: 100px">
          @endif
            <div id="{{$panelId}}-area"></div>
          </div>
          <div class="col-md-4">
            <div class="row mar-btm">
                <div class="col-lg-12 pad-btm text-center">
                    <div class="text-lg">
                        <p class="text-2x text-thin">
                            <i class="pci-caret-down text-success mar-all"></i>
                            <span class="text-3x text-thin">
                              {{ array_get($summary,'issue.open') }}
                            </span>
                        </p>
                    </div>
                    <p class="text-uppercase text-bold text-main">
                      {{ __('joesama/project::dashboard.portfolio.gp') }}
                    </p>
                </div>
            </div>
            <div class="row mar-btm">
              <div class="col-lg-12">
                  <p class="text-uppercase text-bold text-main">
                    {{ __('joesama/project::dashboard.portfolio.task') }}
                  </p>
                  <ul class="list-unstyled">
                      <li class="pad-btm">
                          @php 
                              $totalTask = array_get($summary,'task.total');
                              $overdueTask = array_get($summary,'task.overdue');
                              $completeTask = array_get($summary,'task.complete');
                              $overdue = ($totalTask > 0) ? round(($overdueTask/$totalTask)*100,2) : 0;
                          @endphp
                          <div class="clearfix">
                              <p class="pull-left mar-no">Overdue</p>
                              <p class="pull-right mar-no">{{$overdue}}%</p>
                          </div>
                          <div class="progress progress-sm">
                              <div class="progress-bar progress-bar-danger" style="width: {{$overdue}}%;">
                                  <span class="sr-only">{{$overdue}}%</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          @php 
                              $complete = ($totalTask > 0) ? round(($completeTask/$totalTask)*100,2) : 0;
                          @endphp
                          <div class="clearfix">
                              <p class="pull-left mar-no">Complete</p>
                              <p class="pull-right mar-no">{{$complete}}%</p>
                          </div>
                          <div class="progress progress-sm">
                              <div class="progress-bar progress-bar-success" style="width: {{$complete}}%;">
                                  <span class="sr-only">{{$complete}}%</span>
                              </div>
                          </div>
                      </li>
                  </ul>
              </div>
            </div>
            <div class="row mar-btm">
              <div class="col-lg-12">
                  <p class="text-uppercase text-bold text-main">
                    {{ __('joesama/project::dashboard.portfolio.issue') }}
                  </p>
                  <ul class="list-unstyled">
                      <li class="pad-btm">
                          @php 
                              $totalIssue = array_get($summary,'issue.total');
                              $openIssue = array_get($summary,'issue.open');
                              $completeIssue = array_get($summary,'issue.complete');
                              $open = ($totalIssue > 0) ? round(($openIssue/$totalIssue )*100,2) : 0;
                          @endphp
                          <div class="clearfix">
                              <p class="pull-left mar-no">Open</p>
                              <p class="pull-right mar-no">{{$open}}%</p>
                          </div>
                          <div class="progress progress-sm">
                              <div class="progress-bar progress-bar-danger" style="width: {{$open}}%;">
                                  <span class="sr-only">{{$open}}%</span>
                              </div>
                          </div>
                      </li>
                      <li>
                          @php 
                              $complete = ($totalIssue > 0) ? round(($completeIssue/$totalIssue)*100,2) : 0;
                          @endphp
                          <div class="clearfix">
                              <p class="pull-left mar-no">Complete</p>
                              <p class="pull-right mar-no">{{$complete}}%</p>
                          </div>
                          <div class="progress progress-sm">
                              <div class="progress-bar progress-bar-success" style="width: {{$complete}}%;">
                                  <span class="sr-only">{{$complete}}%</span>
                              </div>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>    
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('content.script')
<script type="text/javascript">
    var chart = Morris.Area({
        element: '{{$panelId}}-area',
        data: [{
            period: 'January 16',
            dl: 77,
            up: 25
            }, {
            period: 'February 16',
            dl: 127,
            up: 58
            }, {
            period: 'March 16',
            dl: 115,
            up: 46
            }, {
            period: 'April 16',
            dl: 239,
            up: 57
            }, {
            period: 'May 16',
            dl: 46,
            up: 75
            }, {
            period: 'June 16',
            dl: 97,
            up: 57
            }, {
            period: 'July 16',
            dl: 105,
            up: 70
            }, {
            period: 'August 16',
            dl: 115,
            up: 106
            }, {
            period: 'September 16',
            dl: 239,
            up: 187
            }, {
            period: 'October 16',
            dl: 97,
            up: 57
            }, {
            period: 'November 16',
            dl: 189,
            up: 70
            }, {
            period: 'December 16',
            dl: 65,
            up: 30
            }, {
            period: 'January 17',
            dl: 35,
            up: 90
            }, {
            period: 'February 17',
            dl: 127,
            up: 58
            }, {
            period: 'March 17',
            dl: 115,
            up: 46
            }, {
            period: 'April 17',
            dl: 239,
            up: 57
            }, {
            period: 'May 17',
            dl: 46,
            up: 75
            }, {
            period: 'June 17',
            dl: 97,
            up: 57
            }, {
            period: 'July 17',
            dl: 105,
            up: 70
            }, {
            period: 'August 17',
            dl: 115,
            up: 106
            }, {
            period: 'September 17',
            dl: 239,
            up: 187
            }, {
            period: 'October 17',
            dl: 97,
            up: 57
            }, {
            period: 'November 17',
            dl: 189,
            up: 70
            }, {
            period: 'December 17',
            dl: 65,
            up: 30
            }, {
            period: 'January 18',
            dl: 35,
            up: 90
            }, {
            period: 'February 18',
            dl: 127,
            up: 58
            }, {
            period: 'March 18',
            dl: 115,
            up: 46
            }, {
            period: 'April 18',
            dl: 239,
            up: 57
            }, {
            period: 'May 18',
            dl: 46,
            up: 75
            }, {
            period: 'June 18',
            dl: 97,
            up: 57
            }, {
            period: 'July 18',
            dl: 105,
            up: 70
            }, {
            period: 'August 18',
            dl: 115,
            up: 106
            }, {
            period: 'September 18',
            dl: 239,
            up: 187
            }, {
            period: 'October 18',
            dl: 97,
            up: 57
            }, {
            period: 'November 18',
            dl: 189,
            up: 70
            }, {
            period: 'December 18',
            dl: 65,
            up: 30
            }, {
            period: 'January 19',
            dl: 35,
            up: 90
            }],
        gridEnabled: true,
        gridLineColor: 'rgba(0,0,0,.1)',
        gridTextColor: '#8f9ea6',
        gridTextSize: '11px',
        behaveLikeLine: true,
        smooth: true,
        xkey: 'period',
        ykeys: ['dl', 'up'],
        labels: ['Actual', 'Planned'],
        lineColors: ['#b5bfc5', '#78c855'],
        pointSize: 0,
        pointStrokeColors : ['#045d97'],
        lineWidth: 0,
        resize:true,
        hideHover: 'auto',
        fillOpacity: 0.9,
        parseTime:false
    });

    chart.options.labels.forEach(function(label, i){
        var legendItem = $('<div class=\'morris-legend-items\'></div>').text(label);
        $('<span></span>').css('background-color', chart.options.lineColors[i]).prependTo(legendItem);
        $('#demo-morris-area-legend').append(legendItem)
    })
</script>
@endpush