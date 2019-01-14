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
		<div class="panel">
		  <div class="panel-body">
		  	{!! $tableProject !!}
		  </div>
		</div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
		  <div class="panel-body">
		  	{!! $tableTask !!}
		  </div>
		</div>
  </div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel">
		  <div class="panel-body">
		  	{!! $tableIssue !!}
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
		  <div class="panel-body">
		  	{!! $tableRisk !!}
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
      	@include('joesama/project::project.component.project-form')
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
      	@include('joesama/project::project.component.project-issue')
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
      	@include('joesama/project::project.component.project-task')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" id="riskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-capitalize font-weight-bold text-light" id="exampleModalLabel">New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	@include('joesama/project::project.component.project-risk')
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


$(document).on('nifty.ready', function() {

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

	$('#riskModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget)
	  var recipient = button.data('title') 
	  console.log(recipient);
	  var modal = $(this)
	  modal.find('.modal-title').text(recipient)
	})

});

</script>
@stack('datagrid')

@endpush