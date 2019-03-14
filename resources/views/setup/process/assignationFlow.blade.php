
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
	<div class="tab-base">	
            <!--Nav Tabs-->
    <ul class="nav nav-tabs">
    	@foreach($flow as $key => $process)
        <li class="{{ ($key == 0 ) ? 'active' : ''  }}">
            <a data-toggle="tab" href="#lft-tab-{{$process->get('id')}}" aria-expanded="false">
            	{{ $process->get('flow') }} 
        	</a>
        </li>
        @endforeach
    </ul>

    <!--Tabs Content-->
    <div class="tab-content">
    	@foreach($flow as $key => $process)
        <div id="lft-tab-{{$process->get('id')}}" class="tab-pane {{ ($key == 0 ) ? 'fade active in' : 'fade'  }}">
            
        	@php
        		$steps = $process->get('steps')
        	@endphp
        	@foreach($steps as $step)
        		@php
					$fieldId = $step->get('cross').'_'. $step->get('role_id')  .'_'. $step->get('status_id');
				@endphp
				<div class="form-group has-feedback">
				    <label class="col-md-2 control-label text-semibold" for="{{ $fieldId }}">
						{{ $step->get('role') }}
						@if($required)
					    <i class="ion-asterisk text-danger" style="font-size: 6px;vertical-align:text-top;"></i>
					    @endif
					</label>
				    <div class="col-md-10">
				    	<select class="selectpicker" name="{{ $fieldId }}" data-live-search="true" data-width="100%">
				            <option value="">{{ __('joesama/project::form.is.choose') }}</option>
				    		@foreach($step->get('profile_list') as $id => $option)
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
        @endforeach
    </div>

	</div>
	</div>
</div>
