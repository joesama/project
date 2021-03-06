<?php
namespace Joesama\Project\Http\Processors\Dashboard; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Dashboard\MasterRepository;
use Joesama\Project\Traits\HasAccessAs;
use Joesama\Project\Traits\ProjectCalculator;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class PortfolioProcessor 
{
	use HasAccessAs, ProjectCalculator;

	public function __construct(
		MasterRepository $masterPortfolio
	){
		$this->masterRepo = $masterPortfolio;
		$this->profile();
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function master(Request $request,int $corporateId)
	{

		$financial = $this->masterRepo->projectCosting();

		$lastPayment = $financial->last();

		$beforePayment =  $financial->slice($financial->count() - 2,1)->first();

		$gp = data_get($lastPayment,'actual') - data_get($lastPayment,'planned');

		$beforeQp = data_get($beforePayment,'actual') - data_get($beforePayment,'planned');

		return [
			'corporateId' => $corporateId,
			'project' => $this->masterRepo->projectSummary(),
			'contract' => $this->masterRepo->projectContract(),
			'task' => $this->masterRepo->projectTask(),
			'issue' => $this->masterRepo->projectIssue(),
			'summary' => [
				'task' => $this->masterRepo->projectTask(),
				'issue' => $this->masterRepo->projectIssue(),
				'payment' => $financial,
				'gp' => $this->shortHandFormat($gp),
				'gpDiff' => floatval($gp) - floatval($beforeQp)
			]
		];
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function group(Request $request,int $corporateId)
	{
		$corporate = $this->masterRepo->subsidiaries();

		$corporateData = collect([]);

		if($this->profile()->corporate_id != 1){
			$corporate = $corporate->where('id',$this->profile()->corporate_id);
		}

		$corporate->each(function($subs)use($corporateData){

			$financial = $this->masterRepo->projectCosting($subs->id);

			$lastPayment = $financial->last();

			$beforePayment =  $financial->slice($financial->count() - 2,1)->first();

			$gp = data_get($lastPayment,'actual') - data_get($lastPayment,'planned');

			$beforeQp = data_get($beforePayment,'actual') - data_get($beforePayment,'planned');

			$corporateData->push(collect([
				'corporate' => $subs,
				'summary' => [
					'task' => $this->masterRepo->projectTask($subs->id),
					'issue' => $this->masterRepo->projectIssue($subs->id),
					'progress' => $this->masterRepo->projectProgress($subs->id),
					'payment' => $financial,
					'gp' => $this->shortHandFormat($gp),
					'gpDiff' => floatval($gp) - floatval($beforeQp),
				]
			]));
		});

		return [
			'project' => $this->masterRepo->projectSummary( data_get( $this->profile(),'corporate_id' ) ),
			'contract' => $this->masterRepo->projectContract( data_get( $this->profile(),'corporate_id' ) ),
			'task' => $this->masterRepo->projectTask( data_get( $this->profile(),'corporate_id' ) ),
			'issue' => $this->masterRepo->projectIssue( data_get( $this->profile(),'corporate_id' ) ),
			'corporate' => $corporateData
		];
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function subsidiaries(Request $request,int $corporateId)
	{
		return [
			'corporateId' => $corporateId,
			'project' => $this->masterRepo->projectSummary($corporateId),
			'contract' => $this->masterRepo->projectContract($corporateId),
			'task' => $this->masterRepo->projectTask($corporateId),
			'issue' => $this->masterRepo->projectIssue($corporateId),
			'costing' => $this->masterRepo->projectCosting($corporateId),
			'costingName' => $this->masterRepo->projectCostingByName($corporateId),
			'variance' => $this->masterRepo->projectVariance($corporateId),
			'health' => $this->masterRepo->projectHealth($corporateId),
			'pertask' => $this->masterRepo->perProjectTask($corporateId),
			'perIssue' => $this->masterRepo->perProjectIssue($corporateId)
		];
	}


} // END class PortfolioProcessor 