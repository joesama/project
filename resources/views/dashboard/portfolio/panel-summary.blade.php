<div class="{{ isset($width) ? 'col-md-6' : 'col-md-12' }}">
  <div class="panel">
    <div class="panel-heading bg-primary">
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
            <div id="{{$panelId}}-area" style="height: 300px"></div>
          </div>
          <div class="col-md-4">
            <div class="row">
                <div class="col-lg-12 pad-btm text-center">
                    <div class="text-lg">
                        <p class="text text-thin">
                          @if(array_get($summary,'gpDiff') > 1)
                            <i class="pci-caret-up text-success mar-all"></i>
                          @elseif(array_get($summary,'gpDiff') == 0)
                            <i class="pci-minus text-muted mar-all"></i>
                          @else
                            <i class="pci-caret-down text-danger mar-all"></i>
                          @endif
                            <span class="text-3x text-thin">
                              {{ array_get($summary,'gp') }}
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
                              <p class="pull-left mar-no">
                                {{ __('joesama/project::dashboard.overdue') }}
                              </p>
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
                              <p class="pull-left mar-no">
                                {{ __('joesama/project::dashboard.complete') }}
                              </p>
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
                              <p class="pull-left mar-no">
                                {{ __('joesama/project::dashboard.open') }}
                              </p>
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
                              <p class="pull-left mar-no">
                              {{ __('joesama/project::dashboard.complete') }}
                              </p>
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
@php
  $payment = array_get($summary,'payment');
  if($payment->isEmpty()){
    $payment->push([
      'period' => \Carbon\Carbon::now()->format('d-m-Y'),
      'planned' => 0,
      'actual' => 0
    ]);
  }
@endphp
@push('content.script')
<script type="text/javascript">

    var chart = Morris.Area({
        element: '{{$panelId}}-area',
        data: @json($payment),
        gridEnabled: true,
        gridLineColor: 'rgba(0,0,0,.1)',
        gridTextColor: '#8f9ea6',
        gridTextSize: '11px',
        behaveLikeLine: true,
        smooth: true,
        xkey: 'period',
        ykeys: ['planned','actual'],
        labels: ['Planned','Actual'],
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