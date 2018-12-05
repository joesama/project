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
		  <div class="panel-heading">
		  	<div class="panel-control">
		    	<button class="btn btn-primary" data-toggle="modal" data-target="#projectModal">
		        	<i class="ion-plus-round"></i>&nbsp;Project
		      	</button>
		  	</div>
	      	<h3 class="panel-title text-bold">Project</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-striped table-bordered table-striped" cellspacing="0" width="100%" id="project-table" >
		  		<thead>
		  			<tr class="text-light">
		  				<th width="15px">No.</th>
		  				<th>{{ __('joesama/project::project.info.name') }}</th>
		  				<th width="120px">PIC</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.no') }}</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.date.start') }}</th>
		  				<th width="120px">{{ __('joesama/project::project.info.contract.date.end') }}</th>
		  				<th width="100px">Action</th>
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
		  					<a href="{{ handles('joesama/project::project/info/'.data_get($title,'id')) }}" class="btn btn-default btn-circle btn-icon">
			                  <i class="psi-magnifi-glass"></i>
			                </a>
		  					<a href="{{ handles('joesama/project::report/project/'.data_get($title,'id')) }}" class="btn btn-default btn-circle btn-icon">
			                  <i class="psi-file-edit"></i>
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
		<div class="panel">
		  <div class="panel-heading">
		  	<div class="panel-control">
		  		<button class="btn btn-primary" data-toggle="modal" data-target="#taskModal" data-title="New Task">
		  			<i class="ion-plus-round"></i>&nbsp;Task
		      	</button>
		  	</div>
	      	<h3 class="panel-title text-bold">Open Task</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="text-light">
		  				<th width="15px">No.</th>
		  				<th>{{ __('joesama/project::project.task.task') }}</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			<tr>
		  				<td colspan="3" class="text-center text-capitalize">Tiada Data</td>
		  			</tr>
		  		</tbody>
		  	</table>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
		  <div class="panel-heading">
		  	<div class="panel-control">
		  		<button class="btn btn-primary" data-toggle="modal" data-target="#issueModal" data-title="New Issue">
		  			<i class="ion-plus-round"></i>&nbsp;Issue
		      	</button>
		  	</div>
	      	<h3 class="panel-title text-bold">Issue</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="text-light">
		  				<th width="15px">No.</th>
		  				<th>Issue</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			<tr>
		  				<td colspan="3" class="text-center text-capitalize">Tiada Data</td>
		  			</tr>
		  		</tbody>
		  	</table>
		  </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel">
		  <div class="panel-heading">
		  	<div class="panel-control">
		  		<button class="btn btn-primary" data-toggle="modal" data-target="#riskModal" data-title="New Risk">
		  			<i class="ion-plus-round"></i>&nbsp;Risk
		      	</button>
		  	</div>
	      	<h3 class="panel-title text-bold">Risk</h3>
		  </div>
		  <div class="panel-body">
		  	<table class="table table-sm table-borderless table-striped">
		  		<thead>
		  			<tr class="text-light">
		  				<th width="15px">No.</th>
		  				<th>Risk</th>
		  				<th width="15px">Action</th>
		  			</tr>
		  		</thead>
		  		<tbody>
		  			<tr>
		  				<td colspan="3" class="text-center text-capitalize">Tiada Data</td>
		  			</tr>
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


    // DATA TABLES
    // =================================================================
    // Require Data Tables
    // -----------------------------------------------------------------
    // http://www.datatables.net/
    // =================================================================

    $.fn.DataTable.ext.pager.numbers_length = 5;


    // Basic Data Tables with responsive plugin
    // -----------------------------------------------------------------
    $('#project-table').dataTable( {
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="psi-arrow-left"></i>',
              "next": '<i class="psi-arrow-right"></i>'
            }
        }
    } );

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

</script>
@endpush