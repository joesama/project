<div class="form-group has-feedback">
    @include('joesama/project::components.form.label-form')
    <div class="col-md-10">
    	<select class="date-select2 form-validation" {{ ($required) ? 'required="TRUE"':'' }} id="{{ $fieldId }}" name="{{ $fieldId }}[]" data-width="100%" multiple="multiple" title="Choose one of the following...">
    		@foreach($optionList as $id => $option)
    			<option value="{{$id}}">
    				{{ ucwords($option) }}
    			</option>
    		@endforeach
    	</select>
        <small class="help-block hidden">
        	{{ __('joesama/project::form.'.$formId.'.helpblock.'.$fieldId) }}
    	</small>
    </div>
</div>