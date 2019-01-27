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
			<div class="panel-footer text-right">
		  		@php
		  			$projectUrl = 'manager/project/view/'.$project->corporate_id.'/'.$project->id;
		  		@endphp
		        <a class="btn btn-dark" href="{{ handles($projectUrl) }}">
		        	<i class="psi-folder-with-document icon-fw"></i>
		        	{{ __('joesama/project::manager.project.view') }}
		        </a>
		    </div>
	    </div>
	</div>
</div>
@endsection
@push('content.script')
<script type="text/javascript">
$(document).on('nifty.ready', function () {
    $('#need_action').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
});
</script>
@endpush

