<div class="col-md-6" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#physicalCurve" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.curve.physical') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="physicalCurve">
      <div class="panel-body">
        @if( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager && is_null($isReport))   <div class="row">
          <div class="col-md-12 pad-no mar-btm">
            <a class="btn btn-dark pull-right mar-hor" href="{{ handles('joesama/project::manager/physical/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
              <i class="psi-numbering-list icon-fw"></i>
              {{ __('joesama/project::manager.physical.list')  }}
            </a>
          </div>
        </div>
        @endif
        <div id="physicalSpline"></div>
      </div>
    </div>
  </div>
</div>
@php

  $taskCategories = $projectSchedule->get('categories');
  $planned = $projectSchedule->get('planned');
  $actual = $projectSchedule->get('actual');
  $latest = $projectSchedule->get('latest');
  $taskLabel = ' VARIANCE : '.number_format($projectSchedule->get('variance'),2)

@endphp
@push('content.script')
<script type="text/javascript">
  
  var chartPhy = bb.generate({
  data: {
    columns: [
      @json($planned),
      @json($actual)
    ],
    type: "spline"
  },
  axis: {
    x: {
      label: "{{ $taskLabel }}",
      type: "category",
      categories: @json($taskCategories)
    },
    y: {
      label: "% Progress"
    }
  },
  bindto: "#physicalSpline",
  legend: {
    position: "inset",
    usePoint: true
  }
});

chartPhy.xgrids.add(
  {value: "{{ data_get($latest,'label') }}" , text: "{{ __('joesama/project::report.current') }}"}
);

</script>
@endpush