<div class="col-lg-4">
    <div class="panel panel-bordered-dark">
    	<div class="panel-heading text-center">
    		<h3 class="panel-title">
                {{ __('joesama/project::report.workflow.'.$status) }}      
            </h3>
    	</div>
        <div class="panel-body text-center">
            <img alt="Profile Picture" class="img-md img-circle mar-btm" src="{{ data_get($profile,'user.photo',asset('packages/joesama/entree/img/profile.png')) }}">
            <p class="text-lg text-semibold mar-no text-main">
            	{{ data_get($profile,'name') }}
            </p>
            <p class="text-muted">
                {{ data_get($profile,'position.description') }}
            </p>
            <form method="POST" action="{{ $action }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $projectId }}">
            <input type="hidden" name="start" value="{{ $reportStart }}">
            <input type="hidden" name="end" value="{{ $reportEnd }}">
            <input type="hidden" name="cycle" value="{{ $reportDue }}">
            <input type="hidden" name="state" value="{{ $state }}">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="hidden" name="need_action" value="{{ $need_action }}">
            <input type="hidden" name="type" value="{{ request()->segment(2) }}">
            <textarea id="textarea-input" name="remark" rows="9" class="form-control" placeholder="Your content here.."></textarea>
            <button type="submit" class="btn btn-dark mar-ver pull-right">
            	<i class="psi-pen icon-fw"></i>
            	Submit
            </button>
            </form>
        </div>
    </div>
</div>