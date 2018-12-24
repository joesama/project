<div class="form-group">
    <label class="col-md-2 control-label" for="{{ $fieldId }}">
    	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
    </label>
    <div class="col-md-10">
    	<select class="selectpicker" id="{{ $fieldId }}" name="{{ $fieldId }}" multiple title="Choose one of the following...">
    		@foreach($optionList as $id => $option)
    			<option {{ ($value == $id) ?  'selected':'' }} value="{{$id}}">
    				{{ ucwords($option) }}
    			</option>
    		@endforeach
    	</select>
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>