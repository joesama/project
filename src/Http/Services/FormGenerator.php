<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use \DB;

/**
 * Form Generator
 **/
class FormGenerator 
{
	private $model, $modelId, $formId, $fields, $inputFields, $optionlist, $mappinglist;

	/**
	 * @param  string $formId Id For The Form
	 * @return void
	 */
	public function newModelForm(Model $model)
	{

		$this->model = $model->newQuery();
		$this->formId = $model->getTable();

		$table =  $model->fromQuery("SHOW FIELDS FROM ".$this->formId);

		$this->fields = collect(collect($table)->pluck('Type','Field'))->except(['created_at','updated_at','deleted_at']);

		return $this;
	}

	/**
	 * @param  Model Id
	 * @return [type]
	 */
	public function id($id = NULL)
	{
		$this->modelId = $id;

		return $this;
	}

	/**
	 * @param  array $optionList
	 * @return [type]
	 */
	public function option(array $optionList)
	{
		$this->optionlist = collect($optionList);

		return $this;
	}

	/**
	 * @param  array $mapping 
	 * @return void
	 */
	public function mapping(array $mappings)
	{
		$this->mappinglist = collect($mappings);

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
			'value' => $this->model->find($this->modelId)
		]);
	}

	/**
	 * @param  array $fields
	 * @return array
	 */
	protected function recognizeType(array $fields)
	{

		return collect($fields)->map(function($field, $key){

			$pos = strripos($field, '(');

			if($pos === false){
				$type = trim($field," \t\n\r\0\x0B");
			}else{
				$type = trim(stristr($field,'(', true)," \t\n\r\0\x0B");
			}

			if(in_array($type,['varchar',])){
				return 'text';
			}

			if(in_array($type,['date'])){
				return 'datepicker';
			}

			if(in_array($key,$this->optionlist->keys()->toArray())){
				return 'select';
			}

			if(in_array($key,$this->mappinglist->keys()->toArray())){
				return 'hidden';
			}

		});
	}

} // END class FormGenerator 