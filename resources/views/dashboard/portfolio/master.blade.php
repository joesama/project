@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3" id="group-dashboard">
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-project')
    </div>
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-contract')
    </div>
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-task')
    </div>
    <div class="col-md-6">
    	@include('joesama/project::dashboard.portfolio.panel-issue')
    </div>
</div>
@endsection
@push('content.script')
<script type="text/javascript">
    $('#group-dashboard').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
</script>
@endpush