<div class="card">
  <div class="card-header py-0 bg-default" id="headingIssue">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#issues" aria-expanded="true" aria-controls="issues">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.issue') }}
          </h4>
      </button>
  </div>
  <div id="issues" class="collapse show" aria-labelledby="headingIssue" data-parent="#accordionExample">
    <div class="card-body">
      @if(is_null($id))
      <a href="{{ handles('joesama/project::project/issues/'.$projectId) }}" class="btn btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"onclick="openischedule(this)">
        <i class="far fa-calendar-plus"></i>&nbsp;{{ __('joesama/project::project.issues.name') }}
      </a>
      @endif
      <div class="clearfix">&nbsp;</div>
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr class="bg-primary text-light">
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
            <i class="{{ config('joesama/project::data.status.icon.'.data_get($issues,'priority')) }} text-{{ config('joesama/project::data.status.color.'.data_get($issues,'priority')) }}"></i>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">New Issue</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-sm table-borderless">
            <tbody>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  Date
                </td>
                <td class="text-left form-group">
                  {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  Issue
                </td>
                <td class="text-left form-group">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@push('content.script')

<script type="text/javascript">
  function openissue(modal) {
    $('#issueModal').modal('toggle')
  }
  function editissue(modal) {
    $('#issueModal .modal-title').text('Edit Issues');
    $('#issueModal textarea').text($(modal.closest('td')).text());
    $('#issueModal').modal('toggle')
  }
</script>
@endpush