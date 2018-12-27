<div class="col-sm-4 col-md-2">
	<div class="panel">
	    <div class="pad-all bg-mint text-center">
	    	<div id="{{ $id }}" data-percent="{{ is_null($value) ? 0 : $value }}" class="pie-title-center">
                <span class="  pie-value">
                	{{ is_null($value) ? 0 : $value }}
            	</span>
          	</div>
	    </div>
		<div class="pad-all text-center text-mint">
            <p class="text-semibold mar-no">
            	{{ $title }}
            </p>
        </div>
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