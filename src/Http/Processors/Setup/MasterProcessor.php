<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Master\Master;
use Joesama\Project\Http\Processors\Setup\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;

/**
 * Master Record 
 *
 * @package default
 * @author 
 **/
class MasterProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Master $master
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $master;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->master($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder->newModelForm($this->modelObj);

		// if(is_null($request->segment(5))){
		// 	$form->extras([

		// 	]);
		// }else{
		// 	$form = $form->mapping([
		// 		'project_id' => $request->segment(5)
		// 	]);
		// }

		// if(!is_null($request->segment(6))){
		// 	$form->extras([
		// 		'task_progress' => 'text'
		// 	]);

		// 	$form->readonly(['end','start']);
		// }

		$form = $form->option([

		])
		->id($request->segment(5))
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.master.save',[$corporateId, $request->segment(5)])
		);

		return compact('form');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$view = $this->viewBuilder->newView($this->modelObj)
		->id($request->segment(5))
		->renderView(
			__('joesama/project::'.$request->segment(1).'.'
				.$request->segment(2).'.'
				.$request->segment(3))
		);

		$table = $this->listProcessor->data($request,$corporateId);

		return compact('view','table');
	}

} // END class MakeProjectProcessor 