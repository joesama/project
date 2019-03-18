<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#processflow" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::form.process_step.assign') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="processflow">
      <div class="panel-body">
        @includeIf('joesama/project::setup.process.assignationView',['flow' => $processFlow])
      </div>
    </div>
  </div>
</div>