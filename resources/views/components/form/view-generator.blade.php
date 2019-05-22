<form class="form-horizontal form-padding">
	<div class="panel">
		<div class="panel-heading">
	        <h3 class="panel-title text-bold">{{ $title }}</h3>
	    </div>
	  	<div class="panel-body">
        <table class="table table-bordered table-sm">
            @foreach($fields as $field)
                @if($field != 'id')
                <tr>
                    <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                        {{ __('joesama/project::form.'.$viewId.'.'.$field) }}
                    </td>
                    <td class="pl-2">
                        @php
                            $dataField = data_get($relation, $field, $field);
                            $dataValue = data_get($data, $dataField);
                        @endphp
                        @if ($callback->get($field) instanceof \Closure)
                            {!! $callback->get($field)($dataValue) !!}
                        @else
                            {!! ucwords(strip_tags($dataValue) ) !!}
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
        </table>
		</div>
	</div>
</form>