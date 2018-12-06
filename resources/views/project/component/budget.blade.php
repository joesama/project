<div class="panel panel-primary">
  <div class="panel-heading" id="headingBudget">
    <h4 class="panel-title">
      <a data-parent="#accordionExample" data-toggle="collapse" href="#budget" aria-expanded="true" aria-controls="budget">
              {{ __('joesama/project::project.category.financial') }}
      </a>
    </h4>
  </div>
  <div id="budget" class="panel-collapse collapse in" aria-labelledby="headingBudget" >
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <table class="table table-sm table-borderless " style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="2" class="bg-primary text-light px-2"  style="color: white">Contract Info</th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">Value (RM)</th>
                <th class="text-center">Periods (Years)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">274,000.00</td>
                <td class="text-center">3.08</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless " style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2"  style="color: white">
                VO
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/vo/'.$projectId) }}" class="btn btn-sm btn-action report">
                  <i class="fas fa-list-ul"></i>
                </a>
                @endif
                </th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">{!! $dateReport->format('M-Y') !!}</th>
                <th class="text-center">YTD (RM)</th>
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless " style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2"  style="color: white">Revised Sum</th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">0.00</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2"  style="color: white">
                Amount Claim
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/claim/'.$projectId) }}" class="btn btn-sm btn-action report">
                  <i class="fa fa-list"></i>
                </a>
                @endif
                </th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">{!! $dateReport->format('M-Y') !!}</th>
                <th class="text-center">YTD (RM)</th>
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
                <td class="text-right font-weight-bold">237,911.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2"  style="color: white">
                Amount Paid
                  @if(is_null($id))
                  <a href="{{ handles('joesama/project::project/payment/'.$projectId) }}" class="btn btn-sm btn-action report" >
                    <i class="fa fa-list"></i>
                  </a>
                  @endif
                </th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">{!! $dateReport->format('M-Y') !!}</th>
                <th class="text-center">YTD (RM)</th>
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">17,200.00</td>
                <td class="text-center">66,378.00</td>
                <td class="text-right font-weight-bold">237,911.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-danger text-light px-2"  style="color: white">
                LAD
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/lad/'.$projectId) }}" class="btn btn-sm btn-action report" onclick="openclaim(this)">
                  <i class="fa fa-list"></i>
                </a>
                @endif
                </th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">{!! $dateReport->format('M-Y') !!}</th>
                <th class="text-center">YTD (RM)</th>
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">0.00</td>
                <td class="text-center">0.00</td>
                <td class="text-right font-weight-bold">0.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2"  style="color: white">
                Retention
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/retention/'.$projectId) }}" class="btn btn-sm btn-action report" >
                  <i class="fa fa-list"></i>
                </a>
                @endif
                </th>
              </tr>
              <tr class=" text-light px-2">
                <th class="text-center">{!! $dateReport->format('M-Y') !!}</th>
                <th class="text-center">YTD (RM)</th>
                <th class="text-center">TTD (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-center">1,720.00</td>
                <td class="text-center">9,957.00</td>
                <td class="text-right font-weight-bold">35,687.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th class="bg-warning text-light px-2"  style="color: white">Balance Contract (RM)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="font-weight-light px-2">
                <td class="text-right font-weight-bold">36,089.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>