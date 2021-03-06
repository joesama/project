<div class="row">
    <div class="col-md-9">
        <h4 class="text-bold text-justify">{{ data_get($project,'name') }}
        <br><small class="text-thin text-muted">{{ data_get($project,'contract') }}</small>
        </h4>
    </div>
    <div class="col-md-3 text-right" class="vertical">
        @if($id > 0)
        <p class="text-bold">{{ __('joesama/project::project.date.report') }}</p>
        @else
        <p class="text-bold">{{ __('joesama/project::project.date.data') }}</p>
        @endif
        <p class="text-muted">{!! $dateReport->format('d-m-Y') !!}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.name') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.name') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.tel') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.phone') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.pm') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.manager') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.contact') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.contact') }}
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.partner.name') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.partner.name') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.tel') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.partner.tel') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.pm') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.partner.pmo') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.contact') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'client.partner.name') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6 text-left">
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.info.contract.value') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'contract.value') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.scope') }}
                </td>
                <td class="pl-2">
                    {{ data_get($project,'contract.scope') }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.start') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime(data_get($project,'start'))) }}
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.end') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime(data_get($project,'end'))) }}
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-sm">
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.info.contract.gp.original') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.gp.latest') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.bond') }}
                </td>
                <td class="pl-2">
                </td>
            </tr>
            <tr>
                <td class="text-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.eot') }}
                </td>
                <td class="pl-2">
                    31 July 2017 (1st EOT), 28 February 2018 (2nd EOT), 30 June 2018 (3rd EOT), 30 November 2018 (4th EOT)
                </td>
            </tr>
        </table>
    </div>
</div>