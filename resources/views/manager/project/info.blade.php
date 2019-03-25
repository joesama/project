@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm">
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.name') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'name') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'name') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.contract.no') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'contract') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'contract') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::form.project.job_code') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'job_code') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'job_code') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize"  style="width: 15%">
                                    {{ __('joesama/project::project.info.contract.scope') }}
                                </td>
                                <td class="pl-2">
                                    {!! strip_tags(data_get($project,'scope')) !!}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{!! strip_tags(data_get($infoProject,'scope')) !!}
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
                                    {{ data_get($project,'client.name') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'client.name') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.tel') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'client.phone') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'client.phone') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.pm') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'client.manager') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'client.manager') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.client.contact') }}
                                </td>
                                <td class="pl-2">
                                    {{ data_get($project,'client.contact') }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ data_get($infoProject,'client.contact') }}
                                </td>
                            </tr>
                        </table>
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
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" style="width: 30%">
                                    {{ __('joesama/project::project.info.contract.value') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'value'),2) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ number_format(data_get($infoProject,'value'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.date.start') }}
                                </td>
                                <td class="pl-2">
                                    {{ date('d-m-Y' , strtotime(data_get($project,'start'))) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ date('d-m-Y' , strtotime(data_get($infoProject,'start'))) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.date.end') }}
                                </td>
                                <td class="pl-2">
                                    {{ date('d-m-Y' , strtotime(data_get($project,'end'))) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ date('d-m-Y' , strtotime(data_get($infoProject,'end'))) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize" >
                                    {{ __('joesama/project::project.info.contract.gp.original') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'gp_propose'),2) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ number_format(data_get($infoProject,'gp_propose'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.gp.latest') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'gp_latest'),2) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ number_format(data_get($infoProject,'gp_latest'),2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ __('joesama/project::project.info.contract.bond') }}
                                </td>
                                <td class="pl-2">
                                    RM {{ number_format(data_get($project,'bond'),2) }}&nbsp;
                                    <i class="text-bold text-danger psi-arrow-out-right"></i>
                                    &nbsp;{{ number_format(data_get($infoProject,'gp_latest'),2) }}
                                </td>
                            </tr>
                            @foreach(data_get($project,'attributes') as $index => $attributes)
                            <tr>
                                <td class="text-bold bg-primary text-light text-capitalize">
                                    {{ data_get($attributes,'variable') }}
                                </td>
                                <td class="pl-2">
                                    {!! data_get($attributes,'data') !!}
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
@includeWhen(
    ( $project->active && (data_get($workflow,'current.profile_assign.id') == $profile->id )),
    'joesama/project::manager.project.part.flowProcessing', 
    [
        'workflow' => $workflow
    ]
)

@includeWhen(
    ( $project->active && (data_get($workflow,'current.profile_assign.id') != $profile->id )),
    'joesama/project::manager.project.part.flowHistory', 
    [
        'workflow' => $workflow
    ]
)
@endsection