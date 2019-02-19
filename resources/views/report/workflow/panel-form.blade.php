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
            <input type="hidden" name="status" id="status" value="{{ $status }}">
            <input type="hidden" name="need_action" id="need_action" value="{{ $need_action }}">
            <input type="hidden" name="need_step" id="need_step" value="{{ $need_step }}">
            <input type="hidden" name="type" value="{{ request()->segment(2) }}">
            <textarea id="textarea-input" name="remark" rows="9" onkeyup="copyremark()" class="form-control" placeholder="Your content here.."></textarea>
            @if(isset($last_status) && $last_status == 'rejected')
            <button type="submit" onclick="closeproject()" class="btn btn-dark mar-ver pull-left">
            	<i class="ion-asterisk text-danger icon-fw"></i>
            	{{ __('joesama/project::form.action.close') }}
            </button>
            @endif
            <button type="submit" class="btn btn-dark mar-ver pull-right">
            	<i class="psi-yes text-success icon-fw"></i>
            	{{ __('joesama/project::form.action.approve') }} 
            </button>
            </form>
            @if($back_action)
            <form method="POST" action="{{ $action }}">
            @csrf
            <input type="hidden" name="project_id" value="{{ $projectId }}">
            <input type="hidden" name="start" value="{{ $reportStart }}">
            <input type="hidden" name="end" value="{{ $reportEnd }}">
            <input type="hidden" name="cycle" value="{{ $reportDue }}">
            <input type="hidden" name="state" value="{{ $back_state }}">
            <input type="hidden" name="status" value="{{ $back_status }}">
            <input type="hidden" name="need_action" value="{{ $back_action }}">
            <input type="hidden" name="need_step" value="{{ $back_step }}">
            <input type="hidden" name="type" value="{{ request()->segment(2) }}">
            <input type="hidden" id="backremark" name="remark" value="{{ request()->segment(2) }}">
            <button type="submit" class="btn btn-danger mar-ver pull-left">
                <i class="psi-pen icon-fw"></i>
                {{ __('joesama/project::form.action.reject') }} 
            </button>
            </form>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    function copyremark(){
        document.getElementById('backremark').value = document.getElementById('textarea-input').value;
    }
    function closeproject(){
        event.preventDefault();
        $('#status').val('closed');
        $('#need_action').val(null);
        $('#need_step').val(0);
        $('form').submit();
        
    }
</script>