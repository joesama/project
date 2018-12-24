@extends('joesama/entree::layouts.form')
@push('form.style')

@endpush
@section('form')
<div class="row mb-3">
    <div class="col-md-12">
		
		  	{!! $form !!}
		  
    </div>
</div>
@endsection
@push('form.script')

@endpush