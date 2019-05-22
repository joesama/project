@extends('joesama/entree::layouts.content')
@push('content.style')
<link href="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.css" rel="stylesheet">
@endpush
@section('content')
@section('content')
<div class="row mb-3">
	<div class="col-md-12">
		@include('joesama/project::report.format-monthly')
	</div>
</div>
@endsection
@prepend('content.script')
<script src="https://naver.github.io/billboard.js/release/latest/dist/billboard.pkgd.min.js"></script>
<script type="text/javascript">
    $('.mh-byrow').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
</script>
@stack('datagrid')
@endprepend

