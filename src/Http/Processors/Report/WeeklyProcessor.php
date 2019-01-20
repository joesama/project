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
		if(is_null($request->segment(6)) && is_null($request->get('report')) ){
			$projectId = data_get($this->reportCard->getWeeklyReportInfo($projectId),'project_id');
		}

		$project = $this->projectInfo->getProject($projectId);
		$reportDue = Carbon::now()->weekOfYear;
		
		$startOfWeek = Carbon::now()->startOfWeek();

		$reportStart = $startOfWeek->format('d-m-Y');
		$dueStart = $startOfWeek->format('Y-m-d');

		$endOfWeek = Carbon::now()->endOfWeek();

		$reportEnd = $endOfWeek->format('d-m-Y');
		$dueEnd = $endOfWeek->format('Y-m-d');

		$workflow = $this->reportCard->weeklyWorkflow($corporateId, $projectId, $dueStart, $dueEnd, $project->profile);

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