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
        <h3 class="panel-title">{{ $title }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center approvalPanel">
          @includeIf('joesama/project::setup.process.workflow',[ 'workflow' => $workflow ])
      </div>
    </div>
  </div>
</div>
@push('content.script')
<script type="text/javascript">
    $('.approvalPanel').each(function() {
        $(this).find('.panel').matchHeight({
            byRow: true
        });
    });
</script>
@endpush