<div class="form-group">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
        <input type="text" name="{{ $fieldId }}" value="{{ $value }}"  id="{{ $fieldId }}" class="form-control" placeholder="{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}">
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>