@extends('joesama/entree::layouts.form')
@push('form.style')

@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
				{!! $form !!}
			</div>
		</div>
    </div>
</div>
@endsection
@push('form.script')
@endpush