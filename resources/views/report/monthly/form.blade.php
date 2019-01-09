@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3">
	<div class="col-md-12">
	    <div class="panel">
	        <div class="panel-body">
	        	@include('joesama/project::report.format')
	        </div>
	    </div>
	</div>
</div>
@endsection
@push('content.script')

@endpush

