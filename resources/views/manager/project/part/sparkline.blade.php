<div class="panel panel-{{$background}} panel-colorful text-left">
    <div class="pad-all">
        <p class="text-lg text-semibold">
          <i class="demo-pli-basket-coins icon-fw"></i> 
          {{ $title }}
        </p>
        <p class="mar-no">
          {{ Carbon\Carbon::now()->localeMonth }}
          <span class="pull-right text-bold">
            RM&nbsp;{{ number_format(data_get($transData,'monthTrans'),2) }}
          </span>
        </p>
        <p class="mar-no">
          YTD
          <span class="pull-right text-bold">
            RM&nbsp;{{ number_format(data_get($transData,'ytd'),2) }}
          </span>
        </p>
        <p class="mar-no">
          TTD
          <span class="pull-right text-bold">
            RM&nbsp;{{ number_format(data_get($transData,'ttd'),2) }}
          </span>
        </p>
    </div>
    <div class="text-center">
        <!--Placeholder-->
        <div id="{{$chartId}}-bar" class="box-inline"></div>
    </div>
</div>
@php
  $sparlineData = data_get($transData,'sparlineData');
@endphp
@push('pages.script')
<script type="text/javascript">

    var barEl = $("#"+"{{$chartId}}-bar");
    var barValues = @json($sparlineData);
    var barValueCount = barValues.length;
    var barSpacing = 1;

    var salesSparkline = function(){
         barEl.sparkline(barValues, {
            type: 'bar',
            height: 45,
            barWidth: Math.round((barEl.parent().width() - ( barValueCount - 1 ) * barSpacing ) / barValueCount),
            barSpacing: barSpacing,
            zeroAxis: false,
            tooltipChartTitle: "{{ $title }}",
            tooltipSuffix: "{{ $title }}",
            barColor: 'rgba(0,0,0,.15)'
        });
    }


    $(window).on('resizeEnd', function(){
        salesSparkline();
    })

    salesSparkline();

</script>
@endpush