@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')

	<?php $project = config('joesama/project::data.tel'); ?>
	@include('joesama/project::project.portfolio.counter')
	<div class="clearfix mb-4">&nbsp;</div>
	@include('joesama/project::project.portfolio.subs')
	<div class="clearfix mb-5">&nbsp;</div>
@endsection
@prepend('content.script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endprepend