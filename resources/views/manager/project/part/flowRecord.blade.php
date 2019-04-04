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
@foreach($records as $record)
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