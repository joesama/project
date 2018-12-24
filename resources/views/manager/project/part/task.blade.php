<div class="panel panel-primary">
  <div class="panel-heading" id="headingOne">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#schedule" aria-expanded="true" aria-controls="schedule">
          {{ __('joesama/project::project.category.schedule') }}
      </a>
    </h4>
  </div>
  <div id="schedule" class="panel-collapse collapse in" aria-labelledby="headingOne" >
    <div class="panel-body">
      {!! $scheduleTable !!}
      @php
        $task = data_get($project,'task');
      @endphp
      <div class="clearfix">&nbsp;</div>
      <div class="row">
        <div class="col-md-12">
          <div id="chart_div"></div>
        </div>
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
        @foreach($task as $key => $schedule)
          [ 
            "{{ $key+1 }}", 
            "{!! data_get($schedule,'name') !!}", 
            new Date("{!! data_get($schedule,'start') !!}"), 
            new Date("{!! data_get($schedule,'end') !!}"), 
            null ,
            {!! data_get($schedule,'progress.progress') !!}, 
            null 
          ],
        @endforeach
      ]);

      var options = {
        height: 400
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
@endpush