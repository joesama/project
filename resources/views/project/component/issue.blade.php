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
      <button class="btn btn-dark float-right mb-2" onclick="openissue(this)">
        <i class="fas fa-plus"></i>
      </button>
      <div class="clearfix">&nbsp;</div>
      <table class="table table-sm table-bordered table-striped">
        <thead>
          <tr class="bg-primary text-light">
            <th width="15px">No.</th>
            <th>
            Issues
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">1</td>
            <td>Land acquisition from Majlis Daerah Tg Malim & JKR for 33 kV transmission line work
              <a href="#" class="btn btn-sm text-dark btn-action" onclick="editissue(this)">
                  <i class="far fa-edit"></i>
                </a>
            </td>
          </tr>
          <tr>
            <td class="text-center">2</td>
            <td>Equipment delivery to PMU Slim River<a href="#" class="btn btn-sm text-dark btn-action" onclick="editissue(this)">
                  <i class="far fa-edit"></i>
                </a>
            </td>
          </tr>
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