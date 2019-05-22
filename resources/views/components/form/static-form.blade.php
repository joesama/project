<form class="form-horizontal form-padding">
	<div class="panel">
		<div class="panel-heading">
	        <h3 class="panel-title text-bold">{{ $title }}</h3>
	    </div>
	  	<div class="panel-body">
			@foreach($fields as $field)
				@if($field != 'id')
				<div class="form-group">
                    <label class="col-md-3 text-bold control-label">
                    	{{ __('joesama/project::form.'.$viewId.'.'.$field) }}
                    </label>
                    <div class="col-md-9">
                    	<p class="form-control-static">
                    		:&nbsp;&nbsp;
                    		@php
                    			$dataField = data_get($relation, $field, $field);
                    			$dataValue = data_get($data, $dataField, NULL);
                    		@endphp
                    		@if ($callback->get($field) instanceof \Closure)
                    			@if ($dataValue !== NULL)
									{!! $callback->get($field)($dataValue) !!}
								@endif
                    		@else
                    			{!! ucwords(strip_tags($dataValue) ) !!}
                    		@endif
                    	</p>
                    </div>
                </div>
                @endif
			@endforeach
		</div>
	</div>
</form>