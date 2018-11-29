@extends('joesama/entree::layouts.content')
@push('content.style')
<style type="text/css">
    .btn-action{
        padding: 0px 4px;
        float: right;
        color: white;
    }
</style>
@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="card">
		  <div class="card-header bg-primary font-weight-bold text-light">
		    <button class="btn btn-action text-dark" onclick="newProject(this)">
		        <i class="fas fa-plus"></i>
		      </button>
		      <h4 class="mb-0">Project</h4>
		  </div>
		  <div class="card-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="bg-dark text-light">
		  				<th width="15px">No.</th>
		  				<th>{{ __('joesama/project::project.info.name') }}</th>
		  				<th width="120px">PIC</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.no') }}</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.date.start') }}</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.date.end') }}</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			@foreach($project as $key => $title)
		  			<tr>
		  				<td class="text-center">{{$key+1 }}</td>
		  				<td class="text-justify">{{ data_get($title,'name') }}</td>
		  				<td>{{ data_get($title,'pic') }}</td>
		  				<td>{{ data_get($title,'contract.no') }}</td>
		  				<td>{{ data_get($title,'start') }}</td>
		  				<td>{{ data_get($title,'end') }}</td>
		  				<td class="text-center">
		  					<a href="{{ handles('joesama/project::project/info/'.data_get($title,'id')) }}" class="btn btn-sm btn-secondary">
			                  <i class="far fa-eye"></i>
			                </a>
		  				</td>
		  			</tr>
		  			@endforeach
		  		</tbody>
		  	</table>
		  </div>
		</div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
		<div class="card mb-5">
		  <div class="card-header bg-primary font-weight-bold text-light">
		    <button class="btn btn-action text-dark" data-toggle="modal" data-target="#taskModal" data-title="New Task">
		        <i class="fas fa-plus"></i>
		      </button>
		      <h4 class="mb-0">Open Task</h4>
		  </div>
		  <div class="card-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="bg-dark text-light">
		  				<th width="15px">No.</th>
		  				<th>{{ __('joesama/project::project.task.task') }}</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>

		  		</tbody>
		  	</table>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card mb-5">
		  <div class="card-header bg-primary font-weight-bold text-light">
		    <button class="btn btn-action text-dark" data-toggle="modal" data-target="#issueModal" data-title="New Issue">
		        <i class="fas fa-plus"></i>
		      </button>
		      <h4 class="mb-0">Open Issues</h4>
		  </div>
		  <div class="card-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="bg-dark text-light">
		  				<th width="15px">No.</th>
		  				<th>Issue</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>

		  		</tbody>
		  	</table>
		  </div>
		</div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-capitalize font-weight-bold text-light" id="exampleModalLabel">New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-capitalize font-weight-bold text-light" id="exampleModalLabel">New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-capitalize font-weight-bold text-light" id="exampleModalLabel">New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('content.script')
<script type="text/javascript">
  function newProject(modal) {
    // $('#projectModal .modal-title').text($(modal.closest('th')).text());
    $('#projectModal').modal('toggle')
  }

$('#taskModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var recipient = button.data('title') 
  console.log(recipient);
  var modal = $(this)
  modal.find('.modal-title').text(recipient)
})

$('#issueModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var recipient = button.data('title') 
  console.log(recipient);
  var modal = $(this)
  modal.find('.modal-title').text(recipient)
})

</script>

</script>
@endpush