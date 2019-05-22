<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Generate View For Specific Model
 *
 **/
class ViewGenerator
{
    private $model,
            $modelId,
            $viewId,
            $fields,
            $relationship,
            $exclude,
            $describeClosure;

    /**
     * Generate Model Attributes
     **/
    public function newView(Model $model)
    {
        $this->model = $model->newQuery();

        $this->viewId = $model->getTable();

        $this->relationship = collect([]);

        $this->exclude = collect([]);

        $this->describeClosure = collect([]);

        $tableAttributes =  $model->fromQuery("SHOW FIELDS FROM ".$this->viewId);

        $this->fields = collect($tableAttributes->pluck('Field', 'Field'))->except(['id','created_at','updated_at','deleted_at']);

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
     * @param  array $excludes [field name]
     * @return $this
     */
    public function excludes(array $excludes)
    {
        $this->exclude = $this->exclude->merge($excludes);
        
        $this->fields = $this->fields->diff($this->exclude);
        
        return $this;
    }

    /**
     * Attach callback to item listing
     * 
     * @param  array  $callback Array of mapped closure
     * @return $this
     */
    public function extends(array $callback)
    {
    	$this->describeClosure = $this->describeClosure->merge($callback);

    	return $this;
    }

    /**
     * @param  string $title
     * @return view
     */
    public function renderView(string $title)
    {
        return view('joesama/project::components.form.view-generator', [
            'fields' => $this->fields,
            'title' => $title,
            'viewId' => $this->viewId ,
            'relation' => $this->relationship,
            'callback' => $this->describeClosure,
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
        $with = $this->relationship->map(function ($relate) {
            if (!is_null($rel = stristr($relate, '.', true))) {
                return $rel;
            }
        })->values()->toArray();

        return $this->model->with($with)->find($this->modelId);
    }
} // END class ViewGenerator
