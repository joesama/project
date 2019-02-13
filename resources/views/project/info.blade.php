@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">
    .btn-action{
        padding: 0px 4px;
        float: right;
        color: white;
    }
</style>
@endpush
@section('content')

    <div class="row">
        <div class="col-md-12">
            <?php $dateReport = Carbon\Carbon::create(2018,11,18) ?>
            <?php $id = null; ?>
            <div class="panel">{{dd('sss')}}
                <div class="panel-body">
                    @includeIf('joesama/project::project.component.info')
                </div>
            </div>
            <div class="accordion" id="accordionExample">
                @includeIf('joesama/project::project.component.schedule')
                @includeIf('joesama/project::project.component.progress')
                @includeIf('joesama/project::project.component.issue')
                @includeIf('joesama/project::project.component.budget')
                @includeIf('joesama/project::project.component.hse')
                @includeIf('joesama/project::project.component.owner')
            </div>
        </div>
    </div>

@endsection
@push('content.script')

@endpush