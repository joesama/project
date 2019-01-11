<div class="form-group has-feedback">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
		<div id="date-{{ $fieldId }}">
		    <div class="input-group date">
		        <input type="text" class="form-control form-validation"  {{ ($required) ? 'required="TRUE"':'' }} {{ ($readonly) ? 'disabled':'' }} name="{{ $fieldId }}"  id="{{ $fieldId }}"  value="{{ Carbon\Carbon::parse(old($fieldId,$value))->format('d/m/Y') }}" >
		        <span class="input-group-addon"><i class="pli-calendar-4"></i></span>
		    </div>
		    <small class="text-muted">Auto close on select</small>
		</div>
	</div>
</div>