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
      $index = 1;
      $corporateId = $project->corporate_id;
      $projectId = $project->id;
      $reportStart = '';
      $reportEnd = '';
      $reportDue = '';
      $action = route('api.workflow.approval',[$corporateId,$projectId]);
      $nextflow = $approvalWorkflow;
    @endphp
    @foreach($approvalWorkflow as $state => $flow)
      @php
        $next = $nextflow->slice($index,1)->first();
        $profile = data_get($flow,'profile');
        $flowRecord = data_get($flow,'approval');
      @endphp
      @if(  is_null( $flowRecord ) && $approvalWorkflow->keys()->first() == $state)
        @if( intval(data_get($profile,'user_id')) == intval(auth()->id()) )
            @include('joesama/project::report.workflow.panel-form',[
            'state' => $state,
            'need_action' => data_get($next,'profile.id'),
            'need_step' => data_get($next,'step'),
            'status' => data_get($flow,'status'),
            'profile' => $profile,
            ])
        @endif
      @elseif( !is_null( $flowRecord  ) )
        @if(data_get($flowRecord,'state') == data_get($flow,'status'))
            @include('joesama/project::report.workflow.panel-info',[
            'state' => $state,
            'status' => data_get($flow,'status'),
            'record' => $flowRecord,
            'profile' => $profile,
            ])
        @endif
      @else
        @if( (intval(data_get($profile,'user_id')) == intval(auth()->id())) && ( intval(data_get($project,'approval.need_step')) == intval($state) ) )
          @include('joesama/project::report.workflow.panel-form',[
          'state' => $state,
          'need_action' => data_get($next,'profile.id'),
          'need_step' => data_get($next,'step'),
          'status' => data_get($flow,'status'),
          'profile' => $profile,
          ])
          @endif
        }
      @endif
      @php
        $index++;
      @endphp
    @endforeach
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