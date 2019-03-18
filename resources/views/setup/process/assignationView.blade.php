<div class="row mt-3">
	<div class="col-md-12">
	<div class="tab-base">	
            <!--Nav Tabs-->
    <ul class="nav nav-tabs">
    	@foreach($flow as $key => $process)
        <li class="text-bold bord-btm {{ ($key == 0 ) ? 'active' : ''  }}">
            <a data-toggle="tab" href="#lft-tab-{{$process->get('id')}}" aria-expanded="false">
            	{{ $process->get('flow') }} 
        	</a>
        </li>
        @endforeach
    </ul>

    <!--Tabs Content-->
    <div class="tab-content pad-no pad-top">
    	@foreach($flow as $key => $process)
        <div id="lft-tab-{{$process->get('id')}}" class="tab-pane {{ ($key == 0 ) ? 'fade active in' : 'fade'  }}">
            
        	@php
        		$steps = $process->get('steps')
        	@endphp
        	<table class="table table-bordered table-sm">
        	@foreach($steps as $step)
        		@php
					$fieldId = $step->get('cross').'_'. $step->get('role_id')  .'_'. $step->get('status_id');
				@endphp
                <tr>
                    <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                        {{ $step->get('role') }}
                    </td>
                    <td class="pl-2">
				    	{{ $step->get('profile_assign')->name ?? 'PROFILE' }}
				    	<small class="help-block text-warning">
				        	Will Assign For : {{ $step->get('label')}}
				    	</small>
                    </td>
                </tr>
        	@endforeach
        	</table>
        </div>
        @endforeach
    </div>

	</div>
	</div>
</div>
