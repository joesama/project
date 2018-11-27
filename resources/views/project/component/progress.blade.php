<div class="card">
  <div class="card-header py-0 bg-default" id="headingProgress">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#progress" aria-expanded="true" aria-controls="progress">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.progress.physical') }}&nbsp;&&nbsp;
              {{ __('joesama/project::project.category.progress.finance') }}
          </h4>
      </button>
  </div>
  <div id="progress" class="collapse show" aria-labelledby="headingProgress" data-parent="#accordionExample">
    <div class="card-body">
      <div class="row mt-5">
        <div class="col-lg-10 col-md-10">
          <div id="physical_chart"></div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 text-center">
        <div class="row">
          <div class="col-md-12">
            <a href="{{ handles('joesama/project::project/physical/'.$projectId) }}" class="btn btn-block btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"onclick="openischedule(this)">
              <i class="fas fa-pen"></i></i>&nbsp;&nbsp;{{ __('joesama/project::project.progress.name') }}
            </a>
          </div>
        </div>
          <div class="card mb-4 mt-1">
            @php 
              $physicalVar = -9.53;
              $financeVar = 5.03;
            @endphp
            <div class="card-body font-weight-bold text-{{ ($physicalVar > 0) ? 'success' : 'danger' }}" style="font-size: 34px">
                {!! $physicalVar !!}
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
        <div class="row">
          <div class="col-md-12">
              <a href="{{ handles('joesama/project::project/physical/'.$projectId) }}" class="btn btn-block btn-dark float-right mb-2 py-1"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"onclick="openischedule(this)">
                <i class="fas fa-pen"></i>&nbsp;&nbsp;{{ __('joesama/project::project.progress.name') }}
              </a>
            </div>
          </div>          
          <div class="card mb-4 mt-1">
            <div class="card-body font-weight-bold text-{{ ($financeVar > 0) ? 'success' : 'danger' }}" style="font-size: 34px">
                {!! $financeVar !!}
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
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Planned', 'Actual'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var pOptions = {
          title: '{{ __('joesama/project::project.category.progress.physical')  }}',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var fOptions = {
          title: '{{ __('joesama/project::project.category.progress.finance')  }}',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var physical = new google.visualization.LineChart(document.getElementById('physical_chart'));
        var financial = new google.visualization.LineChart(document.getElementById('financial_chart'));

        physical.draw(data, pOptions);
        financial.draw(data, fOptions);
      }
    </script>

@endpush