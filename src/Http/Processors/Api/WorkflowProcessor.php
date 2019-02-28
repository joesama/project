<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MakeReportCardRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoWorkflowRepository;
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
		ProjectWorkflowRepository $projectApproval,
		ProjectInfoWorkflowRepository $projectInfoflow
	){
		$this->projectObj 		= $projectInfo;
		$this->makeReport 		= $makeReportCard;
		$this->projectApproval 	= $projectApproval;
		$this->projectInfoFlow 	= $projectInfoflow;
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

		return redirect_with_message(
			handles('manager/project/view/'.$corporateId.'/'.$projectId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.approval')
			]),
            'success'
		);
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function info(Request $request,int $corporateId, int $projectId)
	{
		$projectInfo = $this->projectInfoFlow->projectInfo($request->segment(6));
		
		$this->projectInfoFlow->processInfo($projectInfo,$request);

		return redirect_with_message(
			handles('manager/project/info/'.$corporateId.'/'.$projectId.'/'.$projectInfo->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.'.$request->segment(2).'.info')
			]),
            'success'
		);
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

		$report = $this->makeReport->{$type}( $project, $request);

		$message = 	trans('joesama/entree::respond.data.success', [
						'form' => trans('joesama/project::report.'.$transtype.'.view')
					]);

		if($transtype == 'monthly'){

			if($request->get('register')){
				return $report;
			}

			return redirect_with_message(
				handles('manager/project/view/'.$corporateId.'/'.$projectId .'/'.$report->id),
				$message,
	            'success'
			);
		}else{
			return redirect_with_message(
				handles('report/'.$transtype.'/form/'.$corporateId.'/'.$projectId .'/'.$report->id),
				$message,
	            'success'
			);
		}
	}


} // END class MakeProjectProcessor 