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
    <div class="col-12">
        <?php $dateReport = Carbon\Carbon::create(2018,11,18) ?>
        <?php $id = request()->segment(4); ?>

            @includeIf('joesama/project::manager.project.part.info')
            @foreach($policies as $policyId => $policy)
                @php
                    $view = 'joesama/project::manager.project.part.'.$policyId
                @endphp
                @if(!view()->exists($view))
                    @php
                    $view = 'joesama/project::manager.project.part.table'
                    @endphp
                @endif

                @include($view,[
                        'table' => ${$policyId.'Table'},
                        'title' => 'joesama/project::manager.'.$policyId.'.list',
                        'tableId' => $policyId
                    ])
            @endforeach
            {{-- @includeIf('joesama/project::project.component.progress') --}}
            {{-- @includeIf('joesama/project::project.component.budget') --}}
            {{-- @includeIf('joesama/project::project.component.hse') --}}
            {{-- @includeIf('joesama/project::project.component.owner') --}}

    </div>
</div>
@endsection
@push('content.script')


</script>
@stack('datagrid')
@endpush