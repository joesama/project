<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Database\Eloquent\Model;


/**
 * Generate View For Specific Model 
 *
 **/
class ViewGenerator 
{
	private $model, $modelId, $viewId, $fields, $relationship = [];

	/**
	 * Generate Model Attributes
	 **/
	public function newView(Model $model)
	{
		$this->model = $model->newQuery();
		$this->viewId = $model->getTable();
		$this->relationship = collect([]);
		$tableAttributes =  $model->fromQuery("SHOW FIELDS FROM ".$this->viewId);
		$this->fields = collect($tableAttributes->pluck('Field','Field'))->except(['id','created_at','updated_at','deleted_at']);

		return $this;
	}

	/**
	 * Define relation her or else will determine base on eloquent's relationship definition
	 * @param  array $relation
	 * @return void
	 */
	public function relation(array $relation)
	{
		$this->relationship = $this->relationship->merge($relation);

		return $this;
	}

	/**
	 * @param  Model Id
	 * @return [type]
	 */
	public function id($id)
	{
		$this->modelId = $id;

		return $this;
	}

	/**
	 * @param  string $title
	 * @return view
	 */
	public function renderView(string $title)
	{
		return view('joesama/project::components.form.static-form',[
			'fields' => $this->fields,
			'title' => $title,
			'viewId' => $this->viewId ,
			'relation' => $this->relationship,
			'data' => $this->retrieveData()
		]);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	protected function retrieveData()
	{

		$with = $this->relationship->map(function($relate){
			if(!is_null($rel = stristr($relate, '.', true))){
				return $rel;
			}
		})->values()->toArray();

		return $this->model->with($with)->find($this->modelId);
	}

} // END class ViewGenerator 