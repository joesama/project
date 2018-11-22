<div class="card">
  <div class="card-header py-0 bg-default" id="headingHse">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#owner" aria-expanded="true" aria-controls="owner">
          <h4 class="my-0 font-weight-bold text-light">
              {{ __('joesama/project::project.category.owner') }}
          </h4>
      </button>
  </div>
  <div id="owner" class="collapse show" aria-labelledby="headingHse" data-parent="#accordionExample">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <table class="table table-sm table-borderless" id="prepared">
            <thead>
              <tr>
                <th colspan="4" class="bg-primary text-light px-2">
                  {{ __('joesama/project::project.owner.prepared') }}
                  @if(is_null($id))
                  <a href="#" class="btn btn-sm btn-action" onclick="openmodal(this)">
                    <i class="far fa-edit"></i>
                  </a>
                  @endif
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4" class="text-justify" height="100px">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left">
                  @if($id > 0)
                    Azhar Abdullah
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class=text-left">
                  @if($id > 0)
                    019-2641901
                  @endif</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left">
                  @if($id > 0)
                    Assistant General Manager
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
          <table class="table table-sm table-borderless" id="approvalowner">
            <thead>
              <tr>
                <th colspan="4" class="bg-primary text-light px-2">
                {{ __('joesama/project::project.owner.approval') }}
                @if($id == 1)
                <a href="#" class="btn btn-sm btn-action" onclick="openmodal(this)">
                  <i class="far fa-edit"></i>
                </a>
                @endif
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4"  class="text-justify" height="100px">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left">
                  @if($id > 1)
                    Mohamad Mazri Bin. Zainal Abidin
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class=text-left">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left">
                  @if($id > 1)
                    Vice President/CEO, KUB Power
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header py-0 bg-default" id="headingHse">
      <button class="btn btn-link btn-category" type="button" data-toggle="collapse" data-target="#gosb" aria-expanded="true" aria-controls="gosb">
          <h4 class="my-0 font-weight-bold text-light">
              GROUP OPERATIONS & STRATEGIC DEVELOPMENT (GOSD)
          </h4>
      </button>
  </div>
  <div id="gosb" class="collapse show" aria-labelledby="headingHse" data-parent="#accordionExample">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
          <table class="table table-sm table-borderless" id="validate">
            <thead>
              <tr>
                <th colspan="4" class="bg-primary text-light px-2">
                  {{ __('joesama/project::project.owner.validate') }}
                   @if($id == 2)
                  <a href="#" class="btn btn-sm btn-action" onclick="openmodal(this)">
                    <i class="far fa-edit"></i>
                  </a>
                  @endif
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4"  class="text-justify" height="100px">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left">
                  @if($id > 2)
                    Mohd Aisamuddin Mohd Fadzil 
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class=text-left">
                  @if($id > 2)
                    017-9144813
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left">
                  @if($id > 2)
                    Assistant Manager, PMO
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
          <table class="table table-sm table-borderless" id="review">
            <thead>
              <tr>
                <th colspan="4" class="bg-primary text-light px-2">
                {{ __('joesama/project::project.owner.review') }}
                @if($id == 3)
                <a href="#" class="btn btn-sm btn-action" onclick="openmodal(this)">
                  <i class="far fa-edit"></i>
                </a>
                @endif
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4"  class="text-justify" height="100px">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left">
                  @if($id > 3)
                    Shahril Fitri Mustapha
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class=text-left">                
                  @if($id > 3)
                    019-2738123
                  @endif     
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left">            
                  @if($id > 3)
                    Senior Manager, PMO
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
          <table class="table table-sm table-borderless" id="approval">
            <thead>
              <tr>
                <th colspan="4" class="bg-primary text-light px-2">
                {{ __('joesama/project::project.owner.approval') }}
                @if($id == 4)
                <a href="#" class="btn btn-sm btn-action" onclick="openmodal(this)">
                  <i class="far fa-edit"></i>
                </a>
                @endif
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="4"  class="text-justify" height="100px">&nbsp;</td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left">
                  @if($id > 4)
                    Azman Abdullah
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class=text-left">
                  @if($id > 4)
                    012-4807030
                  @endif
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left">
                  @if($id > 4)
                    Vice President, GOSD
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <tr>
                <td colspan="4"  class="text-justify form-group" height="100px">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.name') }}
                </td>
                <td class="text-left form-group">
                  {{ \Auth::user()->fullname }}
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.mobile') }}
                </td>
                <td class="text-left form-group">
                  Assistant General Manager
                </td>
              </tr>
              <tr class="font-weight-normal px-2">
                <td class="w-25 text-light bg-secondary">
                  {{ __('joesama/project::project.owner.position') }}
                </td>
                <td class="text-left form-group">
                  019-2641901
                </td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{ handles('joesama/report::project/info/'.(request()->segment(3)+1)) }}" class="btn btn-primary">Save changes</a>
      </div>
    </div>
  </div>
</div>
@push('content.script')

<script type="text/javascript">
  function openmodal(modal) {
    let origin = modal.closest('table');
    $('#'+origin.id).focus();
    $('#exampleModal .modal-title').text($(modal.closest('th')).text());
    $('#exampleModal').modal('toggle')
  }
</script>
@endpush