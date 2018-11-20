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
      <div class="row">
        <div class="col-md-6">
          <div id="physical_chart"></div> 
        </div>
        <div class="col-md-6">
          <div id="financial_chart"></div> 
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