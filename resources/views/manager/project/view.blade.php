@extends('joesama/entree::layouts.content')
@push('content.style')
<link href="https://naver.github.io/billboard.js/release/latest/dist/billboard.min.css" rel="stylesheet">
@endpush
@section('content')

<div class="row">
    <div class="col-12">

            @includeIf('joesama/project::manager.project.part.info')

            @includeIf('joesama/project::manager.project.part.processflow')

            @includeIf('joesama/project::manager.project.part.physical-curve')

            @includeIf('joesama/project::manager.project.part.financial-curve')

            @foreach($policies as $policyId => $policy)
                @php
                    $currentView = 'joesama/project::manager.project.part.'.$policyId;

                    $view = 'joesama/project::manager.project.part.table';
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

            @includeWhen(
                ( !$project->active && (data_get($approval,'current.profile_assign.id') == $profile->id )),
                'joesama/project::manager.project.part.flowProcessing', 
                [
                    'workflow' => $approval
                ]
            )

            @includeWhen(
                ( !$project->active && (data_get($approval,'current') == null )),
                'joesama/project::manager.project.part.flowHistory', 
                [
                    'workflow' => $approval
                ]
            )

            {{-- @includeIf('joesama/project::manager.project.part.back-panel') --}}

            {{-- @includeWhen($project->active && is_null($isReport) ,'joesama/project::manager.project.part.workflow') --}}
            {{-- @includeWhen($isReport,'joesama/project::manager.project.part.monthlyReport') --}}

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

