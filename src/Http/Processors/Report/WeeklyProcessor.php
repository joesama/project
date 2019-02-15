<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class WeeklyProcessor 
{
	use HasAccessAs;
	
	private $reportCard;

	public function __construct(
		ProjectInfoRepository $projectInfo,
		ReportCardInfoRepository $reportCardInfo
	){
		$this->projectInfo = $projectInfo;
		$this->reportCard = $reportCardInfo;
		$this->profile();
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = app(ListProcessor::class)->weeklyReport($request, $corporateId);

		return compact('table');
	}

	/**
	 * Weekly Report Form
	 * 
	 * @param  Request $request     
	 * @param  int     $corporateId  Corporate Id
	 * @param  int     $projectId    Project Id
	 * @return array
	 */
	public function form(Request $request, int $corporateId, $projectId)
	{
		$report = FALSE;

		if( $projectId == 'report' || !is_null($request->segment(6)) ){

			$report = $this->reportCard->getWeeklyReportInfo($request->segment(6));
			$projectId = data_get($report,'project_id');
		}

		$project = $this->projectInfo->getProject($projectId);
		$reportDue = Carbon::now()->weekOfYear - Carbon::parse($project->start)->weekOfYear;
		
		$startOfWeek = ($report) ? Carbon::parse($report->report_date) : Carbon::now()->startOfWeek();

		$reportStart = $startOfWeek->format('d-m-Y');
		$dueStart = $startOfWeek->format('Y-m-d');

		$endOfWeek = ($report) ? Carbon::parse($report->report_end) : Carbon::now()->endOfWeek();

		$reportEnd = $endOfWeek->format('d-m-Y');
		$dueEnd = $endOfWeek->format('Y-m-d');

		$workflow = $this->reportCard->weeklyWorkflow($corporateId, $dueStart, $dueEnd, $project);

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