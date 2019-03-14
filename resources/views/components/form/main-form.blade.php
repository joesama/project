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
					'start' => data_get($value,'start',array_get($default,'start')),
					'end' => data_get($value,'end',array_get($default,'end')),
					'value' => data_get($value,$fieldId,array_get($default,$fieldId)),
					'default' => array_get($default,$fieldId),
					'readonly' => $readonly->contains($fieldId) ? TRUE : FALSE,
					'required' => $requiredInclude
				])
				@php
					$validator = collect([]);

					if($requiredInclude){
						$validator->put('notEmpty' , [ 'message' => __('joesama/project::form.is.required') ] );
					}

					if($type == 'numeric'){
						$validator->put('numeric' , [ 'message' => __('joesama/project::form.is.numeric') ] );
						$validator->put('lessThan' , [ 'inclusive' => true, 
														'value' =>  999999999999,
														'message' => __('joesama/project::form.is.maxnumber') 
													] );
					}

					$fields->put($fieldId,[
						'validators' => $validator->toArray()
					]);
				@endphp
			@endforeach
			@foreach($extraView as $view => $params)
				@includeIf($view,$params)
			@endforeach
		</div>
		<div class="panel-footer text-right">
	  		@php
	  			$listUrl = request()->segment(1).'/'.request()->segment(2).'/list/'.request()->segment(4);
	  			$listCaption = request()->segment(1).'.'.request()->segment(2).'.list';
	  			if( ( request()->segment(1) == 'manager' || request()->segment(2) == 'data' || request()->segment(2) == 'step' ) && !is_null(request()->segment(5))):
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
@if(request()->segment(1) == 'manager' && !is_null(request()->segment(5)))
<script type="text/javascript">
    $('#start').change(function(){
        countdays();
    });
    $('#end').change(function(){
        countdays();
    });
    $(document).on('nifty.ready', function() {
        countdays();
    });
    function parseDate(str) {
        var mdy = str.split('/');
        return new Date(mdy[2], mdy[1]-1, mdy[0]);
    }

    function datediff(first, second) {
        // Take the difference between the dates and divide by milliseconds per day.
        // Round to nearest whole number to deal with DST.
        var result = Math.round((second-first)/(1000*60*60*24));
        if (result < 0 || isNaN(result)){
            result = 0;
        } else {
            result = result + 1;
        }
        return result;
    }
    
    function countdays(){
        var start = $('#start').val();
        var end = $('#end').val();
        if((typeof(start) != "undefined" && start !== null) && (typeof(end) != "undefined" && end !== null)) {
            var days = datediff(parseDate(start), parseDate(end));
        } else {
            var days = 0;
        }
        $('#days').val(days);
    }
</script>
@endif
<script type="text/javascript">
$(document).on('nifty.ready', function() {

    var faIcon = {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
    }

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
		    },
		    onImageUpload: function(files) {

		    	var editor = this.id;


		    	data = new FormData(); 
		    	data.append("upload", files[0]);
		    	data.append("client", $('#client_id :selected').val());

				axios.post('/api/upload/save/{{request()->segment(4)}}{{"/".request()->segment(5)}}', data)
				.then(function (response) {
					$('#' + editor).summernote('insertImage', response.data);
				})
				.catch(function (error) {
				console.log(error);
				});
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