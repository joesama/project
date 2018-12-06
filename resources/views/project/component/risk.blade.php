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
      @if(is_null($id))
      <a href="{{ handles('joesama/project::project/risk/'.$projectId) }}" class="btn btn-primary pull-right mar-btm"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"onclick="openischedule(this)">
        <i class="ion-plus-round"></i>&nbsp;{{ __('joesama/project::project.risk.name') }}
      </a>
      @endif
      <div class="clearfix">&nbsp;</div>
      <table class="table table-sm table-bordered">
        <thead>
          <tr>
            <th width="15px">No.</th>
            <th>{{ __('joesama/project::project.issues.name') }}</th>
            <th class="text-center">{{ __('joesama/project::project.issues.status') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach(config('joesama/project::data.issues') as $key => $issues)
          <tr>
            <td class="text-center">{{ $key +1 }}</td>
            <td>{{ data_get($issues,'name') }}</td>
            <td class="text-center">
            <i class="icon-2x {{ config('joesama/project::data.status.icon.'.data_get($issues,'priority')) }} text-{{ config('joesama/project::data.status.color.'.data_get($issues,'priority')) }}"></i>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>