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

    <!--Panel body-->
    <div class="collapse in" id="financial">
      <div class="panel-body">
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
        <div class="row mh-byrow">
          <div class="col-md-1"></div>
          <div class="col-md-2 text-right">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center pad-ver">
                    <i class="pli-coin icon-3x"></i>
                </div>
                <div class="pad-btm text-center">
                    <p class="text-2x text-semibold text-lg mar-no">
                    {{ __('joesama/project::form.financial.value') }}
                    </p>
                    <p class="text-bold mar-no">
                      {{ number_format(data_get($project,'value'),2) }}
                    </p>
                    <p class="text-2x text-semibold text-lg mar-no">
                    {{ __('joesama/project::form.financial.duration') }}
                    </p>
                    <p class="text-bold mar-no">
                    {{ \Carbon\Carbon::parse(data_get($project,'start'))->diffInYears(\Carbon\Carbon::parse(data_get($project,'end'))) }} Years
                    </p>
                </div>
            </div>
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.vo'),
                'chartId' => 'vo',
                'transData' => $vo,
                'background' => 'primary'
              ])
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.revise'),
                'chartId' => 'revise',
                'transData' => $vo,
                'background' => 'primary'
              ])
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.claim'),
                'chartId' => 'claim',
                'transData' => $claim,
                'background' => 'warning'
              ])
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.paid'),
                'chartId' => 'paid',
                'transData' => $payment,
                'background' => 'mint'
              ])
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.lad'),
                'chartId' => 'lad',
                'transData' => $lad,
                'background' => 'danger'
              ])
          </div>
          <div class="col-md-3 text-right">
            @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.retention'),
                'chartId' => 'retention',
                'transData' => $retention,
                'background' => 'danger'
              ])
          </div>
          <div class="col-md-2 text-right">
            <div class="panel panel-{{ ($balanceSheet > 0)  ? 'success' : 'danger' }} panel-colorful">
                <div class="panel-body text-center pad-ver">
                    <i class="pli-coin icon-3x"></i>
                </div>
                <div class="pad-btm text-center">
                    <p class="text-2x text-semibold text-lg mar-no">
                    {{ __('joesama/project::form.financial.balance') }}
                    </p>
                    <p class="text-bold mar-no">
                      {{ $balanceSheet }}
                    </p>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
