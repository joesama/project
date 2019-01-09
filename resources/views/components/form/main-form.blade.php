


<form class="form-horizontal form-padding" id="{{$formId}}" action="{{ $action }}" method="{{ $method}}">
	<div class="panel">
		<div class="panel-heading">
	        <h3 class="panel-title">{{ $title }}</h3>
	    </div>
	  	<div class="panel-body">
	  		@csrf
			@foreach($fields as $fieldId => $type)
				@includeIf('joesama/project::components.form.'.$type,[
					'mapValue' => array_get($mapping,$fieldId),
					'optionList' => array_get($option,$fieldId),
					'value' => data_get($value,$fieldId,array_get($default,$fieldId)),
					'readonly' => $readonly->contains($fieldId) ? TRUE : FALSE
				])
			@endforeach
		</div>
		<div class="panel-footer text-right">
	  		@php
	  			$listUrl = request()->segment(1).'/'.request()->segment(2).'/list/'.request()->segment(4).'/'.request()->segment(5);
	  			$listCaption = request()->segment(1).'.'.request()->segment(2).'.list';
	  			if(request()->segment(1) == 'manager' && !is_null(request()->segment(5))):
	  			$projectUrl = request()->segment(1).'/project/view/'.request()->segment(4).'/'.request()->segment(5);
	  			$projectCaption = request()->segment(1).'.project.view';
	  			endif;
	  		@endphp
	        <a class="btn btn-dark" href="{{ handles($listUrl) }}">
	        	<i class="psi-numbering-list icon-fw"></i>
	        	{{ __('joesama/project::'.$listCaption) }}
	        </a>
	        @if(request()->segment(1) == 'manager' && !is_null(request()->segment(5)))
	        <a class="btn btn-dark" href="{{ handles($projectUrl) }}">
	        	<i class="psi-folder-with-document icon-fw"></i>
	        	{{ __('joesama/project::'.$projectCaption) }}
	        </a>
	        @endif
	        <button class="btn btn-primary" type="submit">
	        	<i class="psi-data-save icon-fw"></i>
	        	{{ __('joesama/project::form.submit') }}
	        </button>
	    </div>
	</div>
</form>
@push('form.script')
<script type="text/javascript">
$(document).on('nifty.ready', function() {

$('.input-group.date').datepicker({
	autoclose:true,
	format: 'dd/mm/yyyy'
});

});
</script>
@endpush