<div class="row">
	<div class="col-md-6 col-lg-6 col-sm-12">
		<div class="panel">
			<div class="panel-heading">
                <h3 class="panel-title">
                	{{ __('joesama/project::portfolio.subsidiary.cost') }}
                </h3>
            </div>
			<div class="panel-body text-center clearfix">
				<div id="bar_div"></div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-sm-12">
		<div class="panel">
			<div class="panel-heading">
                <h3 class="panel-title">
                	{{ __('joesama/project::portfolio.subsidiary.variance') }}
                </h3>
            </div>
			<div class="panel-body text-center clearfix">
				<div id="chart_div"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3 col-lg-3 col-sm-12">
		<div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                	{{ __('joesama/project::portfolio.subsidiary.health') }}
                </h3>
            </div>
            <div class="panel-body">
	            <div class="bord-btm">
	                <ul class="list-group bg-trans">
	                	@foreach($project as $health)
	                    <li class="list-group-item">
	                        <div class="pull-right">
	                            @if(data_get($health,'health') == 1)
								<i class="icon-2x fa fa-check-circle text-success"></i>
								@endif
								@if(data_get($health,'health') == 2)
								<i class="icon-2x fa fa-exclamation-circle text-warning"></i>
								@endif
								@if(data_get($health,'health') == 3)
								<i class="icon-2x fa fa-exclamation-circle text-danger"></i>
								@endif
	                        </div>
	                        <a href="{{ handles('joesama/project::project/info/1') }}" class="add-tooltip text-bold text-2x" data-toggle="tooltip" data-container="body" data-placement="right" data-original-title="{{ __('joesama/project::portfolio.subsidiary.report') }}">
	                        {{data_get($health,'name')}}
	                    	</a>
	                    </li>
	                    @endforeach
	                </ul>
	            </div>
            </div>
        </div>
	</div>
	<div class="col-md-3 col-lg-3 col-sm-12">
		<div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                	{{ __('joesama/project::portfolio.portfolio.task') }}
                </h3>
            </div>
            <div class="panel-body">
				<div id="piechart"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-lg-3 col-sm-12">
		<div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                	{{ __('joesama/project::portfolio.portfolio.issue') }}
                </h3>
            </div>
            <div class="panel-body">
				<div id="donutchart"></div>
			</div>
		</div>
	</div>
</div>
<?php

$sum = collect([]);

collect(collect($project)->pluck('resource'))->each(function($item,$kit) use($sum){
	collect($item)->each(function($let,$name)use($sum){
		$sum->put($name,$sum->get($name)+$let);
	});
});

?>
@push('content.script')
<script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawColColors);
	google.charts.setOnLoadCallback(drawBasic);
	google.charts.setOnLoadCallback(drawResources);
	google.charts.setOnLoadCallback(drawPie);
	google.charts.setOnLoadCallback(drawDonut);

	function drawColColors() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Project');
      data.addColumn('number', 'Planned');
      data.addColumn('number', 'Actual');

      data.addRows([
      	@foreach($project as $cost)
        ["{{data_get($cost,'name')}}", {{data_get($cost,'planned')}}, {{data_get($cost,'actual')}}],
        @endforeach
      ]);

      var options = {
        title: 'Project Cost RM 000',
        colors: ['#9575cd', '#33ac71'],
        hAxis: {
          title: 'Project'
        },
        vAxis: {
          title: 'Cost RM 000'
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('bar_div'));
      chart.draw(data, options);

    }

	function drawBasic() {

      var bardata = google.visualization.arrayToDataTable([
      	['Project', 'GP Variance'],
      	@foreach($project as $cost)
        ["{{data_get($cost,'name')}}", {{data_get($cost,'gp')}}],
        @endforeach
      ]);

      var baroptions = {
        title: 'GP Variance',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'GP Variance',
          minValue: 0
        },
        vAxis: {
          title: 'Project'
        }
      };

      var barchart = new google.visualization.BarChart(document.getElementById('chart_div'));

      barchart.draw(bardata, baroptions);
    }
	
	function drawResources() {

      var resourcesData = new google.visualization.DataTable();
      resourcesData.addColumn('string', 'Resource');
      resourcesData.addColumn('number', 'Task');

      resourcesData.addRows([
      	@foreach($sum as $name => $resSum)
        ["{{$name}}", {{$resSum}}],
        @endforeach
      ]);

      var resourcesOptions = {
        title: 'Resources',
        hAxis: {
          title: 'Resource',
        },
        vAxis: {
          title: 'Task'
        }
      };

      var resourcesChart = new google.visualization.ColumnChart(
        document.getElementById('resources_div'));

      resourcesChart.draw(resourcesData, resourcesOptions);
    }

     function drawPie() {
        var drawPiedata = google.visualization.arrayToDataTable([
          ['Project', 'Task'],
	      	@foreach($project as $task)
	        ["{{data_get($task,'name')}}", {{data_get($task,'task')}}],
	        @endforeach
        ]);

		var drawPieoptions = {
			legend: 'bottom',
			pieSliceText: 'value',
			title: '{{ __('joesama/project::portfolio.portfolio.task') }}',
			pieStartAngle: 100,
		};

        var drawPiechart = new google.visualization.PieChart(document.getElementById('piechart'));
        drawPiechart.draw(drawPiedata, drawPieoptions);
  	}

     function drawDonut() {
        var drawPiedata = google.visualization.arrayToDataTable([
          ['Project', 'Task'],
	      	@foreach($project as $task)
	        ["{{data_get($task,'name')}}", {{data_get($task,'issue')}}],
	        @endforeach
        ]);

		var drawPieoptions = {
			legend: 'bottom',
			pieSliceText: 'value',
			title: '{{ __('joesama/project::portfolio.portfolio.issue') }}',
			pieStartAngle: 100,
			pieHole: 0.4,
		};

        var drawPiechart = new google.visualization.PieChart(document.getElementById('donutchart'));
        drawPiechart.draw(drawPiedata, drawPieoptions);
  	}

</script>
@endpush