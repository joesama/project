<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class WeeklyProcessor 
{
	private $reportCard;

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
		$reportDue = Carbon::now()->weekOfYear;
		$reportStart = Carbon::now()->startOfWeek()->format('d-m-Y');
		$reportEnd = Carbon::now()->endOfWeek()->format('d-m-Y');

		$workflow = $this->reportCard->weeklyWorkflow($corporateId, $projectId);

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