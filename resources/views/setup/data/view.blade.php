@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
		  	<div class="panel-body">
		  		{!! $view !!}
		  	</div>
		  	<div class="panel-footer text-right">
		  		@php
		  			$listUrl = request()->segment(1).'/master/view/'.request()->segment(4).'/'.request()->segment(5);
		  			$listCaption = request()->segment(1).'.master.view';
		  		@endphp
		        <a class="btn btn-dark" href="{{ handles($listUrl) }}">
		        	<i class="psi-numbering-list icon-fw"></i>
		        	{{ __('joesama/project::'.$listCaption) }}
		        </a>
		    </div>
		</div>
    </div>
</div>
@endsection
@push('content.script')
@endpush