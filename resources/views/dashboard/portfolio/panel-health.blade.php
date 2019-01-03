<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ __('joesama/project::dashboard.subsidiary.health') }}
        </h3>
    </div>
    <div class="panel-body text-left clearfix">
        <div class="list-group bg-trans">
            @foreach($health as $projek)
            <li class="list-group-item pad-ver">
                <div class="col-md-11">  
                    <a class="col-md-12 text-lg text-{{config('joesama/project::master.status.color.'.data_get($projek,'condition') )}}" href="{{ handles('joesama/project::manager/project/view/'.$corporateId.'/'.data_get($projek,'id')) }}" >  
                        <i class="psi-next icon-lg icon-fw"></i>{{ str_limit(ucwords(data_get($projek,'name'),50)) }}
                    </a>
                </div>
                <div class="col-md-1">
                    <i class="{{config('joesama/project::master.status.icon.'.data_get($projek,'condition') )}} text-{{config('joesama/project::master.status.color.'.data_get($projek,'condition') )}} icon-lg icon-fw"></i>
                </div>
            </li>
            @endforeach
        </div>
    </div>
</div>