<div class="{{ $sub ? 'col-md-4' : 'col-md-2' }}">
  <h5 class="text-uppercase text-muted text-semibold">
      {{ $title }}
  </h5>
  <hr class="new-section-xs">
  <div class="row mar-top">
        <div class="{{ $sub ? 'col-sm-5' : 'col-sm-12' }}">
            <div class="panel">
                <div class="pad-all bg-mint text-center">
                    <div id="{{ $id }}" data-percent="{{ $total ?? 0 }}" class="pie-title-center">
                        <span class="  pie-value">
                            {{ $total ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @if($sub)
        <div class="col-sm-7">
            <ul class="list-group bg-trans">
                <li class="list-group-item pad-no" href="#">
                    <span class="label label-info pull-right">{{ $month }}</span>
                    <i class="psi-information icon-sm icon-fw"></i> This Month
                </li>
                @foreach($sub as $detail)
                    <li class="list-group-item pad-no">
                        <span class="label label-info pull-right">
                            {{ data_get($detail,'count') }}
                        </span>
                        <i class="psi-ruler icon-sm icon-fw"></i> 
                        {{ data_get($detail,'item') }}
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
  </div>
</div>
@push('content.script')
<script type="text/javascript">
	$('{{'#'.$id}}').easyPieChart({
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