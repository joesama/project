<div class="col-md-12" style="padding: 0px 5px">
  <div class="panel">
    <div class="panel-heading bg-primary">
        <div class="panel-control">
            <button class="btn btn-default" data-panel="fullscreen">
                <i class="icon-max psi-maximize-3"></i>
                <i class="icon-min psi-minimize-3"></i>
            </button>
            <button class="btn btn-default collapsed" data-panel="minmax" data-target="#{{$tableId}}" data-toggle="collapse" aria-expanded="false"><i class="psi-chevron-up"></i></button>
        </div>
        <h3 class="panel-title">{{ __($title) }}</h3>
    </div>

    <!--Panel body-->
    <div class="collapse in" id="{{$tableId}}">
      <div class="panel-body">
            {!! $table !!}
            @php
              $task = data_get($project,'task');
            @endphp
            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-md-12" style="overflow: auto;padding: 10px 0px;">
                <div id="chart_div"></div>
              </div>
            </div>
      </div>
    </div>
  </div>
</div>
@push('pages.script')
@if($task->count() > 0)
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
      var height = data.getNumberOfRows() * 41 + 50;
      var options = {
        height: height,
        barHeight:10
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
@endif
@endpush