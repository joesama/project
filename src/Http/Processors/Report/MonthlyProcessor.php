<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class MonthlyProcessor 
{
	private $project, $reportCard;

	public function __construct(
		ProjectInfoRepository $projectInfo,
		ReportCardInfoRepository $reportCardInfo
	){
		$this->projectInfo = $projectInfo;
		$this->reportCard = $reportCardInfo;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		
		return [];
	}

	/**
	 * Weekly Report Form
	 * 
	 * @param  Request $request     
	 * @param  int     $corporateId  Corporate Id
	 * @param  int     $projectId    Project Id
	 * @return array
	 */
	public function form(Request $request, int $corporateId, int $projectId)
	{
		$project = $this->projectInfo->getProject($projectId);
		$reportDue = Carbon::now()->format('m');
		
		$startOfMonth = Carbon::now()->startOfMonth();

		$reportStart = $startOfMonth->format('d-m-Y');
		$dueStart = $startOfMonth->format('Y-m-d');

		$endOfMonth = Carbon::now()->endOfMonth();

		$reportEnd = $endOfMonth->format('d-m-Y');
		$dueEnd = $endOfMonth->format('Y-m-d');

		$workflow = $this->reportCard->monthlyWorkflow($corporateId, $projectId, $dueStart, $dueEnd);

		return compact('project','reportDue','reportStart','reportEnd','corporateId','projectId','workflow');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{

		return [];
	}

} // END class ClientProcessor 