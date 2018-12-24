<div class="panel panel-primary">
  <div class="panel-heading" id="headingRisk">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#risk" aria-expanded="true" aria-controls="budget">
          {{ __('joesama/project::project.category.risk') }}
      </a>
    </h4>
  </div>
  <div id="risk" class="panel-collapse collapse in" aria-labelledby="headingRisk" >
    <div class="panel-body">
      {!! $riskTable !!}
    </div>
  </div>
</div>