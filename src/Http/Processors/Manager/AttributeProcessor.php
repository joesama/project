<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\Attribute;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class AttributeProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Attribute $issue
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $issue;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
						'project_id' => $request->segment(5)
				])
				->id($request->segment(5))
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.attribute.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}

} // END class MakeProjectProcessor 