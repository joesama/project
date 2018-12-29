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
            <a class="btn btn-dark pull-right" href="{{ handles('joesama/project::manager/financial/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
              <i class="psi-numbering-list icon-fw"></i>
              {{ __('joesama/project::form.financial.record')  }}
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            
          </div>
          <div class="col-md-6 text-right">

            @includeIf('joesama/project::manager.project.part.sparkline')
            @includeIf('joesama/project::manager.project.part.sparkline')
            @includeIf('joesama/project::manager.project.part.sparkline')

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
