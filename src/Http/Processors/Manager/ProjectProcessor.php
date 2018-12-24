<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Processors\Project\ProjectInfoProcessor;

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
		ProjectInfoProcessor $projectProcessor
	){
		$this->listProcessor = $listProcessor;
		$this->projectProcessor = $projectProcessor;
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
		$projectId = $request->segment(6);

		$component = $this->projectProcessor->projectInfo($projectId);

		
		return compact('component');
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
		];
	}

} // END class MakeProjectProcessor 