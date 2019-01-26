<div class="col-md-6" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#{{$tableId}}" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __($title) }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="{{$tableId}}">
      <div class="panel-body">
        <div class="table-responsive">
          {!! $table !!}
        </div>
      </div>
    </div>
  </div>
</div>