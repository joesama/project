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
      <button class="btn btn-dark float-right mb-2" onclick="openischedule(this)">
        <i class="fas fa-plus"></i>
      </button>
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
          <tr>
            <td>1</td>
            <td> Letter of Acceptance (LOA)
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                  
            <td>Azhar</td> 
            <td>1-Jul-16</td>    
            <td>18-Jul-16</td>   
            <td>100</td>
          </tr>
          <tr>
            <td>2 </td>
            <td>Procurement
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                                 
            <td>Azhar</td> 
            <td>27-Oct-16</td>    
            <td>2-Nov-16</td>     
            <td>100</td>
          </tr>  
          <tr>
            <td>3 </td>
            <td>Design & Engeenering
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>              
            <td>Azhar</td>
            <td>3-Nov-16</td>    
            <td>27-Mar-17</td>    
            <td>81</td> 
          </tr> 
          <tr>
            <td>4 </td>
            <td>Manufacturing
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>               
            <td>Azhar</td> 
            <td>13-Feb-17</td>   
            <td>8-Apr-17</td>     
            <td>83</td>
          </tr>   
          <tr>
            <td>5 </td>
            <td>Factory Acceptance Test
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                
            <td>Azhar <td>13-Feb-17</td>    
            <td>8-Apr-17</td>     
            <td>63</td> 
          </tr>
          <tr> 
            <td>6</td> 
            <td>Delivery
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                
            <td>Azhar</td> 
            <td>16-Feb-17</td>    
            <td>2-May-17</td>     
            <td>36</td>
          </tr>   
          <tr>
            <td>7 </td>
            <td>Erection
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                
            <td>Azhar</td> 
            <td>3-Apr-17</td>     
            <td>26-Jul-17</td>    
            <td>1</td>
          </tr>  
          <tr>
            <td>8</td> 
            <td>Testing and commissioning
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                
            <td>Azhar</td> 
            <td>27-Jul-17</td>    
            <td>31-Jul-17</td>    
            <td>0 </td> 
          </tr>
          <tr>
            <td>9</td> 
            <td>Defect Liability Period (One Year period)
              <a href="#" class="btn btn-sm btn-action text-dark" onclick="editschedule(this)">
                <i class="far fa-edit"></i>
              </a>
            </td>                
            <td>Azhar</td>  
            <td>1-Aug-17</td>     
            <td>31-Jul-19</td>    
            <td>12.07</td> 
          </tr>
        </tbody>
      </table>
      <div class="clearfix">&nbsp;</div>
      <div id="chart_div"></div>
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
        ['LOA', 'Letter of Acceptance (LOA)',
         new Date(2016, 6, 1), new Date(2016, 6, 16), null,  100,  null],
        ['Procurement', 'Procurement',
         new Date(2016, 6, 18), new Date(2016, 6, 20), null, 100, 'LOA'],
        ['Design', 'Design & Engeenering',
         new Date(2016, 6, 21), new Date(2016, 6, 25), null, 81, 'Procurement'],
        ['Manufacturing', 'Manufacturing',
         new Date(2016, 6, 26), new Date(2016, 6, 28), null, 83, 'Design,Procurement'],
        ['Test', 'Factory Acceptance Test',
         new Date(2016, 6, 28), new Date(2016, 6, 30), null, 63, 'Manufacturing']
      ]);

      var options = {
        height: 275
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