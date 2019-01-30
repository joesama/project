<?php
namespace Joesama\Project\Http\Processors\Dashboard; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Dashboard\MasterRepository;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class PortfolioProcessor 
{
	use HasAccessAs;

	public function __construct(
		MasterRepository $masterPortfolio
	){
		$this->masterRepo = $masterPortfolio;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function master(Request $request,int $corporateId)
	{
		return [
			'corporateId' => $corporateId,
			'project' => $this->masterRepo->projectSummary(),
			'contract' => $this->masterRepo->projectContract(),
			'task' => $this->masterRepo->projectTask(),
			'issue' => $this->masterRepo->projectIssue(),
			'summary' => [
				'task' => $this->masterRepo->projectTask(),
				'issue' => $this->masterRepo->projectIssue(),
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

			$corporateData->push(collect([
				'corporate' => $subs,
				'summary' => [
					'task' => $this->masterRepo->projectTask($subs->id),
					'issue' => $this->masterRepo->projectIssue($subs->id),
					'progress' => $this->masterRepo->projectProgress($subs->id),
				]
			]));
		});

		$financial = $this->masterRepo->projectCosting();

		$lastPayment = $financial->last();
		$gp = data_get($lastPayment,'actual') - data_get($lastPayment,'planned');

		if ($gp < 1000000000) {
		    // Anything less than a billion
		    $unit = 'M';
		    $format = round($gp / 1000000,2);
		} else {
		    $unit = 'B';
		    $format = round($gp / 1000000000,2);
		}

		$gp = $format.$unit;

		return [
			'project' => $this->masterRepo->projectSummary(),
			'contract' => $this->masterRepo->projectContract(),
			'task' => $this->masterRepo->projectTask(),
			'issue' => $this->masterRepo->projectIssue(),
			'payment' => $financial,
			'corporate' => $corporateData,
			'gp' => $gp

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
			'variance' => $this->masterRepo->projectVariance($corporateId),
			'health' => $this->masterRepo->projectHealth($corporateId),
			'pertask' => $this->masterRepo->perProjectTask($corporateId),
			'perIssue' => $this->masterRepo->perProjectIssue($corporateId)
		];
	}


} // END class PortfolioProcessor 