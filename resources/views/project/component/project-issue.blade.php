<style type="text/css">
	label.col-form-label{
		color: rgb(13, 13, 14);
		font-weight: bold;
		text-align: right;
	}
</style>
<form class="form-horizontal">
  <div class="form-group">
    <label for="staticEmail" class="col-sm-3 control-label text-semibold">
    	Date Create
    </label>
    <div class="col-md-9">
      <p class="form-control-static" > {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
    </div>
  </div>
  <div class="form-group">
    <label for="staticEmail" class="col-sm-3 control-label text-semibold">
      {{ __('joesama/project::project.info.name') }}
    </label>
    <div class="col-md-9">
      <select class="form-control" id="exampleFormControlSelect1">
        @foreach(config('joesama/project::data.project') as $key => $title)
          <option>{{ data_get($title,'name') }}</option>
        @endforeach
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="staticEmail" class="col-sm-3 control-label text-semibold">
    	{{ __('joesama/project::project.priority') }}
    </label>
    <div class="col-md-9">
      <select class="form-control" id="exampleFormControlSelect1">
        @foreach(config('joesama/project::data.priority') as $key => $priority)
          <option class="text-{{$priority}}">{{ ucwords($key) }}</option>
        @endforeach
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="staticEmail" class="col-sm-3 control-label text-semibold">
    	Issue
    </label>
    <div class="col-md-9">
      <input type="text" class="form-control" id="staticEmail" placeholder="Issue">
    </div>
  </div>
</form>	