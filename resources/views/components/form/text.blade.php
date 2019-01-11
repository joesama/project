<div class="form-group has-feedback">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
        <input type="text" {{ ($readonly) ? 'readonly':'' }} name="{{ $fieldId }}" value="{{ old($fieldId,$value) }}"  id="{{ $fieldId }}" class="form-control form-validation" placeholder="{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}">
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>