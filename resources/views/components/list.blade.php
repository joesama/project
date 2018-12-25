@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">
	w-100{
		width: 100px;
	}
</style>
@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
				{!! $table !!}
			</div>
		  	<div class="panel-footer text-right">
		  		@php
		  			$projectUrl = request()->segment(1).'/project/view/'.request()->segment(4).'/'.request()->segment(5);
		  			$projectCaption = request()->segment(1).'.project.view';
		  		@endphp
		        <a class="btn btn-dark" href="{{ handles($projectUrl) }}">
		        	<i class="psi-folder-with-document icon-fw"></i>
		        	{{ __('joesama/project::'.$projectCaption) }}
		        </a>
		    </div>
		</div>
    </div>
</div>
@endsection
@push('content.script')
@stack('datagrid')
@endpush