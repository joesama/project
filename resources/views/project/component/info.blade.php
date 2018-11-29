<div class="row">
    <div class="col-md-9">
        <h4 class="pl-2 text-justify">{{ data_get($component,'name') }}
        <br><small class="font-italic text-muted">{{ data_get($component,'contract.no') }}</small>
        </h4>
    </div>
    <div class="col-md-3 text-right" class="vertical">
        @if($id > 0)
        <p class="font-weight-bold mb-1">{{ __('joesama/project::project.date.report') }}</p>
        @else
        <p class="font-weight-bold mb-1">{{ __('joesama/project::project.date.data') }}</p>
        @endif
        <p class="text-muted">{!! $dateReport->format('d-m-Y') !!}</p>
    </div>
</div>
<hr class="mb-4">
<div class="row">
    <div class="col-md-6">
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.name') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.name') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.tel') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.tel') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.pm') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.pmo') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.contact') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.contact') }}
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.partner.name') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.partner.name') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.tel') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.partner.tel') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.pm') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.partner.pmo') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.contact') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'client.partner.name') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6 text-left">
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.info.contract.value') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'contract.value') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.scope') }}
                </td>
                <td class="pl-2">
                    {{ data_get($component,'contract.scope') }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.start') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime(data_get($component,'start'))) }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.end') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime(data_get($component,'end'))) }}
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.info.contract.gp.original') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.gp.latest') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.bond') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.eot') }}
                </td>
                <td class="pl-2">
                    31 July 2017 (1st EOT), 28 February 2018 (2nd EOT), 30 June 2018 (3rd EOT), 30 November 2018 (4th EOT)
                </td>
            </tr>
        </table>
    </div>
</div>