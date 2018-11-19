@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @includeIf('joesama/project::project.component.info')
                    <div class="accordion" id="accordionExample">
                        @includeIf('joesama/project::project.component.schedule')
                        @includeIf('joesama/project::project.component.progress')
                        @includeIf('joesama/project::project.component.issue')
                        @includeIf('joesama/project::project.component.budget')
                        @includeIf('joesama/project::project.component.hse')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('content.script')


</script>
@endpush