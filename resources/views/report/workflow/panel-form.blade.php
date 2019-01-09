<div class="col-lg-3">
    <div class="panel panel-bordered-dark">
    	<div class="panel-heading text-center">
    		<h3 class="panel-title">Approve</h3>
    	</div>
        <div class="panel-body text-center">
            <img alt="Profile Picture" class="img-md img-circle mar-btm" src="{{ asset('packages/joesama/entree/img/profile.png') }}">
            <p class="text-lg text-semibold mar-no text-main">
            	{{ auth()->user()->fullname }}
            </p>
            <p class="text-muted">Position</p>
            <form method="POST" action="{{ handles('joesama/project::workflow/process/'.$corporateId.'/'.$projectId) }}">
            <textarea id="textarea-input" rows="9" class="form-control" placeholder="Your content here.."></textarea>
            <button type="submit" class="btn btn-dark mar-ver pull-right">
            	<i class="psi-pen icon-fw"></i>
            	Submit
            </button>
            </form>
        </div>
    </div>
</div>