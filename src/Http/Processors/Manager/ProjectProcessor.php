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
use Joesama\Project\Database\Repositories\Project\ProjectWorkflowRepository;
use Joesama\Project\Database\Repositories\Project\ReportCardInfoRepository;
use Joesama\Project\Http\Processors\Manager\HseProcessor;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
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

	private $listProcessor, 
			$hseScoreProcessor, 
			$financialRepo, 
			$reportCardRepo, 
			$projectWorkflowRepo, 
			$projectInfo, 
			$formBuilder;

	/**
	 * Build Class for project processor
	 * 
	 * @param ListProcessor         	$listProcessor  	List Manager
	 * @param ProjectInfoRepository 	$projectInfo    	Project Manager
	 * @param FinancialRepository   	$financialRepo  	Financial Info
	 * @param ReportCardInfoRepository  $reportCard  		Financial Info
	 * @param ProjectWorkflowRepository $projectWorkflow  	Approval Workflow
	 * @param HseProcessor          	$hseScoreCard   	HSE Info
	 * @param FormGenerator         	$formBuilder    	Form builder
	 */
	public function __construct(
		ListProcessor $listProcessor,
		ProjectInfoRepository $projectInfo,
		FinancialRepository $financialRepo,
		ReportCardInfoRepository $reportCard,
		ProjectWorkflowRepository $projectWorkflow,
		HseProcessor $hseScoreCard,
		FormGenerator $formBuilder
	){
		$this->listProcessor = $listProcessor;
		$this->hseScoreProcessor = $hseScoreCard;
		$this->financialRepo = $financialRepo;
		$this->reportCardRepo = $reportCard;
		$this->projectWorkflowRepo = $projectWorkflow;
		$this->projectInfo = $projectInfo;
		$this->formBuilder = $formBuilder;
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
	 * Form to create project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
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
					'manager_id' => Profile::sameGroup($corporateId)->pluck('name','id'),
					'approver_id' => Profile::sameGroup($corporateId)->pluck('name','id'),
					'validator_id' => Profile::fromParent()->pluck('name','id'),
					'reviewer_id' => Profile::fromParent()->pluck('name','id'),
					'acceptance_id' => Profile::fromParent()->pluck('name','id'),
					'scope' => 'textarea',
				])
				->default([
					'manager_id' 	=> 	data_get(Profile::sameGroup($corporateId)->whereHas('role',function($query) use($request){
											$query->where('project_id',$request->segment(5));
											$query->where('role_id',2);
										})->first(),'id'),
					'approver_id' 	=> 	data_get(Profile::sameGroup($corporateId)->whereHas('role',function($query) use($request){
											$query->where('project_id',$request->segment(5));
											$query->where('role_id',4);
										})->first(),'id'),
					'validator_id' 	=> 	data_get(Profile::fromParent()->whereHas('role',function($query) use($request){
											$query->where('project_id',$request->segment(5));
											$query->where('role_id',5);
										})->first(),'id'),
					'reviewer_id' 	=> 	data_get(Profile::fromParent()->whereHas('role',function($query) use($request){
											$query->where('project_id',$request->segment(5));
											$query->where('role_id',3);
										})->first(),'id'),
					'acceptance_id' => 	data_get(Profile::fromParent()->whereHas('role',function($query) use($request){
											$query->where('project_id',$request->segment(5));
											$query->where('role_id',4);
										})->first(),'id'),
				])
				->excludes(['start','end','effective_days','planned_progress','acc_progress','actual_progress','actual_payment','planned_payment','current_variance'])
				->id($request->segment(5))
				->required(['*'])
				->renderForm(
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

		$reportWorkflow = $this->reportCardRepo->reportWorkflow($project,$project->id);
		$approvalWorkflow = $this->projectWorkflowRepo->projectWorkflow($project->profile,$project->approval);

		return [
			'project' => $project,
			'reportWorkflow' => $reportWorkflow,
			'approvalWorkflow' => $approvalWorkflow,
			'weeklyReport' => $this->listProcessor->weeklyReport($request,$corporateId),
			'monthlyReport' => $this->listProcessor->monthlyReport($request,$corporateId),
			'taskTable' => $this->listProcessor->task($request,$corporateId, !is_null(data_get($project,'approval.approved_by'))),
			'issueTable' => $this->listProcessor->issue($request,$corporateId, !is_null(data_get($project,'approval.approved_by'))),
			'riskTable' => $this->listProcessor->risk($request,$corporateId, !is_null(data_get($project,'approval.approved_by'))),
			'hsecard' => data_get($project,'hsecard'),
			'claim' => $this->financialRepo->getSparklineData($claim,'claim_amount'),
			'payment' => $this->financialRepo->getSparklineData($paid,'paid_amount'),
			'vo' => $this->financialRepo->getSparklineData($vo,'amount'),
			'retention' => $this->financialRepo->getSparklineData($retention,'amount'),
			'lad' => $this->financialRepo->getSparklineData($lad,'amount'),
			'balanceSheet' => $this->financialRepo->balanceSheet($project),
			'policies' => collect(config('joesama/project::policy.dashboard'))
		];
	}

} // END class MakeProjectProcessor 