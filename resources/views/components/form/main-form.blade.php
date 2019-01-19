<form class="form-horizontal form-padding" id="{{$formId}}" action="{{ $action }}" method="{{ $method}}" novalidate="novalidate">
	<div class="panel">
		<div class="panel-heading">
	        <h3 class="panel-title">{{ $title }}</h3>
	    </div>
	  	<div class="panel-body">
	  		@csrf
	  		@php
	  			$allRequired = $required->contains('*') ? TRUE : FALSE;
	  		@endphp
			@foreach($fields as $fieldId => $type)
				@php
					$requiredExclude = $notRequired->contains($fieldId);
					$requiredInclude = ( $allRequired && !$requiredExclude) ? $allRequired : ( $required->contains($fieldId) ? TRUE : FALSE );
				@endphp
				@includeIf('joesama/project::components.form.'.$type,[
					'mapValue' => array_get($mapping,$fieldId),
					'optionList' => array_get($option,$fieldId),
					'value' => data_get($value,$fieldId,array_get($default,$fieldId)),
					'readonly' => $readonly->contains($fieldId) ? TRUE : FALSE,
					'required' => $requiredInclude
				])
				@php
					$validator = ($requiredInclude) ? [ 'notEmpty' => [ 'message' => __('joesama/project::form.is.required') ] ] : null;
					$fields->put($fieldId,[
						'validators' => $validator
					]);
				@endphp
			@endforeach
		</div>
		<div class="panel-footer text-right">
	  		@php
	  			$listUrl = request()->segment(1).'/'.request()->segment(2).'/list/'.request()->segment(4);
	  			$listCaption = request()->segment(1).'.'.request()->segment(2).'.list';
	  			if( ( request()->segment(1) == 'manager' || request()->segment(2) == 'data' ) && !is_null(request()->segment(5))):
	  			$listUrl = request()->segment(1).'/'.request()->segment(2).'/list/'.request()->segment(4).'/'.request()->segment(5);
	  			$projectUrl = request()->segment(1).'/project/view/'.request()->segment(4).'/'.request()->segment(5);
	  			$projectCaption = request()->segment(1).'.project.view';
	  			endif;
	  		@endphp
	        <a class="btn btn-dark" href="{{ handles($listUrl) }}">
	        	<i class="psi-numbering-list icon-fw"></i>
	        	{{ __('joesama/project::'.$listCaption) }}
	        </a>
	        @if(request()->segment(1) == 'manager' && !is_null(request()->segment(5)))
	        <a class="btn btn-dark" href="{{ handles($projectUrl) }}">
	        	<i class="psi-folder-with-document icon-fw"></i>
	        	{{ __('joesama/project::'.$projectCaption) }}
	        </a>
	        @endif
	        <button class="btn btn-primary" type="submit">
	        	<i class="psi-data-save icon-fw"></i>
	        	{{ __('joesama/project::form.submit') }}
	        </button>
	    </div>
	</div>
</form>

@push('form.script')
<script type="text/javascript">
$(document).on('nifty.ready', function() {

    var faIcon = {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
    }

	$('.input-group.date').datepicker({
		autoclose:true,
		format: 'dd/mm/yyyy'
	});

    $("{{'#'.$formId}}").bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: @json($fields)
    })
    .find('textarea')
    .summernote({
        height: 100,
		callbacks: {
			onKeydown: function(e) {
				validateEditor();
			},
			onKeyup: function(e) {
		      validateEditor();
		    },
		    onPaste: function(e) {
		      validateEditor();
		    }
		}
    });

    function validateEditor() {
        // Revalidate the content when its value is changed by Summernote

        $('textarea').each(function(element,item) {
		  $("{{'#'.$formId}}").bootstrapValidator('revalidateField', item.name);
		});
        // textArea.
    };

});
</script>
@endpush