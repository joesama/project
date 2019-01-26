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
        <div id="physicalSpline"></div>
      </div>
    </div>
  </div>
</div>
@php
  $taskCategories = collect($projectSchedule->first())->get('categories')->splice(1);
  $taskLabel = $projectSchedule->mapWithKeys(function($item, $key){
      return [$key => $key.' VARIANCE : '.number_format($item->get('variance'),2)];
  })->implode(',');
  $taskLine = $projectSchedule->mapWithKeys(function($item, $key){
      return [$key => $item->get('latest')];
  })->first();
@endphp
@push('content.script')
<script type="text/javascript">
  
  var chartPhy = bb.generate({
  data: {
    columns: [
    @foreach($projectSchedule->except('count') as $payables)
      @foreach($payables->except(['categories','variance','latest']) as $chart)

        @json($chart),

      @endforeach
    @endforeach
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
  bindto: "#physicalSpline"
});

chartPhy.xgrids.add(
  {value: "24-01-2019" , text: "Current Progress"}
);

</script>
@endpush