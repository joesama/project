<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MakeReportCardRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class WorkflowProcessor 
{
	private $makeReportCard, $projectApproval;

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MakeReportCardRepository $makeReportCard,
		ProjectWorkflowRepository $projectApproval
	){
		$this->projectObj 		= $projectInfo;
		$this->makeReport 		= $makeReportCard;
		$this->projectApproval 	= $projectApproval;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function approval(Request $request,int $corporateId, int $projectId)
	{
		$project = $this->projectObj->getProject($projectId);
		
		$report = $this->projectApproval->approveProject($project,$request);

		return redirect(handles('manager/project/view/'.$corporateId.'/'.$projectId));
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

		$transtype = ($request->get('type') == 'project') ? 'monthly' : $request->get('type');

		$type = 'init'.ucfirst($transtype);
		$workflow = $type.'Workflow';
		
		$report = $this->makeReport->{$type}($project,$request);

		if($transtype == 'monthly'){
			return redirect(handles('manager/project/view/'.$corporateId.'/'.$projectId .'/'.$report->id));
		}else{
			return redirect(handles('report/'.$request->get('type').'/form/'.$corporateId.'/'.$projectId .'/'.$report->id));
		}
	}


} // END class MakeProjectProcessor 