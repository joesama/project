<div class="col-md-12" style="padding: 0px 5px">
    <div class="panel">
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0px 5px">
                <div class="row mar-btm">
                    <div class="col-md-9">

                    </div>
                    <div class="col-md-3 text-right" class="vertical">
                        @if( (($project->active || !is_null(data_get($project,'approval.approved_by')))  && is_null($isReport)) || $isProjectManager )
                        <a class="btn btn-dark mar-btm pull-right" href="{{ handles('joesama/project::manager/project/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                            <i class="psi-file-edit icon-fw"></i>
                            {{ __('joesama/vuegrid::datagrid.buttons.edit') }}
                        </a>
                        @elseif($isReport)
                            <div class="col-md-12 text-center"> 
                                <div class="row bord-all">
                                    <div class="col-md-12 text-bold text-center" style="padding: 3px">
                                        {{ strtoupper( __('joesama/project::report.format.monthly') ) }}
                                        {{ strtoupper( $reportDue ) }}
                                    </div>
                                </div>
                                <div class="row text-thin text-center">
                                    <div class="col-md-4 text-bold bord-hor bord-btm"  style="padding: 3px">
                                        {{ $reportStart }}
                                    </div>
                                    <div class="col-md-4 bord-rgt bord-btm"  style="padding: 3px">
                                        {{ __('joesama/project::report.format.through') }}
                                    </div>
                                    <div class="col-md-4 text-bold bord-rgt bord-btm"  style="padding: 3px">
                                        {{ $reportEnd }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.name') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'name') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.contract.no') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'contract') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.contract.scope') }}
                                </td>
                                <td class="pl-2">
                                    {!! strip_tags(data_get($project,'scope')) !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::form.project.client_id') }}
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
                        @if( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager && is_null($isReport))
                        <a class="btn btn-dark btn-xs mar-btm pull-right" href="{{ handles('joesama/project::manager/partner/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                            <i class="fa fa-plus icon-fw"></i>
                            {{ __('joesama/project::project.client.partner.name') }}
                        </a>
                        @endif
                        @forelse(data_get($project,'partner') as $index => $partner)
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.client.partner.name') }}  {{ ($index+1) }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($partner,'name') }}
                                    @if($isProjectManager && is_null($isReport))
                                    <a class="btn btn-danger btn-xs pull-right" href="{{ route('api.partner.delete',[$project->corporate_id,$project->id,$partner->id]) }}">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                    @endif
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
                            @foreach($reportWorkflow as $state => $assignee)
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::report.workflow.'.$state) }}
                                </td>
                                <td class="pl-2">
                                    {{ ucwords(data_get($assignee,'profile.name')) }}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                         @if( ($project->active || !is_null(data_get($project,'approval.approved_by'))) && $isProjectManager && is_null($isReport))
                        <a class="btn btn-dark btn-xs mar-btm pull-right" href="{{ handles('joesama/project::manager/attribute/form/'.request()->segment(4).'/'.request()->segment(5)) }}">
                            <i class="fa fa-plus icon-fw"></i>
                            {{ __('joesama/project::project.attr') }}
                        </a>
                        @endif
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.info.contract.value') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'value'),2) }}
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
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" >
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
                            @foreach(data_get($project,'attributes') as $index => $attributes)
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ data_get($attributes,'variable') }}
                                </td>
                                <td class="pl-2">
                                    {!! data_get($attributes,'data') !!}
                                    @if($isProjectManager)
                                    <a class="btn btn-danger btn-xs pull-right" href="{{ route('api.attribute.delete',[$project->corporate_id,$project->id,$attributes->id]) }}">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                    @endif
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