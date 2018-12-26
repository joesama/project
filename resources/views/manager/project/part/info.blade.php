<div class="col-md-12" style="padding: 0px 5px">
    <div class="panel">
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0px 5px">
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
                        <a class="btn btn-dark btn-xs mar-btm pull-right" href="{{ handles('joesama/project::manager/partner/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                            <i class="fa fa-plus icon-fw"></i>
                            {{ __('joesama/project::project.client.partner.name') }}
                        </a>
                        @forelse(data_get($project,'partner') as $index => $partner)
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.client.partner.name') }}  {{ ($index+1) }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($partner,'name') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.tel') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($partner,'phone') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.pm') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($partner,'manager') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.contact') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($partner,'contact') }}
                                </td>
                            </tr>
                        </table>
                        @empty
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.client.partner.name') }}
                                </td>
                                <td class="pl-2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.tel') }}
                                </td>
                                <td class="pl-2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.pm') }}
                                </td>
                                <td class="pl-2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.partner.contact') }}
                                </td>
                                <td class="pl-2">&nbsp;</td>
                            </tr>
                        </table>
                        @endforelse
                    </div>
                    <div class="col-md-6 text-left">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.info.contract.value') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'contract'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.scope') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'scope') }}
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
                        <a class="btn btn-dark btn-xs mar-btm pull-right" href="{{ handles('joesama/project::manager/attribute/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                            <i class="fa fa-plus icon-fw"></i>
                            {{ __('joesama/project::project.attr') }}
                        </a>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.info.contract.gp.original') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'gp_propose'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.gp.latest') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'gp_latest'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.bond') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'bond'),2) }}
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
                            @foreach(data_get($project,'attributes') as $index => $attributes)
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ data_get($attributes,'variable') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($attributes,'data') }}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>