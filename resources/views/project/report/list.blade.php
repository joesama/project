@extends('joesama/entree::layouts.content')
@push('content.style')

@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="panel">
            <div class="panel-body">
                  <a href="{{ handles('joesama/project::report/format/'.$projectId) }}" class="btn btn-dark pull-right mar-btm"  data-toggle="tooltip" data-placement="top" title="Tooltip on top" >
                    <i class="fa fa-plus"></i>&nbsp;{{ __('joesama/project::project.report.title') }}
                  </a>
		      <table class="table table-sm table-borderless table-striped">
		        <thead>
		          <tr>
		            <th class="bg-primary text-light" style="color: white">No.</th>
		            <th class="bg-primary text-light w-50" style="color: white">
		              {{ __('joesama/project::project.report.title') }}
		            </th>
		            <th class="bg-primary text-light" style="color: white">PIC</th>
		            <th class="bg-primary text-light" style="color: white" width="150px">
		              {{ __('joesama/project::project.date.report') }}
		            </th>
                        <th class="bg-primary text-light" style="color: white" width="120px">
                          {{ __('joesama/project::project.action') }}
                        </th>
		          </tr>
		        </thead>
		        <tbody>
		          @php
		            $task = collect(config('joesama/project::project.report'))->where('project_id',$projectId);
		          @endphp
		          @foreach($task as $key => $taskschedule)
		          <tr>
		            <td>{{ $key+1 }}</td>
		            <td> {{ data_get($taskschedule,'name') }}</td>                  
		            <td>{{ data_get($taskschedule,'pic') }}</td> 
		            <td>{{ data_get($taskschedule,'date') }}</td> 
		            <td class="text-center">
                            <a href="{{ handles('joesama/project::report/format/'.$projectId.'/'.data_get($taskschedule,'id')) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
		          </tr>
		          @endforeach
		        </tbody>
		      </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('content.script')


@endpush