<?php
namespace Joesama\Project\Http\Processors\Dashboard; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Dashboard\MasterRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class PortfolioProcessor 
{

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

		return [
			'project' => $this->masterRepo->projectSummary(),
			'contract' => $this->masterRepo->projectContract(),
			'task' => $this->masterRepo->projectTask(),
			'issue' => $this->masterRepo->projectIssue(),
			'corporate' => $corporateData,

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