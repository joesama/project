<label class="col-md-2 control-label text-semibold" for="{{ $fieldId }}">
	{{ __('joesama/project::form.'.$formId.'.'.$fieldId) }}
	@if($required)
    <i class="ion-asterisk text-danger" style="font-size: 6px;vertical-align:text-top;"></i>
    @endif
</label>