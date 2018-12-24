


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
				'value' => data_get($value,$fieldId)
			])
		@endforeach
	</div>
	<div class="panel-footer text-right">
        <button class="btn btn-primary" type="submit">
        	<i class="psi-data-save icon-fw"></i>{{ __('joesama/project::form.submit') }}
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