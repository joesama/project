<div class="col-md-12" style="padding: 0px 5px">
    <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#financial" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.financial.summary') }}</h3>
    </div>
    <div class="collapse in" id="financial">
        <div class="panel-body">
            @if ( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager)
            <div class="row">
                <div class="col-md-12 pad-no mar-btm">
                    <a class="btn btn-dark pull-right mar-hor" href="{{ handles('joesama/project::manager/financial/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
                      <i class="psi-numbering-list icon-fw"></i>
                      {{ __('joesama/project::form.financial.record')  }}
                    </a>
                    <a class="btn btn-dark pull-right mar-lft" href="{{ handles('joesama/project::manager/financial/retention/'.request()->segment(4).'/'.request()->segment(5)) }}">
                      <i class="psi-numbering-list icon-fw"></i>
                      {{ __('joesama/project::form.financial.retention')  }}
                    </a>
                    <a class="btn btn-dark pull-right mar-lft" href="{{ handles('joesama/project::manager/financial/lad/'.request()->segment(4).'/'.request()->segment(5)) }}">
                      <i class="psi-numbering-list icon-fw"></i>
                      {{ __('joesama/project::form.financial.lad')  }}
                    </a>
                    <a class="btn btn-dark pull-right mar-lft" href="{{ handles('joesama/project::manager/financial/vo/'.request()->segment(4).'/'.request()->segment(5)) }}">
                      <i class="psi-numbering-list icon-fw"></i>
                      {{ __('joesama/project::form.financial.vo')  }}
                    </a>
                </div>
            </div>
            @endif
            <div class="row mh-byrow">
                <div class="col-md-12 text-right">
                    <div class="panel">
                    <div class="panel-body text-center clearfix">
                            <div class="col-sm-12">
                                <p class="text-lg text-semibold">Project Information</p>
                                <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                    <li class="col-xs-3">
                                        <p class="text-sm text-muted mar-no">
                                            {{ __('joesama/project::form.financial.contractval') }} (RM)
                                        </p>
                                        <span class="text-lg text-semibold text-main">
                                            {{ number_format(data_get($project,'value'),2) }}
                                        </span>
                                    </li>
                                    <li class="col-xs-2">
                                        <p class="text-sm text-muted mar-no">
                                            {{ __('joesama/project::form.financial.duration') }}
                                        </p>
                                        <span class="text-lg text-semibold text-main">
                                            {{ data_get($project,'duration_word') }}
                                        </span>
                                    </li>
                                    <li class="col-xs-2">
                                        <p class="text-sm text-muted mar-no">
                                            Variation Order YTD (RM)
                                        </p>
                                        <span class="text-lg text-semibold text-main">
                                            {{ number_format($vo->get('ytd'),2) }}
                                        </span>
                                    </li>
                                    <li class="col-xs-2">
                                        <p class="text-sm text-muted mar-no">
                                            Variation Order TTD (RM)
                                        </p>
                                        <span class="text-lg text-semibold text-main">
                                            {{ number_format($vo->get('ttd'),2) }}
                                        </span>
                                    </li>
                                    <li class="col-xs-3">
                                        <p class="text-sm text-muted mar-no">
                                            {{ __('joesama/project::form.financial.revise') }}
                                        </p>
                                        <span class="text-lg text-semibold text-main">
                                            {{ number_format((data_get($project,'value')+$vo->get('ttd')),2) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
