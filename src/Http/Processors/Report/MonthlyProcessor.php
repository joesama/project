<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\CardWorkflow;
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
class MonthlyProcessor 
{
	use HasAccessAs;
	
	private $project, $reportCard;

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
		$table = app(ListProcessor::class)->monthlyReport($request, $corporateId);

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

		if( $projectId == 'report' ){
			$report = $this->reportCard->getMonthlyReportInfo($request->segment(6));
			$projectId = data_get($report,'project_id');
		}

		$project = $this->projectInfo->getProject($projectId);

		$projectDate = Carbon::parse($project->start);

		$reportDue = Carbon::now()->format('m');

		$startOfMonth = Carbon::now()->startOfMonth();

		$startOfMonth = $projectDate->greaterThan($startOfMonth) ? $projectDate : $startOfMonth;

		$startOfMonth = ($report) ? Carbon::parse($report->report_date) : $startOfMonth;

		$reportStart = $startOfMonth->format('j M Y');

		$dueStart = $startOfMonth->format('Y-m-d');

		$endOfMonth = ($report) ? Carbon::parse($report->report_end) : Carbon::now()->endOfMonth();

		$reportEnd = $endOfMonth->format('j M Y');

		$dueEnd = $endOfMonth->format('Y-m-d');

		$workflow = $this->reportCard->monthlyWorkflow($corporateId, $dueStart, $dueEnd, $project);

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