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
        {!! $tableWeekly !!}
      </div>
    </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
		  <div class="panel-body">
		  	{!! $tableMonthly !!}
		  </div>
		</div>
    </div>
</div>
<div class="row">
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