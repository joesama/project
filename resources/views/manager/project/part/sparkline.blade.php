<div class="panel panel-warning panel-colorful text-left">
    <div class="pad-all">
        <p class="text-lg text-semibold">
          <i class="demo-pli-basket-coins icon-fw"></i> 
          {{ __('joesama/project::form.financial.claim') }}
        </p>
        <p class="mar-no">
          {{ Carbon\Carbon::now()->localeMonth }}
          <span class="pull-right text-bold">$764</span>
        </p>
        <p class="mar-no">
          YTD (RM)
          <span class="pull-right text-bold">$764</span>
        </p>
        <p class="mar-no">
          TTD (RM)
          <span class="pull-right text-bold">$1,332</span>
        </p>
    </div>
    <div class="text-center">
        <!--Placeholder-->
        <div id="demo-sparkline-bar" class="box-inline"></div>
    </div>
</div>
@push('pages.script')
<script type="text/javascript">

    var barEl = $("#demo-sparkline-bar");
    var barValues = [40,32,65,53,62,55,24,67,45,70,45,56,34,67,76,32,65,53,62,55,24,67,45,70,45,56,70,45,56,34,67,76,32,65,53];
    var barValueCount = barValues.length;
    var barSpacing = 1;

    var salesSparkline = function(){
         barEl.sparkline(barValues, {
            type: 'bar',
            height: 78,
            barWidth: Math.round((barEl.parent().width() - ( barValueCount - 1 ) * barSpacing ) / barValueCount),
            barSpacing: barSpacing,
            zeroAxis: false,
            tooltipChartTitle: 'Daily Sales',
            tooltipSuffix: ' Sales',
            barColor: 'rgba(0,0,0,.15)'
        });
    }


    $(window).on('resizeEnd', function(){
        salesSparkline();
    })

    salesSparkline();

</script>
@endpush