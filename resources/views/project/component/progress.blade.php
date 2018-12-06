<div class="panel panel-primary">
  <div class="panel-heading" id="headingProgress">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#progress" aria-expanded="true" aria-controls="budget">
          {{ __('joesama/project::project.category.progress.physical') }}&nbsp;&&nbsp;
          {{ __('joesama/project::project.category.progress.finance') }}
      </a>
    </h4>
  </div>
  <div id="progress" class="panel-collapse collapse in" aria-labelledby="headingProgress" >
    <div class="panel-body">
      <div class="row mt-5">
        <div class="col-lg-10 col-md-10">
          <div id="physical_chart"></div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 text-center">
          @if(is_null($id))
          <div class="row">
            <div class="col-md-12">
              <a href="{{ handles('joesama/project::project/physical/'.$projectId) }}" class="btn btn-block btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                <i class="fas fa-pen"></i></i>&nbsp;&nbsp;{{ __('joesama/project::project.progress.name') }}
              </a>
            </div>
          </div>
          @endif
          <div class="card mb-4 mt-1">
            @php 
              $scurve = collect(config('joesama/project::project.scurve'))
                        ->where('project_id',$projectId);
              $lastCurve = $scurve->last();
              $physicalVar = data_get($lastCurve,'physical_planned') - data_get($lastCurve,'physical_actual');
              $financeVar = data_get($lastCurve,'financial_planned') - data_get($lastCurve,'financial_actual');
            @endphp
            <div class="card-body font-weight-bold text-{{ ($physicalVar > 0) ? 'success' : 'danger' }}" style="font-size: 24px">
                {!! $physicalVar !!}&nbsp;%
            </div>
            <div class="card-footer font-weight-bold text-light bg-{{ ($physicalVar > 0) ? 'success' : 'danger' }}">
              {{ __('joesama/project::project.progress.var') }}
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="row mt-5">
        <div class="col-lg-10 col-md-10">
          <div id="financial_chart"></div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 text-center">
          @if(is_null($id))
          <div class="row">
            <div class="col-md-12">
              <a href="{{ handles('joesama/project::project/financial/'.$projectId) }}" class="btn btn-block btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                <i class="fas fa-pen"></i>&nbsp;&nbsp;{{ __('joesama/project::project.progress.name') }}
              </a>
            </div>
          </div> 
          @endif         
          <div class="card mb-4 mt-1">
            <div class="card-body font-weight-bold text-{{ ($financeVar > 0) ? 'success' : 'danger' }}" style="font-size: 24px">
                {!! number_format($financeVar,2) !!}
            </div>
            <div class="card-footer font-weight-bold text-light bg-{{ ($financeVar > 0) ? 'success' : 'danger' }}">
              {{ __('joesama/project::project.progress.var') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('pages.script')

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var physicaldata = google.visualization.arrayToDataTable([
          ['Year', 'Planned', 'Actual'],
          @foreach($scurve as $curve)
          ["{{ data_get($curve,'month') }}",  {{ data_get($curve,'physical_planned') }},      {{ data_get($curve,'physical_actual') }}],
          @endforeach
        ]);

        var financedata = google.visualization.arrayToDataTable([
          ['Month', 'Planned', 'Actual'],
          @foreach($scurve as $curve)
          ["{{ data_get($curve,'month') }}",  {{ data_get($curve,'financial_planned') }},      {{ data_get($curve,'financial_actual') }}],
          @endforeach
        ]);

        var pOptions = {
          title: '{{ __('joesama/project::project.category.progress.physical')  }}',
          curveType: 'function',
          crosshair: {
            color: '#000',
            trigger: 'selection'
          },        
          hAxis: {
            title: 'Month'
          },
          vAxis: {
            title: 'Progress'
          },
        };

        var fOptions = {
          title: '{{ __('joesama/project::project.category.progress.finance')  }}',
          curveType: 'function',
          crosshair: {
            color: '#000',
            trigger: 'selection'
          },     
          hAxis: {
            title: 'Month'
          },
          vAxis: {
            title: 'RM'
          },
        };

        var physical = new google.visualization.LineChart(document.getElementById('physical_chart'));
        var financial = new google.visualization.LineChart(document.getElementById('financial_chart'));

        physical.draw(physicaldata, pOptions);
        financial.draw(financedata, fOptions);
      }
    </script>

@endpush