<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Repositories\Project\FinancialRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;
use Joesama\Project\Http\Processors\Manager\HseProcessor;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class ProjectProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		ProjectInfoRepository $projectInfo,
		FinancialRepository $financialRepo,
		HseProcessor $hseScoreCard,
		FormGenerator $formBuilder
	){
		$this->listProcessor = $listProcessor;
		$this->hseScoreProcessor = $hseScoreCard;
		$this->financialRepo = $financialRepo;
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
			'profile_id' => Profile::sameGroup($corporateId)->pluck('name','id')
		])
		->excludes(['effective_days','planned_progress','actual_progress','actual_payment','planned_payment','current_variance'])
		->id($request->segment(5))
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

		return [
			'project' => $project,
			'taskTable' => $this->listProcessor->task($request,$corporateId),
			'issueTable' => $this->listProcessor->issue($request,$corporateId),
			'riskTable' => $this->listProcessor->risk($request,$corporateId),
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