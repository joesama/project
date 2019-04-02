<?php
namespace Joesama\Project\Http\Processors\Report; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Repositories\Project\FinancialRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\ProcessFlowManager;
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
		$table = app(ListProcessor::class)->monthlyReportHistory($request);

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
        $reportId = $request->segment(6);

        $isProjectManager = $this->isProjectManager();

        if ($reportId !== NULL) {
            $report = $this->reportCard->getMonthlyReportInfo($reportId);

            $projectId = data_get($report, 'project_id');

            $project = data_get($report, 'project');
        }else{
            $report = false;

        	$project = $this->projectInfo->getProject($projectId,'month');
        }

        $processFlow = new ProcessFlowManager($project->corporate_id);

		$projectDate = Carbon::parse($project->start);

		$reportDue = Carbon::now()->format('m');

        $startOfMonth = Carbon::now()->startOfMonth();

        $startOfMonth = $projectDate->greaterThan($startOfMonth) ? $projectDate : $startOfMonth;

        $reportStart = ($report) ? Carbon::parse($report->report_date) : $startOfMonth;

        $endOfMonth = Carbon::now()->endOfMonth();

        $endOfMonth = $projectDate->greaterThan(Carbon::now()->startOfMonth()) ? $projectDate->clone()->endOfMonth() : $endOfMonth;

        $reportEnd = ($report) ? Carbon::parse($report->report_end) : $endOfMonth;

		$workflow = $processFlow->getMonthlyFlow($project, $reportId);

		$financialRepo = app(FinancialRepository::class);

		$listProcessor = app(ListProcessor::class);

		$paymentSchedule = $financialRepo->schedulePayment($project->id);

		$projectSchedule = $this->reportCard->scheduleTask($project->id);

		$projectStart = $reportStart->format('Y-m-d');

		$projectEnd = $reportEnd->format('Y-m-d');

		$claim = $financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'claim'),
			'claim_date',
			'claim_amount'
		);

		$paid = $financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'payment'),
			'payment_date',
			'paid_amount'
		);

		$vo = $financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'vo')
		);

		$retention = $financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'retention')
		);

		$lad = $financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'lad')
		);

		$hsecard = data_get($project,'hsecard');

		$claim = $financialRepo->getSparklineData($claim,'claim_amount');

		$payment = $financialRepo->getSparklineData($paid,'paid_amount');

		$vo = $financialRepo->getSparklineData($vo,'amount');

		$retention = $financialRepo->getSparklineData($retention,'amount');

		$lad = $financialRepo->getSparklineData($lad,'amount');

		$taskTable = $listProcessor->task($request,$corporateId);

		$issueTable = $listProcessor->issue($request,$corporateId);

		$riskTable = $listProcessor->risk($request,$corporateId);

		$policies = collect(config('joesama/project::policy.dashboard'));

		$balanceSheet = $financialRepo->balanceSheet($project);

		return compact('project','reportDue','reportStart','reportEnd','corporateId','projectId','workflow', 'paymentSchedule','projectSchedule', 'claim', 'payment', 'paid', 'vo', 'retention', 'lad', 'taskTable', 'issueTable', 'riskTable', 'policies', 'hsecard', 'balanceSheet');
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