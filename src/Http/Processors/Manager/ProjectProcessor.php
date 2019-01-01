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
			'profile_id' => Profile::pluck('name','id')
		])
		->id($request->segment(5))
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.project.save',[$corporateId, $request->segment(5)])
		);


		return compact('form');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$projectId = $request->segment(5);

		$project = $this->projectInfo->getProject($projectId);

		$claim = $this->financialRepo->projectClaimTransaction(
			data_get($project,'start'),
			data_get($project,'end'),
			data_get($project,'claim')
		);

		$paid = $this->financialRepo->projectPaymentTransaction(
			data_get($project,'start'),
			data_get($project,'end'),
			data_get($project,'payment')
		);

		$claimTransdata = collect([
	        'monthTrans' => $claim->get(Carbon::now()->format('Y'))
	                    ->get(Carbon::now()->format('m'))
	                    ->sum('claim_amount'),
	        'ytd' => $claim->get(Carbon::now()->format('Y'))->flatten(1)->sum('claim_amount'),
	        'ttd' => $claim->flatten(2)->sum('claim_amount'),
	        'sparlineData' => $claim->flatten(2)->pluck('claim_amount')->map(function($item){
	        	return is_null($item) ? 0 :$item;
 	        })->toArray()
	    ]);

		$paidTransdata = collect([
	        'monthTrans' => $paid->get(Carbon::now()->format('Y'))
	                    ->get(Carbon::now()->format('m'))
	                    ->sum('paid_amount'),
	        'ytd' => $paid->get(Carbon::now()->format('Y'))->flatten(1)->sum('paid_amount'),
	        'ttd' => $paid->flatten(2)->sum('paid_amount'),
	        'sparlineData' => $paid->flatten(2)->pluck('paid_amount')->map(function($item){
	        	return is_null($item) ? 0 :$item;
 	        })->toArray()
	    ]);

		$voTransdata = collect([
	        'monthTrans' => 0,
	        'ytd' => 0,
	        'ttd' => 0,
	        'sparlineData' => collect([])->map(function($item){
	        	return is_null($item) ? 0 :$item;
 	        })->toArray()
	    ]);

		return [
			'project' => $project,
			'taskTable' => $this->listProcessor->task($request,$corporateId),
			'issueTable' => $this->listProcessor->issue($request,$corporateId),
			'riskTable' => $this->listProcessor->risk($request,$corporateId),
			'hsecard' => data_get($project,'hsecard'),
			'claim' => $claimTransdata,
			'payment' => $paidTransdata,
			'vo' => $voTransdata,
			'balanceSheet' => $this->financialRepo->balanceSheet($project),
			'policies' => collect(config('joesama/project::policy.dashboard'))
		];
	}

} // END class MakeProjectProcessor 