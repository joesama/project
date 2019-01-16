<div class="col-lg-4">
    <div class="panel panel-bordered-dark">
        <div class="panel-heading text-center">
            <h3 class="panel-title">
                {{ __('joesama/project::report.workflow.'.$status) }}
            </h3>
        </div>
        <div class="panel-body text-center">
            <img alt="Profile Picture" class="img-md img-circle mar-btm" src="{{ asset('packages/joesama/entree/img/profile.png') }}">
            <p class="text-lg text-semibold mar-no text-main">
            	{{ data_get($profile,'name') }}
            </p>
            <p class="text-muted">
                {{ data_get($profile,'position.description') }}
            </p>
            <p class="text-md">
                {{ data_get($record,'remark') }}
            </p>
        </div>
    </div>
</div>