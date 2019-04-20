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
          <div class="col-md-4 text-right">
            <div class="panel panel-dark panel-colorful">
                <div class="pad-all text-left">
                    <p class="text-lg text-semibold">
                      <i class="pli-coins icon-fw"></i> 
                      Project Information
                    </p>
                    <p class="mar-no text-semibold">
                      <span class="text-left text-semibold">
                        {{ __('joesama/project::form.financial.duration') }}
                      </span>
                      <span class="pull-right text-semibold">
                        {{ data_get($project,'duration_word') }}
                      </span>
                    </p>
                    <p class="mar-no text-semibold">
                      <span class="text-left text-semibold">
                        {{ __('joesama/project::form.financial.contractval') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format(data_get($project,'value'),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-semibold">
                      <span class="text-left text-bold">
                        {{ __('joesama/project::form.financial.vo') }} YTD
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($vo->get('ytd'),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-semibold">
                      <span class="text-left text-bold">
                        {{ __('joesama/project::form.financial.vo') }} TTD
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($vo->get('ttd'),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-semibold">
                      <span class="text-left text-bold">
                        {{ __('joesama/project::form.financial.revise') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format((data_get($project,'value')+$vo->get('ttd')),2) }}
                      </span>
                    </p>
                </div>
            </div>
          </div>
          @php
            $color = collect(['warning','mint','info','danger'])
          @endphp
          @foreach($paymentTrans as $key => $payTransaction)
            <div class="col-md-4 text-right">
              @includeIf('joesama/project::manager.project.part.sparkline',[
                'title' => __('joesama/project::form.financial.'.$key),
                'chartId' => $key,
                'transData' => $payTransaction,
                'background' => $color->first()
              ])
            </div>
            @php
              $arranger = $color->slice(1,$color->count())->push($color->first())->toArray();
              $color->splice(0,1,$arranger);
            @endphp
          @endforeach
          <div class="col-md-4 text-right">
            <div class="panel panel-{{ ($balanceSheet->get('balanceContract',0) > 0)  ? 'success' : 'danger' }} panel-colorful">
                <div class="panel-body text-center pad-ver">
                    <i class="pli-calculator icon-3x"></i>
                </div>
                <div class="pad-all text-left">
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-plus icon-fw"></i>
                        {{ __('joesama/project::form.financial.retentionTo') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('rententionTo',0),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-minus icon-fw text-danger"></i>
                        {{ __('joesama/project::form.financial.paymentFrom') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('paymentIn',0),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-minus icon-fw text-danger"></i>
                        {{ __('joesama/project::form.financial.ladby') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('ladBy',0),2) }}
                      </span>
                    </p>
                    <p class="clearfix"></p>
                    <p class="mar-no text-lg bord-top pad-top">
                      <span class="text-left text-bold">
                        
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('balanceContract',0),2) }}
                      </span>
                    </p>
                    <p class="clearfix"></p>
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-minus icon-fw text-danger"></i>
                        {{ __('joesama/project::form.financial.retentionBy') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('rententionBy',0),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-minus icon-fw text-danger"></i>
                        {{ __('joesama/project::form.financial.paymentTo') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('paymentOut',0),2) }}
                      </span>
                    </p>
                    <p class="mar-no text-sm">
                      <span class="text-left text-bold">
                        <i class="fa fa-plus icon-fw"></i>
                        {{ __('joesama/project::form.financial.ladto') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('ladTo',0),2) }}
                      </span>
                    </p>
                    <p class="clearfix"></p>
                    <p class="mar-no text-lg bord-top pad-top">
                      <span class="text-left text-bold">
                        {{ __('joesama/project::form.financial.balance') }}
                      </span>
                      <span class="pull-right text-semibold">
                        RM {{ number_format($balanceSheet->get('financialend',0),2) }}
                      </span>
                    </p>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
