<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#hse" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.hse.view') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="hse">
      <div class="panel-body">
          @if(!is_null($hsecard))
             @if ( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager)
            
            <div class="row">
              <div class="col-md-6">
                <p class="text-bold mar-no">
                  {{ __('joesama/project::form.project_incident.last') }}&nbsp;:&nbsp;
                  @php
                    $lastIncident = data_get(collect(data_get($project,'incident'))->first(),'created_at');
                  @endphp
                  {{ $lastIncident != null ? Carbon\Carbon::parse($lastIncident)->format('d/m/Y') : 'N/A' }}
                </p>
              </div>
              <div class="col-md-6">
                <a class="btn btn-dark mar-btm pull-right mar-rgt" href="{{ handles('joesama/project::manager/hse/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                  <i class="psi-pen-5 icon-fw"></i>
                  {{ __('joesama/project::manager.hse.form') }}
                </a>
                <a class="btn btn-dark mar-btm pull-right mar-rgt" href="{{ handles('joesama/project::manager/hse/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
                  <i class="psi-numbering-list icon-fw"></i>
                  {{ __('joesama/project::manager.hse.list') }}
                </a>
              </div>
            </div>
            @endif
            
            @foreach($hsecard as $hse)
              @includeIf('joesama/project::manager.project.part.card-panel2',[
                  'id' => $hse['code'],
                  'title' => $hse['title'],
                  'total' => $hse['total'],
                  'month' => $hse['month'],
                  'sub' => $hse['subdata'],
                ])
            @endforeach()
          @endif
      </div>
    </div>
  </div>
</div>
@push('content.script')
<script type="text/javascript">
  $('#123').easyPieChart({
        barColor :'#ffffff',
        scaleColor:'#1B8F85',
        trackColor : '#1B8F85',
        lineCap : 'round',
        lineWidth :8,
        onStep: function(from, to, percent) {
            $(this.el).find('.pie-value').text(Math.round(percent));
        }
    });
</script>
@endpush