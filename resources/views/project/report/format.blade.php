@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <img width="100%" src="{{ asset('packages/joesama/project/img/weekly.png') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('content.script')


@endpush