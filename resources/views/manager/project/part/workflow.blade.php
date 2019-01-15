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
          <div class="row">
            <div class="col-md-12 text-center">
              @foreach($workflow as $state => $workflow)
                @if( ( is_null( data_get($workflow,'weekly') ) || is_null( data_get($workflow,'monthly') ) )  && $state == "pm")
                  @include('joesama/project::report.workflow.panel-info',[
                      'state' => $state,
                      'status' => data_get($workflow,'status'),
                      'profile' => data_get($workflow,'profile'),
                    ])
                @elseif( !is_null( data_get($workflow,'weekly') ) || !is_null( data_get($workflow,'monthly') ) )
                  @include('joesama/project::report.workflow.panel-info',[
                      'state' => $state,
                      'status' => data_get($workflow,'status'),
                      'profile' => data_get($workflow,'profile'),
                    ])
                @endif
              @endforeach
            </div>
          </div>
          @php
            $isManager = data_get($profile,'role')->filter(function($role) use($project){
                return $role->where('id',2)->where('pivot.profile_id',data_get($project,'id'));
            });
          @endphp
          @if( ( is_null( data_get($workflow,'weekly') ) || is_null( data_get($workflow,'monthly') ) ) && $isManager->isNotEmpty() )
          <div class="row">
            <div class="col-md-3 pad-hor">
              @if( is_null( data_get($workflow,'weekly') ) )
              <a class="btn btn-dark mar-btm" href="{{handles('joesama/projet::report/weekly/form/'.$project->corporate_id.'/'.$project->id)}}" style="width:200px">
                <i class="psi-file-add icon-fw"></i>
                {{ __('joesama/project::manager.workflow.weekly') }}
              </a>
              @endif
              @if( is_null( data_get($workflow,'monthly') ) )
              <a class="btn btn-dark" href="{{handles('joesama/projet::report/monthly/form/'.$project->corporate_id.'/'.$project->id)}}" style="width: 200px">
                <i class="psi-file-add icon-fw"></i>
                {{ __('joesama/project::manager.workflow.monthly') }}
              </a>      
              @endif      
            </div>
          </div>
          @endif
      </div>
    </div>
  </div>
</div>