<div class="form-group">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
    	<p class="form-control-static">
    		{{ $value }}
    	</p>
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>