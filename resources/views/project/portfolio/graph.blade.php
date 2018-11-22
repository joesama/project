<div class="row">
	@foreach(config('joesama/project::data.subsidiary') as $key => $subsidiary)
	<?php $data = data_get($subsidiary,'budget.data'); ?>
	<?php $issue = data_get($subsidiary,'issue'); ?>
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="card text-center">
			<div class="card-header text-light bg-dark" style="font-size: 24px;">
				<a class=" font-weight-bold btn-link btn-category" style="color: white;" href="{{ handles('joesama/project::subsidiaries') }}">
				{{ data_get($subsidiary,'name') }}
				</a>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="row">
							<div class="col-md-12">
								<div id="chart_{{$key}}" style="width: 100%; height: 500px;"></div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 font-weight-bold text-right text-{{ (data_get($subsidiary,'task') < 15) ? 'success' : (data_get($subsidiary,'task') > 15 && data_get($subsidiary,'task') < 20) ? 'warning' : 'danger'}}"  style="font-size: 50px">
								{{ floatval(data_get($subsidiary,'task')) }}
							</div>
							<div class="col-md-8 font-weight-bold text-left align-middle" style="font-size: 36px;line-height: 2;">
								Overdue Task
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 text-center">
						<div class="row">
							<div class="col-md-12 font-weight-bold text-center text-success"  style="font-size: 50px">
								{{ floatval(data_get($subsidiary,'gp')) }}
							</div>
							<div class="col-md-12 font-weight-bold text-center" style="font-size: 26px">
								GP Variant
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="pie_{{$key}}" style="width: 100%; height: 300px;"></div>
							</div>
						</div>
						<div class="row text-center">
							<div class="col-md-12 font-weight-bold text-center" style="font-size: 26px">
								Project Issue
							</div>
						</div>
						<div class="row text-center">
							@foreach($issue as $ky => $iss)
							@if($ky != 0)
							<?php $color = (data_get($iss,0) == 'Open') ?  '#3366cc' : '#dc3912';?>
							<div class="col-md-6 font-weight-bold text-center">
								<div style="font-size: 24px;color:{{$color}}">{{ data_get($iss,0) }}</div>
								<div style="font-size: 24px;color:{{$color}}">{{ data_get($iss,1) }}</div>
							</div>
							@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	@push('content.script')
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  var {{'div'.$key}} = @json($data);

	  function drawChart() {
	    var data = google.visualization.arrayToDataTable({{'div'.$key}});

	    var options = {
	      title: '{{ data_get($subsidiary,'budget.stat') }}',
	      hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
	      vAxis: {minValue: 0},
	      chartArea:{top:100,bottom:20}
	    };

	    var chart = new google.visualization.AreaChart(document.getElementById('chart_{{$key}}'));
	    chart.draw(data, options);
	  }
	</script>
	<script type="text/javascript">
	  google.charts.load("current", {packages:["corechart"]});
	  google.charts.setOnLoadCallback(drawChart);

	  var {{'pie'.$key}} = @json($issue);

	  function drawChart() {
	    var data = google.visualization.arrayToDataTable({{'pie'.$key}});


	  var options = {
	    legend: {position: 'right', textStyle: {color: 'blue', fontSize: 16}},
	    pieSliceText: 'label',
	    title: 'Project Issues',
	    pieStartAngle: 100,
	    chartArea:{left:20,top:100,bottom:20,width:'100%',height:'100%'}
	  };

	    var chart = new google.visualization.PieChart(document.getElementById('pie_{{$key}}'));
	    chart.draw(data, options);
	  }
	</script>
	@endpush
	@endforeach
</div>