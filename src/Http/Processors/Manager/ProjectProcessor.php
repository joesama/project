<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Processors\Project\ProjectInfoProcessor;
use Joesama\Project\Http\Services\FormGenerator;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class ProjectProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		ProjectInfoProcessor $projectProcessor,
		FormGenerator $formBuilder
	){
		$this->listProcessor = $listProcessor;
		$this->projectProcessor = $projectProcessor;
		$this->formBuilder = $formBuilder;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->project($request,$corporateId);
		
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
			app(\Joesama\Project\Database\Model\Project\Project::class)
		)
		->option([
			'client_id' => Client::whereHas('project')->pluck('name','id')
		])
		->mapping([
			'corporate_id' => $corporateId
		])
		->extras([
			'profile_id' => Profile::pluck('name','id')
		])
		->id($request->segment(5))
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.project.save',[$corporateId, $request->segment(5)])
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
		$projectId = $request->segment(5);

		return [
			'project' => $this->projectProcessor->projectInfo($projectId),
			'scheduleTable' => $this->listProcessor->task($request,$corporateId),
			'issueTable' => $this->listProcessor->issue($request,$corporateId),
			'riskTable' => $this->listProcessor->risk($request,$corporateId),
			'policies' => collect(config('joesama/project::policy.dashboard'))
		];
	}

} // END class MakeProjectProcessor 