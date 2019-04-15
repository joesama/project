<div class="tab-base" style="padding: 0px 5px">        
    <!--Nav tabs-->
    <ul class="nav nav-tabs tabs-right">
        <li class="active">
            <a data-toggle="tab" href="#info" aria-expanded="true">
                {{ __('joesama/project::manager.project.view') }}
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#weekly" aria-expanded="false">
                {{ __('joesama/project::manager.workflow.weekly') }}
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#monthly" aria-expanded="false">
                {{ __('joesama/project::manager.workflow.monthly') }}
            </a>
        </li>
        @if($project->active)
        <li class="">
            <a data-toggle="tab" href="#update" aria-expanded="false">
                {{ __('joesama/project::manager.project.info') }}
            </a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#approval" aria-expanded="false">
                {{ __('joesama/project::manager.workflow.approval-project') }}
            </a>
        </li>
        @endif
    </ul>

    <!--Tabs Content-->
    <div class="tab-content">
        <div id="info" class="tab-pane fade active in">
            <div class="row mar-btm">
                <div class="col-md-9">
                </div>
                <div class="col-md-3 text-right" class="vertical">
                    @if( $approval !== null && ( data_get($approval,'first.profile_assign.id') ==  $profile->id ) || $infoUpdate !== null && ( data_get($infoUpdate,'first.profile_assign.id') ==  $profile->id ) ) 
                    <a class="btn btn-primary mar-btm pull-right" href="{{ handles('joesama/project::manager/project/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                        <i class="psi-file-edit icon-fw"></i>
                        {{ __('joesama/project::manager.project.info') }}
                    </a>
                    @endif
                </div>
            </div>
            @include('joesama/project::manager.project.part.projectInfo')
        </div>
        <div id="weekly" class="tab-pane fade">
            {!! $weeklyReport !!}
        </div>
        <div id="monthly" class="tab-pane fade">
            {!! $monthlyReport !!}
        </div>
        @if($project->active)
        <div id="update" class="tab-pane fade">
            {!! $projectUpdate !!}
        </div>
        <div id="approval" class="tab-pane fade">
            <h5>{{ __('joesama/project::manager.workflow.approval-project') }}</h5>
            @includeIf('joesama/project::manager.project.part.flowRecord',[ 'records' => data_get($project,'approval.workflow')])
        </div>
        @endif
    </div>
</div>