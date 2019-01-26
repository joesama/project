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
				<div class="table-responsive">
					{!! $table !!}
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
@push('content.script')
@stack('datagrid')
@endpush