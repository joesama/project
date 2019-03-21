<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;

class WorkflowProcessor 
{
	/**
	 * Process Approval Workflow
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
			return redirect_with_message(
				handles('manager/project/list/'.$corporateId),
				trans('joesama/entree::respond.data.success', [
					'form' => trans('joesama/project::manager.workflow.approval')
				]),
	            'success'
			);
		}else{
			return redirect_with_message(
				handles('manager/project/view/'.$corporateId.'/'.$project->id),
				trans('joesama/entree::respond.data.success', [
					'form' => trans('joesama/project::manager.workflow.approval')
				]),
	            'success'
			);
		}
	}
} // END class MakeProjectProcessor 