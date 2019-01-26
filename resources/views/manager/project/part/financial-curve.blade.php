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
        <div id="financialSpline"></div>
      </div>
    </div>
  </div>
</div>
@php
  $categories = $paymentSchedule->first()->get('categories')->splice(1);
  $label = $paymentSchedule->mapWithKeys(function($item, $key){
      return [$key => $key.' VARIANCE : '.number_format($item->get('variance'),2)];
  })->implode(',');
  $line = $paymentSchedule->mapWithKeys(function($item, $key){
      return [$key => $item->get('latest')];
  })->first();
@endphp
@push('content.script')
<script type="text/javascript">
  
var chart = bb.generate({
  data: {
    columns: [
    @foreach($paymentSchedule->except('count') as $payables)
      @foreach($payables->except(['categories','variance','latest']) as $chart)

        @json($chart),

      @endforeach
    @endforeach
    ],
    type: "spline"
  },
  axis: {
    x: {
      label: "{{ $label }}",
      type: "category",
      categories: @json($categories)
    },
    y: {
      label: "Amount Claim"
    }
  },
  bindto: "#financialSpline"
});

chart.xgrids.add(
  {value: "{{$line}}" , text: "Current"}
);

</script>
@endpush