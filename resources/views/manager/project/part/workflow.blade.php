<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#workflow" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.workflow.report') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center">
          <a class="btn btn-dark text-2x" href="{{handles('joesama/projet::report/weekly/form/'.$project->corporate_id.'/'.$project->id)}}">
            <i class="psi-file-add icon-fw"></i>
            {{ __('joesama/project::manager.workflow.weekly') }}
          </a>
          <a class="btn btn-dark text-2x" href="{{handles('joesama/projet::report/monthly/form/'.$project->corporate_id.'/'.$project->id)}}">
            <i class="psi-file-add icon-fw"></i>
            {{ __('joesama/project::manager.workflow.monthly') }}
          </a>
      </div>
    </div>
  </div>
</div>