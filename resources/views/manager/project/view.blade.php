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
            <div class="panel">
                <div class="panel-body">
                    @includeIf('joesama/project::manager.project.part.info')
                </div>
            </div>
            <div class="panel-group accordion" id="accordionExample">
                @foreach($policies as $policyId => $policy)
                    @php
                        $view = 'joesama/project::manager.project.part.'.$policyId;
                    @endphp
                    @if(view()->exists($view))
                        @include($view)
                    @else
                        @include('joesama/project::manager.project.part.table',[
                            'table' => ${$policyId.'Table'},
                            'title' => 'joesama/project::manager.'.$policyId.'.list',
                        ])
                    @endif
                @endforeach
                {{-- @includeIf('joesama/project::project.component.progress') --}}
                {{-- @includeIf('joesama/project::manager.project.part.issue') --}}
                {{-- @includeIf('joesama/project::project.component.risk') --}}
                {{-- @includeIf('joesama/project::project.component.budget') --}}
                {{-- @includeIf('joesama/project::project.component.hse') --}}
                {{-- @includeIf('joesama/project::project.component.owner') --}}
            </div>
        </div>
    </div>

@endsection
@push('content.script')


</script>
@stack('datagrid')
@endpush