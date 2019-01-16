<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MakeReportCardRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class WorkflowProcessor 
{
	private $makeReportCard;

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MakeReportCardRepository $makeReportCard
	){
		$this->projectObj = $projectInfo;
		$this->makeReport = $makeReportCard;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function process(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->projectObj->getProject($projectId);

		$type = 'init'.ucfirst($request->get('type'));
		$workflow = $type.'Workflow';
		
		$report = $this->makeReport->{$type}($project,$request);

		return redirect(handles('report/'.$request->get('type').'/form/'.$corporateId.'/'.$projectId .'?report='.$report->id));
	}


} // END class MakeProjectProcessor 