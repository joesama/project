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
        <h3 class="panel-title">{{ __('joesama/project::manager.curve.financial') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="physicalCurve">
      <div class="panel-body">
        <div class="row mar-btm">
            <a class="btn btn-dark pull-right" href="{{ handles('joesama/project::manager/finance/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
              <i class="psi-numbering-list icon-fw"></i>
              {{ __('joesama/project::manager.finance.milestone')  }}
            </a>
        </div>
        <div id="financialSpline"></div>
      </div>
    </div>
  </div>
</div>
@php
  $financial = data_get($project,'finance');
  $chart = $financial->pluck('weightage')->prepend('Planned');
  $categories = $financial->pluck('label')->map(function($item){
                  return strtoupper($item);
                });
@endphp
@push('content.script')
<script type="text/javascript">
  
  var chart = bb.generate({
  data: {
    columns: [
      @json($chart),
      ["actual", 0,0,0,0,0]
    ],
    type: "spline"
  },
  axis: {
    x: {
      label: "Milestone",
      type: "category",
      categories: @json($categories)
    },
    y: {
      label: "Amount Claim"
    }
  },
  bindto: "#financialSpline"
});

</script>
@endpush