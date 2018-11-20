<style type="text/css">
	label.col-form-label{
		color: rgb(13, 13, 14);
		font-weight: bold;
		text-align: right;
	}
</style>
<form>
  <div class="form-group row">
    <label for="staticEmail" class="col-md-3 col-form-label">
    	Task Created
    </label>
    <div class="col-md-9">
      <input type="text" class="form-control-plaintext" readonly="true" id="staticEmail" value="{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}">
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-md-3 col-form-label">
    	{{ __('joesama/project::project.info.name') }}
    </label>
    <div class="col-md-9">
      <select class="form-control" id="exampleFormControlSelect1">
        @foreach(config('joesama/project::data.project') as $key => $title)
          <option>{{ $title }}</option>
        @endforeach
    </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="staticEmail" class="col-md-3 col-form-label">
    	Issue
    </label>
    <div class="col-md-9">
      <input type="text" class="form-control" id="staticEmail" placeholder="Issue">
    </div>
  </div>
</form>	