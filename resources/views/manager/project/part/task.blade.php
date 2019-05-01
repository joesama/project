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
      data.addColumn('string', 'Resource');
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
            "{!! data_get($schedule,'assignee.abbr') !!}",
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
        barHeight:10,
        gantt: {
          labelStyle: {
            fontName: 'Arial',
            fontSize: 14,
            color: '#757575'
          },
          palette: [
            {
              "color": "#008000",
              "dark": "#004d00",
              "light": "#e6ffe6"
            },
            {
              "color": "#5e97f6",
              "dark": "#2a56c6",
              "light": "#c6dafc"
            },
            {
              "color": "#db4437",
              "dark": "#a52714",
              "light": "#f4c7c3"
            },
            {
              "color": "#f2a600",
              "dark": "#ee8100",
              "light": "#fce8b2"
            },
            {
              "color": "#0f9d58",
              "dark": "#0b8043",
              "light": "#b7e1cd"
            },
            {
              "color": "#ab47bc",
              "dark": "#6a1b9a",
              "light": "#e1bee7"
            },
            {
              "color": "#00acc1",
              "dark": "#00838f",
              "light": "#b2ebf2"
            },
            {
              "color": "#ff7043",
              "dark": "#e64a19",
              "light": "#ffccbc"
            },
            {
              "color": "#9e9d24",
              "dark": "#827717",
              "light": "#f0f4c3"
            },
            {
              "color": "#5c6bc0",
              "dark": "#3949ab",
              "light": "#c5cae9"
            },
            {
              "color": "#f06292",
              "dark": "#e91e63",
              "light": "#f8bbd0"
            },
            {
              "color": "#00796b",
              "dark": "#004d40",
              "light": "#b2dfdb"
            },
            {
              "color": "#c2185b",
              "dark": "#880e4f",
              "light": "#f48fb1"
            }
          ],
          criticalPathEnabled: false
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
@endif
@endpush