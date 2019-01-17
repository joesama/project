<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#hse" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.hse.view') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="hse">
      <div class="panel-body">
          @if(!is_null($hsecard))
            @if($project->active)
            <div class="row">
              <div class="col-md-6">
                <p class="text-bold mar-no">
                  {{ __('joesama/project::form.project_incident.last') }}&nbsp;:&nbsp;
                  {{ Carbon\Carbon::parse(data_get(collect(data_get($project,'incident'))->first(),'created_at'))->format('d/m/Y') }}
                </p>
              </div>
              <div class="col-md-6">
                <a class="btn btn-dark mar-btm pull-right mar-rgt" href="{{ handles('joesama/project::manager/hse/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                  <i class="psi-pen-5 icon-fw"></i>
                  {{ __('joesama/project::manager.hse.form') }}
                </a>
                <a class="btn btn-dark mar-btm pull-right mar-rgt" href="{{ handles('joesama/project::manager/hse/list/'.request()->segment(4).'/'.request()->segment(5)) }}">
                  <i class="psi-numbering-list icon-fw"></i>
                  {{ __('joesama/project::manager.hse.list') }}
                </a>
              </div>
            </div>
            @endif
            @foreach(collect($hsecard->toArray())->except(['id','created_at','updated_at','deleted_at']) as $field => $hse)
              @includeIf('joesama/project::manager.project.part.card-panel',[
                  'id' => $field,
                  'title' => __('joesama/project::form.project_hse.'.$field),
                  'value' => $hse,
                ])
            @endforeach()
          @endif
      </div>
    </div>
  </div>
</div>