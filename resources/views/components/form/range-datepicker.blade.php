<div class="form-group has-feedback">
	@include('joesama/project::components.form.label-form')
    <div class="col-md-10">
		<div id="date-{{ $fieldId }}">
		    <div class="input-daterange input-group  text-semibold">
		        <input type="text" class="form-control form-validation"  {{ ($required) ? 'required="TRUE"':'' }} {{ ($readonly) ? 'disabled':'' }} name="start"  id="start"  value="{{ Carbon\Carbon::parse(old('start',$start))->format('d/m/Y') }}" >
		        <span class="input-group-addon"><i class="psi-triangle-arrow-right"></i></span>
		        <input type="text" class="form-control form-validation"  {{ ($required) ? 'required="TRUE"':'' }} {{ ($readonly) ? 'disabled':'' }} name="end"  id="end"  value="{{ Carbon\Carbon::parse(old('end',$end))->format('d/m/Y') }}" >
		    </div>
		</div>
	</div>
</div>
@php
	$startDate = (is_null($default)) ? Carbon\Carbon::now()->subYears(2)->format('d/m/Y') : Carbon\Carbon::parse($default)->format('d/m/Y');
@endphp
@push('form.script')
<script type="text/javascript">
$(document).on('nifty.ready', function() {
	$("#start").mask('99/99/9999');
	$("#end").mask('99/99/9999');
	$("{{ '#date-'.$fieldId }} .input-daterange").datepicker({
		autoclose:true,
		format: 'dd/mm/yyyy',
		startDate: "{{ $startDate }}",
		todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
	});

});
</script>
@endpush