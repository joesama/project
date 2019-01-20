<div class="col-lg-3">
    <div class="panel panel-bordered panel-mint">
        <div class="panel-heading text-center">
            <h3 class="panel-title text-bold">
                {{ __('joesama/project::report.workflow.'.$status) }}
            </h3>
        </div>
        <div class="panel-body text-center">
            <img alt="{{ data_get($profile,'name') }}" class="img-md img-circle mar-btm" src="{{ asset('packages/joesama/entree/img/profile.png') }}">
            <p class="text-thin text-semibold mar-no">
            	{{ data_get($profile,'name') }}
            </p>
            <p class="text-muted mar-top">
                {!! data_get($profile,'position.description','&nbsp;') !!}
            </p>
            <p class="text-md mar-top" style="vertical-align: text-bottom;">
                {!! data_get($record,'remark') !!}
            </p>
        </div>
    </div>
</div>