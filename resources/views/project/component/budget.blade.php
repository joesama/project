<div class="card">
  <div class="card-header py-0 bg-default" id="headingBudget">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#budget" aria-expanded="true" aria-controls="budget">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.financial') }}
          </h4>
      </button>
  </div>
  <div id="budget" class="collapse show" aria-labelledby="headingBudget" data-parent="#accordionExample">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <table class="table table-sm table-borderless " style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="2" class="bg-primary text-light px-2">Contract Info</th>
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
                <th colspan="3" class="bg-primary text-light px-2">
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
                <th colspan="3" class="bg-primary text-light px-2">Revised Sum</th>
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
                <th colspan="3" class="bg-primary text-light px-2">
                Amount Claim
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/claim/'.$projectId) }}" class="btn btn-sm btn-action report">
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
                <td class="text-right font-weight-bold">237,911.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2">
                Amount Paid
                  @if(is_null($id))
                  <a href="{{ handles('joesama/project::project/payment/'.$projectId) }}" class="btn btn-sm btn-action report" >
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
                <td class="text-center">17,200.00</td>
                <td class="text-center">66,378.00</td>
                <td class="text-right font-weight-bold">237,911.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-danger text-light px-2">
                LAD
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/lad/'.$projectId) }}" class="btn btn-sm btn-action report" onclick="openclaim(this)">
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
                <td class="text-right font-weight-bold">0.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th colspan="3" class="bg-primary text-light px-2">
                Retention
                @if(is_null($id))
                <a href="{{ handles('joesama/project::project/retention/'.$projectId) }}" class="btn btn-sm btn-action report" >
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
                <td class="text-center">1,720.00</td>
                <td class="text-center">9,957.00</td>
                <td class="text-right font-weight-bold">35,687.00</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-borderless "  style="margin-bottom: 0px">
            <thead>
              <tr>
                <th class="bg-warning text-light px-2">Balance Contract (RM)</th>
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
<div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-capitalize" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-sm table-borderless">
            <tbody>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light ">
                  Date
                </td>
                <td class="text-left form-group">
                  {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light ">
                  Amount (RM)
                </td>
                <td class="text-left form-group">
                  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="00.00">
                </td>
              </tr>
              <tr>
                <td colspan="4"  class="text-justify form-group" height="100px">
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
@push('content.script')

<script type="text/javascript">
  function openclaim(modal) {
    var hse = modal.closest('div .card-footer');
    $('#budgetModal .modal-title').text($(modal.closest('th')).text());
    $('#budgetModal').modal('toggle')
  }
</script>
@endpush