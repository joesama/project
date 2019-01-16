<!--Shortcut buttons-->
<!--================================-->
<div id="mainnav-shortcut">
    <ul class="list-unstyled shortcut-wrap">
        <li class="col-xs-3" data-content="{{ trans('joesama/project::manager.dashboard.overall') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/entree::'.config('joesama/entree::entree.landing','home')) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                <i class="pli-project "></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="{{ trans('joesama/project::dashboard.portfolio.master') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::dashboard/portfolio/master/'.request()->segment(4)) !!}"">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                <i class="psi-bar-chart-2"></i>
                </div>
            </a>
        </li>
        <li class="col-xs-3" data-content="{{ trans('joesama/project::manager.project.list') }}">
            <a class="shortcut-grid" href="{!! handles('joesama/project::manager/project/list/'.request()->segment(4)) !!}">
                <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                <i class="pli-calendar"></i>
                </div>
            </a>
        </li>
    </ul>
</div>
<!--================================-->
<!--End shortcut buttons-->