<div class="row">
    <div class="col-md-9">
        <h1>PROJECT DASHBOARD</h1>
    </div>
    <div class="col-md-3 text-right" class="vertical">
        <p class="font-weight-bold mb-1">{{ __('joesama/project::project.date.report') }}</p>
        <p class="text-muted">{!! date('d-m-Y') !!}</p>
    </div>
</div>
<hr class="mb-4">
<div class="row">
    <div class="col-md-12">
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize" style="width: 14.5%">
                    {{ __('joesama/project::project.info.name') }}
                </td>
                <td class="pl-2 text-justify">
                    Balance of Plant Electrical Works, Transmission Line Interconnection and Other Associated Works for 6 Mv Sg. Slim Mini Hydro 
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.no') }}
                </td>
                <td class="pl-2">
                    AK47
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.name') }}
                </td>
                <td class="pl-2">
                    Panzana Enterprise Sdn Bhd
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.tel') }}
                </td>
                <td class="pl-2">
                    03-20950849 (Tel) / 03-20951848 (fax)
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.pm') }}
                </td>
                <td class="pl-2">
                    Fadios Abd Rahman
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.contact') }}
                </td>
                <td class="pl-2">
                    012-9912084
                </td>
            </tr>
        </table>
        <table class="table table-borderless table-sm">
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize" style="width: 30%">
                    {{ __('joesama/project::project.client.partner.name') }}
                </td>
                <td class="pl-2">
                    China  Western Power International Pte Ltd
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.tel') }}
                </td>
                <td class="pl-2">
                    1109017661@qq.com
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.pm') }}
                </td>
                <td class="pl-2">
                    Jiang Shuhong
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-primary text-light text-capitalize">
                    {{ __('joesama/project::project.client.partner.contact') }}
                </td>
                <td class="pl-2">
                    65 9068 0208
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
                    RM 274,000.00
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.scope') }}
                </td>
                <td class="pl-2">
                    Construction and Engineering
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.start') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime('01-07-2016')) }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.date.end') }}
                </td>
                <td class="pl-2">
                    {{ date('d-m-Y' , strtotime('01-07-2016')) }}
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
                <td class="ont-weight-bold bg-default text-light text-capitalize">
                    {{ __('joesama/project::project.info.contract.eot') }}
                </td>
                <td class="pl-2">
                    31 July 2017 (1st EOT), 28 February 2018 (2nd EOT), 30 June 2018 (3rd EOT), 30 November 2018 (4th EOT)
                </td>
            </tr>
        </table>
    </div>
</div>