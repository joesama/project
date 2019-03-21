<div class="col-md-6" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#financialCurve" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.curve.financial') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="financialCurve">
      <div class="panel-body">        
        @if( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager && is_null($isReport))  <div class="row">
          <div class="col-md-12 pad-no mar-btm">
            <a class="btn btn-dark pull-right mar-hor" href="{{ handles('joesama/project::manager/finance/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
              <i class="psi-numbering-list icon-fw"></i>
              {{ __('joesama/project::manager.finance.list')  }}
            </a>
          </div>
        </div>
        @endif
        <div id="financialSpline"></div>
      </div>
    </div>
  </div>
</div>
@php
  $fCategories = $paymentSchedule->get('categories');
  $fPlanned = $paymentSchedule->get('planned');
  $fActual = $paymentSchedule->get('actual');
  $fLatest = $paymentSchedule->get('latest');
  $fLabel = ' VARIANCE : '.$paymentSchedule->get('variance')
@endphp
@push('content.script')
<script type="text/javascript">
  
var chart = bb.generate({
  data: {
    columns: [
      @json($fPlanned),
      @json($fActual)
    ],
    type: "spline"
  },
  axis: {
    x: {
      label: "{{ $fLabel }}",
      type: "category",
      categories: @json($fCategories)
    },
    y: {
      label: "Amount Claim (RM)"
    }
  },
  bindto: "#financialSpline",
  legend: {
    position: "inset",
    usePoint: true
  }
});

chart.xgrids.add(
  {value: "{{ data_get($fLatest,'label') }}" , text: "{{ __('joesama/project::report.current') }}"}
);

</script>
@endpush