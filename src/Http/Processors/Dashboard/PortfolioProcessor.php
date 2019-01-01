<?php
namespace Joesama\Project\Http\Processors\Dashboard; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Dashboard\MasterRepository;
use Joesama\Project\Database\Repositories\Project\ProjectInfoRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class PortfolioProcessor 
{

	public function __construct(
		ProjectInfoRepository $projectInfo,
		MasterRepository $masterPortfolio
	){
		$this->projectObj = $projectInfo;
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
			'project' => $this->masterRepo->projectSummary($this->projectObj->projectAll())
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
		return [];
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function subsidiaries(Request $request,int $corporateId)
	{
		return [];
	}


} // END class PortfolioProcessor 