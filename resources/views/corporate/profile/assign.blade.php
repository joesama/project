@extends('joesama/entree::layouts.form')
@push('form.style')

@endpush
@section('form')
<div class="row mb-3">
    <div class="col-md-12">
		{!! $form !!}
    </div>
</div>
@if(data_get($profile,'project')->count() > 0)
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
			    <div class="bord-hor bord-ver pad-all col-md-3 col-md-offset-3 text-bold  bg-dark">
			    	{{ __('joesama/project::project.info.name') }}
			    </div>
			    <div class="bord-rgt bord-ver pad-all col-md-3 text-bold bg-dark">
			    	{{ __('joesama/project::corporate.profile.assign') }}
			    </div>
				@foreach(data_get($profile,'project') as $project)
			    <div class="bord-hor bord-btm pad-all col-md-3 col-md-offset-3">
						{{ data_get($project,'name') }}
			    </div>
			    <div class="bord-rgt bord-btm pad-all col-md-3">
					@php
					 $roles = data_get($project,'role')->filter(function($role) use($profile){
					 	return $role->pivot->profile_id == $profile->id;
					 });
					@endphp
					{{ $roles->pluck('role')->implode(',') }}
			    </div>
			    <a class="btn btn-danger btn-sm pull-left pad-ver" href="{{ route('api.profile.reassign',[$profile->id,data_get($project,'id')]) }}">
		        	<i class="psi-remove"></i>
		        </a>
			    @endforeach
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@push('form.script')

@endpush