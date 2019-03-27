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
    </ul>

    <!--Tabs Content-->
    <div class="tab-content">
        <div id="info" class="tab-pane fade active in">
            @include('joesama/project::manager.project.part.projectInfo')
        </div>
        <div id="weekly" class="tab-pane fade">
            {!! $weeklyReport !!}
        </div>
        <div id="monthly" class="tab-pane fade">
            {!! $monthlyReport !!}
        </div>
    </div>
</div>