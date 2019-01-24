<div class="col-md-6" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#physicalCurve" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __('joesama/project::manager.curve.physical') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="physicalCurve">
      <div class="panel-body">
        <div class="row mar-btm">
            <a class="btn btn-dark pull-right" href="{{ handles('joesama/project::manager/financial/retention/'.request()->segment(4).'/'.request()->segment(5)) }}">
              <i class="psi-numbering-list icon-fw"></i>
              {{ __('joesama/project::manager.milestone.physical')  }}
            </a>
        </div>
        <div id="physicalSpline"></div>
      </div>
    </div>
  </div>
</div>
@push('content.script')
<script type="text/javascript">
  
  var chart = bb.generate({
  data: {
    columns: [
      ["planned", 0, 0, 50, 90, 90, 100],
      ["actual", 0, 9, 50, 85, 90, 90],
      ["planned1", 0, 0, 0, 0, 0, 10, 50, 90, 90, 100],
      ["actual1", 0, 0, 0, 0, 0, 0, 50, 90, 90, 90]
    ],
    type: "spline"
  },
  axis: {
    x: {
      label: "Milestone",
      type: "category",
      categories: [
        "Milestone 1",
        "Milestone 2",
        "Milestone 3",
        "Milestone 4",
        "Milestone 5",
        "Milestone 6",
        "Milestone 7",
        "Milestone 8",
        "Milestone 9",
      ]
    },
    y: {
      label: "% Progress"
    }
  },
  bindto: "#physicalSpline"
});

</script>
@endpush