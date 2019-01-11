<div class="form-group has-feedback">
    <label class="col-md-2 control-label" for="{{ $fieldId }}"">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
        <textarea name="{{ $fieldId }}" {{ ($required) ? 'required="TRUE"':'' }} id="{{ $fieldId }}" {{ ($readonly) ? 'readonly':'' }} rows="10" class="form-control form-validation" placeholder="{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}">
        	{{ old($fieldId,$value) }} 
        </textarea>
    </div>
</div>