<div class="form-group">
    <label class="col-md-2 control-label" for="{{ $fieldId }}"">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
        <textarea name="{{ $fieldId }}" id="{{ $fieldId }}" {{ ($readonly) ? 'readonly':'' }} rows="10" class="form-control" placeholder="{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}">
        	{{ $value }} 
        </textarea>
    </div>
</div>