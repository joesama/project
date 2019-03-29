<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ProjectUpdateWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\MakeReportCardRepository;

class WorkflowProcessor 
{
	/**
	 * Process Approval Workflow
	 * 
	 * @param  Request $request     Http Input Request
	 * @param  int     $corporateId Current Corporate Id
	 * @param  int     $projectId   Current Project Id
	 * @return void              
	 */
	public function approval(Request $request, int $corporateId, int $projectId)
	{
        $approval = new ProjectWorkflowRepository();

        $project = $approval->processApproval($projectId, $request);

        if ($request->get('state') == 'closed') {
			$uriHandler = handles('manager/project/list/'.$corporateId);
		}else{
			$uriHandler = handles('manager/project/view/'.$corporateId.'/'.$project->id);
		}

		return $this->redirectAction($uriHandler, $request->get('type'));
	}

	/**
	 * Update Information Workflow
	 * 
	 * @param  Request $request     Http Input Request
	 * @param  int     $corporateId Current Corporate Id
	 * @param  int     $projectId   Current Project Id
	 * @return void 
	 */
	public function update(Request $request, int $corporateId, int $projectId)
	{
		$projectInfoId = $request->segment(6);

		$update = new ProjectUpdateWorkflowRepository();

		$projectInfo = $update->processInfo($projectInfoId, $request);

		if ($request->get('need_step') ==  null) {
			$uriHandler = handles('manager/project/view/'.$corporateId.'/'.$projectInfo->project_id);
		}else{
			$uriHandler = handles('manager/project/info/'.$corporateId.'/'.$projectInfo->project_id.'/'.$projectInfo->id);
		}

		return $this->redirectAction($uriHandler, $request->get('type'));

	}

	/**
	 * Weekly Report Workflow
	 * 
	 * @param  Request $request     Http Input Request
	 * @param  int     $corporateId Current Corporate Id
	 * @param  int     $projectId   Current Project Id
	 * @return void 
	 */
	public function week(Request $request, int $corporateId, int $projectId)
	{
		$reportId = $request->segment(6);

		$report = new MakeReportCardRepository();
		
		$reportInfo = $report->initWeeklyWorkflow($request, $projectId, $reportId);

		if ($request->get('need_step') ==  null) {
			$uriHandler = handles('manager/project/view/'.$corporateId.'/'.$reportInfo->project_id);
		}else{
			$uriHandler = handles('report/weekly/form/'.$corporateId.'/'.$reportInfo->project_id.'/'.$reportInfo->id);
		}

		return $this->redirectAction($uriHandler, $request->get('type'));

	}

	/**
	 * Redirect action
	 * 
	 * @param  string $uriHandler Uri Handler for redirection
	 * @param  string $flowType   Type of the flow
	 * @param  string $type       Response type
	 * @return void
	 */
	protected function redirectAction(string $uriHandler, string $flowType, string $type = 'success')
	{
		return redirect_with_message(
			$uriHandler,
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::manager.workflow.'.$flowType)
			]),
            $type
		);
	}

} // END class MakeProjectProcessor 