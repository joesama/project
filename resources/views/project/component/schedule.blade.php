<div class="card">
  <div class="card-header py-0 bg-default" id="headingOne">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#schedule" aria-expanded="true" aria-controls="schedule">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.schedule') }}
          </h4>
      </button>
  </div>
  <div id="schedule" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
    <div class="card-body">
      @if(is_null($id))
      <a href="{{ handles('joesama/project::project/task/'.$projectId) }}" class="btn btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"onclick="openischedule(this)">
        <i class="far fa-calendar-plus"></i>&nbsp;{{ __('joesama/project::project.task.task') }}
      </a>
      @endif
      <table class="table table-sm table-borderless table-striped">
        <thead>
          <tr>
            <th class="bg-primary text-light">No.</th>
            <th class="bg-primary text-light w-50">
              {{ __('joesama/project::project.task.task') }}
            </th>
            <th class="bg-primary text-light">PIC</th>
            <th class="bg-primary text-light" width="150px">
              {{ __('joesama/project::project.task.date.start') }}
            </th>
            <th class="bg-primary text-light" width="150px">
              {{ __('joesama/project::project.task.date.end') }}
            </th>
            <th class="bg-primary text-light" width="100px">
              {{ __('joesama/project::project.task.progress') }}
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach(config('joesama/project::data.progress') as $key => $taskschedule)
          <tr>
            <td>{{ $key+1 }}</td>
            <td> {{ data_get($taskschedule,'task') }}</td>                  
            <td>{{ data_get($taskschedule,'pic') }}</td> 
            <td>{{ data_get($taskschedule,'start') }}</td>    
            <td>{{ data_get($taskschedule,'end') }}</td>   
            <td>{{ data_get($taskschedule,'progress') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="clearfix">&nbsp;</div>
      <div class="row">
        <div class="col-md-12">
          <div id="chart_div"></div>
        </div>
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
          <table class="table table-sm table-borderless">
            <tbody>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.task.task') }}
                </td>
                <td class="text-left form-group">
                  <input type="text" id="task" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.task') }}">
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.task.date.start') }}
                </td>
                <td class="text-left form-group">
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.date.start') }}">
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.task.date.end') }}
                </td>
                <td class="text-left form-group">
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.date.end') }}">
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.task.progress') }}
                </td>
                <td class="text-left form-group">
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="{{ __('joesama/project::project.task.progress') }}">
                </td>
              </tr>
              <tr>
                <td class="w-25 text-light bg-secondary">
                  Remarks
                </td>
                <td class="text-justify form-group" height="100px">
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
@push('pages.script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');

      data.addRows([
        @foreach(config('joesama/project::data.progress') as $key => $taskschedule)
          [ "{{$key}}", "{{ data_get($taskschedule,'task') }}", new Date("{{ data_get($taskschedule,'start') }}"), new Date("{{ data_get($taskschedule,'end') }}"), null ,{{ data_get($taskschedule,'progress') }}, null ],
        @endforeach
      ]);

      var options = {
        height: 400
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
  <script type="text/javascript">
    function openischedule(modal) {
      $('#scheduleModal .modal-title').text('New Schedule');
      $('#scheduleModal').modal('toggle')
    }
    function editschedule(modal) {
      $('#scheduleModal .modal-title').text('Edit Schedule');
      console.log($(modal.closest('td')).text());
      $('#scheduleModal table td #task').text($(modal.closest('td')).text());
      $('#scheduleModal').modal('toggle')
    }
  </script>
@endpush