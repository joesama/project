<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use \DB;

/**
 * Form Generator
 **/
class FormGenerator 
{
	private $model, 
			$modelId, 
			$formId, 
			$fields, 
			$inputFields, 
			$static = FALSE, 
			$optionlist = [], 
			$mappinglist = [], 
			$readonly = [], 
			$exclude = [],
			$defaultValue = [], 
			$requiredField = [],
			$sortFields = [],
			$notRequiredField = [],
			$extraView = [];

	/**
	 * Generate Model Attributes
	 *
	 * $this->model - model for form
	 * $this->formId - form Id
	 * $this->optionlist - declaration for option / selection
	 * $this->extras - extra field to be pass ass parameter
	 * $this->exclude - field to be exclude from form generation
	 * $this->mappinglist - mapping field to specific value
	 * $this->readonlyList - display field that readonly
	 * $this->fields - all field from table
	 * $this->requiredField - all field that required
	 * $this->notRequiredField - all field that not required
	 * $this->defaultValue - default value for specific
	 * $this->sortFields - sort fields according this
	 **/
	public function newModelForm(Model $model)
	{
		$this->model = $model->newQuery();

		$this->formId = $model->getTable();

		$this->optionlist = collect([]);

		$this->extras = collect([]);

		$this->exclude = collect([]);

		$this->defaultValue = collect([]);

		$this->mappinglist = collect([]);

		$this->readonlyList = collect([]);

		$this->requiredField = collect([]);

		$this->notRequiredField = collect([]);

		$this->sortFields = collect([]);

		$this->extraView = collect([]);

		$table =  $model->fromQuery("SHOW FIELDS FROM ".$this->formId);

		$this->fields = collect(collect($table)->pluck('Type','Field'))->except(['created_at','updated_at','deleted_at']);

		return $this;
	}

	/**
	 * @param  Model Id
	 * @return this
	 */
	public function id($id = NULL)
	{
		$this->modelId = $id;

		return $this;
	}

	/**
	 * Set the current model to view only
	 * @return this
	 */
	public function staticForm()
	{
		$this->static = TRUE;

		return $this;
	}

	/**
	 * @param  array $sortedFields
	 * @return this
	 */
	public function sortedFields(array $sortedFields)
	{
		$this->sortFields = $this->sortFields->merge($sortedFields);

		return $this;
	}

	/**
	 * @param  array $optionList
	 * @return this
	 */
	public function option(array $optionList)
	{
		$this->optionlist = $this->optionlist->merge($optionList);

		return $this;
	}

	/**
	 * @param  array $mappings 
	 * @return this
	 */
	public function mapping(array $mappings)
	{
		$this->mappinglist = $this->mappinglist->merge($mappings);

		return $this;
	}

	/**
	 * @param  array $required 
	 * @return this
	 */
	public function required(array $required)
	{
		$this->requiredField = $this->requiredField->merge($required);

		return $this;
	}

	/**
	 * @param  array $notRequired 
	 * @return this
	 */
	public function notRequired(array $notRequired)
	{
		$this->notRequiredField = $this->notRequiredField->merge($notRequired);

		return $this;
	}

	/**
	 * @param  array $readonly 
	 * @return void
	 */
	public function readonly(array $readonly)
	{
		$this->readonlyList = $this->readonlyList->merge($readonly);

		return $this;
	}

	/**
	 * @param  array $excludes [field name]
	 * @return void
	 */
	public function excludes(array $excludes)
	{
		$this->exclude = $this->exclude->merge($excludes);

		return $this;
	}

	/**
	 * @param  array $excludes [field name]
	 * @return void
	 */
	public function default(array $defaults)
	{
		$this->defaultValue = $this->defaultValue->merge($defaults);

		return $this;
	}

	/**
	 * @param  array $extras [field name => field type]
	 * @return void
	 */
	public function extras(array $extras)
	{
		$this->extras = $this->extras->merge($extras);

		$this->extras->each(function($type,$field){

			if(is_string($type)){
				$this->fields->put($field,$type);
			}else{

				if( $type instanceof Collection){
					$this->fields->put($field,'int');
					$this->optionlist->put($field,$type);
				}
			}

		});

		return $this;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function appendView($view)
	{
		$this->extraView = $this->extraView->merge($view);

		return $this;
	}

	/**
	 * @param  string $title Id For the form
	 * @param  string $path Path to submit the form
	 * @param  string $type Type of submission
	 * @return view
	 */
	public function renderForm(string $title, string $action , string $method = 'POST')
	{
		$this->inputFields = $this->recognizeType($this->fields->toArray());

		return view('joesama/project::components.form.main-form',[
			'fields' => $this->inputFields,
			'title' => $title,
			'formId' => $this->formId,
			'action' => $action,
			'method' => $method,
			'option' => $this->optionlist,
			'mapping' => $this->mappinglist,
			'readonly' => $this->readonlyList,
			'value' => $this->model->find($this->modelId),
			'default' => $this->defaultValue,
			'required' => $this->requiredField,
			'notRequired' => $this->notRequiredField,
			'extraView' => $this->extraView
		]);
	}

	/**
	 * @param  array $fields
	 * @return array
	 */
	protected function recognizeType(array $fields)
	{
		$fieldsList = collect($fields)->map(function($field, $key){

			$pos = strripos($field, '(');

			if($pos === false){
				$type = trim($field," \t\n\r\0\x0B");
			}else{
				$type = trim(stristr($field,'(', true)," \t\n\r\0\x0B");
			}

			if(!$this->exclude->contains($key)){
				if(!$this->static){

					if(in_array($key,collect($this->mappinglist)->keys()->toArray())){
						return 'hidden';
					}

					if(in_array($type,['varchar','text'])){
						return 'text';
					}

					if(in_array($type,['double','decimal'])){
						return 'numeric';
					}

					if(in_array($type,['textarea'])){
						return 'textarea';
					}

					if(in_array($type,['date'])){
						return 'datepicker';
					}

					if(in_array($type,['range'])){
						return 'range-datepicker';
					}

					if(in_array($type,['tag'])){
						return 'tag';
					}

					if(in_array($type,['checkbox'])){
						return 'checkbox';
					}

					if(in_array($type,['multi'])){
						return 'multiselect';
					}

					if(in_array($key,collect($this->optionlist)->keys()->toArray())){

						$extraKey = $this->extras->get($key);

						if ( $extraKey instanceof Collection){
							return 'select';
						} else {
							return $this->extras->get($key,'select');
						}
					}

				}else{

					if(in_array($type,['varchar','double','decimal','text','date'])){
						return 'static';
					}

					if(in_array($key,collect($this->extras)->keys()->toArray())){
						return 'select';
					}

					if(in_array($type,['multi'])){
						return 'multiselect';
					}
				}
			}

		});

		$sortFields = collect([]);

		$this->sortFields->each(function($field) use($fieldsList,$sortFields){
			$sortFields->put($field, $fieldsList->get($field));
		});

		return $sortFields->merge($fieldsList->except($this->sortFields));

	}

} // END class FormGenerator 