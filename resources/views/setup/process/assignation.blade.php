
<hr>
<div class="row">
	<div class="col-md-12">
		<h3 class="panel-title">
		{{ __('joesama/project::form.process_step.assign') }}
		</h3>
		<div class="clearfix">&nbsp;</div>
	</div>
</div>
<div class="row mt-3">
	<div class="col-md-12">
	@foreach($flow as $step)
		@php
			$fieldId = $step->get('identifier');
		@endphp
		<div class="form-group has-feedback">
		    <label class="col-md-2 control-label text-semibold" for="{{ $fieldId }}">
				{{ $step->get('cross') == 1 ? 'Cross Org.' : '' }}&nbsp;{{ $step->get('role') }}
				@if($required)
			    <i class="ion-asterisk text-danger" style="font-size: 6px;vertical-align:text-top;"></i>
			    @endif
			</label>
		    <div class="col-md-10">
		    	<select class="selectpicker" name="{{ $fieldId }}" data-live-search="true" data-width="100%">
		            <option value="">{{ __('joesama/project::form.is.choose') }}</option>
		    		@foreach($step->get('profile') as $id => $option)
		    			<option {{ (old($fieldId) == $id) ?  'selected':'' }} value="{{$id}}">
		    				{{ ucwords($option) }}
		    			</option>
		    		@endforeach
		    	</select>
		    	<small class="help-block text-warning">
		        	Will Assign For : {{ $step->get('label')}}
		    	</small>
		    </div>
		</div>		
	@endforeach
	</div>
</div>
