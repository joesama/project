@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">

</style>
@endpush
@section('content')

	<?php $project = config('joesama/project::data.tel'); ?>
	@include('joesama/project::project.portfolio.counter')
	@include('joesama/project::project.portfolio.subs')
@endsection
@prepend('content.script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endprepend