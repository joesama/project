@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')
	@include('joesama/project::project.portfolio.counter')
	<div class="clearfix">&nbsp;</div>
	@include('joesama/project::project.portfolio.graph')
@endsection
@prepend('content.script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endprepend