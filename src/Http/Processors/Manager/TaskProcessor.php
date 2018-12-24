<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class TaskProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->task($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder->newModelForm(
			app(\Joesama\Project\Database\Model\Project\Task::class)
		)
		->option([
			'profile_id' => Profile::where('corporate_id',$request->segment(4))->pluck('name','id')
		])
		->id($request->segment(6))
		->mapping([
			'project_id' => $request->segment(5)
		])
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.task.save',[$corporateId, $request->segment(5), $request->segment(6)])
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
		$table = $this->listProcessor->task($request,$corporateId);
		
		return compact('table');
	}

} // END class MakeProjectProcessor 