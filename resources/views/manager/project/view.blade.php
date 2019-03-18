@extends('joesama/entree::layouts.content')
@push('content.style')
<link href="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.css" rel="stylesheet">
@endpush
@section('content')

<div class="row">
    <div class="col-12">

            @includeIf('joesama/project::manager.project.part.info')
            @includeIf('joesama/project::manager.project.part.physical-curve')
            @includeIf('joesama/project::manager.project.part.financial-curve')
            @foreach($policies as $policyId => $policy)
                @php
                    $currentView = 'joesama/project::manager.project.part.'.$policyId
                @endphp

                @php
                $view = 'joesama/project::manager.project.part.table'
                @endphp

                @includeFirst([$currentView,$view],[
                        'table' => ${$policyId.'Table'},
                        'title' => 'joesama/project::manager.'.$policyId.'.list',
                        'tableId' => $policyId
                    ])
            @endforeach
            @includeIf('joesama/project::manager.project.part.financial')
            @includeIf('joesama/project::manager.project.part.hse')
            @includeWhen($project->active && is_null($isReport) ,'joesama/project::manager.project.part.upload')
            {{-- @includeWhen($project->active && is_null($isReport) ,'joesama/project::manager.project.part.workflow') --}}
            {{-- @includeWhen(!$project->active,'joesama/project::manager.project.part.approval') --}}
            {{-- @includeWhen($isReport,'joesama/project::manager.project.part.monthlyReport') --}}
            @includeIf('joesama/project::manager.project.part.processflow')

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

