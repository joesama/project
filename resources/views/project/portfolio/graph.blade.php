<div class="row">
	@foreach(config('joesama/project::data.subsidiary') as $key => $subsidiary)
	<?php $data = data_get($subsidiary,'budget.data'); ?>
	<?php $issue = data_get($subsidiary,'issue'); ?>
	<div class="col-md-6">
		<div class="panel panel-primary" id="panel-{{$key}}">		
		    <!--Panel heading-->
		    <div class="panel-heading">
		        <div class="panel-control">
		        	<button class="btn btn-default" data-panel="fullscreen">
		                <i class="icon-max psi-maximize-3"></i>
		                <i class="icon-min psi-minimize-3"></i>
		            </button>
		            <button id="panel-{{$key}}-refresh" class="btn btn-default btn-active-primary" data-toggle="panel-overlay" data-target="#panel-{{$key}}"><i class="psi-repeat-2"></i></button>
		        </div>
		        <h3 class="panel-title text-bold">
		        	<a href="{{ handles('joesama/project::subsidiaries') }}" class="add-tooltip" data-toggle="tooltip" data-container="body" data-placement="right" data-original-title="{{ __('joesama/project::portfolio.subsidiary.dashboard') }}">
		        	<img class="img-circle bg-light mar-rgt" src="{{ asset(memorize('threef.logo','packages/joesama/entree/img/profile.png')) }}" alt="logo"  style="width:30px;height:30px" >
		        	{{ data_get($subsidiary,'name') }}
		        	<i class="icon-min pli-binocular"></i>
		        	</a>
		        </h3>
		    </div>
		    <!--Panel body-->
		    <!--chart placeholder-->
		    <div class="row">
		    	<div class="col-md-6">
                	<div class="mar-lft mar-top" id="chart_{{$key}}" style="width: 100%; height: 100%;"></div>
					<div class="panel mar-lft mar-top">
			            <div class="media-body text-center pad-all mar-top">
			                <div class="text-lg">
			                	<p class="text-5x text-bold text-{{ (data_get($subsidiary,'task') < 15) ? 'success' : (data_get($subsidiary,'task') > 15 && data_get($subsidiary,'task') < 20) ? 'warning' : 'danger'}}">
			                    {{ floatval(data_get($subsidiary,'task')) }}
			                    </p>
			                </div>
			                <p class="text-3x mar-no text-thin">Overdue Task</p>
			            </div>
		            </div>
		    	</div>
		    	<div class="col-md-6">
					<div class="panel mar-rgt mar-top">
		            	<div class="pad-all ">
		                    <p class="text-5x text-bold text-center text-success">
		                    	<i class="ion-arrow-up-b"></i>&nbsp;{{ floatval(data_get($subsidiary,'gp')) }}
		                    </p>
		                    <p class="text-thin text-3x text-center">GP Variance</p>
		                </div>
		            </div>
		            <div class="mar-rgt" id="pie_{{$key}}" style="width: 100%; "></div>
		            <h3 class="text-center mar-rgt text-bold">Project Issue</h3>
		            @foreach($issue as $ky => $iss)
					@if($ky != 0)
					<?php $color = (data_get($iss,0) == 'Open') ?  '#3366cc' : '#dc3912';?>
					<div class="col-md-6 text-center">
						<div style="font-size: 24px;color:{{$color}}">{{ data_get($iss,0) }}</div>
						<div style="font-size: 24px;color:{{$color}}">{{ data_get($iss,1) }}</div>
					</div>
					@endif
					@endforeach
		    	</div>
		    </div>
            <div class="pad-all">
            </div>
            
		    <div id="panel-collapse-default" class="panel-body">

		    </div>
		</div>
	</div>
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
	      chartArea:{top:10,bottom:20}
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
	    legend: {position: 'none'},
	    pieSliceText: 'label',
	    title: 'Project Issues',
	    pieStartAngle: 100,
	    chartArea:{top:5,bottom:5,width:'100%',height:'100%'}
	  };

	    var chart = new google.visualization.PieChart(document.getElementById('pie_{{$key}}'));
	    chart.draw(data, options);
	  }
	</script>
	@endpush
	@endforeach
</div>