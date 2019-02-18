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
        <h3 class="panel-title">{{ __('joesama/project::manager.workflow.approval') }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center approvalPanel">
    @php
        
      $corporateId = $project->corporate_id;
      $projectId = $project->id;
      $reportStart = '';
      $reportEnd = '';
      $reportDue = '';
      $last_status = '';
      $action = route('api.workflow.approval',[$corporateId,$projectId]);
      $firstStep = $approvalWorkflow->pluck('step')->first();
      $sliceIndex = $approvalWorkflow->pluck('step')->search(data_get($project,'approval.need_step'));
      $next = $approvalWorkflow->slice($sliceIndex+1,1)->first();
      $back = $approvalWorkflow->first();
      $currentAction = $approvalWorkflow->where('profile.user_id',auth()->id())
                      // ->where("approval",null)
                      ->where("step",data_get($project,'approval.need_step'))
                      ->first();
      $allTrails = data_get($project,'approval.workflow');
      $profileRole = data_get($currentAction,'profile.pivot.role_id');
    @endphp
        @foreach($allTrails as $trail)
          @include('joesama/project::report.workflow.panel-info',[
            'status' => data_get($trail,'state'),
            'record' => $trail,
            'profile' => data_get($trail,'profile'),
          ])
          @php
          $last_status = data_get($trail,'state');
          @endphp
        @endforeach
        @if( $currentAction )
          @include('joesama/project::report.workflow.panel-form',[
          'back_state' => data_get($back,'step'),
          'state' => data_get($currentAction,'step'),
          'need_action' => data_get($next,'profile.id'),
          'need_step' => data_get($next,'step'),
          'status' => data_get($currentAction,'status'),
          'last_status' => $last_status,
          'profile' => data_get($currentAction,'profile'),
          'back_action' => ($firstStep != data_get($project,'approval.need_step') && $profileRole != 2) ? data_get($back,'profile.id') : FALSE,
          'back_step' => data_get($back,'step'),
          'back_status' => 'rejected',
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