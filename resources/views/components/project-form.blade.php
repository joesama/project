@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
		  	<div class="panel-body">
		  		{!! $form !!}
		  	</div>
		  	<div class="panel-footer text-right">
		  		@php
		  			$listUrl = request()->segment(1).'/'.request()->segment(2).'/list/'.request()->segment(4).'/'.request()->segment(5);
		  			$listCaption = request()->segment(1).'.'.request()->segment(2).'.list';
		  			$projectUrl = request()->segment(1).'/project/view/'.request()->segment(4).'/'.request()->segment(5);
		  			$projectCaption = request()->segment(1).'.project.view';
		  		@endphp
		        <a class="btn btn-dark" href="{{ handles($listUrl) }}">
		        	<i class="psi-numbering-list icon-fw"></i>
		        	{{ __('joesama/project::'.$listCaption) }}
		        </a>
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