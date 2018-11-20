@push('pages.style')

<style type="text/css">

#hseCard h1.card-title{
  font-size: 5rem;
}

</style>

@endpush
<div class="card">
  <div class="card-header py-0 bg-default" id="headingHse">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#hse" aria-expanded="true" aria-controls="hse">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.hse') }}
          </h4>
      </button>
  </div>
  <div id="hse" class="collapse show" aria-labelledby="headingHse" data-parent="#accordionExample">
    <div class="card-body">
      <div class="row" id="hseCard">
        @foreach(config('joesama/project::data.hse') as $key => $title)
        <div class=" col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <h1 class="card-title">0</h1>
            </div>
            <div class="font-weight-bold card-footer bg-primary text-light">
              {{ ucwords($title) }}
              <a href="#" class="btn btn-sm btn-action report" onclick="opensafety(this)">
                <i class="fas fa-plus"></i>
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-sm table-borderless">
            <tbody>
              <tr>
                <td colspan="4"  class="text-justify form-group" height="100px">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  Date
                </td>
                <td class="text-left form-group">
                  {{ \Carbon\Carbon::now()->format('d-m-Y') }}
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
  function opensafety(modal) {
    var hse = modal.closest('div .card-footer');
    $('#hseModal .modal-title').text($(hse).text());
    $('#hseModal').modal('toggle')
  }
</script>
@endpush