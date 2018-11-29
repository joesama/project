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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                      <button class="btn btn-dark float-right"  data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="newtask(this)">
                        <i class="far fa-calendar-plus"></i>&nbsp;{{ __('joesama/project::project.issues.name') }}
                      </button>
                </div>
                <div class="card-body">
                  <table class="table table-sm table-borderless table-striped">
                    <thead>
                      <tr>
                        <th width="10px" class="bg-primary text-light">No.</th>
                        <th class="bg-primary text-light w-50">
                          {{ __('joesama/project::project.issues.name') }}
                        </th>
                        <th class="bg-primary text-light" width="100px">PIC</th>
                        <th class="bg-primary text-light" width="100px">
                          {{ __('joesama/project::project.issues.dateline') }}
                        </th>
                        <th class="bg-primary text-light" width="100px">
                          {{ __('joesama/project::project.issues.progress') }}
                        </th>
                        <th class="bg-primary text-light" width="50px">
                          {{ __('joesama/project::project.action') }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($component as $key => $taskschedule)

                      <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td> {{ data_get($taskschedule,'name') }}</td>                  
                        <td>{{ data_get($taskschedule,'pic') }}</td> 
                        <td>{{ data_get($taskschedule,'dateline') }}</td> 
                        <td class="text-center">{{ data_get($taskschedule,'progress') }}</td>
                        <td class="text-center">
                            <button class="btn btn-dark btn-sm" onclick="editschedule(this)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">New Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="taskForm">
        <div class="form-group">
            <label for="formGroupExampleInput">{{ __('joesama/project::project.task.task') }}</label>
            <input type="text" id="task" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.task') }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">
                  {{ __('joesama/project::project.task.date.start') }}
            </label>
            <input type="text" id="start" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.date.start') }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">
                  {{ __('joesama/project::project.task.date.end') }}
            </label>
            <input type="text" id="end" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.date.end') }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">
                  {{ __('joesama/project::project.task.progress') }}
            </label>
            <input type="text" id="progress" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.progress') }}">
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="savedata()">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('content.script')
  <script type="text/javascript">

    var task = @json($component);

    function newtask(modal) {
      $('#scheduleModal .modal-title').text('New Task');
      $('#scheduleModal').modal('show');
    }
    function editschedule(modal) {
      $('#scheduleModal .modal-title').text('Edit Schedule');
      $('#scheduleModal table td #task').text($(modal.closest('td')).text());
      $('#scheduleModal').modal('toggle')
    }

    function savedata(){

        var formData = $("form#taskForm :input").serializeArray();
        console.log($(document.getElementById("taskForm")).serializeArray());
    }

  </script>
@endpush