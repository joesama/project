<div class="col-lg-3">
    <div class="panel panel-bordered-dark">
        <div class="panel-heading text-center">
            <h3 class="panel-title">
                {{ __('joesama/project::report.workflow.'.$state) }}
            </h3>
        </div>
        <div class="panel-body text-center">
            <img alt="Profile Picture" class="img-md img-circle mar-btm" src="{{ asset('packages/joesama/entree/img/profile.png') }}">
            <p class="text-lg text-semibold mar-no text-main">
            	{{ $profile->name }}
            </p>
            <p class="text-muted">Position</p>
            <p class="text-md"></p>
        </div>
    </div>
</div>