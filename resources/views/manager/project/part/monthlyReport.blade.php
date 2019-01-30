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
        <h3 class="panel-title">{{ __('joesama/project::manager.workflow.monthly') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center approvalPanel">
      @php

        $corporateId = request()->segment(4);
        $projectId = request()->segment(5);
        $record = collect(data_get($project,'card'))->where('id',request()->segment(6))->first();

        $firstStep = $monthlyWorkflow->pluck('step')->first();

        $currentAction = $monthlyWorkflow->where('profile.user_id',auth()->id())
                      ->where("step", (!is_null($record)) ? data_get($record,'need_step') : $firstStep )
                      ->first();

        $action = route('api.workflow.process',[$corporateId,$projectId]);
        $sliceIndex = $monthlyWorkflow->pluck('step')->search(data_get($record,'need_step'));
        $next = $monthlyWorkflow->slice($sliceIndex+1,1)->first();
        $back = $monthlyWorkflow->first();

        $allTrails = data_get($record,'workflow');
        $profileRole = data_get($currentAction,'profile.pivot.role_id');

        @endphp
        @if(!is_null($allTrails))
          @foreach($allTrails as $trail)
            @include('joesama/project::report.workflow.panel-info',[
              'status' => data_get($trail,'state'),
              'record' => $trail,
              'profile' => data_get($trail,'profile'),
            ])
          @endforeach
        @endif
        @if( $currentAction )
          @include('joesama/project::report.workflow.panel-form',[
            'back_state' => data_get($back,'step'),
            'state' => data_get($currentAction,'step'),
            'need_action' => data_get($next,'profile.id'),
            'need_step' => data_get($next,'step'),
            'status' => data_get($currentAction,'status'),
            'profile' => data_get($currentAction,'profile'),
            'back_action' => ($firstStep != data_get($record,'need_step') && $profileRole != 2) ? data_get($back,'profile.id') : FALSE,
            'back_step' => data_get($back,'step'),
            'back_status' => 'ammend',
            ])
        @endif
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