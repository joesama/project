<div class="form-group has-feedback">
    @include('joesama/project::components.form.label-form')
    <div class="col-md-10">
    	<select class="selectpicker" {{ ($required) ? 'required="TRUE"':'' }} {{ ($readonly) ? 'disabled':'' }} id="{{ $fieldId }}" name="{{ $fieldId }}" data-live-search="true" data-width="100%">
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