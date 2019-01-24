<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\MilestoneRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class FinanceProcessor 
{
	private $milestoneObj;

	public function __construct(
		MilestoneRepository $mileStoneRepository
	){
		$this->milestoneObj = $mileStoneRepository;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId, int $projectId)
	{
		$task = $this->milestoneObj->financialMilestone(collect($request->all()),$projectId,$request->segment(6));

		return redirect(handles('manager/'.$request->segment(2).'/list/'.$corporateId.'/'.$task->project_id));
	}

	/**
	 * Remove task data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		return $this->milestoneObj->deleteFinance($corporateId,$projectId,$request->segment(6));
	}
} // END class MakeProjectProcessor 