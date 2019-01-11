<div class="form-group has-feedback">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
    	<select class="date-select2 form-validation" {{ ($required) ? 'required="TRUE"':'' }} id="{{ $fieldId }}" name="{{ $fieldId }}" data-width="100%" multiple="multiple" title="Choose one of the following...">
    		@foreach($optionList as $id => $option)
    			<option {{ (old($fieldId,$value) == $id) ?  'selected':'' }} value="{{$id}}">
    				{{ ucwords($option) }}
    			</option>
    		@endforeach
    	</select>
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>