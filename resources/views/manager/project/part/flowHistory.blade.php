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
        <h3 class="panel-title">{{ config('joesama/project::workflow.process.'.data_get($workflow,'type')) }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="workflow">
      <div class="panel-body text-center approvalPanel">
          <table class="table table-bordered table-condensed">
            <tr>
              <th class="text-bold text-main text-center bg-dark" style="width: 15%;color: white;">
                {{ __('joesama/project::form.process.status') }}
              </th>
              <th class="text-bold text-main text-center bg-dark" style="width: 25%;color: white;">
                {{ __('joesama/project::form.process.assignee') }}
              </th>
              <th class="text-bold text-main text-center bg-dark" style="color: white;">
                {{ __('joesama/project::form.process.remark') }}
              </th>
              <th class="text-bold text-main text-center bg-dark" style="width: 15%;color: white;">
                {{ __('joesama/project::form.process.date') }}
              </th>
            </tr>
          @foreach($workflow->get('record') as $record)
                <tr>
                    <td class="text-normal text-uppercase">
                        {{ data_get($record,'state') }}
                    </td>
                    <td class="text-normal">
                        {{ data_get($record,'profile.name') }}
                    </td>
                    <td class="text-normal">
              {!! data_get($record,'remark') !!}
                    </td>
                    <td class="text-normal">
                        {{ Carbon\Carbon::parse(data_get($record,'created_at'))->format('d-m-Y H:i:s') }}
                    </td>
                </tr>
          @endforeach
          </table>
      </div>
    </div>
  </div>
</div>