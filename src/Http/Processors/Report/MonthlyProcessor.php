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
use Joesama\Project\Traits\ProjectCalculator;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class MonthlyProcessor 
{
	use HasAccessAs, ProjectCalculator;
	
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
     * Redirecting current report to exact uri
     *
     * @param  int    $reportId  Current report id
     * @param  Request $request  [description]
     * @return [type]            [description]
     */
    public function redirect(Request $request, int $reportId)
    {
        $report = $this->reportCard->getMonthlyReportInfo($reportId);

        return redirect(
            handles('report/monthly/form/'.$report->project->corporate_id.'/'.$report->project_id.'/'.$reportId)
        );
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

		$today = Carbon::now();

		$reportDue = $this->calculateMonth($today, $projectDate);

        $startOfMonth = $today->startOfMonth();

        $startOfMonth = $projectDate->greaterThan($startOfMonth) ? $projectDate : $startOfMonth;

        $reportStart = ($report) ? Carbon::parse($report->report_date) : $startOfMonth;

        $endOfMonth = $today->clone()->endOfMonth();

        $endOfMonth = $projectDate->greaterThan(Carbon::now()->startOfMonth()) ? $projectDate->clone()->endOfMonth() : $endOfMonth;

        $reportEnd = ($report) ? Carbon::parse($report->report_end) : $endOfMonth;

		$workflow = $processFlow->getMonthlyFlow($project, $reportId);

		$financialRepo = app(FinancialRepository::class);

		$listProcessor = app(ListProcessor::class);

		$paymentSchedule = $financialRepo->schedulePayment($project->id);

		$projectSchedule = $this->reportCard->scheduleTask($project->id);

		$projectStart = $reportStart->format('Y-m-d');

		$projectEnd = $reportEnd->format('Y-m-d');

		$hsecard = $this->projectInfo->hseScore($project);

		$vo = $financialRepo->financialMapping($project,'vo');

		$paymentTrans = collect([
			'claimTo' => $financialRepo->financialMapping(
				$project,
				'claim',
				true,
				'claim_date',
				'claim_amount'
			),
			'paymentFrom' => $financialRepo->financialMapping(
				$project,
				'payment',
				true,
				'payment_date',
				'paid_amount'
			),
			'retentionTo' => $financialRepo->financialMapping($project, 'retention'),
			'ladby' => $financialRepo->financialMapping($project, 'lad'),
			'claimBy' => $financialRepo->financialMapping(
				$project,
				'claim',
				false,
				'claim_date',
				'claim_amount'
			),
			'paymentTo' => $financialRepo->financialMapping(
				$project,
				'payment',
				false,
				'payment_date',
				'paid_amount'
			),
			'retentionBy' => $financialRepo->financialMapping($project, 'retention', false),
			'ladto' => $financialRepo->financialMapping($project, 'lad', false)
		]);

		$taskTable = $listProcessor->task($request,$corporateId);

		$issueTable = $listProcessor->issue($request,$corporateId);

		$riskTable = $listProcessor->risk($request,$corporateId);

		$policies = collect(config('joesama/project::policy.dashboard'));

		$balanceSheet = $financialRepo->balanceSheet($project);

        $lastAction = collect(data_get($report, 'workflow'))
        ->where('state', strtolower(data_get($workflow,'last.status')))
        ->where('profile_id', strtolower(data_get($workflow,'last.profile_assign.id')));

        $printed = $lastAction->count();

        if ($request->get('print') == true) {
            dd($request->get('print'));
        }

		return compact('project','reportDue','reportStart','reportEnd','reportId','corporateId','projectId','workflow', 'paymentSchedule','projectSchedule', 'claim', 'payment', 'paid', 'vo', 'paymentTrans', 'taskTable', 'issueTable', 'riskTable', 'policies', 'hsecard', 'balanceSheet', 'printed');
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