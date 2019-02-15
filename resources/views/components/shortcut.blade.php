<!--Shortcut buttons-->
<!--================================-->
@php
    if(!session()->has('profile-'.auth()->id())){
        $profile = session([
            'profile-'.auth()->id() =>  Joesama\Project\Database\Model\Organization\Profile::where('user_id',auth()->id())
                                        ->with('role')->first()
        ]);
    }else{
        $profile = session('profile-'.auth()->id());
    }
@endphp
<style type="text/css">
#container.mainnav-sm #mainnav-shortcut {
    min-height: 300px;
}
</style>
<div id="mainnav-shortcut">
    <ul class="list-unstyled shortcut-wrap">
        <li class="col-xs-3" data-content="{{ trans('joesama/project::menu.manager.dashboard') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::manager/dashboard/overall/'.$profile->corporate_id) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                <i class="pli-project "></i>
                </div>
            </a>
        </li>
        @if($profile->corporate_id == 1)
        <li class="col-xs-3" data-content="{{ trans('joesama/project::dashboard.portfolio.master') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::dashboard/portfolio/master/'.$profile->corporate_id) !!}"">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                <i class="psi-bar-chart-2"></i>
                </div>
            </a>
        </li>
        @else
        <li class="col-xs-3" data-content="{{ trans('joesama/project::dashboard.portfolio.group') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::dashboard/portfolio/group/'.$profile->corporate_id) !!}"">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                <i class="psi-bar-chart-2"></i>
                </div>
            </a>
        </li>
        @endif
        <li class="col-xs-3" data-content="{{ trans('joesama/project::manager.project.list') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::manager/project/list/'.$profile->corporate_id) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                <i class="pli-calendar"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="{{ trans('joesama/project::manager.workflow.approval-project') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::manager/project/approval/'.$profile->corporate_id) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                <i class="psi-calendar-4"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="{{ trans('joesama/project::report.weekly.list') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::report/weekly/list/'.$profile->corporate_id) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                <i class="psi-note"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="{{ trans('joesama/project::report.monthly.list') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::report/monthly/list/'.$profile->corporate_id) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                <i class="psi-note"></i>
                </div>
            </a>
        </li>
    </ul>
</div>
<!--================================-->
<!--End shortcut buttons-->