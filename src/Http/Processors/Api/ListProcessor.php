<?php
namespace Joesama\Project\Http\Processors\Api; 

use Joesama\Project\Database\Repositories\Organization\OrganizationInfoRepository;
use Joesama\Project\Database\Repositories\Project\MilestoneRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectUploadRepository;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Database\Repositories\Setup\MasterDataRepository;
use Joesama\Project\Database\Repositories\Setup\ProcessRepository;
use Joesama\Project\Http\Services\DataGridGenerator;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class ListProcessor 
{
	private $projectObj,
		$masterDataObj,
		$organizationObj,
		$reportCardObj,
		$approvalObj,
		$milestoneObj,
		$uploadObj;

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MasterDataRepository $masterData,
		OrganizationInfoRepository $organizationData,
		ProjectWorkflowRepository $projectWorkflow,
		ReportCardInfoRepository $reportCardObj,
		MilestoneRepository $milestoneObj,
		ProjectUploadRepository $uploadObj,
		ProcessRepository $processObj
	){
		$this->projectObj = $projectInfo;
		$this->masterDataObj = $masterData;
		$this->organizationObj = $organizationData;
		$this->reportCardObj = $reportCardObj;
		$this->approvalObj = $projectWorkflow;
		$this->milestoneObj = $milestoneObj;
		$this->uploadObj = $uploadObj;
		$this->processObj = $processObj;
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function project($request,$corporateId)
	{
		return $this->projectObj->projectList($corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function task($request,$corporateId)
	{
		return $this->projectObj->listProjectTask($corporateId, $request->segment(5));
	}
    
    /**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function plan($request,$corporateId)
	{
		return $this->projectObj->listProjectPlan($corporateId, $request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function issue($request,$corporateId)
	{
		return $this->projectObj->listProjectIssue($corporateId, $request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function risk($request,$corporateId)
	{
		return $this->projectObj->listProjectRisk($corporateId, $request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function master($request,$corporateId)
	{
		return $this->masterDataObj->listMaster($corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function data($request,$corporateId)
	{
		return $this->masterDataObj->listData($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function client($request,$corporateId)
	{
		return $this->projectObj->clientAll();
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function incident($request,$corporateId)
	{
		return $this->projectObj->listProjectIncident($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function payment($request,$corporateId)
	{
		return $this->projectObj->listProjectPayment($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function vo($request,$corporateId)
	{
		return $this->projectObj->listProjectVo($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function retention($request,$corporateId)
	{
		return $this->projectObj->listProjectRetention($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function lad($request,$corporateId)
	{
		return $this->projectObj->listProjectLad($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function profile($request,$corporateId)
	{
		return $this->organizationObj->listProfile($corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function weekly($request, int $corporateId)
	{
		return $this->reportCardObj->weeklyList($corporateId,$request->segment(5));
	}

	/**
	 * Get Weekly Report Base On Profile Id
	 * 
	 * @param  int    $profileId Current User Profile Id
	 * @return [type]            [description]
	 */
	public function week($request, int $corporateId, ?int $profileId)
	{
		return $this->reportCardObj->weeklyList($request->segment(4), NULL, $profileId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function monthly($request, $corporateId)
	{
		return $this->reportCardObj->monthlyList($corporateId,$request->segment(5));
	}

	/**
	 * Get Monthly Report Base On Profile Id
	 * 
	 * @param  int    $profileId Current User Profile Id
	 * @return [type]            [description]
	 */
	public function month($request, int $corporateId, ?int $profileId)
	{
		return $this->reportCardObj->monthlyList($request->segment(4), NULL, $profileId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function approval($request,$corporateId)
	{
		return $this->approvalObj->projectApprovalList($request,$corporateId);
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function finance($request,$corporateId)
	{
		return $this->milestoneObj->financeList($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function physical($request,$corporateId)
	{
		return $this->milestoneObj->physicalList($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function upload($request,$corporateId)
	{
		return $this->uploadObj->listUpload($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function flow($request,$corporateId)
	{
		return $this->processObj->getAllFlowByCorporation($corporateId,$request->segment(5));
	}

	/**
	 * @param  array $request
	 * @param  int $request,$corporateId
	 * @return Illuminate\Pagination\LengthAwarePaginator
	 */
	public function step($request,$corporateId)
	{
		return $this->processObj->getFlowSteps($request->segment(5));
	}
} // END class MakeProjectProcessor 