<style type="text/css">
	.tab-stacked-left .nav-tabs{
		width: 20% !important;
	}
	.tab-base .nav-tabs>.active>a{
		background-color: #3a444e;
		color: white;
	}
	.tab-base .nav-tabs>.active>a, .tab-base .nav-tabs>.active a:hover, .tab-base .nav-tabs>.active>a:focus {
	    border-color: transparent;
	    background-color: #3a444e;
	    color: white;
	}	
</style>
<div class="tab-base">					
	<!--Nav tabs-->
	<ul class="nav nav-tabs tabs-right text-bold text-left">
	    <li class="active">
	        <a data-toggle="tab" href="#need-action" aria-expanded="false">
	        	{{ __('joesama/project::form.process.action') }}
	        </a>
	    </li>
	    <li class="">
	        <a data-toggle="tab" href="#action-record" aria-expanded="false">
	        	{{ __('joesama/project::form.process.record') }}
	        </a>
	    </li>
	</ul>
	@php
		$workflowType = data_get($workflow, 'type');
	@endphp
	<!--Tabs Content-->
	<div class="tab-content bord-all">
	    <div id="need-action" class="tab-pane fade active in">
	        <h5 class="text-main text-semibold text-uppercase">
	        {{ config('joesama/project::workflow.process.'.data_get($workflow,'type')) }} : 
	        {{ data_get($workflow,'current.label') }}
	    	</h5>
			<form method="POST" id="workflowForm" action="{{ route('api.workflow.'.$workflowType,[request()->segment(4), request()->segment(5), request()->segment(6)]) }}" class="panel-body form-horizontal form-padding text-left">
			@csrf	
            @php
            	$next = $workflow->get('next');
            	$current = $workflow->get('current');
            @endphp
                <div class="form-group">
                    <label class="col-md-2 control-label text-bold">
                    	{{ __('joesama/project::form.process.form.action') }}
                    </label>
                    <div class="col-md-10">
                    	<p class="form-control-static">
                    		{{ data_get($current, 'profile_assign.name') }}
                    	</p>
                	</div>
                </div>
	            <input type="hidden" name="state" id="state" value="{{ strtolower(data_get($current, 'status')) }}">
	            <input type="hidden" name="type" id="type" value="{{ data_get($workflow,'type') }}">
	            <input type="hidden" name="status" id="status" value="{{ data_get($next, 'status_id') }}">
	            <input type="hidden" name="need_action" id="need_action" value="{{ data_get($next, 'profile_assign.id') }}">
	            <input type="hidden" name="need_step" id="need_step" value="{{ data_get($next, 'id') }}">
	            <input type="hidden" name="current_step" id="current_step" value="{{ data_get($current, 'id') }}">
	            <input type="hidden" name="current_action" id="current_action" value="{{ data_get($current, 'profile_assign.id') }}">
                <div class="form-group">
                    <label class="col-md-2 control-label text-bold" for="demo-textarea-input">
                    	{{ __('joesama/project::form.process.remark') }}
                    </label>
                    <div class="col-md-10">
                        <textarea id="remark" name="remark" rows="9" class="form-control" placeholder="{{ __('joesama/project::form.process.remark') }}"></textarea>
                    </div>
                </div>
                <div class="form-group text-right">
                	@if(data_get($workflow, 'first.id') === data_get($workflow, 'current.id'))
	            	<input type="hidden" name="abandon" id="abandon" value="true">
		            <button type="submit" onclick="closeproject()" class="btn btn-danger mar-ver">
		            	<i class="ion-asterisk icon-fw"></i>
		            	{{ __('joesama/project::form.action.close') }}
		            </button>
		            @else
		            <button type="submit" onclick="reject()" class="btn btn-danger mar-ver">
		                <i class="psi-pen icon-fw"></i>
		                {{ __('joesama/project::form.action.reject') }} 
		            </button>
		            @endif
		            <button type="submit" class="btn btn-primary mar-ver">
		            	<i class="psi-yes text-success icon-fw"></i>
		            	{{ __('joesama/project::form.action.approve') }} 
		            </button>
	        	</div>
            </form>
	    </div>
	    <div id="action-record" class="tab-pane fade">
	        <table class="table table-bordered table-condensed">
	        	<tr>
	        		<th class="text-bold text-main text-center bg-dark" style="width: 15%;color: white;">
	        			{{ __('joesama/project::form.process.status') }}
	        		</th>
	        		<th class="text-bold text-main text-center bg-dark" style="width: 25%;color: white;">
	        			{{ __('joesama/project::form.process.assignee') }}
	        		</th>
	        		<th class="text-bold text-main text-center bg-dark" style="color: white;">
	        			{{ __('joesama/project::form.process.remark') }}
	        		</th>
	        		<th class="text-bold text-main text-center bg-dark" style="width: 15%;color: white;">
	        			{{ __('joesama/project::form.process.date') }}
	        		</th>
	        	</tr>
        	@foreach($workflow->get('record') as $record)
                <tr>
                    <td class="text-normal text-uppercase">
                        {{ data_get($record,'state') }}
                    </td>
                    <td class="text-normal">
                        {{ data_get($record,'profile.name') }}
                    </td>
                    <td class="text-normal">
				    	{!! data_get($record,'remark') !!}
                    </td>
                    <td class="text-normal">
                        {{ Carbon\Carbon::parse(data_get($record,'created_at'))->format('d-m-Y H:i:s') }}
                    </td>
                </tr>
        	@endforeach
        	</table>
	    </div>
	</div>
</div>
@push('content.script')
<script type="text/javascript">
    function copyremark(){
        document.getElementById('backremark').value = document.getElementById('textarea-input').value;
    }

    function reject(){
        event.preventDefault();
        $('#state').val("rejected");
        $('#status').val("{{ intval(data_get($workflow, 'first.status_id')) }}");
        $('#need_action').val("{{ intval(data_get($workflow, 'first.profile_assign.id')) }}");
        $('#need_step').val("{{ intval(data_get($workflow, 'first.id')) }}");
        $('form#workflowForm').submit();
        
    }

    function closeproject(){
        event.preventDefault();
        $('#state').val("closed");
        $('#status').val(null);
        $('#need_action').val(null);
        $('#need_step').val(null);
        $('form#workflowForm').submit();
        
    }

</script>
@endpush