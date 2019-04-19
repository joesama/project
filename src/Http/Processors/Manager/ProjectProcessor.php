<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\CardWorkflow;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\ReportWorkflow;
use Joesama\Project\Database\Repositories\Project\FinancialRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Database\Repositories\Project\ProjectUpdateWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\HseProcessor;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ProcessFlowManager;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class ProjectProcessor 
{
	use HasAccessAs;

	/**
	 * Processing all project related listing
	 * 
	 * @var Joesama\Project\Http\Services\DataGridGenerator
	 */
	private $listProcessor;

	/**
	 * Processing HSE Score Card
	 * 
	 * @var Joesama\Project\Http\Processors\Manager\HseProcessor
	 */
	private $hseScoreProcessor;

	/**
	 * Financial Data Processor
	 * 
	 * @var Joesama\Project\Database\Repositories\Project\FinancialRepository
	 */
	private $financialRepo;

	/**
	 * Report Card Data Processor
	 * 
	 * @var Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository
	 */
	private $reportCardRepo;

	/**
	 * Project Approval Work Flow Data Processor
	 * 
	 * @var Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository
	 */
	private $projectWorkflowRepo;

	/**
	 * Project Info Work Flow Data Processor
	 * 
	 * @var Joesama\Project\Database\Repositories\Project\projectUpdateWorkflowsitory
	 */
	private $projectUpdateWorkflow;

	/**
	 * Project Information Data Processor
	 * 
	 * @var Joesama\Project\Database\Repositories\Project\ProjectInfoRepository
	 */
	private $projectInfo;
	
	/**
	 * Form Generator 
	 * 
	 * @var Joesama\Project\Http\Services\FormGenerator
	 */
	private $formBuilder;


	/**
	 * Build Class for project processor
	 * 
	 * @param ListProcessor         	$listProcessor  	List Manager
	 * @param ProjectInfoRepository 	$projectInfo    	Project Manager
	 * @param FinancialRepository   	$financialRepo  	Financial Info
	 * @param ReportCardInfoRepository  $reportCard  		Financial Info
	 * @param ProjectWorkflowRepository $projectWorkflow  	Approval Workflow
	 * @param ProjectUpdateWorkflowRepository $projectInfoWorkflow  	Project Info Workflow
	 * @param HseProcessor          	$hseScoreCard   	HSE Info
	 * @param FormGenerator         	$formBuilder    	Form builder
	 */
	public function __construct(
		ListProcessor $listProcessor,
		ProjectInfoRepository $projectInfo,
		FinancialRepository $financialRepo,
		ReportCardInfoRepository $reportCard,
		ProjectWorkflowRepository $projectWorkflow,
		ProjectUpdateWorkflowRepository $projectInfoWorkflow,
		HseProcessor $hseScoreCard,
		FormGenerator $formBuilder
	){
		$this->listProcessor = $listProcessor;

		$this->hseScoreProcessor = $hseScoreCard;

		$this->financialRepo = $financialRepo;

		$this->reportCardRepo = $reportCard;

		$this->projectWorkflowRepo = $projectWorkflow;

		$this->projectUpdateWorkflow = $projectInfoWorkflow;

		$this->projectInfo = $projectInfo;

		$this->formBuilder = $formBuilder;

		$this->profileRefresh();
	}


	/**
	 * Project data listing
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->project($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * Project Approval data listing
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function approval(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->projectApproval($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * Project Approval data listing
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function info(Request $request, int $corporateId)
	{
		$updateFlowId = $request->segment(6);

		$infoProject = $this->projectUpdateWorkflow->projectInfo($updateFlowId);

		$project = $infoProject->project;

		$processFlow = new ProcessFlowManager( ($project) ? $project->corporate_id : $corporateId );
		
		$workflow = $processFlow->getUpdateFlow($project, $updateFlowId);

		return compact('infoProject','workflow', 'project');
	}

	/**
	 * Form to create project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{

		$processFlow = new ProcessFlowManager($corporateId);

		$form = $this->formBuilder->newModelForm(
					app(\Joesama\Project\Database\Model\Project\Project::class)
				)
				->option([
					'client_id' => Client::pluck('name','id')
				])
				->mapping([
					'corporate_id' => $corporateId
				])
				->extras([
					'duration' => 'range',
					'scope' => 'textarea',
				])
				->excludes(['start','end','effective_days','planned_progress','acc_progress','actual_progress','actual_payment','planned_payment','current_variance'])
				->id($request->segment(5))
				->required(['*']);

		if(!$request->segment(5)){
			$form->appendView([
				'joesama/project::setup.process.assignation' => [ 'flow' => $processFlow->formRoleListing() ]
			]);
		}

		$form = $form->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.project.save',[$corporateId, $request->segment(5)])
				);

		return compact('form');
	}

	/**
	 * Project Information
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$project = $this->projectInfo->getProject($projectId);

		$processFlow = new ProcessFlowManager( ($project) ? $project->corporate_id : $corporateId );

		$projectStart = data_get($project,'start');

		$projectEnd = data_get($project,'end');

		$claim = $this->financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'claim'),
			'claim_date',
			'claim_amount'
		);

		$paid = $this->financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'payment'),
			'payment_date',
			'paid_amount'
		);

		$vo = $this->financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'vo')
		);

		$retention = $this->financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'retention')
		);

		$lad = $this->financialRepo->projectComponentTransaction(
			$projectStart,
			$projectEnd,
			data_get($project,'lad')
		);

		return [
			'project' => $project,
            'processFlow' => $processFlow->getAssignedFlowToProject($project),
            'approval' => (!$project->active) ? $processFlow->getApprovalFlow($project) : null,
            'infoUpdate' => ($project->active) ? $processFlow->getUpdateFlow($project) : null,
			'projectUpdate' => $this->listProcessor->projectUpdate($project, $processFlow->getUpdateFlow($project)),
			'weeklyReport' => $this->listProcessor->weeklyReport($project, $processFlow->getWeeklyFlow($project)),
			'monthlyReport' => $this->listProcessor->monthlyReport($project, $processFlow->getMonthlyFlow($project)),
			'upload' => $this->listProcessor->upload($request,$corporateId,$project->id),
			'paymentSchedule' =>  $this->financialRepo->schedulePayment($project->id),
			'projectSchedule' =>  $this->reportCardRepo->scheduleTask($project->id),
			'taskTable' => $this->listProcessor->task($request,$corporateId),
			'issueTable' => $this->listProcessor->issue($request,$corporateId),
			'riskTable' => $this->listProcessor->risk($request,$corporateId),
			'hsecard' => $this->projectInfo->hseScore($project),
			'claim' => $this->financialRepo->getSparklineData($claim,'claim_amount'),
			'payment' => $this->financialRepo->getSparklineData($paid,'paid_amount'),
			'retention' => $this->financialRepo->getSparklineData($retention,'amount'),
			'lad' => $this->financialRepo->getSparklineData($lad,'amount'),
			'vo' => $this->financialRepo->getSparklineData($vo,'amount'),
			'balanceSheet' => $this->financialRepo->balanceSheet($project),
			'policies' => collect(config('joesama/project::policy.dashboard'))
		];
	}

} // END class MakeProjectProcessor 