<div class="panel panel-primary">
  <div class="panel-heading" id="headingOne">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#schedule" aria-expanded="true" aria-controls="schedule">
          {{ __($title) }}
      </a>
    </h4>
  </div>
  <div id="schedule" class="panel-collapse collapse in" aria-labelledby="headingOne" >
    <div class="panel-body">
      {!! $table !!}
    </div>
  </div>
</div>