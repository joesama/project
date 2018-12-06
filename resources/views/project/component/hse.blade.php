@push('pages.style')

<style type="text/css">

#hseCard h1.card-title{
  font-size: 5rem;
}

</style>

@endpush
<div class="panel panel-primary">
  <div class="panel-heading" id="headingHse">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#hse" aria-expanded="true" aria-controls="budget">
          {{ __('joesama/project::project.category.hse') }}
      </a>
    </h4>
  </div>
  <div id="hse" class="panel-collapse collapse in" aria-labelledby="headingHse" >
    <div class="panel-body">
      <div class="row" id="hseCard">
        @foreach(config('joesama/project::data.hse') as $key => $title)
        <div class=" col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <h1 class="card-title">0</h1>
            </div>
            <div class="font-weight-bold card-footer bg-primary text-light">
              {{ ucwords($title) }}
              @if(is_null($id))
              <a href="#" class="btn btn-sm btn-action report" onclick="opensafety(this)">
                <i class="fas fa-plus"></i>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
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