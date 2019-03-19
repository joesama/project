<style type="text/css">
	.tab-stacked-left .nav-tabs{
		width: 20% !important;
	}
</style>

<div class="tab-base tab-stacked-left  bord-all pad-all">					
	<!--Nav tabs-->
	<ul class="nav nav-tabs text-bold text-left">
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

	<!--Tabs Content-->
	<div class="tab-content bord-all">
	    <div id="need-action" class="tab-pane fade">
	        <h5 class="text-main text-semibold">
	        {{ data_get($workflow,'current.label') }}
	    	</h5>
	        
	    </div>
	    <div id="action-record" class="tab-pane fade">
	        <h5 class="text-main text-semibold">
	        	{{ __('joesama/project::form.process.record') }}
	        </h5>
	        <table class="table table-bordered table-sm">
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
                    <td class="text-normal">
                        {{ data_get($record,'step.status.description') }}
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