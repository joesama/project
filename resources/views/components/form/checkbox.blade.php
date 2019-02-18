<div class="form-group">
	@include('joesama/project::components.form.label-form')
    <div class="col-md-10">
    <input id="{{ $fieldId }}" class="" name="{{ $fieldId }}" {{ (old($fieldId,$value) == 1) ? 'checked' : '' }} type="checkbox">
    </div>
</div>